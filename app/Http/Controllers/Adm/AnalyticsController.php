<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Clients;
use App\Models\ClientStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {

        $clients = Clients::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        );
        //$clients->count(); //Quantidade de clientes no mes

        $status = ClientStatus::whereStatus('analysis')
            ->whereStatus('requirement')
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
        //$status->count(); //Quantidade de Analises e Exigências

        $benefits = Benefits::whereMonth('created_at', '=', Carbon::now()->subMonth()->month);
        //$benefitsTotal = $benefits->count(); //Quantidade total de Beneficios


        return view('admin.index', compact('clients', 'status', 'benefits'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
