<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\UserOrder as Order;

class HomeAdmController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
}
