<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'nid', 'phone_number', 'present_address', 'parmanent_address', 'user_type', 'status', 'created_by', 'password_hint', 'designation', 'basic_salary', 'gross_salary', 'joining_date', 'resign_date', 'resign_desc', 'branch_id'
                                  
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userTypeDtls()
    {
        return $this->hasOne('App\Models\UserType', 'id', 'user_type');
    }
}
