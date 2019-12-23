<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = ['product_id', 'color_name'];
    public function relProduct()
    {
        return $this->belongsTo('App\Product','product_id','id');
    }
}
