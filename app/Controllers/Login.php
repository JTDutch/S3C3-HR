<?php

namespace App\Controllers;

use Config\Cognito; 

class Login extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
        $this->cognito = new Cognito();
    }

    public function index()
    {
        $this->viewData['title'] = 'HR-Application | Login';
        $this->viewData['view'] = 'Login/index';
        echo view('template', $this->viewData);
    }

public function callback()
{
    $code = $this->request->getGet('code');
    if (!$code) {
        return $this->response
            ->setStatusCode(400)
            ->setBody('No authorization code received from Cognito.');
    }

    // Cognito config
    $cognitoConfig = $this->cognito;
    $tokenUrl      = rtrim($cognitoConfig->domain, '/') . '/oauth2/token';
    $clientId      = $cognitoConfig->clientId;
    $clientSecret  = $cognitoConfig->secret;
    $redirectUri   = $cognitoConfig->callback_url; // variabele redirect URL

    // Token request
    $postData = http_build_query([
        'grant_type'   => 'authorization_code',
        'client_id'    => $clientId,
        'code'         => $code,
        'redirect_uri' => $redirectUri,
    ]);

    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret),
    ];

    $context = stream_context_create([
        'http' => [
            'method'        => 'POST',
            'header'        => implode("\r\n", $headers),
            'content'       => $postData,
            'timeout'       => 15,
            'ignore_errors' => true,
        ],
        'ssl' => [
            'verify_peer'      => true,
            'verify_peer_name' => true,
        ],
    ]);

    $response = file_get_contents($tokenUrl, false, $context);
    $tokens   = json_decode($response, true);

    if (!is_array($tokens) || !isset($tokens['access_token'], $tokens['id_token'])) {
        log_message('error', 'Cognito token exchange failed: ' . $response);
        return $this->response
            ->setStatusCode(401)
            ->setBody('Authentication failed.');
    }

    // Tokens opslaan in session
    session()->set([
        'logged_in'      => true,
        'access_token'   => $tokens['access_token'],
        'id_token'       => $tokens['id_token'],
        'refresh_token'  => $tokens['refresh_token'] ?? null,
    ]);

    // Decode id_token voor username
    $idTokenPayload = json_decode(base64_decode(explode('.', $tokens['id_token'])[1]), true);
    $username       = $idTokenPayload['cognito:username'] ?? null;

    if (!$username) {
        log_message('error', 'ID token missing username.');
        return redirect()->to('/login')->with('error', 'Login failed.');
    }

    try {
        // Cognito client
        $cognito = new \Aws\CognitoIdentityProvider\CognitoIdentityProviderClient([
            'version'     => '2016-04-18',
            'region'      => $cognitoConfig->region,
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Groepen ophalen
        $result = $cognito->adminListGroupsForUser([
            'UserPoolId' => $cognitoConfig->userPoolId,
            'Username'   => $username,
        ]);

        $groups = array_column($result['Groups'], 'GroupName');

        $groupIdMap = [
            'IT'        => 1,
            'Marketing' => 2,
            'HR'        => 3,
        ];

        $userGroupName = null;
        $userGroupId   = null;
        foreach ($groupIdMap as $groupName => $id) {
            if (in_array($groupName, $groups)) {
                $userGroupName = $groupName;
                $userGroupId   = $id;
                break; // Stop bij de eerste gevonden
            }
        }

        session()->set([
            'group'    => $userGroupName, // HR / IT / Marketing
            'group_id' => $userGroupId,   // 1 / 2 / 3
        ]);


        // Redirect op basis van groep
        return redirect()->to('/Home');

    } catch (\Throwable $e) {
        log_message('error', 'Failed to get user groups: ' . $e->getMessage());

        return redirect()->to('/login')->with('error', 'Login failed.');
    }
}


}
