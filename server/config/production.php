<?php

return [

    'app' => [
        'name' => 'jokes_blog',
        'title' => 'Jokes Blog',
        
        'url' => 'http://<your-domain>/',

        'hash' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10,
        ],
    ],

    'db' => [
        'host' => 'localhost',
        'database' => '<your-database-name>',
        'username' => '<your-database-username>',
        'password' => '<your-database-password>',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ],
    
    'uploader' => [
        'storage_dir' => '../storage/',

        'uploads_dir_local' => '../../client/public/uploads/',
        'uploads_dir_public' => '/uploads/',
        'users_avatar_dir_local' => '../../client/public/uploads/avatars/',
        'users_avatar_dir_public' => '/uploads/avatars/',
    ],
];