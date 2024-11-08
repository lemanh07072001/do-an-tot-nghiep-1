<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $service;
    public function __construct(){
        $this->service = new ProfileService();
    }
    public function showTabs(Request $request){
        $title = 'Thông tin tài khoản';

        $activeTab = $this->service->showTabs($request);
        $getOders = $this->service->getOders($request);
        $getProfile = $this->service->getProfile();

        return view('client.profile.index',compact(['activeTab', 'getOders', 'getProfile','title']));
    }

    public function changePassword(Request $request){
        return $this->service->changePassword($request);
    }
}
