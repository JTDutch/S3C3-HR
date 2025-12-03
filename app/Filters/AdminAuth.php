<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in
        if (!session()->get('account_id')) {
            // If not logged in, redirect to login page
            return redirect()->to(base_url('Login'))->with('error', 'You must be logged in to access the HR panel.');
        }

        // If logged in, allow the request to proceed
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing required
    }
}
