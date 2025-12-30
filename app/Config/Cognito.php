<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cognito extends BaseConfig
{
    public string $userPoolId;
    public string $clientId;
    public string $domain;
    public string $region;

    public function __construct()
    {
        $this->userPoolId = getenv('COGNITO_USER_POOL_ID');
        $this->clientId   = getenv('COGNITO_CLIENT_ID');
        $this->domain     = getenv('COGNITO_DOMAIN');
        $this->region     = getenv('COGNITO_REGION');
    }
}
