<?php

namespace Tests\Integration;

use App\Services\CepService;
use Tests\TestCase;

class CepServiceTest extends TestCase
{
    /** @test */
    public function should_return_address_by_cep()
    {
        $cep = '59380000';
        $address = CepService::fetchCep($cep);
        $this->assertEquals([
            'state' => 'RN',
            'city' => 'Currais Novos',
            'neighborhood' => '',
            'street' => '',
            'postal_code' => '59380-000'
        ], $address);
    }
}
