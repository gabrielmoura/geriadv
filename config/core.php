<?php
return [
    /**
     * Informações para aposentadoria
     */
    'minimum' => [

        //Salário minimo
        'salary' => env('SALARY', 1200),

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
    'docs' => ['cras', 'cpf', 'rg', 'birth_certificate', 'proof_of_address'],
    'ForgetDeletes'=> 'yearly',// yearly monthly weekly
];
