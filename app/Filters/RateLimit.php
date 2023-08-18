<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class RateLimit implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttler = Services::throttler();

        // Obtém o ID do usuário autenticado usando a classe de autenticação Myth/Auth.
        $authenticate = Services::authentication();
        if ($authenticate->check()) {
            $userId = $authenticate->user()->id;

            // Restringe um usuário autenticado a não mais do que 30 solicitações
            // por minuto em todas as rotas protegidas.
            if ($throttler->check($userId, 30, MINUTE) === false)
            {
                return Services::response()->setStatusCode(429);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}