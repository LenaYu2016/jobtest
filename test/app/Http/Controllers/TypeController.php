<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input;
use App\Http\Requests;

class TypeController extends Controller
{
    public static function importdata($data){
   foreach($data as $value){

       $type=new Type();
      $type->type_name=$value;
       $type->save();
   }
    }
    public function types(){

       return json_decode(json_encode(Type::all()));
    }
    public function findIdByName($name){
        $type=Type::where('type_name',$name)->first();
   if(empty((array)$type)){
       return false;
   }
        $id=$type->id;
        return $id;
    }
}
