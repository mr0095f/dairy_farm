<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table="suppliers";
    protected $fillable = ['name', 'company_name', 'phn_number', 'present_address', 'mail_address', 'profile_image','branch_id'];
}
