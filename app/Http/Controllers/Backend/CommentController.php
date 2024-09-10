<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\Backend\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CommentService();
    }

    public function index()
    {
        $getAllUsersSelect = $this->service->getAllUsersSelect();
        return view('backend.comment.index', compact('getAllUsersSelect'));
    }

    public function getData(Request $request)
    {
        return $this->service->getData($request);
    }

    public function create()
    {
        return view('backend.comment.create');
    }

}
