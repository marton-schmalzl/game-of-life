<?php

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => false,

        // database settings
        'pdo' => [
            'dsn' => 'mysql:host=localhost;dbname=notes;charset=utf8',
            'username' => 'root',
            'password' => '123',
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__.'/../log/app.log',
        ],
    ],
];
