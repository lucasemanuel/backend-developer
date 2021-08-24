<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];

    protected $fillable = [
        'id', 'date', 'amount', 'customer', 'installments', 'totalInstallments'
    ];

    protected $hidden = [
        'totalInstallments'
    ];

    public function setAmountAttribute($value)
    {
        $value = strval($value);
        $value = substr_replace($value, '.', -2, 0);
        $this->attributes['amount'] = number_format((float) $value, 2, '.', '');
    }

    public function setTotalInstallmentsAttribute($value)
    {
        $installments = [];
        $amount = number_format((floor(($this->amount / $value) * 100) / 100), 2, '.', '');
        $amountFirtsInstallment = number_format(($this->amount - ($amount * $value)), 2, '.', '');
        for ($i = 0; $i < $value; $i++) {
            $amountInstallment = $amount;
            if ($i == 0) {
                $amountInstallment += $amountFirtsInstallment;
            }
            $installment = new Installment([
                'installment' => $i + 1,
                'amount' => $amountInstallment
            ]);
            array_push($installments, $installment);
        }

        $this->setRelation('installments', collect($installments));
        $this->attributes['totalInstallments'] = $value;
    }
}
