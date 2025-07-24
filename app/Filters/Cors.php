<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Permitir todos los orígenes, métodos y encabezados
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        if ($request->getMethod() === 'options') {
            // Responder a solicitudes OPTIONS
            die();
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario hacer nada después
    }
}
