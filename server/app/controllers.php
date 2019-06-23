<?php

use \App\Controllers\Api\AuthController;

$c['Api\AuthController'] = function ($c) {
    return new AuthController ($c);
};