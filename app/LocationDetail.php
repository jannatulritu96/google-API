<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationDetail extends Model
{
    protected $table = 'location_details';
    protected $fillable = [ 'place_id','name','formatted_address','formatted_phone_number','international_phone_number','opening_hours','rating','user_ratings_total'];

    public function relLocation()
    {
        return $this->belongsTo('App\Location','place_id','id');
    }

    public function relLocationPhoto()
    {
        return $this->hasMany('App\LocationPhoto','place_id','place_id');
    }

    public function relLocationReview()
    {
        return $this->hasMany('App\LocationReview','place_id','place_id');
    }
}
