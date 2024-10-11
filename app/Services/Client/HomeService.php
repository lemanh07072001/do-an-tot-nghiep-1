<?php

namespace App\Services\Client;

use App\Models\Contact;

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
}
