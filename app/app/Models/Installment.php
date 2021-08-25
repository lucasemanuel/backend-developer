<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];

    protected $fillable = [
        'installment', 'amount', 'date'
    ];

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = number_format((float) $value, 2, '.', '');
    }
}
