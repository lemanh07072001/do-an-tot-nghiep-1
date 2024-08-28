<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Backend\TransactionService;

class TransactionController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new TransactionService();
    }

    public function index()
    {
        return view('backend.transaction.index');
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function getTransactionById(Request $request){
        return $this->service->getTransactionById($request);
    }

    public function createTransaction(Request $request){
        return $this->service->createTransaction($request);
    }

    public function exportTransaction(Request $request){
        return $this->service->exportTransaction($request);
    }
}
