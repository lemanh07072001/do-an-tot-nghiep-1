<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Backend\RoleService;

class RoleController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new RoleService();
    }
    public function index(){

        return view('backend.roles.index');
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create(Request $request){

        $getPermission = $this->service->getPermission($request);

        return view('backend.roles.create',compact('getPermission'));
    }

    public function store(Request $request){
        return $this->service->store($request);
    }

    public function edit(Role $role , Request $request)
    {
        $getPermission = $this->service->getPermission($request);
        return view('backend.roles.edit', compact(['getPermission','role']));
    }

    public function deleteRow(Request $request){
        return $this->service->deleteRow($request);
    }

    public function deleteAll(Request $request)
    {
        return $this->service->deleteAll($request);
    }
}
