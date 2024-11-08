<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\AboutPageService;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    protected $service;

    public function __construct(){
        $this->service = new AboutPageService();
    }

    public function index(Request $request){
        $title = 'Giới thiệu';
        $getData = $this->service->getAboutPage();
        return view("client.aboutPage.index",compact(['getData','title']));
    }
}
