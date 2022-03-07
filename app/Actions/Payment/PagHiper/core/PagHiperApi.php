<?php

namespace App\Actions\Payment\PagHiper\core;

use Illuminate\Http\Client\Factory as HttpKernel;

abstract class PagHiperApi
{
    protected $config;
    protected \Illuminate\Http\Client\PendingRequest $api;
    protected \Illuminate\Http\Client\PendingRequest $pix;

    public function __construct($config, HttpKernel $http)
    {
        $this->config = $config;
        $api = $http->withHeaders([
            'Accept' => 'application/json',
            'Accept-Charset' => 'UTF-8',
            'Accept-Encoding' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $this->api = $api->baseUrl('https://api.paghiper.com/');
        $this->pix = $api->baseUrl('https://pix.paghiper.com/');
        //  transaction/create/
    }
}
