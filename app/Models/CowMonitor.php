<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CowMonitor extends Model
{
    protected $table = "cow_monitor";
    protected $fillable = [
        'shed_no', 'cow_id', 'date', 'note', 'weight', 'height', 'milk', 'branch_id' ,'health_score','new_images','user_id'
    ];
}
