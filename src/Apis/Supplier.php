<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Supplier extends ZenFactuurApi
{
    const GET_LIST_OF_SUPPLIER_URL = '/api/v2/suppliers.json';
    const SEARCH_ALL_SUPPLIER_URL = '/api/v2/suppliers.json';
    const SPECIFIC_SUPPLIER_URL = '/api/v2/suppliers/:id.json';

    /**
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getListOfSuppliers(int $page = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_SUPPLIER_URL, [
            'page' => $page
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param string $q
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function searchAllSuppliers(string $q = '', int $page = null): array
    {
        $response = $this->makeGetRequest(self::SEARCH_ALL_SUPPLIER_URL, [
            'q' => $q,
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
    public function getSuppler(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_SUPPLIER_URL));

        return $this->returnBody($response);
    }
}