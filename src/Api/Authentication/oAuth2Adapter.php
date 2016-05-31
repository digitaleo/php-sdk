<?php

namespace Digitaleo\SDK\Api\Authentication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use RuntimeException;

/**
 * Class oAuth2Adapter
 *
 * @package Digitaleo\SDK\Api\Authentication
 */
class oAuth2Adapter extends AuthenticationAdapter
{
    /**
     * oAuth server's URL
     */
    const OAUTH_URL = 'https://oauth.messengeo.net/token';

    /**
     * Grant type
     */
    const GRANT_PASSWORD = 'client_credentials';

    /**
     * Authenticate the user
     *
     * @return $this
     * @throws RuntimeException
     */
    public function authenticate()
    {
        $client = new Client([
            'allow_redirects' => true,
        ]);

        $response = $client->post(
            self::OAUTH_URL, [
                'form_params' => $this->getCredentialsDetails(),
            ]
        );

        try {
            $body = json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $ce) {
            throw $ce;
        }

        if (! $body['access_token']) {
            throw new RuntimeException('No access token found');
        }

        $this->credentials->setToken($body['access_token']);

        return $this;
    }

    /**
     * Prepare the credentials
     *
     * @return array
     */
    private function getCredentialsDetails()
    {
        return [
            'client_id'     => $this->credentials->getClientId(),
            'client_secret' => $this->credentials->getClientSecret(),
            'grant_type'    => self::GRANT_PASSWORD,
            'username'      => $this->credentials->getUsername(),
            'password'      => $this->credentials->getPassword(),
        ];
    }
}