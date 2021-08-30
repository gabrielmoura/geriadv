<?php

namespace App\Http\Controllers\PublicControllers;

use App\Http\Controllers\Controller;
use App\Models\Documentos;
use App\Models\View\ClientOrderView;
use Illuminate\Support\Facades\Response;

class ExportOrder extends Controller
{


    public function index($reference)
    {
        return ClientOrderView::where('reference',$reference)->get();
    }
}
