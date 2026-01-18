<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cognito extends BaseConfig
{
    public string $userPoolId;
    public string $clientId;
    public string $domain;
    public string $region;
    public string $secret;
    public string $callback_url;
    public string $logout_url;
    public string $login_url;


    public function __construct()
    {
        $this->userPoolId       = getenv('COGNITO_USER_POOL_ID');
        $this->clientId         = getenv('COGNITO_CLIENT_ID');
        $this->domain           = getenv('COGNITO_DOMAIN');
        $this->region           = getenv('AWS_REGION');
        $this->secret           = getenv('COGNITO_CLIENT_SECRET');
        $this->callback_url     = getenv('COGNITO_CALLBACK_URL');
        $this->logout_url       = getenv('COGNITO_LOGOUT_URL');
        $this->login_url       = getenv('COGNITO_LOGIN_URL');

    }
}
