<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationPhoto extends Model
{
    protected $table = 'location_photos';
    protected $fillable = [ 'place_id','photo_reference'];

    public function relLocation()
    {
        return $this->belongsTo('App\Location','place_id','id');
    }
}
