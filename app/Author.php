<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $timestamps = false;

    public function biblios(){
        return $this->belongsToMany('App\Biblio','authors_biblios','authors_id','biblios_id')
                    ->withPivot('primary_author');
    }
}
