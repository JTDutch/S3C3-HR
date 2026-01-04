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
    $first_name    = trim($this->request->getPost('first_name'));
    $middle_name   = trim($this->request->getPost('middle_name'));
    $last_name     = trim($this->request->getPost('last_name'));
    $email         = trim($this->request->getPost('email'));
    $department_id = $this->request->getPost('department_id');
    $start_date    = $this->request->getPost('start_date');
    // Validatie
    $required = [
        'First name' => $first_name,
        'Last name'  => $last_name,
        'Email'      => $email,
        'Department' => $department_id,
        'Start date' => $start_date,
    ];

    foreach ($required as $label => $value) {
        if ($value === '' || $value === null) {
            session()->setFlashdata('error', "$label is required");
            return redirect()->to('/Home');
        }
    }
    try {
        // 1️⃣ Cognito user aanmaken
        $cognito = new \App\Libraries\CognitoService();
        $cognitoSub = $cognito->createUser($email, $first_name, $last_name, $department_id);
        // 2️⃣ Opslaan in je eigen database
        $this->AccountModel->onboard_employee(
            $cognitoSub,
            $first_name,
            $middle_name,
            $last_name,
            $email,
            $department_id,
            $start_date
        );

        session()->setFlashdata('success', 'Employee successfully onboarded');
        return redirect()->to('/Home');

    } catch (\Throwable $e) {

    debug([
        'class'   => get_class($e),
        'message' => $e->getMessage(),
        'code'    => $e->getCode(),
        'file'    => $e->getFile(),
        'line'    => $e->getLine(),
    ], true);
}
}

}
