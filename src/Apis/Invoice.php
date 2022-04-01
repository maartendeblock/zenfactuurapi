<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Invoice extends ZenFactuurApi
{
    const GET_LIST_OF_All_INVOICES_URL = '/api/v2/invoices.json';
    const GET_LIST_OF_UNPAID_INVOICES_URL = '/api/v2/invoices/unpaid.json';
    const SPECIFIC_INVOICE_URL = '/api/v2/invoices/:id.json';
    const SEND_INVOICE_VIA_EMAIL_URL = '/api/v2/invoices/:id/send_by_email.json';

    /**
     * @param int|null $page
     * @param int|null $perPage
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getAllInvoices(int $page = null, int $perPage = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_All_INVOICES_URL, [
            'page' => $page,
            'per_page' => $perPage
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param int|null $page
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getAllUnpaidInvoices(int $page = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_UNPAID_INVOICES_URL, [
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
    public function getInvoice(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_INVOICE_URL));

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $postData = [
     *    'client' => ['type_id' => 0,'name' => 'Sohel From Api'],
     *    'invoice' => ['serial_number' => '1234', 'date' => '2022-03-31']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/invoices/create.en.html
     *
     * @param array $postData
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function createInvoice(array $postData)
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_All_INVOICES_URL, $postData);

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
     * For full list of available fields visit - https://app.zenfactuur.be/api_docs/v2/invoices/send_by_email.en.html
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function sendInvoiceViaEmailToCustomer(int $id, array $emailData)
    {
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_INVOICE_VIA_EMAIL_URL), $emailData);

        return $this->returnBody($response);
    }
}