<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function class()
    {
        return $this->belongsTo('App\Classes','class_id');
    }
}
