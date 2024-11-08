<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\IntroduceService;

class IntroduceController extends Controller
{
    protected $service;

    public function __construct(){
        $this->service = new IntroduceService();
    }

    public function index(){
        $getData = $this->service->getData();
        return view("backend.introduce.index",compact('getData'));
    }

    public function uploadImage(Request $request){
        return $this->service->uploadImage($request);
    }

    public function store(Request $request){
        return $this->service->store($request);
    }
}
