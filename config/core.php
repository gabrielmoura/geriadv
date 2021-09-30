<?php
return [
    /**
     * Informações para aposentadoria
     */
    'minimum' => [
        //Minimo de idade para se aposentar
        'age_to_retire' => [
            'm' => 65,
            'f' => 62,
        ],
        //Minimo de tempo de contribuição
        'contribution_time' => [
            'm' => 20,
            'f' => 15,
        ],
    ],
    /**
     * Benefícios que o Sistema aceita
     */
    'benefits' => [
        [
            'name' => 'LOAS NIVER',
            'value' => 'niver'
        ],
        [
            'name' => 'APOSENTADORIA',
            'value' => 'aposentadoria'
        ],
        [
            'name' => 'LOAS',
            'value' => 'loas'
        ],

    ]


];
