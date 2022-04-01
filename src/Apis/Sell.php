<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Sell extends ZenFactuurApi
{
    const GET_LIST_OF_SELL_URL = '/api/v2/sales.json';
    const SEARCH_ALL_SELL_URL = '/api/v2/sales/search.json';
    const SPECIFIC_SELL_URL = '/api/v2/sales/:id.json';

    /**
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getAllSells(int $page = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_SELL_URL, [
            'page' => $page,
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param string $q
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function searchAllSells(string $q = '', int $page = null)
    {
        $response = $this->makeGetRequest(self::SEARCH_ALL_SELL_URL, [
            'q' => $q,
            'page' => $page
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getSell(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_SELL_URL));

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $postData = [
     *    'client' => ['type_id' => 0,'name' => 'Sohel From Api'],
     *    'sale' => ['date' => '2022-03-31']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/sales/create.en.html
     *
     * @param array $postData
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function createSell(array $postData)
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_SELL_URL, $postData);

        return $this->returnBody($response);
    }
}