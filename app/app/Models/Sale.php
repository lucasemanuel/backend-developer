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
        $this->setInstallments($value);
        $this->attributes['totalInstallments'] = $value;
    }

    private function setInstallments($total)
    {
        $installments = [];
        $dividedAmount = number_format((floor(($this->amount / $total) * 100) / 100), 2, '.', '');
        $restAmount = number_format(($this->amount - ($dividedAmount * $total)), 2, '.', '');

        for ($i = 0; $i < $total; $i++) {
            $amountByInstallment = $dividedAmount;
            if ($i == 0) $amountByInstallment += $restAmount;
            $installment = new Installment([
                'installment' => $i + 1,
                'amount' => $amountByInstallment
            ]);
            array_push($installments, $installment);
        }

        $this->setRelation('installments', collect($installments));
    }
}
