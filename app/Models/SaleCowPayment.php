<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleCowPayment extends Model
{
    protected $table = "cow_sale_payments";
    protected $fillable = [
        'sale_id', 'date', 'pay_amount'
    ];
}
