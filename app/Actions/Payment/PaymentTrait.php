<?php

namespace App\Actions\Payment;

use App\Actions\Payment\PagHiper\Billets;
use App\Models\Invoice;

trait PaymentTrait
{
    public function billets()
    {
        return $this->hasMany(Billets::class,'client_id', 'id');
    }
    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }
}
