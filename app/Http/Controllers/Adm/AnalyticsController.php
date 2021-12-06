<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Models\ClientStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{

    public function indexV2()
    {
        $statusM = collect();   //Precisa ser collect

        $benefits = collect();    //Pode ser array
        $month = Carbon::now()->subMonth()->month;
        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example

        //  Quantidade de Clientes no mes
        $statusM['client_count'] = Clients::whereMonth(
            'created_at', '=', $month
        )->where('company_id', '=', session()->get('company.id'))->count();


        //  Multiplica valor pelo multiplicador e retorna o valor a receber no mes.
        foreach (Clients::whereMonth('created_at', '=', $month)->where('company_id', '=', session()->get('company.id')) as $all) {
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
        $statusM['calendar_count'] = Calendar::whereMonth('created_at', '=', $month)->where('company_id', '=', session()->get('company.id'))
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
        dd($status);

        return view('admin.analytics.index', compact('status'));
    }

    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return $this->admin();
        } else {
            return $this->manager();
        }
    }

    public function admin()
    {
        $statusM = collect();   //Precisa ser collect
        $statusN = collect();
        $benefits = collect();    //Pode ser array
        $range = [
            'now' => Carbon::now()->month,
            'monthly' => Carbon::now()->subMonth()->month
        ];

        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example
        foreach ($range as $index => $month) {


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
            $statusM['new_entry'] = Clients::whereMonth('created_at', '=', $month)->count();

            //  Conta Clientes por beneficios no ultimo mes
            foreach (Benefits::all() as $all) {

                $benefits[$all['name']] = $all->clients()->count();
            }
            $status[$index] = $statusM->merge(['benefits' => $benefits]);
        }
        //$status = collect()->merge(['monthly' => $statusM->merge(['benefits' => $benefits])]);


        return view('admin.analytics.index', compact('status'));
    }

    public function manager()
    {
        $statusM = [];
        $status = collect();
        $companyId = session()->get('company.id');
        $client_count = Clients::whereCompanyId($companyId)->count();
        $range = [
            'now' => Carbon::now()->month,
            'monthly' => Carbon::now()->subMonth()->month
        ];

        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example
        foreach ($range as $index => $month) {
            // Quantidade de Clientes no mes
            $clients = Clients::whereCompanyId($companyId)->whereMonth('created_at', '=', $month)->get();

            // Quantidade total de Clientes
            $statusM['client_count'] = $client_count;


            // Calcula valor total a receber
            $statusM['amount_count'] = 0.00;
            foreach ($clients as $all) {
                $statusM['amount_count'] += calculateAmount($all->benefit()->first());
            }


            // Deferidos do mes
            $statusM['deferred_count'] = 0;
            foreach ($clients as $all) {
                $statusM['deferred_count'] += $all->status()->whereStatus('deferred')->count();
            }
            // Em Analise do mês
            $statusM['analysis_count'] = 0;
            foreach ($clients as $all) {
                $statusM['analysis_count'] += $all->status()->whereStatus('analysis')->count();
            }

            $statusM['requirement_count'] = 0;
            foreach ($clients as $all) {
                $statusM['requirement_count'] += $all->status()->whereStatus('analysis')->whereStatus('requirement')->count();
            }


            // Conta os agendamentos do mês
            $statusM['calendar_count'] = Calendar::whereCompanyId($companyId)
                ->whereMonth('created_at', '=', $month)
                ->count();


            // Novas Entradas no mes
            $statusM['new_entry'] = $clients->count();

            // Conta Clientes por beneficios no mes
            $statusM['benefits'] = [];
            foreach (Benefits::whereCompanyId($companyId)->get() as $all) {
                $count = 0;
                foreach ($all->clients()->whereCompanyId($companyId)->whereMonth('created_at', '=', $month)
                             ->get() as $tt) {
                    $count += 1;
                }
                $statusM['benefits'] = [$all['name'] => $count];
            }

            // Conta Indicação
            $countName = collect();
            foreach ($clients as $client) {
                if ($countName->has($client->recommendation()->first()->name)) {
                    $countName[$client->recommendation()->first()->name] += 1;
                } else {
                    $countName[$client->recommendation()->first()->name] = 1;
                }

            }
            $statusM['recommendations'] = $countName ?? [];

            // Associa Calculos ao Mẽs
            $status[$index] = $statusM;
        }

        return view('admin.analytics.index', compact('status', 'range'));
    }

}
