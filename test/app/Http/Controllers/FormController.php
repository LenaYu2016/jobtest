<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\Http\Requests;

class FormController extends Controller
{
    public static function import_data($data){
$forms=Array();
        foreach($data as $f) {
            if(!empty($f)){
                if(preg_match('/\\sand\\s/',$f)){
                    $and=explode( ' and ', $f);
                    $forms=array_merge( $forms,$and);

                }
    else if(preg_match('/\\sor\\s/',$f)){
        $or=explode( ' or ', $f);
        $forms=array_merge( $forms,$or);;
    }else{
        $forms[]=$f;
    }
            }

        }
      $forms=array_unique($forms);
        foreach($forms as $f) {
            $line = new Form();
            $line->form_name = $f;
            $line->save();
        }
    }
public function getFormNames($formids){
    $names=Array();
    foreach($formids as $formid) {

        $names[]= Form::find($formid)->form_name;
        }
    return $names;
}
}
