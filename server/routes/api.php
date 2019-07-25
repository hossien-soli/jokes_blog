<?php

$app->post('/register','Api\AuthController:register');
$app->post('/login','Api\AuthController:login');

$app->get('/user','Api\AuthController:userInfo');