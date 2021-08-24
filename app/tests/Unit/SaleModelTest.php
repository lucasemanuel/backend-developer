<?php

namespace Tests\Unit;

use App\Models\Installment;
use App\Models\Sale;
use Tests\TestCase;

class SaleModelTest extends TestCase
{
    /** @test */
    public function should_contain_list_installments_after_create()
    {
        $sale = new Sale([
            'id' => 01,
            'amount' => 12000,
            'totalInstallments' => 03
        ]);

        $this->assertInstanceOf(Installment::class, $sale->installments->first());
        $this->assertCount(3, $sale->installments);
    }
}
