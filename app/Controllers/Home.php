<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
    }

    public function index()
    {

        $this->viewData['offboarded_employees'] = $this->AccountModel->get_offboarded_employees();
        $this->viewData['offboarded_employees_count'] = $this->AccountModel->get_offboarded_employees_count();
        $this->viewData['onboarded_employees'] = $this->AccountModel->get_onboarded_employees();
        $this->viewData['onboarded_employees_count'] = $this->AccountModel->get_onboarded_employees_count();
        $this->viewData['title'] = 'HR-Application | Home';
        $this->viewData['view'] = 'Home/index';
        echo view('template', $this->viewData);
    }
}
