<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = ['location_id', 'place_id', 'lat', 'lng'];

    public function relLocationDetail()
    {
        return $this->hasMany('App\LocationDetail','place_id','place_id')->with(['relLocationPhoto','relLocationReview']);
    }
    public function relLocationPhoto()
    {
        return $this->hasMany('App\LocationPhoto','place_id','place_id');
    }

    public function relLocationReview()
    {
        return $this->hasMany('App\LocationReview','place_id','id');
    }
}
