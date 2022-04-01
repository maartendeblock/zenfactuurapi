<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class VatPercentage extends ZenFactuurApi
{
    const GET_LIST_OF_VAT_PERCENTAGE_URL = '/api/v2/vat_rates.json';

    /**
     * @param string $country
     *
     * For list of available countries visit - https://app.zenfactuur.be/api_docs/v2/vat_rates/index.en.html
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getListOfVatPercentageUsedInEuropeanCountries(string $country = ''): array
    {
        $urlParams = [];
        if (!empty($country)) {
            $urlParams['country'] = $country;
        }
        $response = $this->makeGetRequest(self::GET_LIST_OF_VAT_PERCENTAGE_URL, $urlParams);

        return $this->returnBody($response);
    }
}