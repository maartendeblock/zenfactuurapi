<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Payment extends ZenFactuurApi
{
    const NEW_PAYMENT_FROM_SALE_URL = '/api/v2/financial_transactions.json';

    /**
     *
     * usage:
     * $postData = [
     *    'financial_transaction' => ['sale_id' => 1,'date' => '2022-03-31', 'storage_id' => 1, 'amount' => '50']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/financial_transactions/create.en.html
     *
     * @param array $postData
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function createPaymentFromSale(array $postData)
    {
        $response = $this->makePostRequest(self::NEW_PAYMENT_FROM_SALE_URL, $postData);

        return json_decode($response->getBody());
    }
}