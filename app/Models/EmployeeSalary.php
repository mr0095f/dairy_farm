<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $table = "employee_salary";

    protected $fillable = ['employee_id','year','month','salary', 'paydate', 'addition_money', 'note'];
}
