<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Quotation extends ZenFactuurApi
{
    const GET_LIST_OF_All_QUOTATION_URL = '/api/v2/quotations.json';
    const SPECIFIC_QUOTATION_URL = '/api/v2/quotations/:id.json';
    const SEND_QUOTATION_VIA_EMAIL_URL = '/api/v2/quotations/:id/send_by_email.json';

    /**
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllQuotations(int $page = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_All_QUOTATION_URL, [
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
    public function getQuotation(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_QUOTATION_URL));

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $postData = [
     *    'client' => ['type_id' => 0,'name' => 'Sohel From Api'],
     *    'quotation' => ['serial_number' => '1234', 'date' => '2022-03-31']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/quotations/create.en.html
     *
     * @param array $postData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function createQuotation(array $postData): array
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_All_QUOTATION_URL, $postData);

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $emailData = ['to' => 'example@gmail.com']
     *
     * @param int $id
     * @param array $emailData
     *
     * For full list of available fields visit - https://app.zenfactuur.be/api_docs/v2/quotations/send_by_email.en.html
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function sendQuotationViaEmailToCustomer(int $id, array $emailData): array
    {
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_QUOTATION_VIA_EMAIL_URL), $emailData);

        return $this->returnBody($response);
    }
}
