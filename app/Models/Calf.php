<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calf extends Model
{
     protected $table = "calf";
    protected $fillable = [
        'DOB', 'animal_id', 'age', 'weight', 'height',	'gender', 'color', 'animal_type', 'pictures', 'buy_from', 'buying_price', 'shade_no', 'previous_vaccine_done', 'buy_date', 'branch_id', 'vaccines', 'sale_status', 'note','user_id'
    ];

    public function animal_color_object()
    {
        return $this->hasOne('App\Models\Color', 'id', 'color');
    }

    public function animal_animalType_object()
    {
        return $this->hasOne('App\Models\AnimalType', 'id', 'animal_type');
    }

    public function animal_shed_object()
    {
        return $this->hasOne('App\Models\Shed', 'id', 'shade_no');
    }
}
