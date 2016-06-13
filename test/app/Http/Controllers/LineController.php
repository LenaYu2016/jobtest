<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use App\Line;
class LineController extends Controller
{
    public static function import_data($data){

        foreach($data as $l) {
            $line = new Line();
            $line->line_name = $l;
            $line->save();
        }
    }
   public function getLinesByIds($ids){
       $lines=Array();
       foreach($ids as $id){
          $lines[]= Line::find($id);
       }
       return $lines;
   }

}
