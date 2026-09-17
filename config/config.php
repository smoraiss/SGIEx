<?php
return [
    'db' => [
        'host' => getenv('SGIEX_DB_HOST') ?: 'localhost',
        'name' => getenv('SGIEX_DB_NAME') ?: 'sgiex',
        'user' => getenv('SGIEX_DB_USER') ?: 'root',
        'pass' => getenv('SGIEX_DB_PASS') ?: '',
        'charset' => 'utf8mb4'
    ]
];
