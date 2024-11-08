<?php

namespace App\Http\Controllers\Client;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Client\HomeService;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new HomeService();
    }
    public function index()
    {

        $title = Setting::where('setting_key', 'setting_name')->value('setting_value') ?? 'Laravel';
        return view('client.home.index',compact('title'));
    }

    public function hotlineAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ], [

            // Thông báo lỗi riêng cho email
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',

            // Thông báo lỗi riêng cho từng trường
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập họ tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->service->hotlineAjax($request);
    }

    public function search(){
        $title = "Tìm kiếm sản phẩm";
        return view('client.uitil.search',compact('title'));
    }

    public function searchAjax(Request $request){
        return $this->service->searchAjax($request);
    }
}
