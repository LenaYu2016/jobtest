<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Input;
class HomeController extends Controller
{  private  $lines=['liability','property','eo','excess','umbrella'];
    public function index(){
        $tc=new TypeController();
        $types=$tc->types();
    return view('index',compact('types'));
    }
    public function import_connects(){
        ini_set('max_execution_time',600);
        Excel::load('public/test.xlsx', function($reader) {

            $result = $reader->toArray();

            ConnectController::import_data($result,$this->lines);

        });
    }
    public function import_forms(){
        ini_set('max_execution_time',500);
        Excel::load('public/test.xlsx', function($reader) {

            $result = $reader->select(['liability','property','eo','excess','umbrella'])->toArray();
            $forms=Array();
            foreach ($result[0] as $key => $value) {
                foreach($this->lines as $line){
                    $forms[]=$value[$line];
                }


            }
            FormController::import_data($forms);
        });
    }
    public function import_types(){
        ini_set('max_execution_time',500);
        Excel::load('public/test.xlsx', function($reader) {

            $result = $reader->toArray();
            $types=Array();
            foreach ($result[0] as $key => $value) {

                $types[]= $value['description_of_risk'];

            }

            TypeController::importdata($types);
        });
    }
    public function import_lines(){
        ini_set('max_execution_time',500);

        LineController::import_data($this->lines);
    }
    public function getlines()
    {
        if(request()->ajax()) {
            $tc=new TypeController();
            $cc=new ConnectController();
            $lc=new LineController();
            $input = Input::get('user_input');
            $typeid=$tc->findIdByName($input);
    if($typeid===false){
        return response()->json(['error'=>'Company type can not be found']);
    }
        $connects=$cc->findConnectsByType($typeid);
        $line_ids=$cc->getLineByConnects($connects);
              $lines=$lc->getLinesByIds($line_ids);
            return response()->json($lines);
        }
    }
    public function getforms(){
        if(request()->ajax()) {
            $tc=new TypeController();
            $cc=new ConnectController();
            $lc=new LineController();
            $fc=new FormController();
            $lang = Input::get('lang');
            $lineid = Input::get('line');
            $input=Input::get('input');
            $typeid=$tc->findIdByName($input);

            $forms=$cc->getforms($lineid,$typeid);
                  $results[0]=  $fc->getFormNames($forms[0]);
            $fresults=Array();
            if($lang=='En'){
                foreach($results[0] as $v) {
                   $fresults[]=substr_replace($v,'E',0,1);
                    }
            }else if($lang=='Fr'){
                foreach($results[0] as $v) {
                    $fresults[]=substr_replace($v,'F',0,1);
                }
            }
            $fresults=array_unique($fresults);
            return response()->json(['form'=>$fresults,'relation'=>$forms[1]]);
        }
    }
}
