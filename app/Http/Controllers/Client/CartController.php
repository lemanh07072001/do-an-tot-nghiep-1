<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $service;
    public function __construct(){
        $this->service = new CartService();
    }

    public function index(){
        $title = "Giỏ hàng";
        $data = $this->service->getCart();
        $carts = $data['data'];
        $total = $data['total'];

        $getVouchers = $this->service->getVouchers();

        return view("client.cart.index",compact(["carts","getVouchers", "total",'title']));
    }



    public function addCart(Request $request){
        return $this->service->addCart($request);
    }

    public function updateCart(Request $request){
        return $this->service->updateCart($request);
    }

    public function deleteCart(Request $request){
        return $this->service->deleteCart($request);
    }

    public function checkVoucher(Request $request){
        return $this->service->checkVoucher($request);
    }
}
