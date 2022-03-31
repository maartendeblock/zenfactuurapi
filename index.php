<?php

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\Tests\Config;

require 'vendor/autoload.php';

$api = new \MaartenDeBlock\ZenFactuurApi\Apis\Customer(Config::API_TOKEN);

try {
//    var_dump($api->getAllAccountAssociatedWithOwnerAccount());
    var_dump($api->createCustomer([
        'client' => [
            'type_id' => 0,
            'name' => 'Sohel From Api2'
        ]]));
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}

