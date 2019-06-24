<?php

$db = new \App\Util\DB;

$db->addConnection([
    'driver' => 'mysql',
    'host' => $c->config->get('db.host'),
    'database' => $c->config->get('db.database'),
    'username' => $c->config->get('db.username'),
    'password' => $c->config->get('db.password'),
    'charset' => $c->config->get('db.charset'),
    'collation' => $c->config->get('db.collation'),
    'prefix' => '',
]);

$db->bootEloquent();
$db->setAsGlobal();

$c['db'] = function ($c) {
    return new \App\Util\DB;
};