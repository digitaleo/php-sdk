<?php

namespace Digitaleo\SDK\Api\Authentication;

use Digitaleo\SDK\Api\Credentials;

/**
 * Class AuthenticationAdapter
 *
 * @package Digitaleo\SDK\Api\Authentication
 */
abstract class AuthenticationAdapter
{
    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * AuthenticationAdapter constructor.
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return $this
     */
    public abstract function authenticate();
}