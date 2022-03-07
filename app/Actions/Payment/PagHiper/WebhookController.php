<?php

namespace App\Actions\Payment\PagHiper;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service=new \WebMaster\PagHiper\PagHiper('api_key', 'token');
    }


    /**
     * @param Request $request
     * @return array
     * @throws \WebMaster\PagHiper\Core\Exceptions\PagHiperException
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();
        return $this->service->notification()->response($request->notification_id,$request->idTransacao);
    }
}
