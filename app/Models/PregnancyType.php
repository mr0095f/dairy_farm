<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PregnancyType extends Model
{
    protected $table = "pregnancy_type";
    protected $fillable = [
        'type_name'	
    ];
}
