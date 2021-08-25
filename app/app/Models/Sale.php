<?php

namespace App\Models;

use Carbon\Carbon;
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
        $installments = $this->installmentSale($total);
        $this->setRelation('installments', collect($installments));
    }

    private function installmentSale($total)
    {
        $installments = [];
        list($dividedAmount, $restAmount) = $this->divideAmount($total);

        for ($i = 1; $i <= $total; $i++) {
            $amountByInstallment = $dividedAmount;
            if ($i == 1) $amountByInstallment += $restAmount;
            $date = $this->getDateNextInstallment($this->date, $i);
            $installment = new Installment([
                'installment' => $i,
                'amount' => $amountByInstallment,
                'date' => $date,
            ]);

            array_push($installments, $installment);
        }

        return $installments;
    }

    private function divideAmount($number)
    {
        $dividedAmount = number_format((floor(($this->amount / $number) * 100) / 100), 2, '.', '');
        $restAmount = number_format(($this->amount - ($dividedAmount * $number)), 2, '.', '');

        return [$dividedAmount, $restAmount];
    }

    private function getDateNextInstallment($date, $number)
    {
        $date = Carbon::parse($date);
        $date->addMonths($number);
        while($date->isWeekend()) {
            $date->addDay();
        }
        return $date;
    }
}
