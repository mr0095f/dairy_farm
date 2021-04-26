<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemControl extends Model
{
    protected $table = "system_control";
    protected $primaryKey = 'system_key_id';
	protected $fillable = ['key', 'value', 'status'];
}
