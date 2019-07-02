<?php

namespace App\Auth\Api;

use Slim\Container as SlimContainer;
use App\Models\User;
use App\Util\Hash;

class Auth
{
    protected $container;

    public function __construct (SlimContainer $container)
    {
        $this->container = $container;
    }
    
    public function getApiToken ($username,$password)
    {
        $username = trim($username);
        $password = trim($password);

        $user = User::where('username',$username)->first();
        if (is_null($user))
            return false;
        
        $userPassword = $user->password;
        $hash = new Hash ($this->container->get('config'));
        $isOkay = $hash->check($password,$userPassword);
        if (!$isOkay)
            return false;
        
        return $user->is_active == 1 ? $user->api_token : false;
    }
}