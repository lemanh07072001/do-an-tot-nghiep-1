<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ClientRequest;
use App\Models\Client;
use App\Services\Backend\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ClientService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.client.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.client.create');
    }

    public function store(ClientRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(Client $client)
    {

        return view('backend.client.edit', compact('client'));
    }


    public function update(ClientRequest $request, Client $client)
    {
        return $this->service->update($request, $client);
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
