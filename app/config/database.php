<?php
// config database

return [
    'default' => 'mysql',
    'fetch' => PDO::FETCH_OBJ,
    'migrations' => 'migrations',
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'mvc.sqlite',
            'prefix' => '',
        ],
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'mvc',
            'username' => 'root',
            'password' => 'Rockw00d',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],
        'postgress' => [
            'driver' => 'postgress',
            'host' => 'localhost',
            'database' => 'mydatabase',
            'username' => 'myusername',
            'password' => 'mypassword',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],
    ], 
];