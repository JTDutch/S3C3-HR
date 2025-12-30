<?php

namespace App\Controllers;

class Onboarding extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
    }

    public function create()
    {
        $first_name    = $this->request->getPost('first_name');
        $middle_name   = $this->request->getPost('middle_name');
        $last_name     = $this->request->getPost('last_name');
        $email         = $this->request->getPost('email');
        $department_id = $this->request->getPost('department_id');
        $start_date    = $this->request->getPost('start_date');

        // Controleer vereiste velden zonder empty()
        $required_fields = [
            'First Name'    => $first_name,
            'Last Name'     => $last_name,
            'Email'         => $email,
            'Department'    => $department_id,
            'Start Date'    => $start_date,
        ];

        $errors = [];
        foreach ($required_fields as $label => $value) {
            if (!isset($value) || trim($value) === '') {
                $errors[] = "$label is required";
            }
        }

        if (count($errors) > 0) {
            session()->setFlashdata('error', 'Employee onboarding failed');
            return redirect()->to('/Home');
        }

        // Alles geldig, maak employee aan
        $this->AccountModel->onboard_employee($first_name, $middle_name, $last_name, $email, $department_id, $start_date);

        session()->setFlashdata('success', 'Employee succesfully onboarded');
        return redirect()->to('/Home');
    }
}
