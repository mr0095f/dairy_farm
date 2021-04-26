<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleCowDtls extends Model
{
    protected $table = "cow_sale_dtls";
    protected $fillable = [
        'sale_id', 'cow_id', 'cow_type', 'shed_no','price'
    ];
}
