<?php

namespace App\Actions\Payment;

use Illuminate\Support\Arr;

class Payment
{
    /**
     * @var array
     */
    private $gate = [];
    /**
     * @var
     */
    private $app;

    /**
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param $name
     * @return PaymentInterface
     * @throws \Exception
     */
    public function make($name): PaymentInterface
    {
        $service = Arr::get($this->gate, $name);
        // No need to create the service every time
        if ($service) {
            return $service;
        }
        $createMethod = 'create' . ucfirst($name) . 'GatewayService';
        if (!method_exists($this, $createMethod)) {
            throw new \Exception("Gateway $name is not supported");
        }
        $service = $this->{$createMethod}();
        $this->gate[$name] = $service;
        return $service;
    }


    /**
     * @return PagHiperGateway
     */
    private function createPaghiperGatewayService(): PagHiperGateway
    {

        return new PagHiperGateway($this->app['config']['services.paghiper']);
    }

    /**
     * @return TesterGateway
     */
    private function createAmazonGatewayService(): TesterGateway
    {

        $service = new TesterGateway();
        $config = $this->app['config']['shops.amazon'];
        $service->setConfig($config);
        // Do the necessary configuration to use the Amazon service
        return $service;
    }
}
