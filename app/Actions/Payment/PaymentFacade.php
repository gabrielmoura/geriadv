<?php

namespace App\Actions\Payment;

use Illuminate\Support\Facades\Facade;

class PaymentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return app(\App\Actions\Payment\PaymentInterface::class);
    }
}
