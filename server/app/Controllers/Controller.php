<?php

namespace App\Controllers;

use Slim\Container as SlimContainer;

class Controller
{
    protected $container;

    public function __construct (SlimContainer $container)
    {
        $this->container = $container;
    }
}