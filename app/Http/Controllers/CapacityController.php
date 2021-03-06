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

        $exist = Capacity::where('projectid',$projectid)->get();
     
       if(count($exist) == 0) {
       
          
            $listRoom = Room::where('projectid',$projectid)->get();
            $equipmentid = Equipment::where('projectid',$projectid)->where('equipments','lighting')->first();
            
            if($equipmentid){

                foreach($listRoom as $data){
                    
                    $formdetails = Form::where('roomid',$data->id)->where('equipmentid',$equipmentid->id)->where('category','master')->first();
                    
                    if($formdetails){

                        $deviation = ($formdetails->average - $formdetails->recommendedlux) / ($formdetails->recommendedlux * 100);
                        $formid = $formdetails->id;

                        $capacity = new Capacity;
                        $capacity->projectid = $projectid;
                        $capacity->roomid = $data->id;
                        $capacity->deviation = $deviation;
                        $capacity->formid = $formid;

                        $capacity->save();

                    } 

                }

                //return response()->json(['status'=>'success','value'=>'success generate']);
            

            } else{
                //return response()->json(['status'=>'failed','value'=>'sorry equipment not exist']);
            }

        } else {

          
            //update dekat sini
            foreach($exist as $data){
                
                $formdetails = Form::where('id',$data->formid)->first();

                if($formdetails){
                    $deviation = ($formdetails->average - $formdetails->recommendedlux) / ($formdetails->recommendedlux * 100);
                } else {
                    $deviation = 0;
                }

                $data->deviation = $deviation;
                $data->save();

            }

            //return response()->json(['status'=>'success','value'=>'success updated']);

        } 

        $listcapacity = Capacity::where('projectid',$projectid)->get();

        if($listcapacity){

            foreach($listcapacity as $lc){

                $formdetails = Form::find($lc->formid);

                $temparray = [
                    'id' => $lc->id,
                    'recommendedlux' => $formdetails->recommendedlux,
                    'avarage' => $formdetails->average,
                    'deviation' => $lc->deviation,
                ];

                array_push($finalarray,$temparray);

                

            }
            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry capacity not exist']);
        }

    }
}
