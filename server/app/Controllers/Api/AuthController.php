<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Util\Validator;
use App\Util\FileUploader;
use App\Util\Hash;
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

        $gate = $this->container->get('gate');
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
        if (function_exists('bin2hex') && function_exists('random_bytes'))
            $userData['active_hash'] = uniqid() . bin2hex(random_bytes(15));
        else
            $userData['active_hash'] = str_shuffle(uniqid() . uniqid() . uniqid());

        try {
            User::create($userData);
            return $response->withJson(['ok' => true]);
        }
        catch (PDOException $ex) {
            return $response->withJson(['ok' => false,'errors' => ['Unable to save informations!']]);
        }
    }
}