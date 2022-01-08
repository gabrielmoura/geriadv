<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Traits\CompanySessionTraits;
use Illuminate\Support\Carbon;

/**
 * Class AnalyticsController
 * @package App\Http\Controllers\Adm
 */
class AnalyticsController extends Controller
{
    use CompanySessionTraits;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if ($this->hasRole('admin')) {
            return $this->admin();
        } else {
            return $this->manager();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function admin()
    {
        $statusM = [];
        $status = collect();
        $client_count = Clients::all()->count();
        $range = [
            'now' => Carbon::now()->month,
            'monthly' => Carbon::now()->subMonth()->month
        ];

        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example
        $maxClients = Clients::with(['benefit', 'status', 'recommendation']);
        foreach ($range as $index => $month) {
            // Quantidade de Clientes no mes
            $clients = $maxClients->whereMonth('created_at', '=', $month)->get();


            $statusM['client_count'] = $client_count; // Quantidade total de Clientes
            $statusM['deferred_count'] = 0;// Deferidos do mes
            $statusM['analysis_count'] = 0; // Em Analise do mês
            $statusM['requirement_count'] = 0;
            $statusM['amount_count'] = 0.00; // Calcula valor total a receber
            foreach ($clients as $all) {
                $statusM['amount_count'] += calculateAmount($all->benefit->first());
                $statusM['deferred_count'] += $all->status->whereStatus('deferred')->count();
                $statusM['analysis_count'] += $all->status->whereStatus('analysis')->count();
                $statusM['requirement_count'] += $all->status->whereStatus('analysis')->whereStatus('requirement')->count();
            }


            // Conta os agendamentos do mês
            $statusM['calendar_count'] = Calendar::whereMonth('created_at', '=', $month)
                ->count();


            // Novas Entradas no mes
            $statusM['new_entry'] = $clients->count();

            // Conta Clientes por beneficios no mes
            $statusM['benefits'] = [];
            $allBenefit = Benefits::all();
            foreach ($allBenefit as $all) {
                $statusM['benefits'] = [$all['name'] => $all->clients()->whereMonth('created_at', '=', $month)
                    ->count()];
            }

            // Conta Indicação
            $countName = collect();
            foreach ($clients as $client) {
                if ($countName->has($client->recommendation->first()->name)) {
                    $countName[$client->recommendation->first()->name] += 1;
                } else {
                    $countName[$client->recommendation->first()->name] = 1;
                }

            }
            $statusM['recommendations'] = $countName ?? [];

            // Associa Calculos ao Mẽs
            $status[$index] = $statusM;
        }
        return view('admin.analytics.index', compact('status', 'range'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function manager()
    {
        $statusM = [];
        $status = collect();
        $companyId = $this->getCompanyId();
        $client_count = Clients::whereCompanyId($companyId)->count();
        $range = [
            'now' => Carbon::now()->month,
            'monthly' => Carbon::now()->subMonth()->month
        ];

        //https://hdtuto.com/article/laravel-eloquent-eager-load-count-relation-example
        $maxClients = Clients::with(['benefit', 'status', 'recommendation']);
        foreach ($range as $index => $month) {
            // Quantidade de Clientes no mes
            $clients = $maxClients->whereCompanyId($companyId)->whereMonth('created_at', '=', $month)->get();

            // Quantidade total de Clientes
            $statusM['client_count'] = $client_count;


            // Calcula valor total a receber
            $statusM['amount_count'] = 0.00;
            // Deferidos do mes
            $statusM['deferred_count'] = 0;
            // Em Analise do mês
            $statusM['analysis_count'] = 0;
            $statusM['requirement_count'] = 0;
            foreach ($clients as $all) {
                $statusM['amount_count'] += calculateAmount($all->benefit->first());
                $statusM['deferred_count'] += $all->status->whereStatus('deferred')->count();
                $statusM['analysis_count'] += $all->status->whereStatus('analysis')->count();
                $statusM['requirement_count'] += $all->status->whereStatus('analysis')->whereStatus('requirement')->count();
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
                if ($countName->has($client->recommendation->first()->name)) {
                    $countName[$client->recommendation->first()->name] += 1;
                } else {
                    $countName[$client->recommendation->first()->name] = 1;
                }

            }
            $statusM['recommendations'] = $countName ?? [];

            // Associa Calculos ao Mẽs
            $status[$index] = $statusM;
        }

        return view('admin.analytics.index', compact('status', 'range'));
    }

}
