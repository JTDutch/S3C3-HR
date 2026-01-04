<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Niet ingelogd
        if (!session()->get('logged_in')) {
            return redirect()->to('//Login');
        }

        // Geen tokens = ongeldige sessie
        if (!session()->get('id_token') || !session()->get('access_token')) {
            session()->destroy();
            return redirect()->to('//Login');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // niets
    }
}
