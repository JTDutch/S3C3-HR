<?php

namespace App\Controllers;

use Config\Cognito; 

class Logout extends BaseController
{
    protected Cognito $cognito;

    public function __construct()
    {
        $this->cognito = new Cognito();
    }

    public function index()
    {
        // 1️⃣ Sessie verwijderen
        session()->destroy();

        // 2️⃣ Cognito logout URL
        $logoutUrl = rtrim($this->cognito->domain, '/') . '/logout?' . http_build_query([
            'client_id'    => $this->cognito->clientId,
            'logout_uri'   => $this->cognito->logout_url, // waar je na logout heen wilt
            'response_type'=> 'code', // verplicht voor Cognito
        ]);

        // 3️⃣ Redirect naar Cognito
        return redirect()->to($logoutUrl);
    }
}
