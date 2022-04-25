<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployerApiController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function show($id)
    {
        return Employee::find($id);
    }
}
