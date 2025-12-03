<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
    }

    public function index()
    {
        helper('form');
        $errors = null;
        if ($this->request->getMethod() == 'POST') {
            // Validation rules
            $rules = [
                'email' => [
                    'rules' => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'The Email field is required.',
                        'min_length' => 'Email must be at least 3 characters long.',
                        'max_length' => 'Email can not be more than 255 characters.',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'The password field is required.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password can not be more than 255 characters.'
                    ]
                ]            ];

            // Validate form input
            if ($this->validate($rules)) {

                // If validation is successful, authenticate the user
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $user = $this->AccountModel->authenticate($email, $password);

                if ($user) {
                    // Set session variables
                    $this->session->set('account_id', $user->id);

                    // Redirect to the home page
                    return redirect()->to(base_url('Agenda/index'));
                } else {
                    // If authentication fails, set the error message for invalid login
                    $errors = 'Invalid email or password.';
                }
            } else {
                // If validation fails, capture errors
                $errors = $this->validator;
            }
        }

        // Pass the errors and other view data to the view
        $this->viewData['errors'] = $errors;
        $this->viewData['title'] = 'HR-Application | Login';
        $this->viewData['view'] = 'Login/index';
        echo view('template', $this->viewData);
    }
}
