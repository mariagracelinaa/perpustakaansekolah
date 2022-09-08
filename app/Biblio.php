<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    public function publishers()
    {
        return $this->belongsTo('App\Publisher','publishers_id');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'biblios_id', 'id');
    }
}
