<?php

return [

    'app' => [
        'name' => 'jokes_blog',
        'title' => 'Jokes Blog',
        
        'url' => 'http://127.0.0.1:8009/',

        'hash' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10,
        ],
    ],

    'db' => [
        'host' => 'localhost',
        'database' => 'jokes_blog',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ],

];