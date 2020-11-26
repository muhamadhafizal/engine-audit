<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lightdeviation;
use App\Room;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Signer\Ecdsa;

class LightdeviationController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine lightdeviation']);
    }

    public function generate(Request $request){

        $projectid = $request->input('projectid');
        
        $exist = Lightdeviation::where('projectid',$projectid)->first();

        $listroom = Room::where('projectid',$projectid)->get();

        if($listroom){
            $count =  count($listroom);
        } else {
            $count = 0;
        }

        if($exist){

            $exist->overlitdatapoints = $count;
            $exist->wellitdatapoints = $count;
            $exist->underlitdatapoints = $count;
            $exist->projectid = $projectid;

            $exist->save();
            
            return response()->json(['status'=>'success','value'=>'lightdevation updated total room']);

        } else {
           
            $lightdeviation = new Lightdeviation;

            $lightdeviation->projectid = $projectid;
            $lightdeviation->overlitdatapoints = $count;
            $lightdeviation->wellitdatapoints = $count;
            $lightdeviation->underlitdatapoints = $count;

            $lightdeviation->save();

            return response()->json(['status'=>'success','value'=>'lightdeviation success generate']);

        }
       
    }

    public function save(Request $request){

        $projectid = $request->input('projectid');
        $overlitdeviation = $request->input('overlitdeviation');
        $wellitdeviation = $request->input('wellitdeviation');
        $underlitdeviation = $request->input('underlitdeviation');

        $details = Lightdeviation::where('projectid',$projectid)->first();

        if($details){

            $details->overlitdeviation = $overlitdeviation;
            $details->wellitdeviation = $wellitdeviation;
            $details->underlitdeviation = $underlitdeviation;

            $details->save();

            return response()->json(['status'=>'success','value'=>'success save deviation content']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry lightdeviation not exist, please generate first']);
        }

    }

    public function details(Request $request){

        $projectid = $request->input('projectid');

        $details = Lightdeviation::where('projectid',$projectid)->first();

        if($details){

            $a = json_decode($details->wellitdeviation);

            $temparray = [
                'id' => $details->id,
                'projectid' => $details->projectid,
                'overlitdeviation' => $details->overlitdeviation,
                'overlitdatapoints' => $details->overlitdatapoints,
                'wellitdeviation' => $a,
                'wellitdatapoints' => $details->wellitdatapoints,
                'underlitdeviation' => $details->underlitdeviation,
                'underlitdatapoints' => $details->underlitdatapoints,
            ];
            
           
            
            return response()->json(['status'=>'success','value'=>$temparray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry lightdeviation not exist, please generate first']);
        }

    }
}

