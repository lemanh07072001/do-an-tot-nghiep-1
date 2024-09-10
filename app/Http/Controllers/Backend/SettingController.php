<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new SettingService();
    }

    public function index()
    {

        $settings = $this->service->getAllSettings();
        return view('backend.setting.index',compact(['settings']));
    }

    public function updateOrCreate(Request $request){
        return $this->service->updateOrCreate($request);
    }

    public function getUrlLogo(){

    }
}
