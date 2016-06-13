<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    protected $fillable = [
        'type_id','form_id','line_id'
    ];
    public function form(){

        return $this->belongsTo('App\Form');
    }
    public function type(){

        return $this->belongsTo('App\Type');
    }
    public function line(){

        return $this->belongsTo('App\Line');
    }
}
