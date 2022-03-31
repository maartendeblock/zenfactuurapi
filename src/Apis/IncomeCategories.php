<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class IncomeCategories extends ZenFactuurApi
{
    const GET_LIST_OF_SALES_CATEGORIES_URL = '/api/v2/sales_categories.json';
    const SPECIFIC_SALES_CATEGORIES_URL = '/api/v2/sales_categories/:id.json';

    /**
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getListOfRevenueCategories(int $page = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_SALES_CATEGORIES_URL, [
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
    public function getRevenueCategory(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_SALES_CATEGORIES_URL));

        return json_decode($response->getBody());
    }
}