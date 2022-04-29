<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Models\Company;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class AnalyticsApiController extends Controller
{
    protected $carbon, $cabonFormat = "m-Y", $cacheTime = 60 * 60 * 24 * 15;
    use ApiTrait;


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->carbon = now();
        return $this->try(
            $this->cached(
                $this->refreshMonth(
                    Clients::with(['benefit', 'status', 'recommendation']),
                    Calendar::whereMonth('created_at', '=', $this->carbon->month()),
                    Benefits::all()
                )
            )
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function company($id)
    {
        $this->carbon = now();
        return $this->try(
            $this->cached(
                $this->refreshMonth(
                    Clients::where('company_id', $id)->with(['benefit', 'status', 'recommendation']),
                    Calendar::where('company_id', $id)->whereMonth('created_at', '=', $this->carbon->month()),
                    Benefits::where('company_id', $id)->get()
                )
                , $id)
        );
    }

    /**
     * @param $maxClients
     * @param $maxCalendar
     * @param $allBenefit
     * @return \Closure
     */
    private function refreshMonth($maxClients, $maxCalendar, $allBenefit)
    {
        $month = $this->carbon->month();

        return function () use ($month, $maxClients, $maxCalendar, $allBenefit) {
            // Quantidade de Clientes no mes
            $clients = $maxClients->whereMonth('created_at', '=', $month)->get();
            $statusM['client_count'] = $maxClients->count();

            $statusM['last_count'] = $this->carbon->format($this->cabonFormat);// Data da ultima contagem
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
            $statusM['calendar_count'] = $maxCalendar->count();


            // Novas Entradas no mes
            $statusM['new_entry'] = $clients->count();

            // Conta Clientes por beneficios no mes
            $statusM['benefits'] = [];

            foreach ($allBenefit as $all) {
                $statusM['benefits'] = [$all['name'] => $all->clients()->whereMonth('created_at', '=', $month)
                    ->count()];
            }

            // Conta Indicação
            $countName = collect();
            foreach ($clients as $client) {
                if (isset($client->recommendation)) {
                    if ($countName->has($client->recommendation->first()->name ?? '')) {
                        $countName[$client->recommendation->first()->name] += 1;
                    } else {
                        $countName[$client->recommendation->first()->name] = 1;
                    }
                }
            }
            $statusM['recommendations'] = $countName ?? [];
            return $statusM;
        };
    }

    /**
     * @param $cacheThis
     * @param $op
     * @return mixed
     */
    private function cached($cacheThis, $op = 'all')
    {
        return Cache::remember('analytics:' . $op . ':' . $this->carbon->format($this->cabonFormat), $this->cacheTime, $cacheThis);
    }
}
