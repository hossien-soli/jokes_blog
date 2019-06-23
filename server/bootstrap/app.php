<?php

require "../vendor/autoload.php";

use \Slim\App as SlimApp;

define('INC_ROOT',dirname(__DIR__));
session_start();

$app = new SlimApp ([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

$c = $app->getContainer();

$c['config'] = function ($c) {
    $productionConfigFile = INC_ROOT . '/config/production.php';
    if (file_exists(INC_ROOT . '/mode')) {
        $appMode = file_get_contents(INC_ROOT . '/mode');
        $appMode = strtolower(trim($appMode));
        $validModes = ['development','production'];
        if (in_array($appMode,$validModes))
            $configFile = sprintf(INC_ROOT . '/config/%s.php',$appMode);
        else
            $configFile = $productionConfigFile;
    }
    else
        $configFile = $productionConfigFile;

    return new \App\Util\Config ($configFile);
};

require "../app/controllers.php";
require "../routes/api.php";