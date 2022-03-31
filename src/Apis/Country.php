<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Country extends ZenFactuurApi
{
    const GET_LIST_OF_COUNTRIES_URL = '/api/v2/country_names.json';

    /**
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getListOfStandardEuropeanCountries()
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_COUNTRIES_URL);

        return json_decode($response->getBody());
    }
}