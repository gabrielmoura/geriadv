<?php
return [
    'date_format' => 'd/m/Y',
    'time_format' => 'H:i',
    'primary_language' => 'pt',
    'available_languages' => [
        'en' => 'English',
        'pt' => 'Portuguese',
    ],
    /**
     * Usar DataTable
     */
    'datatable' => true,

    /**
     * Força HTTPS
     */
    'forceHttps' => env('FORCE_HTTPS', true),
    'forceCache' => env('FORCE_CACHE', true),
    // dropZone or fineUpload
    'libUpload' => 'dropZone',
    'downloadHelper' => env('DOWNLOAD_HELPER',false), // True caso o download precise de ajudante.
];
