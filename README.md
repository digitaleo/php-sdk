# This package is still in development, please do not use it in production

# Digitaleo PHP SDK

[![Latest Stable Version](https://poser.pugx.org/digitaleo/php-sdk/v/stable)](https://packagist.org/packages/digitaleo/php-sdk) [![Total Downloads](https://poser.pugx.org/digitaleo/php-sdk/downloads)](https://packagist.org/packages/digitaleo/php-sdk) [![Latest Unstable Version](https://poser.pugx.org/digitaleo/php-sdk/v/unstable)](https://packagist.org/packages/digitaleo/php-sdk) [![License](https://poser.pugx.org/digitaleo/php-sdk/license)](https://packagist.org/packages/digitaleo/php-sdk)

This library aims to give to developers a nice SDK to work with Digitaleo's APIs.

## How to use it

In your project directory :

Run

`composer require digitaleo/php-sdk`

And use it like this :


```php
<?php

require './vendor/autoload.php';

$credentials = new \Digitaleo\SDK\Api\Credentials(
    'your-client-id',
    'your-client-secret',
    'your-username',
    'your-password'
);
$adapter     = new \Digitaleo\SDK\Api\Authentication\oAuth2Adapter($credentials);
$client      = new \Digitaleo\SDK\Api\Client($adapter);

# How to post a contact
$response = $client->post('https://contacts.messengeo.net/rest/contacts', [
    'contacts' => [
        ['civility' => 'M', 'firstName' => 'Michel', 'lastName' => 'Patrick', 'phone' => '0605040302'],
    ],
]);

# How to retrieve your campaigns
$response = $client->get('https://api.messengeo.net/rest/campaigns');
```

## Roadmap

- [x] Basic HTTP Client with oAuth
- [ ] Add tests
- [ ] Add doc
- [ ] Find a way to avoid passing the complete URL as a resource
- [ ] Update HTTP Client to give a nice "Active Record" like interface