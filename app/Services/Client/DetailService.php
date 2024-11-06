<?php

namespace App\Services\Client;

use App\Models\Categories;
use App\Models\GroupProduct;
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\Properties;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class DetailService
{
    public function getFirstCategories($slug)
    {
        $categories = Categories::where("slug", $slug)->where('status', 0)->first();
        return $categories;
    }

    public function getProducts($request)
    {
        //Lấy số lượng sản phẩm trên 1 trang
        $paginateDefault = '1';
        $paginate = Setting::where('setting_key', 'setting_paginate')->value('setting_value') ?? $paginateDefault;

        // Kiểm tra xem giá trị phân trang có phải là số không, nếu không thì sử dụng giá trị mặc định
        $paginate = is_numeric($paginate) ? intval($paginate) : $paginateDefault;


        // Lấy dữ liệu từ database, có thể thêm sắp xếp hoặc phân trang nếu cần
        $sort = $request->get('sort');
        $id = $request->get('id');

        // Kiểm tra hợp lệ của $id
        if (!$id || !is_numeric($id)) {
            return response()->json(['error' => 'ID không hợp lệ'], 400);
        }


        $query = Products::query();
        $query = $query->where('status', 0)->where('categories_id', '=', $id);



        switch ($sort) {
            case '0':
                $query->orderBy('created_at', 'desc'); // Mới nhất
                break;
            case '1':
                $query->orderBy('price', 'asc'); // Giá từ thấp đến cao
                break;
            case '2':
                $query->orderBy('price', 'desc'); // Giá từ cao đến thấp
                break;
            default:
                $query->orderBy('name', 'asc'); // Thứ tự mặc định
                break;
        }

        // Phân trang nếu cần
        $products = $query->paginate($paginate);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        // Trả về JSON
        return response()->json($products);
    }

    public function getAllProduct($request)
    {
        //Lấy số lượng sản phẩm trên 1 trang
        $paginateDefault = '1';
        $paginate = Setting::where('setting_key', 'setting_paginate')->value('setting_value') ?? $paginateDefault;

        // Lấy dữ liệu từ database, có thể thêm sắp xếp hoặc phân trang nếu cần
        $sort = $request->get('sort');

        $query = Products::query();
        $query = $query->where('status', 0);



        switch ($sort) {
            case '0':
                $query->orderBy('created_at', 'desc'); // Mới nhất
                break;
            case '1':
                $query->orderBy('price', 'asc'); // Giá từ thấp đến cao
                break;
            case '2':
                $query->orderBy('price', 'desc'); // Giá từ cao đến thấp
                break;
            default:
                $query->orderBy('name', 'asc'); // Thứ tự mặc định
                break;
        }

        // Phân trang nếu cần
        $products = $query->paginate($paginate);

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
        }

        // Trả về JSON
        return response()->json($products);
    }

    public function getNameGroupProduct($slug)
    {
        return GroupProduct::where('slug', $slug)->where('status', 0)->first();
    }

    public function getGroupProductAjax($request)
    {
        // Lấy số lượng sản phẩm trên mỗi trang, mặc định là 1 nếu không có cài đặt
        $paginateDefault = 1;
        $paginate = Setting::where('setting_key', 'setting_paginate')->value('setting_value') ?? $paginateDefault;

        // Lấy dữ liệu từ request
        $sort = $request->get('sort');
        $slug = $request->get('slug');

        // Tìm group product theo slug
        $groupProduct = GroupProduct::where('slug', $slug)->where('status', 0)->firstOrFail();

        // Kiểm tra nếu không tìm thấy group product
        if (!$groupProduct) {
            abort(404, 'Không tìm thấy nhóm sản phẩm');
        }

        // Lấy sản phẩm thuộc nhóm dựa trên mối quan hệ nhiều-nhiều
        $query = $groupProduct->products()->where('status', 0);

        // Xử lý sắp xếp theo yêu cầu
        switch ($sort) {
            case '0':
                $query->orderBy('created_at', 'desc'); // Mới nhất
                break;
            case '1':
                $query->orderBy('price', 'asc'); // Giá từ thấp đến cao
                break;
            case '2':
                $query->orderBy('price', 'desc'); // Giá từ cao đến thấp
                break;
            default:
                $query->orderBy('name', 'asc'); // Thứ tự mặc định
                break;
        }

        // Phân trang các sản phẩm
        $products = $query->paginate($paginate);

        // Kiểm tra nếu không có sản phẩm nào
        if ($products->isEmpty()) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        // Trả về dữ liệu JSON của sản phẩm
        return response()->json($products);
    }

    public function getFirstCategorie($slug)
    {
        return Categories::where('slug', $slug)->where('status', 0)->first();
    }

    public function getFirstCategoriesAjax($request)
    {
        // Lấy số lượng sản phẩm trên mỗi trang, mặc định là 1 nếu không có cài đặt
        $paginateDefault = 1;
        $paginate = Setting::where('setting_key', 'setting_paginate')->value('setting_value') ?? $paginateDefault;

        // Lấy dữ liệu từ request
        $sort = $request->get('sort');
        $slug = $request->get('slug');

        try {
            // Tìm danh mục theo slug
            $categories = Categories::where('slug', $slug)->where('status', 0)->firstOrFail();

            // Lấy sản phẩm thuộc danh mục dựa trên mối quan hệ nhiều-nhiều
            $query = $categories->products()->where('status', 0);

            // Xử lý sắp xếp theo yêu cầu
            switch ($sort) {
                case '0':
                    $query->orderBy('created_at', 'desc'); // Mới nhất
                    break;
                case '1':
                    $query->orderBy('price', 'asc'); // Giá từ thấp đến cao
                    break;
                case '2':
                    $query->orderBy('price', 'desc'); // Giá từ cao đến thấp
                    break;
                default:
                    $query->orderBy('name', 'asc'); // Thứ tự mặc định
                    break;
            }

            // Phân trang các sản phẩm
            $products = $query->paginate($paginate);

            // Kiểm tra nếu không có sản phẩm nào
            if ($products->isEmpty()) {
                return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
            }

            // Trả về dữ liệu JSON của sản phẩm
            return response()->json($products);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ và trả về trang lỗi 404
            abort(404, 'Không tìm thấy danh mục hoặc sản phẩm');
        }
    }

    public function getFirstProduct($slug)
    {
        // Lấy thông tin sản phẩm
        $getFindProduct = Products::where('slug', $slug)->where('status', 0)->firstOrFail();

        // Lấy ảnh sản phẩm
        $imageString = $getFindProduct->images;

        // Convert string sang array images
        $imageArray = explode(', ', $imageString);

        // Giải mã thuộc tính sản phẩm từ JSON
        $attributeArray = json_decode($getFindProduct->attributes, true);


        // Lấy các khóa thuộc tính
        $attributeKey = array_keys($attributeArray);


        // Mảng để lưu thông tin cha và con
        $arrayData = [];

        // Tạo cấu trúc cho mảng cha và con
        foreach ($attributeArray as $key => $subArray) {
            $arrayData[$key] = [
                'id' => $key,
                'children' => $subArray,
            ];
        }

        // Mảng để lưu thông tin trả về
        $formattedData = [];

        // Duyệt qua các thuộc tính đã tạo
        foreach ($arrayData as $data) {
            $parent = Properties::where('id', $data['id'])->where('status', 0)->orderBy('id', 'DESC')->first();

            $childrenData = [];

            if ($data['children']) {
                foreach ($data['children'] as $childId) {
                    $child = Properties::where('id', $childId)->where('status', 0)->orderBy('id', 'ASC')->first();
                    if ($child) {
                        $childrenData[] = $child;
                    }
                }
            }

            // Thêm thông tin cha và con vào mảng kết quả
            $formattedData[] = [
                'parent' => $parent,
                'children' => $childrenData
            ];
        }





        // Trả về dữ liệu sản phẩm
        $dataProduct = [
            'product' => $getFindProduct,
            'imageArray' => $imageArray,
            'attributes' => $formattedData, // Thay đổi tên thành 'attributes' cho rõ ràng
        ];

        return $dataProduct;
    }

    public function getAttributeAjax($request)
    {

        $ids = $request->data;

        $idProduct = $request->idProduct;
        $avatar = $request->avatar;

        $getFindProduct = Products::with(['product_variants' => function($query) use($ids){
            $query->where('code', $ids);
        }])->where('id', $idProduct)->first();

        $dataVariant = $getFindProduct ? $getFindProduct->product_variants->first() : null;



        $arrayID = explode(', ', $ids);

        $dataName = '';

        foreach ($arrayID as $id) {
            $attriName = Properties::where('id', $id)->first();
            $dataName .= ' - '.$attriName->name ;
        }

        $nameProduct = $getFindProduct->name . $dataName;

        $dataVariant = $getFindProduct->product_variants->where('code',$ids)->first();

        $data = [
            'nameProduct' => $nameProduct,
            'dataVariant' => $dataVariant,
            'avatar' => $avatar
        ];
        return response()->json($data);
    }
}
