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
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllCreditNotes(int $page = null, int $perPage = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_ALL_CREDIT_NOTE_URL, [
            'page' => $page,
            'per_page' => $perPage
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
    public function getCreditNote(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_CREDIT_NOTE_URL));

        return $this->returnBody($response);
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
     * @return array
     *
     * @throws GuzzleException
     */
    public function createCreditNote(array $postData): array
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_ALL_CREDIT_NOTE_URL, $postData);

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
     * For full list of available fields visit - https://app.zenfactuur.be/api_docs/v2/credit_notes/send_by_email.en.html
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function sendInvoiceViaEmailToCustomer(int $id, array $emailData): array
    {
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_CREDIT_NOTE_VIA_EMAIL_URL), $emailData);

        return $this->returnBody($response);
    }
}