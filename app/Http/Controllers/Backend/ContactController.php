<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\ContactService;

class ContactController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ContactService();
    }

    public function index()
    {

        return view('backend.contact.index');
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.contact.create');
    }

    public function getMessage(Request $request)
    {
        return $this->service->getMessage($request);
    }

    public function sendMessage(Request $request)
    {
        return $this->service->sendMessage($request);
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
