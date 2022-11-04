<?php

namespace App\Http\Controllers\Adm;

use App\Actions\Analytics\AnalyticsApi;
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
            $status = $this->cached(
                function () {
                    return (new AnalyticsApi(now()))->countAll()->getData();
                }
            );
        } else {
            $id = $this->getCompanyId();
            $status = $this->cached(
                function () use ($id) {
                    return (new AnalyticsApi(now(), $id))->countAll()->getData();
                }, $id);
        }

        return view('admin.analytics.index', compact('status'));
    }

    private function cached($cacheThis, $op = 'all')
    {
        return Cache::remember('analytics:' . $op . ':' . $this->carbon->format($this->cabonFormat), $this->cacheTime, $cacheThis);
    }

}
