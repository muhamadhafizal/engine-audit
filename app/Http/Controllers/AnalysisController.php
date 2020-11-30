<?php

namespace App\Http\Controllers;
use App\Capacity;
use App\Form;
use App\Subinventory;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine analysis']);
    }

    public function installedlighting(Request $request){

        $finalarray = array();
        $infoarray = array();
        $projectid = $request->input('projectid');

        $forms = Capacity::where('projectid',$projectid)->get();

        foreach($forms as $data){

            //sub by form
            $subs = Subinventory::where('formid',$data->formid)->get();

            foreach($subs as $sub){

                // if(in_array('Fluorescent',$finalarray['name'])){
                //     echo 'a';
                // } 

                $temparray = [
                    'name' => $sub->typeoflighting,
                    'value' => $sub->totalnumberoflightbulb,
                ];

               
                array_push($infoarray,$temparray);

            }

        }
        $totalsum = 0;
        foreach($infoarray as $info){
            $totalsum = $totalsum + $info['value'];
        }

        $finalarray = [
            'data' => $infoarray,
            'total' => $totalsum,
        ];

        return response()->json(['status'=>'success','value'=>$finalarray]);

        
    }

    public function energyconsumption(Request $request){

        $projectid = $request->input('projectid');

        $finalarray = array();
        $infoarray = array();

        $forms = Capacity::where('projectid',$projectid)->get();

        if($forms){

            foreach($forms as $data){

                //sub by form
                $subs = Subinventory::where('formid',$data->formid)->get();

                if($subs){

                    foreach($subs as $sub){

                        $temparray = [
                            'name' => $sub->typeoflighting,
                            'value' => $sub->consumptionduration,
                        ];

                        array_push($infoarray,$temparray);

                    }

                }

            }

            $totalsum = 0;
            foreach($infoarray as $info){
                $totalsum = $totalsum + $info['value'];
            }

            $finalarray = [
                'data' => $infoarray,
                'total' => $totalsum,
            ];

            return response()->json(['status'=>'success','value'=>$finalarray]);

        }

    }
}
