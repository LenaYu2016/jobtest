<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'type_name','id'
    ];
    public function connects(){

        return $this->hasMany('App\Connect');
    }
}
