<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    public function users(){
        return $this->hasMany('App\User','class_id', 'id');
    }

    public $timestamps = false;

    protected $table = 'Class';
}
