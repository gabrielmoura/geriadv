<?php


namespace App\Actions\Payment;


class StateCity
{
    public function ibge(): array
    {
        //22 Maio 2021
        //https://gist.github.com/letanure/3012978
        return json_decode(file_get_contents(app_path('Actions/Payment/estados-cidades.json')), true)['estados'];
    }


    public function state(): array
    {
        $data = [];
        foreach ($this->ibge() as $item) {
            $data[$item['sigla']] = $item['nome'];
        }
        return $data;
    }


    public function city(string $sigla): array
    {
        $data = [];
        foreach ($this->ibge() as $item) {
            if ($item['sigla'] == $sigla) {

                $data = $item['cidades'];
            }
        }
        return $data;
    }
}
