<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Connect;
use Illuminate\Http\Request;
use App\Form;
use App\Http\Requests;
use App\Line;
use App\Type;
use phpDocumentor\Reflection\Types\Object_;

class ConnectController extends Controller
{
    public static function import_data($data, $lines)
    {
        $connects = Array();

        foreach ($data[0] as $key => $value) {


            foreach ($lines as $line) {

               $temp=$value[$line];
                if (!empty($temp)) {

                    if (preg_match('/\\sand\\s/', $temp)) {
                        $ands = explode(' and ', $temp);

                       foreach($ands as $and){


                           $conn=new Connect();
                           $conn->form_id=Form::where('form_name',$and)->firstOrFail()->id;
                           $conn->ralation='and';
                           $conn->line_id=Line::where('line_name',$line)->firstOrFail()->id;
                           $conn->type_id=Type::where('type_name',$value['description_of_risk'])->firstOrFail()->id;
                           $conn->save();
                       }

                    } else if (preg_match('/\\sor\\s/', $temp)) {
                        $ors = explode(' or ', $temp);
                        foreach($ors as $or){

                           $conn=new Connect();
                            $conn->form_id=Form::where('form_name',$or)->firstOrFail()->id;
                            $conn->ralation='or';
                            $conn->line_id=Line::where('line_name',$line)->firstOrFail()->id;
                            $conn->type_id=Type::where('type_name',$value['description_of_risk'])->firstOrFail()->id;
                            $conn->save();
                        }
                    } else {


                        $conn=new Connect();
                        $conn->form_id=Form::where('form_name',$temp)->firstOrFail()->id;
                        $conn->ralation='single';
                        $conn->line_id=Line::where('line_name',$line)->firstOrFail()->id;
                        $conn->type_id=Type::where('type_name',$value['description_of_risk'])->firstOrFail()->id;
                        $conn->save();

                    }

                }
            }
        }
    }
public function findConnectsByType($id){
   return Connect::where('type_id',$id)->get();
}
public  function getLineByConnects($connects){
    $lines=Array();
    foreach($connects as $connect){
       $lines[]= $connect->line_id;
    }
    $lines=array_unique($lines);
    return $lines;
}
    public  function getforms($lineid,$typeid){
        $forms=Array();
        $relation='';
       $connects= Connect::where('type_id',$typeid)->where('line_id',$lineid)->get();
        foreach($connects as $connect){
           $forms[]=$connect->form_id;
            $relation=$connect->ralation;
        }
        return Array($forms,$relation);
    }
}
