<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    
    public function biblios()
    {
        return $this->belongsTo('App\Biblio','biblios_id');
    }

    public function deletions()
    {
        return $this->hasOne('App\Deletion');
    }

    public function borrows(){
        return $this->belongsToMany('App\Borrow','borrow_transaction','register_num','borrows_id')
                    ->withPivot('return_date', 'fine');
    }
    
}
