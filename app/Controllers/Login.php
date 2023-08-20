<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Login extends ResourceController
{
    use ResponseTrait;
    private $loginModel;
    
    public function __construct()
    {
        $this->loginModel = new \App\Models\Login();
    }

    public function index(){
        return  $this->respond("Running", 200);
    }

    public function create()
    {
        $response = [];
        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
        ];
        
        try {
            if($this->loginModel->insert($data)){
                $response = [
                    'status' => 'success',
                    'message' => 'Login created'
                ];
                return $this->respondCreated($response);
            }else{
                $response = [
                    'status' => 'fail',
                    'errors' => $this->loginModel->errors()
                ];
                return $this->fail($response);
            }
        } catch (\Exception $e) {
           $response = [
                    'status' => 'error',
                    'erros' => $e
            ];
            return $this->fail($response);
        }
    }


    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Verificar se o email e a senha estão corretos
        $user = $this->loginModel->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            // Gerar um token de autenticação
            $key = getenv('JWT_SECRET_KEY');
            $expirationTime = time() + 3600;
            $payload = [
                'iat' => time(),
                'exp' => $expirationTime,
                'data' => [
                    'id' => $user['id'],
                    'email' => $user['email']
                ]
            ];
            $token = JWT::encode($payload, $key, 'HS256');

            // Retornar o token e o tempo de expiração para o usuário
            return $this->respond([
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', $expirationTime)
            ], 200);
        } else {
            return $this->respond(['message' => 'Email or password is incorrect'], 401);
        }
    }
}