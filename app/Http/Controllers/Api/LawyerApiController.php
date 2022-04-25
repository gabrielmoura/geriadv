<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class LawyerApiController extends Controller
{
    public function index()
    {
        return Lawyer::all();
    }

    public function show($id)
    {
        return Lawyer::find($id);
    }
}
