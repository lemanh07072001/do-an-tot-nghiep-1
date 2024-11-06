<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;
    public function __construct(){
        $this->service = new OrderService();
    }

    public function order(Request $request){
        return $this->service->order($request);
    }

}
