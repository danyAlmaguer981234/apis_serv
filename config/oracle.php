<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST', '10.4.1.1'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', 'qad'),
        'service_name'   => env('DB_SERVICENAME', 'qadsc'),
        'username'       => env('DB_USERNAME', 'qad'),
        'password'       => env('DB_PASSWORD', 'QAD'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
        'load_balance'   => env('DB_LOAD_BALANCE', 'yes'),
        'dynamic'        => [],
    ],
];
