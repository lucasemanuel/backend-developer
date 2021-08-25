<?php

namespace App\Factories;

use App\Models\Sale;
use App\Factories\CustomerFactory;
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

        $customer = CustomerFactory::create($customerName, $customerCep);
        $sale->setRelation('customer', $customer);

        return $sale;
    }
}
