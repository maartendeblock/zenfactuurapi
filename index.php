<?php

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeblock\zenfactuurapi\Apis\ApiToken;
use MaartenDeblock\zenfactuurapi\Apis\Customer;

require 'vendor/autoload.php';

$apiToken = 'write_token_here_to_test';

$api = new \MaartenDeBlock\ZenFactuurApi\Apis\Bill($apiToken);

try {
    var_dump($api->getAllAccountAssociatedWithOwnerAccount());
//    var_dump($api->customizeCustomer(373424, [
//        'client' => [
//            'type_id' => 0,
//            'name' => 'Sohel From Api2'
//        ]]));
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}

