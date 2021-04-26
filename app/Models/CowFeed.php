<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CowFeed extends Model
{
    protected $table = "cow_feed";
    protected $fillable = [
        'shed_no', 'cow_id', 'date', 'note', 'branch_id' 
    ];
}
