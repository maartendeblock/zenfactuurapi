<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Country extends ZenFactuurApi
{
    const GET_LIST_OF_COUNTRIES_URL = '/api/v2/country_names.json';

    /**
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getListOfStandardEuropeanCountries(): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_COUNTRIES_URL);

        return $this->returnBody($response);
    }
}
