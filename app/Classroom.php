<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function users()
    {
        return $this->hasMany('App\User', 'classrooms_id', 'id');
    }

    public $timestamps = false;
}
