<?php

namespace App\Http\Controllers;
use App\Room;
use App\Equipment;
use App\Form;
use App\Capacity;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine capacity']);
    }

    public function generate(Request $request){

        $finalarray = array();
        $projectid = $request->input('projectid');

        //$exist = Capacity::where('projectid',$projectid)->get();
        //if(count($exist) == 0) {
       
            $listRoom = Room::where('projectid',$projectid)->get();
            $equipmentid = Equipment::where('projectid',$projectid)->where('equipments','lighting')->first();
         
            if($equipmentid){

                foreach($listRoom as $data){
                    
                    $formdetails = Form::where('roomid',$data->id)->where('equipmentid',$equipmentid->id)->where('category','master')->first();
                    
                    if($formdetails){

                        $tempdeviation = ($formdetails->average - $formdetails->recommendedlux) / ($formdetails->recommendedlux * 100);
                        
                        $deviation = number_format((float)$tempdeviation, 2, '.', '');

                        $formid = $formdetails->id;

                        //check capacity exist
                        $capacityexist = Capacity::where('roomid',$data->id)->first();

                        if($capacityexist == null){

                            $capacity = new Capacity;
                            $capacity->projectid = $projectid;
                            $capacity->roomid = $data->id;
                            $capacity->deviation = $deviation;
                            $capacity->formid = $formid;
    
                            $capacity->save();

                        }
                    } 
                }
                //return response()->json(['status'=>'success','value'=>'success generate']);
            } 

        // } else {

          
        //     //update dekat sini
        //     foreach($exist as $data){
                
        //         $formdetails = Form::where('id',$data->formid)->first();

        //         if($formdetails){
        //             $deviation = ($formdetails->average - $formdetails->recommendedlux) / ($formdetails->recommendedlux * 100);
        //         } else {
        //             $deviation = 0;
        //         }

        //         $data->deviation = $deviation;
        //         $data->save();

        //     }

        //     //return response()->json(['status'=>'success','value'=>'success updated']);

        // } 

        $listcapacity = Capacity::where('projectid',$projectid)->get();

        if($listcapacity){

            foreach($listcapacity as $lc){

                $formdetails = Form::find($lc->formid);

                //$deviation = number_format((float)$lc->deviation, 2, '.', '');

                $deviation = $lc->deviation * 10000;

                $temparray = [
                    'id' => $lc->id,
                    'roomname' => $formdetails->roomname,
                    'recommendedlux' => $formdetails->recommendedlux,
                    'avarage' => $formdetails->average,
                    'deviation' => $deviation,
                ];

                array_push($finalarray,$temparray);

                

            }
            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry capacity not exist']);
        }

    }
}
