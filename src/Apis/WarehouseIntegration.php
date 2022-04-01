<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class WarehouseIntegration extends ZenFactuurApi
{
    const LINK_WAREHOUSE_SETTING_URL = '/api/v2/magazijnier_settings/link_to_magazijnier.json';

    /**
     *
     * usage:
     * $postData = [
     *    'financial_transaction' => ['magazijnier_api_token' => '12','use_magazijnier_from_fiscal_year' => '2012']
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/magazijnier_settings/link_to_magazijnier.en.html
     *
     * @param array $postData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function linkWarehouseSetting(array $postData): array
    {
        $response = $this->makePostRequest(self::LINK_WAREHOUSE_SETTING_URL, $postData);

        return $this->returnBody($response);
    }
}