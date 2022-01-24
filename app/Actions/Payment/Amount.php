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
        if (is_null($benefit['wage']) && !is_null($benefit['wage_factor'])) {
            $value = config('core.minimum.salary') * $benefit['wage_factor'];
        } elseif (is_null($benefit['wage_factor']) && !is_null($benefit['wage'])) {
            $value = $benefit['wage'];
        } else {
            $value = $benefit['wage_factor'] * $benefit['wage'];
        }
        return $value;
    }
}
