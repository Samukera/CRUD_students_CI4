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

        // Define a expressão regular para os caracteres reservados.
        $reservedCharsRegex = '/[{}()\/\\\\@:]/';
        $allowedChar = '-';

        // Substitui os caracteres reservados pelo caractere permitido.
        $ipAddress = preg_replace($reservedCharsRegex, $allowedChar, $ipAddress);

        // Restringe um endereço IP a não mais do que 50 solicitações
        // por minuto em toda a rotas.
        if ($throttler->check($ipAddress, 50, MINUTE) === false) {
            return Services::response()->setStatusCode(429);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}
