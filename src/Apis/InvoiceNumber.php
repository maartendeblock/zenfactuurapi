<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class InvoiceNumber extends ZenFactuurApi
{
    const NEXT_INVOICE_SERIAL_NUMBER_URL = '/api/v2/next_invoice_serial_number.json';

    /**
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getNextInvoiceSerialNumber()
    {
        $response = $this->makeGetRequest(self::NEXT_INVOICE_SERIAL_NUMBER_URL);

        return json_decode($response->getBody());
    }
}