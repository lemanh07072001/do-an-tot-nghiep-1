<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\ProductesService;
use Illuminate\Http\Request;

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
        $getAllBrandSelect = $this->service->getAllBrandSelect();
        $getAllLabelSelect = $this->service->getAllLabelSelect();
        return view('backend.products.create', compact(['getCategoriesSelect','getAllBrandSelect','getAllLabelSelect']));
    }
}
