<?php

namespace App\Actions\Payment;

use App\Actions\Payment\PagHiper\Billets;

trait PaymentTrait
{
    public function billets()
    {
        return $this->hasMany(Billets::class,'client_id', 'id');
    }
}
