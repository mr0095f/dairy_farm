<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CowVaccineMonitorDtls extends Model
{
    protected $table = "cow_vaccine_monitor_dtls";
    protected $fillable = [
        'monitor_id', 'vaccine_id', 'remarks','time' 
    ];
}
