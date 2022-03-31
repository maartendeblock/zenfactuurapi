<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Purchase extends ZenFactuurApi
{
    const GET_LIST_OF_PURCHASE_URL = '/api/v2/purchases.json';
    const SEARCH_ALL_PURCHASE_URL = '/api/v2/purchases/search.json';
    const SPECIFIC_PURCHASE_URL = '/api/v2/purchases/:id.json';

    /**
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getAllPurchases(int $page = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_PURCHASE_URL, [
            'page' => $page,
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param string $q
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function searchAllPurchases(string $q = '', int $page = null)
    {
        $response = $this->makeGetRequest(self::SEARCH_ALL_PURCHASE_URL, [
            'q' => $q,
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
    public function getPurchase(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_PURCHASE_URL));

        return json_decode($response->getBody());
    }

    /**
     *
     * usage:
     * $postData = ['supplier' => ['type_id' => 0,'name' => 'Sohel From Api']]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/purchases/create.en.html
     *
     * @param array $postData
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function createPurchase(array $postData)
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_PURCHASE_URL, $postData);

        return json_decode($response->getBody());
    }
}