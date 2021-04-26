<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PregnancyRecord extends Model
{
    protected $table = "pregnancy_record";
    protected $fillable = [
        'stall_no','cow_id','pregnancy_type_id','semen_type','semen_push_date','pregnancy_start_date','semen_cost','other_cost','note','status'
    ];
}
