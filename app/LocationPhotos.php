<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationPhotos extends Model
{
    protected $table = 'location_photos';
    protected $fillable = [ 'place_id','photo_reference'];
}
