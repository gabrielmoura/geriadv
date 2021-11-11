<?php
if (!function_exists('routeIs')) {
    function routeIs($route, $return_ontrue = 'active', $return_onfalse = null)
    {
        return request()->routeIs($route) ? $return_ontrue : $return_onfalse;
    }
}
if (!function_exists('routeActive')) {

    /**
     * Retorna "active" se dentro da rota
     * @param $route
     * @param string $print
     * @return mixed|string
     */
    function routeActive($route, $print = 'active')
    {
        return (str_contains(Route::currentRouteName(), $route)) ? $print : '';
    }
}
if (!function_exists('resumo')) {
    /**
     * Resume uma string
     * @param string $string
     * @param int $chars
     * @return string
     */
    function resumo(string $string, int $chars): string
    {
        if (strlen($string) > $chars)
            return substr($string, 0, $chars) . '...';
        else
            return $string;
    }
}
if (!function_exists('arrayToObject')) {
    /**
     * Converte Array para Objeto
     * @param array $array
     */
    function arrayToObject(array $array)
    {
        return json_decode(json_encode($array), FALSE);
    }
}
if (!function_exists('inObject')) {
    function inObject($name, $object)
    {
        return collect($object)->contains(function ($value, $key) use ($name) {
            $value == $name || $key == name;
        });
    }
}
if (!function_exists('formatHours')) {
    /**
     * Formata Data com hora
     * @param $data
     * @return mixed
     */
    function formatHours($data)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $formatter = new IntlDateFormatter('pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN);
        return $formatter->format($data);
    }
}
if (!function_exists('formatDate')) {
    /**
     * Formata Data sem hora
     * @param string $data
     * @return false|string
     */
    function formatDate(string $data)
    {
        return date_format(date_create($data), "d/m/Y");
    }
}
if (!function_exists('signedRoute')) {
    /**
     * @param string $name
     * @param array $parameters
     * @param null $expiration
     * @param bool $absolute
     * @return string
     */
    function signedRoute(string $name, $parameters = [], $expiration = null, $absolute = true)
    {
        return \Illuminate\Support\Facades\URL::signedRoute($name, $parameters = [], $expiration = null, $absolute = true);
    }
}
if (!function_exists('temporarySignedRoute')) {
    /**
     * @param $name
     * @param $expiration
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function temporarySignedRoute($name, $expiration, $parameters = [], $absolute = true)
    {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute($name, $expiration, $parameters = [], $absolute = true);
    }
}
if (!function_exists('numberClear')) {
    /**
     * @param $n
     * @return string|string[]|null
     */
    function numberClear($n)
    {
        return preg_replace('/[^0-9]/', '', $n);
    }
}
