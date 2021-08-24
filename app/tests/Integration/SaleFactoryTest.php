<?php

namespace Tests\Integration;

use App\Factories\SaleFactory;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Sale;
use Tests\TestCase;

class SaleFactoryTest extends TestCase
{
    /** @test */
    public function should_return_a_sale_model()
    {
        list($id, $date, $amount, $totalInstallments, $customerName, $customerCep) = [
            01, '20201003', 219090, 04, 'any_name', '01001000'
        ];
        $sale = SaleFactory::create($id, $date, $amount, $totalInstallments, $customerName, $customerCep);
        $this->assertInstanceOf(Sale::class, $sale);
    }

    /** @test */
    public function should_contain_id_date_amount_customer_installments()
    {
        list($id, $date, $amount, $totalInstallments, $customerName, $customerCep) = [
            01, '20201003', 219090, 04, 'any_name', '01001000'
        ];
        $sale = SaleFactory::create($id, $date, $amount, $totalInstallments, $customerName, $customerCep);
        $this->assertIsNumeric($sale->id);
        $this->assertEquals('2020-10-03', $sale->toArray()['date']);
        $this->assertIsNumeric($sale->amount);
        $this->assertInstanceOf(Customer::class, $sale->customer);
        $this->assertCount(4, $sale->installments);
        $this->assertInstanceOf(Installment::class, $sale->installments->first());
    }
}
