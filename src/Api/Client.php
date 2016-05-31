<?php

namespace Digitaleo\SDK\Api;

use Digitaleo\SDK\Api\Authentication\AuthenticationAdapter;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 *
 * @package Digitaleo\SDK\Api
 */
class Client
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var CookieJar
     */
    protected $cookieJar;

    /**
     * @var AuthenticationAdapter
     */
    private $authenticationAdapter;

    /**
     * Client constructor.
     *
     * @param AuthenticationAdapter $authenticationAdapter
     */
    public function __construct(AuthenticationAdapter $authenticationAdapter)
    {
        $this->authenticationAdapter = $authenticationAdapter;

        $this->initClient();
    }

    /**
     * Init the HTTP Client
     *
     * @return $this
     */
    protected function initClient()
    {
        $this->authenticationAdapter->authenticate();

        $this->cookieJar = new CookieJar();
        $this->client    = new HttpClient([
            'allow_redirects' => true,
            'cookies'         => $this->cookieJar,
        ]);

        return $this;
    }

    /**
     * Get default headers
     *
     * @return array
     */
    protected function defaultHeaders()
    {
        return [
            'Authorization' => sprintf('Bearer %s', $this->authenticationAdapter->getCredentials()->getToken()),
            'Content-Type'  => [],
            'Accept'        => '',
        ];
    }

    /**
     * Build and send a request
     *
     * @param string $method
     * @param string $resource
     * @param array  $options
     *
     * @return ResponseInterface
     */
    protected function request($method, $resource, array $options = [])
    {
        $options = array_merge(
            $options,
            ['headers' => $this->defaultHeaders()]
        );

        try {
            $response = $this->client->request($method, $resource, $options);
        } catch (ClientException $ce) {
            if (400 === $ce->getResponse()->getStatusCode()) {
                $this->authenticationAdapter->authenticate();
            }

            $response = $this->client->request($method, $resource, $options);
        }

        return $response;
    }

    /**
     * Build a get request
     *
     * @param string $resource
     * @param array  $parameters
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function get($resource, array $parameters = [], array $headers = [])
    {
        return $this->request('GET', $resource, [
            'query'   => $parameters,
            'headers' => $headers,
        ]);
    }

    /**
     * Build a post request
     *
     * @param string $resource
     * @param array  $parameters
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function post($resource, array $parameters = [], $headers = [])
    {
        return $this->request('POST', $resource, [
            'form_params' => $parameters,
            'headers'     => $headers,
        ]);
    }

    /**
     * Build a put request
     *
     * @param string $resource
     * @param array  $parameters
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function put($resource, array $parameters = [], $headers = [])
    {
        return $this->request('PUT', $resource, [
            'form_params' => $parameters,
            'headers'     => $headers,
        ]);
    }

    /**
     * Build a delete request
     *
     * @param string $resource
     * @param array  $parameters
     * @param array  $headers
     */
    public function delete($resource, array $parameters = [], array $headers = [])
    {
        $this->request('DELETE', $resource, [
            'query'   => $parameters,
            'headers' => $headers,
        ]);
    }
}
