<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class EnableCORS
{
    public function __invoke (Request $request,Response $response,$next)
    {
        $response = $next($request,$response);
        return $response->withHeader('Access-Control-Allow-Origin','*')
                ->withHeader('Access-Control-Allow-Headers','X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods','GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
}