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

        // Obtém o endereço IP do usuário.
        $ipAddress = $request->getIPAddress();

        // Define os caracteres reservados e o caractere permitido.
        $reservedChars = ['{', '}', '(', ')', '/', '\\', '@', ':'];
        $allowedChar = '-';

        // Substitui os caracteres reservados pelo caractere permitido.
        $ipAddress = str_replace($reservedChars, $allowedChar, $ipAddress);

        // Restringe um endereço IP a não mais do que 50 solicitações
        // por minuto em toda a rotas.
        if ($throttler->check($ipAddress, 50, MINUTE) === false)
        {
            return Services::response()->setStatusCode(429);
        }

        // // Obtém o ID do usuário autenticado usando a classe de autenticação Myth/Auth.
        // $authenticate = Services::authentication();
        // if ($authenticate->check()) {
        //     $userId = $authenticate->user()->id;

        //     if ($throttler->check($userId, 2, MINUTE) === false)
        //     {
        //         return Services::response()->setStatusCode(429);
        //     }
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}