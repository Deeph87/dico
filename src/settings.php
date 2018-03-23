<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'DBConnect' => [
            'appHost' => 'db',
            'host' => $_ENV['DICO_DB_HOST'],
            'port' => $_ENV['DICO_DB_PORT'],
            'dbname' => $_ENV['DICO_DB_NAME'],
            'user' => $_ENV['DICO_DB_USER'],
            'password' => $_ENV['DICO_DB_PASSWORD'],
            'rootPassword' => $_ENV['DICO_DB_ROOT_PASSWORD']
        ]
    ],
];
