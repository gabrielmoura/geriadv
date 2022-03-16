<?php

namespace App\Actions\Payment\PagHiper\core;

enum BilletStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case PAID = 'paid';
    case PROCESSING = 'processing';
    case REFUNDED = 'refunded';
}
