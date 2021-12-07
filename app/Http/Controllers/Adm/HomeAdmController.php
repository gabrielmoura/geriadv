<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;

class HomeAdmController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
}
