<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'form_name','id'
    ];
    public function connects(){

        return $this->hasMany('App\Connect');
    }
}
