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
        $title = $firstCategories->name;

        return view('client.detail.firstProductCategories',compact(['firstCategories','title']));
    }

    public function getProducts(Request $request){
        return $this->service->getProducts($request);
    }

    public function allProductCategories(){

        $title = "Cửa hàng";
        return view('client.detail.getAllProducts', compact(['title']));
    }

    public function allProductCategoriesAjax(Request $request){
        return $this->service->getAllProduct($request);
    }

    public function allGroupProduct($slug) {
        $nameGroupProduct = $this->service->getNameGroupProduct($slug);
        $title = $nameGroupProduct->name;

        return view('client.detail.detailGroupProducts',compact(['nameGroupProduct','title']));
    }

    public function getGroupProductAjax(Request $request){
        return $this->service->getGroupProductAjax($request);
    }


    public function getFirstCategories($slug)
    {
        $getFirstCategories = $this->service->getFirstCategorie($slug);

        $title = $getFirstCategories->name;

        return view('client.detail.detailCategories', compact(['getFirstCategories','title']));
    }

    public function getFirstCategoriesAjax(Request $request)
    {
        return $this->service->getFirstCategoriesAjax($request);
    }

    public function firstProduct($slug){
        $dataService = $this->service->getFirstProduct($slug);

        $getFirstProduct = $dataService['product'];
        $imageArray = $dataService['imageArray'];
        $dataAttribute = $dataService['attributes'];

        $title = $getFirstProduct->name;

        return view('client.detail.detailProduct',compact(['getFirstProduct', 'imageArray', 'dataAttribute','title']));
    }

    public function getAttributeAjax(Request $request){
        return $this->service->getAttributeAjax($request);
    }


}
