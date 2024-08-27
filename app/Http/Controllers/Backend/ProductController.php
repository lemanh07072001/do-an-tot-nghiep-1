<?php

namespace App\Http\Controllers\Backend;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\ProductesService;
use App\Http\Requests\Backend\ProductRequest;

class ProductController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductesService();
    }

    public function index()
    {
        return view('backend.products.index');
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        $getCategoriesSelect = $this->service->getCategoriesSelect();
        $getAllLabelSelect = $this->service->getAllLabelSelect();
        $getAllProperties = $this->service->getPropertiesSelectByParent();
        return view('backend.products.create', compact(['getCategoriesSelect', 'getAllLabelSelect', 'getAllProperties']));
    }

    public function store(ProductRequest $request){
        return $this->service->store($request);
    }

    public function edit(Products $products){
        $getCategoriesSelect = $this->service->getCategoriesSelect();
        $getAllLabelSelect = $this->service->getAllLabelSelect();
        $getAllProperties = $this->service->getPropertiesSelectByParent();
        return view('backend.products.edit', compact(['getCategoriesSelect', 'getAllLabelSelect', 'getAllProperties','products']));
    }

    public function update(ProductRequest $request,Products $products){
        return $this->service->update($request,$products);
    }


    public function getChildrenProperties(Request $request)
    {
        return $this->service->getChildrenProperties($request);
    }

    public function getAttributeAjax(Request $request){
        return $this->service->getAttributeAjax($request);
    }


    public function toggleStatus(Request $request)
    {
        return $this->service->toggleStatus($request);
    }

    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }


    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }


}
