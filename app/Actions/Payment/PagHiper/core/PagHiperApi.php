<?php

namespace App\Actions\Payment\PagHiper\core;

use Illuminate\Http\Client\Factory as HttpKernel;
use Illuminate\Support\Facades\Http;

abstract class PagHiperApi
{
    protected $config;
    protected \Illuminate\Http\Client\PendingRequest $api;
    protected \Illuminate\Http\Client\PendingRequest $pix;

    public function __construct($config)
    {
        $this->config=$config;
        $api = Http::withHeaders([
            'Accept' => 'application/json',
            'Accept-Charset' => 'UTF-8',
            'Accept-Encoding' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $this->api = clone $api->baseUrl('https://api.paghiper.com/');
        $this->pix = $api->baseUrl('https://pix.paghiper.com/');
    }
}
