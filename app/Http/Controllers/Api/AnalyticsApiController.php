<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Actions\Analytics\AnalyticsApi;
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
                function () {
                    return (new AnalyticsApi(now()))->countAll()->getData();
                }
            )
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function company($id, Request $request)
    {
        $pid = ($request->user()->hasRole('admin')) ? $id : $request->user()->company()->id;
        $this->carbon = now();
        return $this->try(
            $this->cached(function () use ($pid) {
                return (new AnalyticsApi(now(), $pid))->countAll()->getData();
            }
                , $pid)
        );
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
