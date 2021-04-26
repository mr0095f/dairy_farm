<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectMilk extends Model
{
    protected $table = "collect_milk";
    protected $fillable = [
        'account_number', 'name', 'address', 'dairy_number', 'stall_no', 'liter', 'fate', 'liter_price', 'total', 'date' , 'branch_id','added_by'    
    ];
}
