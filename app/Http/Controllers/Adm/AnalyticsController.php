<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Models\ClientStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $statusM = collect();   //Precisa ser collect

        $benefits = collect();    //Pode ser array
        $month = Carbon::now()->subMonth()->month;
        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example

        //  Quantidade de Clientes no mes
        $statusM['client_count'] = Clients::whereMonth(
            'created_at', '=', $month
        )->where('company_id', '=', session()->get('company_id'))->count();


        //  Multiplica valor pelo multiplicador e retorna o valor a receber no mes.
        foreach (Clients::whereMonth('created_at', '=', $month)->where('company_id', '=', session()->get('company_id')) as $all) {
            $statusM['amount_count'] = (float)$all->benefit()->first()->wage * $all->benefit()->first()->wage_factor;
        }

        //  Em Exigência/analise no ultimo mes
        $statusM['requirement_count'] = ClientStatus::whereStatus('analysis')
            ->whereStatus('requirement')
            ->whereMonth('created_at', '=', $month)
            ->count();

        //  Deferidos do mes
        $statusM['deferred_count'] = ClientStatus::whereStatus('deferred')
            ->whereMonth('created_at', '=', $month)
            ->count();
        //Conta os agendamentos
        $statusM['calendar_count'] = Calendar::whereMonth('created_at', '=', $month)->where('company_id', '=', session()->get('company_id'))
            ->count();

        //Novas Entradas no mes
        /*      $statusM['new_entry']=Clients::whereStatus('analysis')->whereStatus('analysis')
                  ->whereMonth('created_at', '=', $month)->count();
      */
        //  Conta Clientes por beneficios no ultimo mes
        //foreach (Benefits::all() as $all) {
          //  $benefits[$all['name']] = $all->clients()->count();
        //}


        $status = collect()->merge(['monthly' => $statusM->merge(['benefits' => $benefits])]);

        return view('admin.analytics.index', compact('status'));
    }


    public function create()
    {
        $statusM = collect();   //Precisa ser collect
        $statusN = collect();
        $benefits = collect();    //Pode ser array
        $month = Carbon::now()->subMonth()->month;
        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example

        //  Quantidade de Clientes no mes
        $statusM['client_count'] = Clients::whereMonth(
            'created_at', '=', $month
        )->count();


        //  Multiplica valor pelo multiplicador e retorna o valor a receber no mes.
        foreach (Clients::whereMonth('created_at', '=', $month) as $all) {
            $statusM['amount_count'] = (float)$all->benefit()->first()->wage * $all->benefit()->first()->wage_factor;
        }

        //  Em Exigência/analise no ultimo mes
        $statusM['requirement_count'] = ClientStatus::whereStatus('analysis')
            ->whereStatus('requirement')
            ->whereMonth('created_at', '=', $month)
            ->count();

        //  Deferidos do mes
        $statusM['deferred_count'] = ClientStatus::whereStatus('deferred')
            ->whereMonth('created_at', '=', $month)
            ->count();
        //Conta os agendamentos
        $statusM['calendar_count'] = Calendar::whereMonth('created_at', '=', $month)
            ->count();

        //Novas Entradas no mes
        /*      $statusM['new_entry']=Clients::whereStatus('analysis')->whereStatus('analysis')
                  ->whereMonth('created_at', '=', $month)->count();
      */
        //  Conta Clientes por beneficios no ultimo mes
        foreach (Benefits::all() as $all) {
            $benefits[$all['name']] = $all->clients()->count();
        }


        $status = collect()->merge(['monthly' => $statusM->merge(['benefits' => $benefits])]);

        return view('admin.analytics.index', compact('status'));
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
