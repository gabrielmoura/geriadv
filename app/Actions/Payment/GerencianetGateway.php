<?php

namespace App\Actions\Payment;

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
use \Illuminate\Support\Collection;
use App\Actions\Payment\GerenciaNet\GerenciaNetApi;

class GerencianetGateway extends GerenciaNetApi implements PaymentInterface
{
     /**
     * @var \Illuminate\Support\Collection
     */
    private \Illuminate\Support\Collection $collect;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->collect = collect([
            'apiKey' => $this->config['api_key'],
            'token' => $this->config['token']
        ]);
    }

    private function createInvoice(array $item = ['name', 'amount', 'value'])
    {
        $clientId = 'informe_seu_client_id'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        $clientSecret = 'informe_seu_client_secret'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

        $options = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
        ];
        $item_1 = [
            'name' => 'Item 1', // nome do item, produto ou serviço
            'amount' => 1, // quantidade
            'value' => 1000 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
        ];

        $item_2 = [
            'name' => 'Item 2', // nome do item, produto ou serviço
            'amount' => 2, // quantidade
            'value' => 2000 // valor (2000 = R$ 20,00)
        ];

        $items =  [
            $item_1,
            $item_2
        ];

        // Exemplo para receber notificações da alteração do status da transação:
        // $metadata = ['notification_url'=>'sua_url_de_notificacao_.com.br']
        // Outros detalhes em: https://dev.gerencianet.com.br/docs/notificacoes

        // Como enviar seu $body com o $metadata
        // $body  =  [
        //    'items' => $items,
        //    'metadata' => $metadata
        // ];

        $body  =  [
            'items' => $items
        ];

        try {
            $api = new Gerencianet($options);
            $charge = $api->createCharge([], $body);

            return $charge;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function charge(Collection $collect, $item = ['description', 'price', 'quantity'], $payer = ['payer_name', 'payer_email', 'payer_cpf_cnpj'])
    {
        $clientId = 'informe_seu_client_id'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        $clientSecret = 'informe_seu_client_secret'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

        $options = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = producao)
        ];

        // $charge_id refere-se ao ID da transação gerada anteriormente
        $params = [
            'id' => $this->createInvoice()
        ];

        $customer = [
            'name' => 'Gorbadoc Oldbuck', // nome do cliente
            'cpf' => '94271564656', // cpf válido do cliente
            'phone_number' => '5144916523' // telefone do cliente
        ];

        $bankingBillet = [
            'expire_at' => '2018-12-12', // data de vencimento do boleto (formato: YYYY-MM-DD)
            'customer' => $customer
        ];

        $payment = [
            'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
        ];

        $body = [
            'payment' => $payment
        ];

        try {
            $api = new Gerencianet($options);
            $charge = $api->payCharge($params, $body);

            return $charge;
        } catch (GerencianetException $e) {
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function refund($charge_id){
        $clientId = 'informe_seu_client_id'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientSecret = 'informe_seu_client_secret'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => true // altere conforme o ambiente (true = Homologação e false = producao)
];
 
// $charge_id refere-se ao ID da transação ("charge_id")
$params = [
  'id' => $charge_id
];
 
try {
    $api = new Gerencianet($options);
    $charge = $api->cancelCharge($params, []);
 
    return $charge;
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (\Exception $e) {
    print_r($e->getMessage());
}
    }
}
