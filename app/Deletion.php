<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deletion extends Model
{
    public $timestamps = false;
    
    public function items()
    {
        return $this->belongsTo('App\Item');
    }
}
