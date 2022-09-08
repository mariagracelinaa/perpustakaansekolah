<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public function biblios()
    {
        return $this->hasMany('App\Biblio', 'publishers_id', 'id');
    }
}
