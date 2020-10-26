<?php

namespace App\Http\Controllers;

use AirconditioningSeeder;
use App\Lightingcontrol;
use Illuminate\Http\Request;
use App\Logging;
use App\Typeoflight;
use App\Airconditioning;
use App\Lighting;
class DatabaseController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'database engine']);
    }

    public function alllogging(){

        $logging = Logging::all();

        return response()->json(['status'=>'success','value'=>$logging]);

    }

    public function detailslogging(Request $request){

        $loggingid = $request->input('loggingid');

        $details = Logging::find($loggingid);

        return response()->json(['status'=>'success','value'=>$details]);

    }

    public function alltypeoflight(){

        $typeoflight = Typeoflight::all();

        return response()->json(['status'=>'success','value'=>$typeoflight]);

    }

    public function detailstypeoflight(Request $request){

        $idtypeoflight = $request->input('idtypeoflight');

        $details =Typeoflight::find($idtypeoflight);

        return response()->json(['status'=>'success','value'=>$details]);

    }

    public function alllightingcontroll(){

        $lightingcontrol = Lightingcontrol::all();

        return response()->json(['status'=>'success','value'=>$lightingcontrol]);

    }

    public function detailslightingcontrol(Request $request){

        $idlightingcontrol = $request->input('idlightingcontrol');

        $details = Lightingcontrol::find($idlightingcontrol);

        return response()->json(['status'=>'success','value'=>$details]);

    }

    public function allairconditioning(){

        $airconditioning = Airconditioning::all();

        return response()->json(['status'=>'success','value'=>$airconditioning]);

    }

    public function detailsairconditioning(Request $request){

        $idairconditioning = $request->input('idairconditioning');

        $details = Airconditioning::find($idairconditioning);

        return response()->json(['status'=>'success','value'=>$details]);

    }

    public function alllighting(){

        $lighting = Lighting::all();

        return response()->json(['status'=>'success','value'=>$lighting]);

    }

    public function detailslighting(Request $request){

        $idlighting = $request->input('idlighting');

        $detailslighting = Lighting::find($idlighting);

        return response()->json(['status'=>'success','value'=>$detailslighting]);

    }
}
