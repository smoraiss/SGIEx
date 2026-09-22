<?php

require_once __DIR__ . '/../app/Core/Env.php';

Env::load(__DIR__ . '/../.env');

return [
    'db' => [
        'host' => Env::get('DB_HOST', 'localhost'),
        'name' => Env::get('DB_NAME', 'sgiex'),
        'user' => Env::get('DB_USER', 'root'),
        'pass' => Env::get('DB_PASS', ''),
        'charset' => 'utf8mb4'
    ]
];
?>
