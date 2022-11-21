<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function biblios()
    {
        return $this->hasMany('App\Biblio', 'categories_id', 'id');
    }

    public $timestamps = false;
}
