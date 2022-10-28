<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Models\DW\ClientAnalytics;
use App\Traits\CompanySessionTraits;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\LazyCollection;

/**
 * Class AnalyticsController
 * @package App\Http\Controllers\Adm
 */
class AnalyticsController extends Controller
{
    use CompanySessionTraits;

    protected $carbon, $cabonFormat = "m-Y", $cacheTime = 60 * 60 * 24 * 15;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->carbon = now();
        if ($this->hasRole('admin')) {
            $status = $this->admin();
        } else {
            $status = $this->manager();
        }
        dd(ClientAnalytics::all());
//        dd($status);
        return view('admin.analytics.index', compact('status'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function admin()
    {
        return $this->cached(
            $this->refreshMonth(
                Clients::with(['benefit', 'status', 'recommendation']),
                Calendar::whereMonth('created_at', '=', $this->carbon->month()),
                Benefits::all()
            )
        );
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function manager()
    {
        $id = $this->getCompanyId();
        return $this->cached(
            $this->refreshMonth(
                Clients::whereCompanyId($id)->with(['benefit', 'status', 'recommendation']),
                Calendar::whereCompanyId($id)->whereMonth('created_at', '=', $this->carbon->month()),
                Benefits::whereCompanyId($id)->with(['allClients'])->cursor()
            )
            , $id);
    }

    private function refreshMonth($maxClients, $maxCalendar, $allBenefit)
    {

        return   function()use ($maxClients, $maxCalendar, $allBenefit) {
            $month = $this->carbon->month();


            $statusM['deferred_count'] = 0;// Deferidos do mes
            $statusM['analysis_count'] = 0; // Em Analise do mês
            $statusM['requirement_count'] = 0;
            $statusM['amount_count'] = 0.00; // Calcula valor total a receber

            $countName = collect();

            foreach ($maxClients->get() as $all) {


                $statusM['amount_count'] += calculateAmount($all->benefit->first());
                $statusM['deferred_count'] += $all->status()->whereStatus('deferred')->count();
                $statusM['analysis_count'] += $all->status()->whereStatus('analysis')->count();
                $statusM['requirement_count'] += $all->status()->whereStatus('analysis')->whereStatus('requirement')->count();

//            if (isset($all->recommendation)) {

                if ($countName->has($all->recommendation->first()->name)) {
                    $countName[$all->recommendation->first()->name] += 1;
                } else {
                    $countName->put($all->recommendation->first()->name, 1);
                }
//            }

            }


            // Conta Clientes por beneficios no mes
            $benefits = [];

            foreach ($allBenefit as $all) {
                $benefits[$all->name] = $all->allClients->count();
            }


            $statusM['recommendations'] = $countName ?? [];

            return Collection::make($statusM)->put('client_count', $maxClients->count())
                ->put('new_entry', $maxClients->whereMonth('created_at', $month)->count())
                ->put('last_count', $this->carbon->format($this->cabonFormat))
                ->put('calendar_count', $maxCalendar->count())
                ->put('benefits', $benefits);

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
