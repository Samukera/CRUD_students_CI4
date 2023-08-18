<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;


class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Recuperar o token do cabeçalho Authorization
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        if (!$authHeader) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Access denied');
        }

        // Extrair o token do cabeçalho
        list(, $token) = explode(' ', $authHeader);
        // Verificar se o token é válido
        try {
            $key = getenv('JWT_SECRET_KEY');
            JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Access denied');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}