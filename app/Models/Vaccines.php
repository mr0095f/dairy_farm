<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    protected $table = "vaccines";
    protected $fillable = [
        'vaccine_name', 'months','repeat_vaccine','dose','note'
    ];
}
