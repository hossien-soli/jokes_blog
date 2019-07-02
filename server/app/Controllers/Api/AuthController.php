<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Util\Validator;
use App\Util\FileUploader;
use App\Util\Hash;
use App\Auth\Gate;
use App\Auth\Api\Auth as ApiAuth;
use PDOException;

class AuthController extends Controller
{
    public function register (Request $request,Response $response)
    {
        $userData = $request->getParsedBody();
        
        foreach (array_keys($userData) as $key)
            $userData[$key] = trim($userData[$key]);

        $validator = new Validator;
        $validation = $validator->make($userData,[
            'name' => 'min:4|max:35',
            'email' => 'required|email',
            'username' => 'required|min:4|max:20',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
        ]);
        $validation->validate();
        if ($validation->fails())
            return $response->withJson(['ok' => false,'errors' => $validation->errors()->all()]);

        $gate = new Gate ($this->container);
        if (!$gate->canUsingEmail($userData['email']))
            return $response->withJson(['ok' => false,'errors' => ['This email is already taken !']]);
            
        if (!$gate->canUsingUsername($userData['username']))
            return $response->withJson(['ok' => false,'errors' => ['This username is already taken !']]);

        if (isset($request->getUploadedFiles()['avatar'])) {
            $userAvatar = $request->getUploadedFiles()['avatar'];
            $uploader = new FileUploader ($userAvatar,$this->container->get('config'));
            $uploader->setMaxFileSize(1024);
            $uploader->setValidExtensions(['png','jpg']);
            if ($uploader->checkForValid()) {
                $uploadResult = $uploader->uploadAsUserAvatar();
                $userData = array_merge($userData,['avatar' => $uploadResult]);
            }
            else
                return $response->withJson(['ok' => false,'errors' => ['Unable to upload user avatar !']]);
        }

        $hash = new Hash ($this->container->get('config'));
        $hashedPassword = $hash->password($userData['password']);
        $userData['password'] = $hashedPassword;
        unset($userData['password_confirm']);
        $userData['api_token'] = strtoupper(uniqid() . bin2hex(random_bytes(40)) . rand(0,999999999999999));
        $userData['active_hash'] = uniqid() . bin2hex(random_bytes(15));

        try {
            User::create($userData);
            return $response->withJson(['ok' => true]);
        }
        catch (PDOException $ex) {
            return $response->withJson(['ok' => false,'errors' => ['Unable to save informations!']]);
        }
    }

    public function login (Request $request,Response $response)
    {
        $loginData = $request->getParsedBody();
        
        foreach (array_keys($loginData) as $key)
            $loginData[$key] = trim($loginData[$key]);
        
        $validator = new Validator;
        $validation = $validator->make($loginData,[
            'username' => 'required|min:4',
            'password' => 'required|min:4',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            return $response->withJson(['ok' => false,'errors' => $errors]);
        }
        
        $apiAuth = new ApiAuth ($this->container);
        $apiToken = $apiAuth->getApiToken($loginData['username'],$loginData['password']);
        if (!$apiToken)
            return $response->withJson(['ok' => false,'errors' => ['Invalid username or password!','Or your account hasn\'t been activated!']]);
        
        return $response->withJson(['ok' => true,'api_token' => $apiToken]);
    }
}