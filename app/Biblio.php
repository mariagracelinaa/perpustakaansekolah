<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    public $timestamps = false;
    
    public function publishers()
    {
        return $this->belongsTo('App\Publisher','publishers_id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Category','categories_id');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'biblios_id', 'id');
    }

    public function authors(){
        return $this->belongsToMany('App\Author','authors_biblios','biblios_id','authors_id')
                    ->withPivot('primary_author');
    }

    public function users(){
        return $this->belongsToMany('App\User','bookings','biblios_id','users_id')
                    ->withPivot('booking_date');
    }
    
}
