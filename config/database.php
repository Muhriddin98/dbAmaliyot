<?php
return [
    'default' => 'postgres',
    'migrations' => 'migrations',
    'connections' => [
        'postgres' => [
            'driver'   => 'pgsql',
            'host'     => env('DB_PG_HOST', 'localhost'),
            'database' => env('DB_PG_DATABASE', 'practice'), // This seems to be ignored
            'port'     => env('DB_PG_PGSQL_PORT', 5432),
            'username' => env('DB_PG_USERNAME', 'postgres'),
            'password' => env('DB_PG_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public'
        ]
    ]
];
