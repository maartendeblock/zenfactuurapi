<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;
use MaartenDeBlock\ZenFactuurApi\Apis\PeppolLookup;

class Invoice extends ZenFactuurApi
{
    const GET_LIST_OF_All_INVOICES_URL = '/api/v2/invoices.json';
    const GET_LIST_OF_UNPAID_INVOICES_URL = '/api/v2/invoices/unpaid.json';
    const SPECIFIC_INVOICE_URL = '/api/v2/invoices/:id.json';
    const SEND_INVOICE_VIA_EMAIL_URL = '/api/v2/invoices/:id/send_by_email.json';
    const SEND_INVOICE_TO_PEPPOL_URL = '/api/v2/invoices/:id/send_to_peppol.json';

    /**
     * @param int|null $page
     * @param int|null $perPage
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllInvoices(int $page = null, int $perPage = null): array
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
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllUnpaidInvoices(int $page = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_UNPAID_INVOICES_URL, [
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
    public function getInvoice(int $id): array
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
     * @return array
     *
     * @throws GuzzleException
     */
    public function createInvoice(array $postData): array
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
     * @return array
     *
     * @throws GuzzleException
     */
    public function sendInvoiceViaEmailToCustomer(int $id, array $emailData): array
    {
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_INVOICE_VIA_EMAIL_URL), $emailData);

        return $this->returnBody($response);
    }

    /**
     * Send invoice to Peppol network
     *
     * @param int $id
     * @param array $data
     * @param bool $checkParticipant Whether to check if participant is registered in Peppol before sending
     *
     * For full list of available fields visit - https://app.zenfactuur.be/api_docs/v2/invoices/send_to_peppol.en.html
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws \Exception
     */
    public function sendInvoiceToPeppol(int $id, array $data = [], bool $checkParticipant = true): array
    {
        if ($checkParticipant) {
            // Get invoice details to find customer VAT
            $invoice = $this->getInvoice($id);
            $vatNumber = $invoice['client']['vat_number'] ?? null;
            
            if ($vatNumber) {
                $peppolLookup = new PeppolLookup();
                $lookupResult = $peppolLookup->checkParticipantByVat($vatNumber);
                
                if ($lookupResult['rate_limited']) {
                    throw new \Exception('Peppol lookup service is rate limited. Please try again later.');
                }
                
                if (!$lookupResult['is_registered']) {
                    $participantId = $lookupResult['participant_id'] ?? 'unknown';
                    throw new \Exception("Customer with VAT $vatNumber (Peppol ID: $participantId) is not registered in Peppol network. Cannot send invoice via Peppol.");
                }
            } else {
                throw new \Exception('Customer does not have a VAT number. Cannot check Peppol registration.');
            }
        }
        
        $response = $this->makePostRequest(str_replace(':id', $id, self::SEND_INVOICE_TO_PEPPOL_URL), $data);

        return $this->returnBody($response);
    }
    
    /**
     * Send invoice via Peppol or fall back to email
     * 
     * Attempts to send invoice via Peppol first. If the customer is not registered
     * in Peppol or if Peppol sending fails, falls back to email.
     *
     * @param int $id Invoice ID
     * @param array $emailData Email data including 'to' address
     * @param array $peppolData Optional Peppol data
     *
     * @return array Result with 'method' indicating how invoice was sent
     *
     * @throws GuzzleException
     */
    public function sendInvoiceViaPeppolOrEmailToCustomer(int $id, array $emailData, array $peppolData = []): array
    {
        // First, try to send via Peppol
        try {
            $peppolResult = $this->sendInvoiceToPeppol($id, $peppolData, true);
            
            return [
                'success' => true,
                'method' => 'peppol',
                'result' => $peppolResult,
                'message' => 'Invoice successfully sent via Peppol network'
            ];
        } catch (\Exception $peppolException) {
            // Peppol failed, try email as fallback
            try {
                $emailResult = $this->sendInvoiceViaEmailToCustomer($id, $emailData);
                
                return [
                    'success' => true,
                    'method' => 'email',
                    'result' => $emailResult,
                    'message' => 'Invoice sent via email (Peppol not available)',
                    'peppol_error' => $peppolException->getMessage()
                ];
            } catch (\Exception $emailException) {
                // Both methods failed
                return [
                    'success' => false,
                    'method' => 'none',
                    'result' => null,
                    'message' => 'Failed to send invoice via both Peppol and email',
                    'peppol_error' => $peppolException->getMessage(),
                    'email_error' => $emailException->getMessage()
                ];
            }
        }
    }
}
