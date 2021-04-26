<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shed extends Model
{
    protected $table = "sheds";
    protected $fillable = [
        'shed_number', 'description', 'branch_id', 'status' 
    ];
}
