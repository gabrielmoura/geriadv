<?php

namespace App\Http\Controllers\Adm;

use App\Actions\Payment\PagHiper\Billets;
use App\Http\Controllers\Controller;
use App\Jobs\Client\CreateBilletClientJob;
use App\Models\Clients;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PaymentController extends Controller
{
    use CompanySessionTraits;


    public function index(\Illuminate\Http\Request $request)
    {
        return response()->json(['create_billet'=>route('admin.billet.create'),
            'create_cc'=>null],200);
    }

}
