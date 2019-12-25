<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{

    protected $table = 'location_foods';
    protected $fillable = ['food_name'];

    public function locations(){
        return $this->hasMany(\App\Location, 'location_id', 'id');
    }
}
