<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class CreditNote extends ZenFactuurApi
{
    const GET_LIST_OF_ALL_CREDIT_NOTE_URL = '/api/v2/credit_notes.json';
    const SPECIFIC_CREDIT_NOTE_URL = '/api/v2/credit_notes/:id.json';
    const SEND_CREDIT_NOTE_VIA_EMAIL_URL = '/api/v2/credit_notes/:id/send_by_email.json';

    /**
     * @param int|null $page
     * @param int|null $perPage
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function getAllCreditNotes(int $page = null, int $perPage = null)
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_ALL_CREDIT_NOTE_URL, [
            'page' => $page,
            'per_page' => $perPage
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
    public function getCreditNote(int $id)
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_CREDIT_NOTE_URL));

        return json_decode($response->getBody());
    }

    /**
     *
     * usage:
     * $postData = [
     *    'client' => ['type_id' => 0,'name' => 'Sohel From Api'],
     *    'credit_note' => ['serial_number' => '1234', 'date' => '2022-03-31']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/credit_notes/create.en.html
     *
     * @param array $postData
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function createCreditNote(array $postData)
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_ALL_CREDIT_NOTE_URL, $postData);

        return json_decode($response->getBody());
    }

    /**
     *
     * usage:
     * $emailData = ['to' => 'example@gmail.com']
     *
     * @param int $id
     * @param array $emailData
     *
     * For full list of available fields visit - https://app.zenfactuur.be/api_docs/v2/credit_notes/send_by_email.en.html
     *
     * @return mixed
     *
     * @throws GuzzleException
     */
    public function sendInvoiceViaEmailToCustomer(int $id, array $emailData)
    {
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_CREDIT_NOTE_VIA_EMAIL_URL), $emailData);

        return json_decode($response->getBody());
    }
}