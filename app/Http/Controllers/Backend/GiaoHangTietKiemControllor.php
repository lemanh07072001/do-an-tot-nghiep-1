<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GiaoHangTietKiemControllor extends Controller
{
    public function getProvinces(){
        $response = Http::get('https://esgoo.net/api-tinhthanh/1/0.htm');

        // Trả về dữ liệu cho AJAX
        return response()->json($response->json());
    }

    public function getDistricts($id){
        $response = Http::get('https://esgoo.net/api-tinhthanh/2/'.$id.'.htm');

        // Trả về dữ liệu cho AJAX
        return response()->json($response->json());
    }

    public function getCommune($id){
        $response = Http::get('https://esgoo.net/api-tinhthanh/3/' . $id . '.htm');

        // Trả về dữ liệu cho AJAX
        return response()->json($response->json());
    }
}
