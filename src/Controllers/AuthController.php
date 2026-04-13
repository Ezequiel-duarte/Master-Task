<?php
namespace App\Controllers;
use App\Models\User;
use App\Validation\UserValidator;
use App\Config\ownJWT;

class AuthController{
    private $UserValidator;
    private  $userModel;
    public function __construct($db){
        $this->userModel = new User($db);
        $this->UserValidator = new UserValidator();
    }

    public function login($body,$id){
        $this->UserValidator->validateLogin($body);
            
        $user = $this->userModel->getUserByName($body['username']);
        if (!$user || !password_verify($body['password'], $user['password'])) {
            throw new \Exception("Invalid credentials", 401);
        }
        return ['token' => ownJWT::generate($user['id'])];

    }

    public function logout($body) {
        return ['message' => 'Session successfully closed'];
    }
}