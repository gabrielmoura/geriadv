@component('mail::message')
# Boleto Gerado com sucesso

Clique abaixo para acessar.

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
