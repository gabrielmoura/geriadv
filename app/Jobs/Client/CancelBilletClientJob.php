<?php

namespace App\Jobs\Client;

use App\Actions\Payment\PaymentFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *  Cancela uma liksta de boletos
 */
class CancelBilletClientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    /**
     * @var array
     */
    private $collect, $billet;


    /**
     * @param array $collect
     */
    public function __construct(array $collect)
    {
        $this->collect = $collect;
        $this->billet = PaymentFacade::make('paghiper');
    }


    /**
     * @return void
     */
    public function handle()
    {
        foreach ($this->collect as $billet) {
            $this->billet->cancelCharge($billet);
        }
    }
}
