<?php

namespace App\Factories;

use App\Models\Customer;
use App\Services\CepService;

class CustomerFactory
{
    public static function create($name, $cep): Customer
    {
        $address = CepService::fetchAddress($cep);
        $customer = new Customer([
            'name' => $name,
        ]);

        $customer->setRelation('address', $address);
        return $customer;
    }
}
