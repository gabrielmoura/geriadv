<?php


namespace App\Actions\Payment\PagHiper\core;

interface PagHiperInterface
{
    public function charge(array $item, array $payer, string $order_id = 'AAA-123', int $days_due_date = 1);

    public function chargeMultiple(array $transactions, string $type);

    public function refund(string $transaction_id);

    public function chargeStatus(string $transaction_id);

    public function chargePix(array $item, array $payer, string $order_id = 'AAA-123', int $days_due_date = 1);

    public function refundPix(string $transaction_id);

    public function chargePixStatus(string $transaction_id);

    public function listBankAccounts();

    public function drawBankAccount(string $bankAccountId);
}
