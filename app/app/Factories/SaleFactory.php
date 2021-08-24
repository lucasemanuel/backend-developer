<?php

namespace App\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Sale;
use App\Services\CepService;
use App\Helpers\FileHelper;

class SaleFactory
{
    public static function create($id, $date, $amount, $totalInstallments, $customerName, $customerCep): Sale
    {
        $date = new \DateTime(implode('-', FileHelper::splitBySizes($date, [4, 2, 2])));
        $sale = new Sale([
            'id' => $id,
            'date' => $date,
            'amount' => $amount,
            'totalInstallments' => $totalInstallments
        ]);
        $customer = self::createCustomer($customerName, $customerCep);
        $sale->setRelation('customer', $customer);

        return $sale;
    }

    private static function createCustomer($name, $cep): Customer
    {
        $addressData = CepService::fetchAddress($cep);
        $address = new Address($addressData);

        $customer = new Customer([
            'name' => $name,
        ]);

        $customer->setRelation('address', $address);
        return $customer;
    }
}
