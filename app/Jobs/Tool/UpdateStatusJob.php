<?php

namespace App\Jobs\Tool;

use App\Actions\Analytics\AnalyticsApi;
use App\Models\Company;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $carbon, $cabonFormat = "m-Y", $cacheTime = 60 * 60 * 24 * 15;

    /**
     *
     */
    public function __construct()
    {
        $this->afterCommit();
    }

    /**
     * @return void
     */
    public function handle()
    {
        if (optional($this->batch())->canceled()) {
            // optionally perform some clean up if necessary
            return;
        }
        $this->carbon = now();
        foreach (Company::all() as $company) {
            $this->company($company->id);
        }
        $this->getAll();
    }

    /**
     * @return void
     */
    protected function getAll()
    {
        $this->cached(
            function () {
                return (new AnalyticsApi(now()))->countAll()->getData();
            }
        );
    }


    /**
     * @param $id
     * @return void
     */
    protected function company($id)
    {
            $this->cached(function () use ($id) {
                return (new AnalyticsApi(now(), $id))->countAll()->getData();
            }, $id);
    }



    /**
     * @param $cacheThis
     * @param $op
     * @return mixed
     */
    private function cached($cacheThis, $op = 'all')
    {
        return Cache::rememberForever('analytics:' . $op . ':' . $this->carbon->format($this->cabonFormat), $cacheThis);
    }
}
