<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsTo('App\User','nisn_niy');
    }

    public function items(){
        return $this->belongsToMany('App\Item','borrow_transaction','borrows_id','register_num')
                    ->withPivot('return_date', 'fine');
    }
}
