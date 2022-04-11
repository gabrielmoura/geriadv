<?php

namespace App\Http\Controllers;

use App\Actions\Payment\PagHiper\Billets;
use App\Jobs\Client\CreateBilletClientJob;
use App\Models\Clients;
use App\Models\Invoice;
use App\Traits\CompanySessionTraits;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

/**
 *  Gerir pagamentos das Empresas
 */
class PaymentController extends Controller
{
   public function __construct()
   {
       $this->middleware('role:admin');
   }
}
