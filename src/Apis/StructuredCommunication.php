<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class StructuredCommunication extends ZenFactuurApi
{
    const GET_PROPOSAL_FOR_STRUCTURED_COMMUNICATION_URL = '/api/v2/proposed_invoice_ogm.json';

    /**
     *
     * @param string $serialNumber
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getProposalForStructuredCommunication(string $serialNumber = ''): array
    {
        $response = $this->makeGetRequest(self::GET_PROPOSAL_FOR_STRUCTURED_COMMUNICATION_URL, [
            'serial_number' => $serialNumber
        ]);

        return $this->returnBody($response);
    }
}