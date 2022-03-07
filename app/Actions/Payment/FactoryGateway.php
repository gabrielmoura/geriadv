<?php

namespace App\Actions\Payment;

use App\Actions\Payment\PagHiperGateway;

class FactoryGateway
{
    public function createGateway($payment) : Payment|null
    {
        $gateway = match ($payment) {
            'boleto' => new PagHiperGateway(),
            default => null
        };
        return $gateway?->createPayment();
    }
}
