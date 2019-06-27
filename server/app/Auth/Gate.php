<?php

namespace App\Auth;

use Slim\Container as SlimContainer;
use App\Models\User;

class Gate
{
    protected $container;

    public function __construct (SlimContainer $container)
    {
        $this->container = $container;
    }

    public function canUsingEmail ($email)
    {
        $findResult = User::where('email',$email)->first();
        return is_null($findResult);
    }

    public function canUsingUsername ($username)
    {
        $findResult = User::where('username',$username)->first();
        return is_null($findResult);
    }
}