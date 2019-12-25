<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationDetails extends Model
{
    protected $table = 'location_details';
    protected $fillable = [ 'place_id','name','formatted_address','formatted_phone_number','international_phone_number','opening_hours','rating','user_ratings_total'];
}
