<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\VoucherRequest;
use App\Services\Backend\VoucherService;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new VoucherService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.voucher.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.voucher.create');
    }

    public function store(VoucherRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Voucher $voucher)
    {
        return view('backend.voucher.edit', compact('voucher'));
    }


    public function update(VoucherRequest $request, Voucher $voucher)
    {
        return $this->service->update($request, $voucher);
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
