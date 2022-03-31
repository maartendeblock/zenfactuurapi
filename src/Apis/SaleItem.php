<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class SaleItem extends ZenFactuurApi
{
    const GET_LIST_OF_SALE_ITEM_URL = '/api/v2/skus.json';
    const SPECIFIC_SALE_ITEM_URL = '/api/v2/skus/:id.json';

    /**
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getListOfSaleItems(int $page = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_SALE_ITEM_URL, [
            'page' => $page
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getSaleItem(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_SALE_ITEM_URL));

        return json_decode($response->getBody());
    }
}