<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service){
        $this->service = $service;
    }

    public function index(Request $request){

        return view("backend.order.index");
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function statusOrder(Request $request){
        return $this->service->statusOrder($request);
    }

    public function getItemOrder(Request $request){
        return $this->service->getItemOrder($request);
    }

    public function excelOrder(Request $request){
        return $this->service->excelOrder($request);
    }
}
