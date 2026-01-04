<?php

namespace App\Libraries;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Config\Cognito;

class CognitoService
{
    private CognitoIdentityProviderClient $client;
    private Cognito $config;

    public function __construct()
    {
        $this->config = config('Cognito');

        $this->client = new CognitoIdentityProviderClient([
            'region'  => $this->config->region,
            'version' => '2016-04-18',
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param int    $departmentId (1 = HR, 2 = IT, 3 = Marketing)
     * @return string Cognito sub
     */
    public function createUser(string $email, string $firstName, string $lastName, int $departmentId): string
    {
        $result = $this->client->adminCreateUser([
            'UserPoolId' => $this->config->userPoolId,
            'Username'   => $email,
            'UserAttributes' => [
                ['Name' => 'email', 'Value' => $email],
                ['Name' => 'email_verified', 'Value' => 'true'],
                ['Name' => 'given_name', 'Value' => $firstName],
                ['Name' => 'family_name', 'Value' => $lastName],
            ],
            'DesiredDeliveryMediums' => ['EMAIL'],
        ]);

        // Haal de Cognito sub op
        $sub = null;
        foreach ($result['User']['Attributes'] as $attr) {
            if ($attr['Name'] === 'sub') {
                $sub = $attr['Value'];
                break;
            }
        }

        if (!$sub) {
            throw new \RuntimeException('Cognito user created but sub not found');
        }

        // Voeg de user toe aan de juiste groep
        $groupMap = [
            1 => 'IT',
            2 => 'Marketing',
            3 => 'HR',
        ];

        if (isset($groupMap[$departmentId])) {
            $this->client->adminAddUserToGroup([
                'UserPoolId' => $this->config->userPoolId,
                'Username'   => $email,
                'GroupName'  => $groupMap[$departmentId],
            ]);
        }

        return $sub;
    }
}
