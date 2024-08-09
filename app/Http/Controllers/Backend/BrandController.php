<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\BrandService;
use App\Http\Requests\Backend\BrandRequest;

class BrandController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new BrandService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.brand.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(BrandRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Brand $brand)
    {

        return view('backend.brand.edit', compact('brand'));
    }


    public function update(BrandRequest $request, Brand $brand)
    {
        return $this->service->update($request, $brand);
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
