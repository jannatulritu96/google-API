<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationReview extends Model
{
    protected $table = 'location_reviews';
    protected $fillable = [ 'place_id','author_name','author_url','profile_photo_url','rating','relative_time_description','text'];

    public function relLocation()
    {
        return $this->belongsTo('App\Location','place_id','id');
    }
}
