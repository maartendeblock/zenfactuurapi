<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Customer extends ZenFactuurApi
{
    const GET_LIST_OF_CUSTOMER_URL = '/api/v2/clients.json';
    const SEARCH_ALL_CUSTOMER_URL = '/api/v2/clients/search.json';
    const SPECIFIC_CUSTOMER_URL = '/api/v2/clients/:id.json';
    const VALID_VAT_NUMBER_URL = '/api/v2/clients/valid_be_vat_number.json';

    /**
     * @param int|null $page
     * @param int|null $perPage
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllCustomers(int $page = null, int $perPage = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_CUSTOMER_URL, [
            'page' => $page,
            'per_page' => $perPage
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param string $q
     * @param string $phone
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function searchAllCustomers(string $q = '', string $phone = '', int $page = null): array
    {
        $response = $this->makeGetRequest(self::SEARCH_ALL_CUSTOMER_URL, [
            'q' => $q,
            'phone' => $phone,
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
    public function getCustomer(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_CUSTOMER_URL));

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $postData = ['client' => ['type_id' => 0,'name' => 'Sohel From Api']]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/clients/create.en.html
     *
     * @param array $postData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function createCustomer(array $postData): array
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_CUSTOMER_URL, $postData);

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $updatedData = ['client' => ['type_id' => 0,'name' => 'Sohel From Api']]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/clients/update.en.html
     *
     * @param int $id
     * @param array $updatedData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function customizeCustomer(int $id, array $updatedData): array
    {
        $response = $this->makePutRequest(str_replace(':id', $id, self::SPECIFIC_CUSTOMER_URL), $updatedData);

        return $this->returnBody($response);
    }

    /**
     * @param string $vatNumber
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function checkVatNumberIsValid(string $vatNumber): array
    {
        $response = $this->makeGetRequest(self::VALID_VAT_NUMBER_URL, [
            'vat_number' => $vatNumber
        ]);

        return $this->returnBody($response);
    }
}