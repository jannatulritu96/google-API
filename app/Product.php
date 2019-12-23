<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name','details','original_price','discount_percentage','discount_amount','price','status'];

    public function relCategory()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }
    public function relProductColor()
    {
        return $this->hasMany('App\ProductColor','product_id','id');
    }
    public function relProduct()
    {
        return $this->hasMany('App\ProductImages','product_id','id');
    }
}
