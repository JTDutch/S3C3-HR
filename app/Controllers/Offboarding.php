<?php

namespace App\Controllers;

class Offboarding extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
    }

    public function delete($id)
    {
        if(isset($id)){

            $cognito = new \App\Libraries\CognitoService();
            $cognito_sub = $this->AccountModel->get_cognito_sub($id);
            $success_cognito = $cognito->deleteUser($cognito_sub);

            if($success_cognito){
                $success = $this->AccountModel->offboard_employee($id);
            }
            else{
                session()->setFlashdata('error', 'Employee offboarding failed');
                return redirect()->to('/Home');

            }

            if ($success){
                session()->setFlashdata('success', 'Employee offboarded successfully');
                return redirect()->to('/Home');
            }
            else{
                session()->setFlashdata('error', 'Employee offboarding failed');
                return redirect()->to('/Home');
                
            }
        }
        else{
            session()->setFlashdata('error', 'Employee offboarding failed');
            return redirect()->to('/Home');
        }

    }
}
