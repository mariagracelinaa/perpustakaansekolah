<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function biblios()
    {
        return $this->belongsTo('App\Biblio','biblios_id');
    }
}
