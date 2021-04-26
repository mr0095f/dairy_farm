<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePurpose extends Model
{
    protected $table = 'expense_purpose';
    protected $fillable = ['purpose_name', 'branch_id'];
}
