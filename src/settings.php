<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],//renderer

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],//logger

        // Database Settings
        'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'db_astornew',
        'driver' => 'mysql',

        //'host' => 'localhost',
        //'user' => 'stmikasi_APITEST',
        //'pass' => 'Lumajang01',
        //'dbname' => 'stmikasi_APITEST',
        //'driver' => 'mysql',
        ],//database
    ],//seting
];//return
