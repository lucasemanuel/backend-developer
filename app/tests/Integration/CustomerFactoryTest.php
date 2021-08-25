<?php

namespace Tests\Integration;

use App\Models\Address;
use App\Models\Customer;
use App\Factories\CustomerFactory;
use Tests\TestCase;

class CustomerFactoryTest extends TestCase
{
    /** @test */
    public function should_return_a_customer()
    {
        $customer = CustomerFactory::create('Full Name', '01001000');
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertInstanceOf(Address::class, $customer->address);
    }
}
