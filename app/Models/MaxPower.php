<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaxPower extends Model
{
    protected $table = "tbl_max_power";
    protected $fillable = [
        'website_url', 'purchase_key', 'email', 'last_check_date'
    ];
}
