<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    public function students(){
        return $this->hasMany('App\Student','class_id', 'id');
    }

    public $timestamps = false;

    protected $table = 'Class';
}
