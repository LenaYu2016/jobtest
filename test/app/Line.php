<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = [
        'line_name','id'
    ];
    public function connects(){

        return $this->hasMany('App\Connect');
    }
}
