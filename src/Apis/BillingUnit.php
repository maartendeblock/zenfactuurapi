<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class BillingUnit extends ZenFactuurApi
{
    const GET_LIST_OF_BILLING_UNIT_URL = '/api/v2/units.json';
    const SPECIFIC_BILLING_UNIT_URL = '/api/v2/units/:id.json';

    /**
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getListOfBillingUnits()
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_BILLING_UNIT_URL);

        return json_decode($response->getBody());
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getBillingUnit(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_BILLING_UNIT_URL));

        return json_decode($response->getBody());
    }
}