<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\ClientView;
use Illuminate\Http\Request;

class ClientApiController extends Controller
{
    public function index()
    {
        return ClientView::all();
    }
    public function show($id){
        return Clients::find($id);
    }
}
