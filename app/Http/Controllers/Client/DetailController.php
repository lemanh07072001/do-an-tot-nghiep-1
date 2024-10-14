<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\DetailService;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    protected $service;

    public function __construct(){
        $this->service = new DetailService();
    }

    public function detail($slug){
        $firstCategories = $this->service->getFirstCategories($slug);
        return view('client.detail.firstProductCategories',compact('firstCategories'));
    }

    public function getProducts(Request $request){
        return $this->service->getProducts($request);
    }

    public function allProductCategories(){

        $title = "Tất cả sản phẩm";
        return view('client.detail.getAllProducts', compact(['title']));
    }

    public function allProductCategoriesAjax(Request $request){
        return $this->service->getAllProduct($request);
    }

    public function allGroupProduct($slug) {
        $nameGroupProduct = $this->service->getNameGroupProduct($slug);
        return view('client.detail.detailGroupProducts',compact(['nameGroupProduct']));
    }

    public function getGroupProductAjax(Request $request){
        return $this->service->getGroupProductAjax($request);
    }


    public function getFirstCategories($slug)
    {
        $getFirstCategories = $this->service->getFirstCategorie($slug);
        return view('client.detail.detailCategories', compact(['getFirstCategories']));
    }

    public function getFirstCategoriesAjax(Request $request)
    {
        return $this->service->getFirstCategoriesAjax($request);
    }

    public function firstProduct($slug){
        $getFirstProduct = $this->service->getFirstProduct($slug);
        $title = 'Nhóm sản phẩm';
        return view('client.detail.detailProduct',compact(['getFirstProduct','title']));
    }


}
