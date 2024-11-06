<?php

use App\Http\Controllers\Backend\GiaoHangTietKiemControllor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/provinces', [GiaoHangTietKiemControllor::class, 'getProvinces']);
Route::get('/districts/{province}', [GiaoHangTietKiemControllor::class, 'getDistricts']);
Route::get('/communes/{districts}', [GiaoHangTietKiemControllor::class, 'getCommune']);
