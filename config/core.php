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
    //  Padrão de Documentos
    'docs' => [
        ['name' => 'cras', 'title' => 'CRAS'],
        ['name' => 'cpf', 'title' => 'CPF'],
        ['name' => 'rg', 'title' => 'RG'],
        ['name' => 'birth_certificate', 'title' => 'Certidão de Nascimento'],
        ['name' => 'proof_of_address', 'title' => 'Comprovante de Residência'],
    ],
    'ForgetDeletes' => 'yearly',// yearly monthly weekly
    'googleTag' => env('GOOGLE_TAG'), // Google Tag
];
