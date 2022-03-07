# Uso do PagHiper

## Payer (Pagador)
```php
$payer=[
    'payer_name',
    'payer_email',
    'payer_cpf_cnpj',
    'payer_phone',  // fixou ou móvel
    'payer_street',
    'payer_number',
    'payer_complement',
    'payer_district', //Bairro
    'payer_city',
    'payer_state', // apenas sigla do estado
    'payer_zip_code', // CEP
  ];
  ```
## Items (Itens)
Pode ser passado um array com apenas 1(um) item, ou um array bidimencional com vários itens.
```php
 $item = [
    'description',
    'price',
    'quantity'
    ];
 ```
