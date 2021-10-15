<?php

namespace App\Http\Controllers;

use App\Abstraction\Pay;
use App\Models\Carousel;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('welcome');
    }

}
