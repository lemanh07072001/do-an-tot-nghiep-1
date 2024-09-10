<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PolicyRequest;
use App\Models\Policy;
use App\Services\Backend\PolicyService;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new PolicyService();
    }

    public function index()
    {

        return view('backend.policy.index');
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.policy.create');
    }

    public function store(PolicyRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Policy $policy)
    {

        return view('backend.policy.edit', compact('policy'));
    }


    public function update(PolicyRequest $request, Policy $policy)
    {
        return $this->service->update($request, $policy);
    }

    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }


    public function deleteRow(Request $request)
    {
        return $this->service->deleteRow($request);
    }

    public function uploadImage(Request $request){
        return $this->service->uploadImage($request);
    }

    public function processContent(Request $request){
        return $this->service->processContent($request);
    }
}
