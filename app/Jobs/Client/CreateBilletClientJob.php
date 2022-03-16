<?php

namespace App\Jobs\Client;

use App\Actions\Payment\PagHiper\Billets;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Illuminate\Support\Collection;
use App\Actions\Payment\PaymentFacade;


/**
 *  Cria boletos para cliente.
 */
class CreateBilletClientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $collect;


    /**
     * @param Collection $collect
     * @param $item array
     * @param $payer array
     */
    public function __construct(Collection $collect, $item = ['description', 'price', 'quantity'], $payer = ['payer_name', 'payer_email', 'payer_cpf_cnpj'])
    {
        $this->collect = $collect->put('item', $item)->put('payer', $payer);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $billet=PaymentFacade::make('paghiper');
        $item = $billet->item();
        // Se array bidimencional foreach para criar varios items
        if (is_array($this->collect->get('item')['description'])) {
            foreach ($this->collect->get('item') as $i) {
                $item->add(
                    $i['description'],
                    $i['price'],
                    $i['quantity']
                );
            }
        } else {
            $item->add(
                $this->collect->get('item')['description'],
                $this->collect->get('item')['price'],
                $this->collect->get('item')['quantity']
            );
        }

        $payer = $this->collect->get('payer');
        $order_id = Uuid::uuid();
        $billets = [];
        for ($i = 0; $i < $this->collect->get('parcel'); $i++) {
            usleep(.2 * 1000000); // 200 ms
            Billets::create($this->normalize(
                collect($billet->charge($item->get(), $payer, $order_id, ($i + 1) * 30))
                    ->put('items', $item->get())->put('order_id', $order_id)
                    ->put('company_id', $this->collect->get('company_id') ?? null)
                    ->put('client_id', $this->collect->get('client_id') ?? null)
                    ->toArray()
            ));
        }

    }

    /**
     * Recebe dados e adequa para ser passado ao Model
     * @param $billets
     * @return array
     */
    private function normalize($billets): array
    {
        return [
            'transaction_id' => $billets['transaction_id'],
            //'created_at' => Carbon::parse($billets['created_date']),
            'status' => $billets['status'],
            'due_date' => Carbon::parse($billets['due_date']),
            'bank_slip' => $billets['bank_slip'],
            'items' => $billets['items'],
            'order_id' => $billets['order_id'],
            'value_cents' => $billets['value_cents'],
            'client_id' => $billets['client_id'],
            'company_id' => $billets['company_id']
        ];
    }
}

