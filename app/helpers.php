<?php
if (!function_exists('routeIs')) {
    function routeIs($route, $return_ontrue = 'active', $return_onfalse = null)
    {
        return request()->routeIs($route) ? $return_ontrue : $return_onfalse;
    }
}
if (!function_exists('resumo')) {
    function resumo(string $string, int $chars): string
    {
        if (strlen($string) > $chars)
            return substr($string, 0, $chars) . '...';
        else
            return $string;
    }
}
