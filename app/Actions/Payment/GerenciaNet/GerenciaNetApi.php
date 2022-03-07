<?php

namespace App\Actions\Payment\PagHiper\core;

use Illuminate\Http\Client\Factory as HttpKernel;

abstract class GerenciaNetApi
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
        $this->api = $api->baseUrl(($this->config['production'])?'https://api.gerencianet.com.br/':'https://sandbox.gerencianet.com.br/');
       //   https://documenter.getpostman.com/view/13574984/TW71kRme#b2cc5388-d166-4a14-92c3-c99da4478dca
    }
}
