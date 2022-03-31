<?php

namespace MaartenDeBlock\Tests;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\Apis\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /**
     * @var Customer|null
     */
    private ?Customer $customer;

    protected function setUp(): void
    {
        $this->customer = new Customer(Config::API_TOKEN);
    }

    protected function tearDown(): void
    {
        $this->customer = NULL;
    }

    public function testCreateCustomer()
    {
        try {
            $customer = $this->customer->createCustomer([
                'client' => [
                    'type_id' => 0,
                    'name' => 'Sohel From Test'
                ]
            ]);
            $this->assertEquals('Sohel From Test', $customer->name);
        } catch (GuzzleException $e) {
            $this->fail($e->getMessage());
        }
    }
}