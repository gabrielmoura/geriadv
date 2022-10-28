<?php

namespace App\Jobs\Company;

use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use App\Models\Company;
use App\Models\DW\ClientAnalytics;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;

class ClientAnalyticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * @return void
     */
    public function handle()
    {
        $companies = LazyCollection::make(Company::all());
        foreach ($companies as $company) {
            $this->saveDw(
                $this->format(
                    $company->id,
                    Clients::whereCompanyId($company->id)->with(['benefit', 'status', 'recommendation']),
                    Calendar::whereCompanyId($company->id)->whereMonth('created_at', '=', now()->month),
                    Benefits::whereCompanyId($company->id)->with(['allClients'])->cursor()
                )
            );
        }
    }


    protected function format($company_id, $clients, $calendar, $allBenefits): Collection
    {
        $month = now()->month;
        $statusM['deferred_count'] = 0;// Deferidos do mes
        $statusM['analysis_count'] = 0; // Em Analise do mês
        $statusM['requirement_count'] = 0;
        $statusM['amount_count'] = 0.00; // Calcula valor total a receber
        $sex_count['m'] = 0;
        $sex_count['f'] = 0;

        $countName = collect();

        foreach ($clients->get() as $all) {
            $sex_count['m'] += $all->sex == 'm' ? 1 : 0;
            $sex_count['f'] += $all->sex == 'f' ? 1 : 0;
            $statusM['amount_count'] += calculateAmount($all->benefit->first());
            $statusM['deferred_count'] += $all->status()->whereStatus('deferred')->count();
            $statusM['analysis_count'] += $all->status()->whereStatus('analysis')->count();
            $statusM['requirement_count'] += $all->status()->whereStatus('analysis')->whereStatus('requirement')->count();


            if ($countName->has($all->recommendation?->first()?->name)) {
                $countName[$all->recommendation->first()->name] += 1;
            } else {
                $countName->put($all->recommendation->first()->name, 1);
            }


        }


        $benefits = [];

        foreach ($allBenefits as $all) {
            $benefits[$all->name] = $all->allClients->count();
        }

        $statusM['recommendations'] = $countName ?? [];

        return Collection::make($statusM)->put('client_count', $clients->count())
            ->put('new_entry', $clients->whereMonth('created_at', $month)->count())
            //->put('last_count', $this->carbon->format($this->cabonFormat))
            ->put('calendar_count', $calendar->count())
            ->put('benefits', $benefits)
            ->put('company_id', $company_id)
            ->put('sex_count', $sex_count);
    }


    /**
     * @param Collection $data
     * @return ClientAnalytics|\Illuminate\Database\Eloquent\Model
     */
    protected function saveDw(Collection $data)
    {
        return ClientAnalytics::create($data->toArray());
    }
}
