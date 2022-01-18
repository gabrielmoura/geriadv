<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'minio'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
        'minio' => [
            'driver' => 's3',
            'key' => env('MINIO_ACCESS_KEY_ID'),
            'secret' => env('MINIO_SECRET_ACCESS_KEY'),
            'region' => env('MINIO_DEFAULT_REGION','us-east-1'),
            'bucket' => env('MINIO_BUCKET'),
            'endpoint' => env('MINIO_URL'),
            //'url'=>"http://mgmercado.localhost",
            //'bucket_endpoint' => false,
            'use_path_style_endpoint' => env('AWS_PATH_STYLE', true),
            //'scheme'  => 'http',
            //'http' => ['verify' => false],
            'options' => [
                'override_visibility_on_copy' => 'private',
            ]
        ],
        'cloudinary' => [
            'driver' => 'cloudinary',
            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
            'api_key' => env('CLOUDINARY_API_KEY'),
            'api_secret' => env('CLOUDINARY_API_SECRET'),
            'url' => [
                'secure' => (bool) env('CLOUDINARY_SECURE_URL', true),
            ],
        ],
        // composer require skydiver/laravel-flysystem-b2
        'backblaze' => [
            'driver'          => 'backblaze',
            'account_id'      => env('B2_APP_ID'),
            'application_key' => env('B2_APP_KEY'),
            'bucket'          => env('B2_BUCKET'),
        ],

        'onedrive' => [
            'driver'       => 'onedrive',
            'access_token' => env('ONEDRIVE_ACCESS_TOKEN'),

            // Options only needed for ignited/flysystem-onedrive
            // 'base_url'     => 'https://api.onedrive.com/v1.0/',
            // 'use_logger'   => false,

            // Option only used by nicolasbeauvais/flysystem-onedrive
            // 'root'         => 'root',
        ],
        'gdrive' => [
            'driver'            => 'gdrive',
            'client_id'         => env('GDRIVE_CLIENT_ID'),
            'secret'            => env('GDRIVE_SECRET'),
            'token'             => env('GDRIVE_TOKEN'),

            // Optional GDrive Settings
            // 'root'              => 'your-root-directory',
            // 'paths_sheet'       => 'your-paths-sheet',
            // 'paths_cache_drive' => 'local',
        ],


    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
