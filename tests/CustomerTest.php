<?php

namespace MaartenDeBlock\Tests;

use Faker\Factory;
use Faker\Generator;
use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\Apis\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /**
     * @var Customer|null
     */
    private ?Customer $customer;

    /**
     * @var Generator
     */
    private Generator $faker;

    protected function setUp(): void
    {
        $this->customer = new Customer(Config::API_TOKEN);
        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->customer = NULL;
    }

    public function testCreateCustomer()
    {
        try {
            $name = $this->faker->name;
            $customer = $this->customer->createCustomer([
                'client' => [
                    'type_id' => 0,
                    'name' => $name
                ]
            ]);
            $this->assertEquals($name, $customer->name);
        } catch (GuzzleException $e) {
            $this->fail($e->getMessage());
        }
    }
}