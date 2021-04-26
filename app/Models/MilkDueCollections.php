<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkDueCollections extends Model
{
    protected $table = "milk_due_collections";
    protected $fillable = [
        'sale_id', 'date', 'pay_amount'  
    ];
}
