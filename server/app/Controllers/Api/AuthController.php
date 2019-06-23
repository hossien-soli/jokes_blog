<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    public function register (Request $request,Response $response)
    {
        return $response->withJson($request->getParsedBody());
    }
}