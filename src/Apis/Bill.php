<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Bill extends ZenFactuurApi
{
    const GET_ALL_ACCOUNT_ASSOCIATED_WITH_OWNER_ACCOUNT_URL = '/api/v2/money_accounts.json';

    /**
     *
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllAccountAssociatedWithOwnerAccount(int $page = null): array
    {
        $response = $this->makeGetRequest(self::GET_ALL_ACCOUNT_ASSOCIATED_WITH_OWNER_ACCOUNT_URL, [
            'page' => $page
        ]);

        return $this->returnBody($response);
    }
}
