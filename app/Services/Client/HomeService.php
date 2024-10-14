<?php

namespace App\Services\Client;

use App\Models\Contact;
use App\Models\Products;
use App\Models\Setting;

class HomeService {
    public function hotlineAjax($request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        $dataInsert = Contact::create($data);
        if($dataInsert){
            return response()->json([
                'status'=> 'success',
                'message' => 'Thành công!'
            ]);
        }else{
            return response()->json([
                'status'=> 'error',
                'message'=> 'Lỗi hệ thống'
            ]);
        }
    }

    public function searchAjax($request){

        //Lấy số lượng sản phẩm trên 1 trang
        $paginateDefault = '1';
        $paginate = Setting::where('setting_key', 'setting_paginate')->value('setting_value') ?? $paginateDefault;

        // Kiểm tra xem giá trị phân trang có phải là số không, nếu không thì sử dụng giá trị mặc định
        $paginate = is_numeric($paginate) ? intval($paginate) : $paginateDefault;


        // Lấy dữ liệu từ database, có thể thêm sắp xếp hoặc phân trang nếu cần
        $sort = $request->get('sort');

        $value = $request->get('value');


        $query = Products::query();
        $query = $query->where('status', 0)
            ->where('name', 'like', '%' . $value . '%'); // Tìm kiếm với điều kiện tương tự (like)



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
}
