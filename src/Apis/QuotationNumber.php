<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class QuotationNumber extends ZenFactuurApi
{
    const NEXT_QUOTATION_SERIAL_NUMBER_URL = '/api/v2/next_quotation_serial_number.json';

    /**
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getNextQuotationNumber(): array
    {
        $response = $this->makeGetRequest(self::NEXT_QUOTATION_SERIAL_NUMBER_URL);

        return $this->returnBody($response);
    }
}