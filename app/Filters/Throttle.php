<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Throttle implements FilterInterface
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

        // Restringe um endereço IP a não mais do que 6 solicitações
        // por minuto em toda a rota de login.
        if ($throttler->check($ipAddress, 6, MINUTE) === false)
        {
            return Services::response()->setStatusCode(429);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}