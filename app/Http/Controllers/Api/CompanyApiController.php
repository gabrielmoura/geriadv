<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyApiController extends Controller
{
    public function index()
    {
        return Company::all();
    }
    public function show($id){
        return Company::find($id);
    }
}
