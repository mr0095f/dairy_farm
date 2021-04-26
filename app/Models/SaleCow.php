<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleCow extends Model
{
    protected $table = "cow_sale";
    protected $fillable = [
        'customer_name', 'customer_number','email', 'address', 'total_price', 'total_paid', 'due', 'note', 'date', 'branch_id' 
    ];
	
	public function collectPayments() {
        return $this->hasMany('App\Models\SaleCowPayment', 'sale_id', 'id');
    }
}
