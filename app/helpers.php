<?php
if (!function_exists('routeIs')) {
    /**
     * @param $route
     * @param string $return_ontrue
     * @param null $return_onfalse
     * @return mixed|string|null
     */
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
    /**
     * @param $name
     * @param $object
     * @return bool
     */
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
        if (class_exists('IntlDateFormatter')) {
            date_default_timezone_set(config('app.timezone'));
            $formatter = new IntlDateFormatter(config('app.locale'),
                IntlDateFormatter::FULL,
                IntlDateFormatter::NONE,
                config('app.timezone'),
                IntlDateFormatter::GREGORIAN);
            return $formatter->format($data);
        } else {
            return $data;
        }
    }
}
if (!function_exists('formatDate')) {
    /**
     * Formata Data sem hora
     * @param string $data
     * @return false|string
     */
    function formatDate($data)
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
        if ($n == null) {
            return null;
        }
        return preg_replace('/[^0-9]/', '', $n);
    }
}
if (!function_exists('calculateAmount')) {
    /**
     * @param $obj
     * @return float
     */
    function calculateAmount($obj)
    {
        return \App\Actions\Payment\Amount::getValue($obj);
    }
}
if (!function_exists('cleanText')) {
    /**
     * Remove Html de um texto.
     * @param $text
     * @return string
     */
    function cleanText($text)
    {
        return html_entity_decode(strip_tags($text));
    }
}
