<?php


namespace App\Actions\Payment;


class Amount
{
    /**
     * Retorna Regra de Calculo
     * @param $benefit
     * @return float
     */
    public static function getValue($benefit): float
    {

        // Caso não haja Fator retornar valor
        if ($benefit['wage_factor']==null) {
            return $benefit['wage'];
        }
        // Caso Salary especificado, retornar a multiplicação.
        if ($benefit['wage_type'] === 'salary') {
            return config('core.minimum.salary') * $benefit['wage_factor'];
        } else {
            // Caso Percent especificado, retornar a multiplicação.
            return $benefit['wage_factor'] * $benefit['wage'];
        }
    }
}
