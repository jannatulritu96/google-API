<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationReviews extends Model
{
    protected $table = 'location_reviews';
    protected $fillable = [ 'place_id','author_name','author_url','profile_photo_url','rating','relative_time_description','text'];
}
