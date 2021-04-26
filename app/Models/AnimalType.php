<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{
    protected $table = "animal_type";
    protected $fillable = [
        'type_name'
    ];
}
