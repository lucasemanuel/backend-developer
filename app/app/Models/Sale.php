<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'id', 'date', 'amount', 'customer', 'installments', 'totalInstallments'
    ];

    protected $hidden = [
        'totalInstallments'
    ];

    public function setTotalInstallmentsAttribute($value)
    {
        $installments = [];
        $valueByInstallment = $this->amount / $value;
        for ($i = 0; $i < $value; $i++) {
            $installment = new Installment([
                'amount' => $valueByInstallment
            ]);
            array_push($installments, $installment);
        }

        $this->setRelation('installments', collect($installments));
        $this->attributes['totalInstallments'] = $value;
    }
}
