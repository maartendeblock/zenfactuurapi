<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class ApiToken extends ZenFactuurApi
{
    const GET_EMAIL_OR_USERNAME_URL = '/api/v2/api_tokens.json';

    /**
     * @throws GuzzleException
     */
    public function getEmailOrUserName()
    {
        $response = $this->makeGetRequest(self::GET_EMAIL_OR_USERNAME_URL);

        return json_decode($response->getBody());
    }
}