<?php

namespace App\Jobs\Client;

use App\Events\Client\BirthdayCustomerEvent;
use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Este deverá buscar aniverssário dos clientes
 * Class BirthdayCustomerJob
 * @package App\Jobs\Client
 */
class BirthdayCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Idade Minima
     * @var array|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected array $age;
    /**
     * Tempo Minimo
     * @var array|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected array $time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->age = config('core.minimum.age_to_retire');
        $this->time = config('core.minimum.contribution_time');
    }

    public function handle()
    {
        try {
            foreach (Clients::all() as $client) {
                $years = Carbon::parse($client->birth_date)->diffInYears(Carbon::now());
                if ($years >= $this->age['m'] || $years >= $this->age['f']) {
                    event(new BirthdayCustomerEvent($client));
                }
            }

        } catch (\Exception $e) {
        }
    }
}
