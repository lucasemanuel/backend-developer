<?php

namespace Tests\Integration;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    /** @test */
    public function should_return_interpreted_sales()
    {
        $content = '23120201014000026380003Comprador 3         01454000';
        $file = UploadedFile::fake()->createWithContent('file.txt', $content);
        $this->post('sales/', [
            'file' => $file
        ])->seeJsonEquals([
            'sales' => [
                0 => [
                    'id' => 231,
                    'date' => '2020-10-14',
                    'amount' => '2638.00',
                    'customer' => [
                        'name' => 'Comprador 3',
                        'address' => [
                            'street' => 'Avenida Cidade Jardim',
                            'neighborhood' => 'Jardim Paulistano',
                            'city' => 'São Paulo',
                            'state' => 'SP',
                            'postal_code' => '01454-000',
                        ],
                    ],
                    'installments' => [
                        0 => [
                            'installment' => 1,
                            'amount' => '879.34',
                            'date' => '2020-11-16',
                        ],
                        1 => [
                            'installment' => 2,
                            'amount' => '879.33',
                            'date' => '2020-12-14',
                        ],
                        2 => [
                            'installment' => 3,
                            'amount' => '879.33',
                            'date' => '2021-01-14',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
