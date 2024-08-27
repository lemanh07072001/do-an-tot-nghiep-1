<?php


namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Label;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Properties;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;


class ProductesService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;


        $filer = [];

        $query =  Products::query();

        $query = $query->with(['user', 'categories']);

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('name', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {

            $filer[] = ['status', '=', $searchStatus];
        }

        if ($request->has('searchUser') && isset($searchUser)) {

            $filer[] = ['user_id', '=', $searchUser];
        }

        if (!empty($filer)) {
            $query = $query->where($filer);
        }




        return DataTables::of($query)
            ->addColumn('sku', function ($products) {
                return '<span class="font-semibold">' . $products->sku . '</span>';
            })
            ->addColumn('avatar', function ($products) {
                return FormatFunction::formatTitleProduct($products);
            })
            ->addColumn('images', function ($products) {
                return FormatFunction::formatImagesProduct($products);
            })
            ->addColumn('price', function ($products) {
                return FormatFunction::formatPriceProduct($products->price);
            })
            ->addColumn('price_sale', function ($products) {
                return FormatFunction::formatPriceProduct($products->price_sale);
            })
            ->addColumn('status', function ($products) {
                return FormatFunction::formatBadge($products->status);
            })
            ->addColumn('action', function ($products) {
                return '
                        <a href="' . route('ecommerce_module.products.edit', ['products' => $products]) . '" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </a>

                        <button type="button" data-delete="deleteRow" class="deleteRow inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    ';
            })

            ->rawColumns(['status',  'action', 'avatar', 'sku', 'images', 'price', 'price_sale'])
            ->make(true);
    }


    public function store($request)
    {

        // Xử lý ngoại lệ
        // Convert Array Images to String
        if (is_array($request->images)) {
            $imageString = implode(', ', $request->images);
        } else {
            $imageString = [];
        }


        //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'sort_description' => $request->sort_description,
            'images' => $imageString,
            'description' => $request->description,
            'avatar' => $request->avatar,
            'sku' => $request->sku,
            'price' => FormatFunction::formatPrice($request->price),
            'price_sale' => FormatFunction::formatPrice($request->price_sale),
            'status' => $request->status,
            'user_id' => Auth::id(),
            'attributeCatalogue' => $this->formatJson($request, 'attributeCatalogue'),
            'attributes' => $this->formatJson($request, 'attribute'),
            'variants' => $this->formatJson($request, 'variant'),
            'label_id' => $request->label_id,
            'categories_id' => $request->categories_id,
            'created_at' => FormatFunction::getDatetime(),
        ];


        //NOTE - Lưu vào cơ sở dữ liệu
        $dataInsert = Products::create($data);
        //NOTE - Thông báo
        if ($dataInsert) {
            $this->createVaniant($dataInsert, $request);
            // Thông báo thành công
            flash()->success('Tạo mới sản phẩm thành công!');
            // Chuyển hướng trang
            return redirect()->route('ecommerce_module.products.index');
        } else {
            // Thông báo thất bại
            flash()->error('Tạo sản phẩm thất bại! Vui lòng đợi trong ít phút');
            // Chuyển hướng trang
            return redirect()->back();
        }
    }

    public function createVaniant($dataInsert, $request)
    {
        $payload = $request->only(['variant', 'productVariant', 'attribute']);

        $variant = $this->createVaniantArray($payload);

        $dataInsert->product_variants()->delete();

        $variants =  $dataInsert->product_variants()->createMany($variant);

        $variantId = $variants->pluck('id');

        $attributesCombines = $this->comebineAttribute(array_values($payload['attribute']));

        $variantAttitude = [];

        if (count($variantId)) {
            foreach ($variantId as $key => $value) {

                if (count($attributesCombines)) {
                    foreach ($attributesCombines[$key] as $attributeId) {
                        $variantAttitude[] = [
                            'attribute_id' => $attributeId,
                            'product_variant_id' => $value,
                        ];
                    }
                };
            }
        }
    }

    private function comebineAttribute($attributes = [], $index = 0)
    {
        if ($index === count($attributes)) return [[]];

        $subCombines = $this->comebineAttribute($attributes, $index + 1);
        $combines = [];

        foreach ($attributes[$index] as $key => $value) {
            foreach ($subCombines as $keySub => $valueSub) {
                $combines[] = array_merge([$value], $valueSub);
            }
        }
        return $combines;
    }

    public function createVaniantArray(array $payload = [])
    {
        $variant = [];

        if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
            foreach ($payload['variant']['sku'] as $key => $value) {
                $variant[] = [
                    'code' => $payload['productVariant']['id'][$key] ?? '',
                    'quantity' => $payload['variant']['quantity'][$key] ?? '',
                    'sku' => $value,
                    'price' => $payload['variant']['price'][$key] ? FormatFunction::formatPrice($payload['variant']['price'][$key]) : '',
                    'user_id' => Auth::id(),
                ];
            }
        }


        return $variant;
    }

    public function formatJson($request, $inputName)
    {
        return ($request->input($inputName) && !empty($request->input($inputName))) ? json_encode($request->input($inputName)) : '';
    }

    public function update($request, $products)
    {
        // Xử lý ngoại lệ
        // Convert Array Images to String
        if (is_array($request->images)) {
            $imageString = implode(', ', $request->images);
        } else {
            $imageString = [];
        }



        //NOTE - Lưu thông tin người dùng vào cơ sở dữ liệu
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'sort_description' => $request->sort_description,
            'images' => $imageString,
            'description' => $request->description,
            'avatar' => $request->avatar,
            'sku' => $request->sku,
            'price' => FormatFunction::formatPrice($request->price),
            'price_sale' => FormatFunction::formatPrice($request->price_sale),
            'status' => $request->status,
            'user_id' => Auth::id(),
            'attributeCatalogue' => $this->formatJson($request, 'attributeCatalogue'),
            'attributes' => $this->formatJson($request, 'attribute'),
            'variants' => $this->formatJson($request, 'variant'),
            'label_id' => $request->label_id,
            'categories_id' => $request->categories_id,
            'created_at' => FormatFunction::getDatetime(),
        ];




        $dataUpdate = $products->update($data);


        if ($dataUpdate) {
            //NOTE - Thông báo
            if ($dataUpdate) {
                $products->product_variants()->each(function ($variant){
                    $variant->delete();
                });

                $this->createVaniant($products, $request);
                // Thông báo thành công
                flash()->success('Cập nhật mới sản phẩm thành công!');
                // Chuyển hướng trang
                return redirect()->route('ecommerce_module.products.index');
            } else {
                // Thông báo thất bại
                flash()->error('Cập nhật sản phẩm thất bại! Vui lòng đợi trong ít phút');
                // Chuyển hướng trang
                return redirect()->back();
            }
        }
    }


    //NOTE - Cập nhật toggle status
    public function toggleStatus($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy ID
            $id = $request->id;

            // Xử lý cập nhật status
            $changeStatus = Products::find($id)->update(['status' => !$request->value]);

            // Thông báo
            if ($changeStatus) {
                // Thành công
                return response()->json([
                    'message' => 'Cập nhật trạng thái thành công!'
                ], 200);
            } else {
                // Thất bại
                return response()->json([
                    'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
            ], 500);
        }
    }

    //NOTE - Xóa tất cả dữ liệu được chọn
    public function deleteAll($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $ids = $request->id;

            // Xóa tài khoản
            $dataDelete = Products::destroy($ids);
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa sản phẩm thành công!'
                ], 200);
            } else {
                // Thông báo thất bại
                return response()->json([
                    'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //NOTE - Xóa tài khoản đang chọn
    public function deleteRow($request)
    {
        // Xử lý ngoại lệ
        try {
            // Lấy id
            $id = $request->id;
            // Xóa tài khoản
            $dataDelete = Products::find($id)->delete();
            if ($dataDelete) {
                // Thông báo thành công
                return response()->json([
                    'message' => 'Xóa sản phẩm thành công!'
                ], 200);
            } else {
                // Thông báo thất bại
                return response()->json([
                    'message' => 'Lỗi hệ thống vui lòng thử lại sau!'
                ], 500);
            }
        } catch (\Exception $e) {
            // Thông báo lỗi xử lý
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //NOTE - Lấy danh sách thuộc tính theo tên
    public function getCategoriesSelect()
    {
        return Categories::withDepth()->where('status', 0)->get()->toFlatTree();
    }

    //NOTE - Lấy danh sách thuộc tính theo cha
    public function getPropertiesSelectByParent()
    {
        return Properties::whereNull('parent_id')->select(['id', 'name'])->get();
    }

    //NOTE - Lấy danh sách thuộc tính theo cha
    public function getAllBrandSelect()
    {
        return Brand::select(['id', 'name'])->where('status', 0)->get();
    }

    public function getAllLabelSelect()
    {
        return Label::select(['id', 'name'])->where('status', 0)->get();
    }

    public function getChildrenProperties($request)
    {
        $id = $request->option['attributeId'];


        // Find the property by ID and get its descendants
        $descendants = Properties::find($id)->descendants;


        $descendants = $descendants->where('status', 0);


        $attrributeMapp = $descendants->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name,

            ];
        })->all();

        // Return the filtered results as JSON
        return response()->json(array('items' => $attrributeMapp));
    }

    public function getAttributeAjax($request)
    {
        $payload['attributes'] = $request['attributes'];
        $payload['attributeId'] = $request['attributeId'];
        $attributeArray = $payload['attributes'][$payload['attributeId']];

        $attributes =  [];
        if (count($attributeArray)) {
            $attributes = Properties::select(['id', 'name'])->whereIn('id', $attributeArray)->get();
        }

        $temp = [];
        if (count($attributes)) {
            foreach ($attributes as $item) {
                $temp[] = ['id' => $item->id, 'name' => $item->name];
            };
        }

        return response()->json(array('items' => $temp));
    }


}
