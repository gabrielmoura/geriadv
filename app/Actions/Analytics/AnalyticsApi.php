<?php

namespace App\Actions\Analytics;

use App\Models\Benefits;
use App\Models\Calendar;
use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnalyticsApi
{
    /**
     * @var Carbon
     */
    private Carbon $now;
    /**
     * @var Collection
     */
    private Collection $out;
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    /**
     * @var Calendar|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    /**
     * @var Calendar|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private $clients, $appointments, $benefits;
    /**
     * @var Benefits[]|Calendar[]|Clients[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|Collection
     */
    private $getClient;

    /**
     * @param Carbon $now
     * @param int $company_id
     */
    public function __construct(Carbon $now, int $company_id = 0)
    {
        $this->now = $now;
        $this->out = collect([]);

        $this->clients = Clients::with(['benefit', 'recommendation']);

        $this->appointments = Calendar::whereMonth('created_at', '=', $now->month);
        $this->benefits = Benefits::with(['clients']);

        $this->getClient = $this->clients
            ->whereMonth('created_at', '=', $this->now->month)->get();

        if ($company_id !== 0) {
            $this->clients->where('company_id', $company_id);
            $this->appointments->where('company_id', $company_id);
            $this->benefits->where('company_id', $company_id);
        }

    }


    /**
     * @return $this
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function countAll()
    {
        try {
            $this->recommendationCount()
                ->benefitsCount()
                ->lastCount()
                ->clientCount()
                ->newEntryCount()
                ->appointmetCount()
                ->amoutCount()
                ->statusCount();
        } finally {
            return $this;
        }
    }


    /**
     * @return $this
     */
    public function clientCount()
    {
        //  "client_count": 0,
        try {
            $this->out->put('client_count', $this->clients->count());
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }

    }


    /**
     * @return $this
     */
    public function statusCount()
    {
        try {
            $status = collect();
            foreach ($this->getClient as $client) {
                foreach ([
                             'analysis', //Analise
                             'rejected', //Indeferido
                             'deferred', //Deferido
                             'called_off', //Cancelado
                             'cancellation', //Cancelamento
                             'deceased', //Falecido
                             'requirement'//Exigência
                         ] as $item){
                    $status->put($item, $client->status()->whereStatus($item)->count());
                }
            }
            $this->out->put('status_count', $status);
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }

    }

    /**
     * @return $this
     */
    public function newEntryCount()
    {
        try {
            $this->out->put('new_entry', $this->getClient->count());
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }

    }

    /**
     * @return $this
     */
    public function appointmetCount()
    {
//    "calendar_count": 0,
        try {
            $this->out->put('calendar_count', $this->appointments->count());
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }
    }

    /**
     * @return $this
     */
    public function amoutCount()
    {
        try {
            $amountCount = 0;
            foreach ($this->getClient as $all) {
                $amountCount += calculateAmount($all->benefit->first());
            }
            $this->out->put('amount_count', $amountCount);
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }


    }

    /**
     * @return $this
     */
    public function lastCount()
    {
//    "last_count": "12-2020",

        try {
            $this->out->put('last_count', $this->now->format('m-Y'));
        } finally {
            return $this;
        }
    }

    /**
     * @return $this
     * @throws \Laravel\Octane\Exceptions\DdException
     */
    public function benefitsCount()
    {
        try {
            $benefits = collect();
            foreach ($this->benefits->get() as $all) {
                $benefits->put($all['name'], $all->clients()->whereMonth('created_at', $this->now->month)->count());
            }
            $this->out->put('benefits', $benefits);
        } catch (\Throwable $throwable) {

        } finally {
            return $this;
        }
    }

    /**
     * @return $this
     */
    public function recommendationCount()
    {
        try {
            $countName = collect();
            foreach ($this->getClient as $client) {
                if (isset($client->recommendation)) {
                    $name = $client->recommendation->first()->name ?? '';
                    if ($countName->has($name)) {
                        $countName[$name] += 1;
                    } else {
                        $countName[$name] = 1;
                    }
                }
            }
            $this->out->put('recommendations', $countName ?? []);
        } catch (\Throwable $throwable) {
        } finally {
            return $this;
        }
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public final function getData()
    {
        return $this->out;
    }

}
