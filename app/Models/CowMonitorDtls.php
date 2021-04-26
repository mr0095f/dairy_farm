<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CowMonitorDtls extends Model
{
    protected $table = "cow_monitor_dtls";
    protected $fillable = [
        'monitor_id', 'service_id', 'result' ,'time'
    ];
}
