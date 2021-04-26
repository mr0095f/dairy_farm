<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = "animals";
    protected $fillable = [
        'DOB', 'age', 'weight', 'height',	'gender', 'color', 'animal_type', 'pregnant_status', 'before_no_of_pregnant', 'pictures', 'pregnancy_time', 'buy_from', 'buying_price', 'milk_ltr_per_day', 'shade_no', 'previous_vaccine_done', 'buy_date', 'branch_id', 'vaccines', 'sale_status','note'
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
