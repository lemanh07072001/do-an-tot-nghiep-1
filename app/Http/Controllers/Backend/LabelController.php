<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LabelRequest;
use App\Models\Label;
use App\Services\Backend\LabelService;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new LabelService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.label.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.label.create');
    }

    public function store(LabelRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Label $label)
    {
        return view('backend.label.edit', compact('label'));
    }


    public function update(LabelRequest $request, Label $label)
    {
        return $this->service->update($request, $label);
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
