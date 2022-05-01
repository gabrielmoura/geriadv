<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Essas credenciais não foram encontradas em nossos registros.',
    'password' => 'A senha informada está incorreta.',
    'throttle' => 'Muitas tentativas de login. Tente novamente em :seconds segundos.',
    'setting' => [
        'two-factor' => [
            'header' => 'Autenticação de dois fatores',//'Two factor authentication'
            'button' => 'Ativar dois fatores', //'Enable Two-Factor'
        ],
        'user-password' => [
            'header' => 'Atualizar senha',//'Update password'
            'button' => 'Atualizar senha',//'Update password'
        ],
        'user-profile-information' => [
            'header' => 'Atualizar informações do perfil', //Update profile information
            'button' => 'Atualizar perfil', //Update Profile
        ],
    ],
];
