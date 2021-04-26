<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleMilk extends Model
{
    protected $table = "sale_milk";
    protected $fillable = [
        'milk_account_number', 'supplier_id', 'name', 'contact', 'email', 'address', 'litter', 'rate', 'total_amount', 'paid', 'due', 'branch_id', 'date' , 'added_by'   
    ];
	
	public function collectPayments() {
        return $this->hasMany('App\Models\MilkDueCollections', 'sale_id', 'id');
    }
}
