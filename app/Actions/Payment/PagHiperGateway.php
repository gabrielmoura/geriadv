<?php

namespace App\Actions\Payment;

use App\Actions\Payment\PagHiper\Item;
use App\Actions\Payment\PagHiper\core\PagHiperInterface;
use App\Actions\Payment\PagHiper\core\PagHiperApi;
use App\Events\Client\CreatedBilletEvent;
use App\Events\Client\FailedCreateBilletEvent;
use Illuminate\Support\Facades\Log;


class PagHiperGateway extends PagHiperApi implements PaymentInterface, PagHiperInterface
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private \Illuminate\Support\Collection $collect;

    /**
     *
     */
    public function __construct($config)
    {
        parent::__construct($config);

        $this->collect = collect([
            'apiKey' => $this->config['api_key'],
            'token' => $this->config['token']
        ]);
    }

    /**
     * @return Item
     */
    public function item()
    {
        return new Item();
    }


    /**
     * @param array $item
     * @param array $payer
     * @param string $order_id
     * @param int $days_due_date
     * @return array|mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function charge(array $item, array $payer, string $order_id = 'AAA-123', int $days_due_date = 1)
    {
        $c = $this->collect
            ->put('items', $item)
            ->merge($payer)
            ->put('order_id', $order_id)
            ->put('type_bank_slip', $this->config['type_bank_slip'])
            ->put('days_due_date', ($days_due_date > 1) ? $days_due_date : $this->config['days_due_date']);

        $r = $this->api->post('transaction/create/', $c->toArray())->throw();
        $o = $r->json('create_request');
        if ($r->successful()) {
            CreatedBilletEvent::dispatch($o);
        }
        Log::debug('Criação de Boleto', $o);
        return $o;
    }

    /**
     * @param array $transactions
     * @param string $type
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargeMultiple(array $transactions, string $type)
    {
        $c = $this->collect
            ->put('transactions', $transactions)
            ->put('type_bank_slip', $type);
        return $this->api->post('/transaction/multiple_bank_slip', $c->toArray())->throw()->json('status_request');
    }

    /**
     * @param $transaction_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function refund($transaction_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id)
            ->put('status', 'canceled');
        return $this->api->post('/transaction/cancel/', $c->toArray())->throw()->json('cancellation_request');
    }

    /**
     * @param string $transaction_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargeStatus(string $transaction_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id);
        return $this->api->post('/transaction/status/', $c->toArray())->throw()->json('status_request');
    }

    /**
     * @param array $filter
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargeList(array $filter)
    {
        $c = $this->collect
            ->push($filter);
        return $this->api->post('/transaction/list/', $c->toArray())->throw()->json('transaction_list_request');
    }

    /**
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function fiscalNoteList()
    {
        return $this->api->post('/invoice/list/', $this->collect->toArray())->throw()->json('invoice_list_request');
    }

    /**
     * @param string $transaction_id
     * @param $notification_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function notification(string $transaction_id, $notification_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id)
            ->put('notification_id', $notification_id);
        return $this->api->post('/transaction/notification/', $c->toArray())->throw()->json('status_request');
    }

    /**
     * @param array $item
     * @param array $payer
     * @param string $order_id
     * @param int $days_due_date
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargePix(array $item, array $payer, string $order_id = 'AAA-123', int $days_due_date = 1)
    {
        $c = $this->collect
            ->put('item', $item)
            ->merge($payer)
            ->put('order_id', $order_id)
            ->put('days_due_date', ($days_due_date > 1) ? $days_due_date : $this->config['days_due_date']);
        return $this->pix->post('/invoice/create', $c->toArray())->throw()->json('pix_create_request');
    }

    /**
     * @param string $transaction_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function refundPix(string $transaction_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id)
            ->put('status', 'canceled');
        return $this->pix->post('/invoice/cancel', $c->toArray())->throw()->json('cancellation_request');
    }

    /**
     * @param string $transaction_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargePixStatus(string $transaction_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id);
        return $this->pix->post('/invoice/status', $c->toArray())->throw()->json('status_request');
    }

    /**
     * @param string $transaction_id
     * @param $notification_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function notificationPix(string $transaction_id, $notification_id)
    {
        $c = $this->collect
            ->put('transaction_id', $transaction_id)
            ->put('notification_id', $notification_id);
        return $this->pix->post('/invoice/notification', $c->toArray())->throw()->json('status_request');
    }

    /**
     * @param array $filter
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function chargePixList(array $filter)
    {
        $c = $this->collect
            ->push($filter);
        return $this->api->post('/invoice/list/', $c->toArray())->throw()->json('transaction_list_request');
    }

    /**
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function listBankAccounts()
    {
        return $this->api->post('/bank_accounts/list/', $this->collect->toArray())->throw()->json('bank_account_list_request');
    }

    /**
     * @param string $bank_account_id
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function drawBankAccount(string $bank_account_id)
    {
        $c = $this->collect
            ->put('bank_account_id', $bank_account_id);
        return $this->api->post('/bank_accounts/cash_out/', $c->toArray())->throw()->json('cash_out_request');

    }
}
