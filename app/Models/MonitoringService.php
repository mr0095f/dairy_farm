<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringService extends Model
{
    protected $table = "monitoring_services";
    protected $fillable = [
        'service_name'
    ];
}
