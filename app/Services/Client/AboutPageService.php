<?php

namespace App\Services\Client;

use App\Models\Introduce;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AboutPageService
{
    public function getAboutPage(){
        return Introduce::first();
    }
}
