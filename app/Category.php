<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function relProduct()
    {
        return $this->hasMany('App\Product','category_id','id');
    }
}
