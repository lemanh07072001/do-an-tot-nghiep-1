<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\GroupProductRequest;
use App\Models\GroupProduct;
use App\Services\Backend\GroupProductService;
use Illuminate\Http\Request;

class GroupProductController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new GroupProductService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.groupProduct.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.groupProduct.create');
    }

    public function store(GroupProductRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(GroupProduct $groupProduct)
    {
        $getGroupProduct = $this->service->getGroupProduct($groupProduct);

        return view('backend.groupProduct.edit', compact(['groupProduct','getGroupProduct']));
    }


    public function update(GroupProductRequest $request, GroupProduct $groupProduct)
    {
        return $this->service->update($request, $groupProduct);
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

    public function getAllProducts(){
        return $this->service->getAllProducts();
    }

    public function searchProduct(Request $request){
        return $this->service->searchProduct($request);
    }
}
