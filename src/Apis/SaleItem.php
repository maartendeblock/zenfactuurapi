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
     * @return array
     *
     * @throws GuzzleException
     */
    public function getListOfSaleItems(int $page = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_SALE_ITEM_URL, [
            'page' => $page
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getSaleItem(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_SALE_ITEM_URL));

        return $this->returnBody($response);
    }
}