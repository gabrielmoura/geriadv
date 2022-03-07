<?php

namespace App\Actions\Payment;

use App\Actions\Payment\AbstractPayment;
use App\Actions\Payment\Payment;
use App\Actions\Payment\Billet;

class TesterGateway extends AbstractPayment implements PaymentInterface
{


    public function getProducts(): array
    {
        return [
            'Amazon Product Sample #1',
            'Amazon Product Sample #2',
            'Amazon Product Sample #3',
        ];
    }
    public function setConfig($config)
    {
        dump("Amazon config was set in a method...");
        $this->config = $config;
        dump($this->config);
    }
}
