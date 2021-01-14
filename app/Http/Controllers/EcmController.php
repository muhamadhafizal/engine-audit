<?php

namespace App\Http\Controllers;

use App\Project;
use App\Room;
use App\Equipment;
use App\Form;
use App\Subinventory;
use App\Setup;
use App\ECM;
use App\Capacity;
use App\Lightdeviation;
use Illuminate\Http\Request;

class EcmController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine ecm']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
    }

    public function list(Request $request){
        $formarray = array();
        $ecmitem = array();
        $projectid = $request->input('projectid');

        //list room
        $listroom = Room::where('projectid',$projectid)->get();

        //List Equipment
        $listequipment = Equipment::where('projectid',$projectid)->where('equipments','lighting')->get();

        //List Form
        foreach($listroom as $rooms){
            foreach($listequipment as $equipments){

                $listform = Form::where('roomid',$rooms->id)->where('equipmentid',$equipments->id)->where('category','master')->first();
            
                array_push($formarray,$listform);
            }
        }
        
        // //dari formarray kita akan tarik dia punya subequipment
        foreach($formarray as $form){

            $listsub = Subinventory::where('formid',$form->id)->get();

            // if($form->average >= $form->recommendedlux){
            //     $luxstandard = 1;
            // } else {
            //     $luxstandard = 0;
            // }

            $temparray = [
                'projectid' => $projectid,
                'formid' => $form->id,
                'formname' => $form->formname,
                'roomid' => $form->roomid,
                'roomname' => $form->roomname,
                // 'recommendedlux' => $form->recommendedlux,
                // 'averagelux' => $form->average,
                // 'luxstandard' => $luxstandard,
                'listsub' => $listsub,
            ];

            array_push($ecmitem,$temparray);

        }

        return response()->json(['status'=>'success','value'=>$ecmitem]);

    }

    public function details(Request $request){

        $subinventoryid = $request->input('subinventoryid');
        $formid = $request->input('formid');
        $projectid = $request->input('projectid');

        //genraldeclare
        $luxstandard = null;
        $controlsystem = null;
        $controlsystemresult = null;
        $daylight = null;
        $daylightresult = null;
        $lampcheck = null;
        $lampcheckresult = null;

        $formdetails = Form::find($formid);
        $subinventorydeails = Subinventory::find($subinventoryid);

        
        //luxstandard & daylight availability & lampcheck

        if($formdetails){

            //luxstandard
            if($formdetails->average >= $formdetails->recommendedlux){
                $luxstandard = 1;
            } else {
                $luxstandard = 0;
            }

            //daylight availability
            if($formdetails->potentialfornaturallighting == 'yes'){
                $daylightavailability = 1;
                $daylightavailabilityresult = 'Maximise daylight usage';
            } else {
                $daylightavailability = 0;
                $daylightavailabilityresult = 'Install more lamp';
            }

            //lampcheck

            $capacitydetails = Capacity::where('projectid',$projectid)->where('roomid',$formdetails->roomid)->first();
            $lightdeviationdetails = Lightdeviation::where('projectid',$projectid)->first();
       
            

            if($capacitydetails != null && $lightdeviationdetails != null){

                if($capacitydetails->deviation > $lightdeviationdetails->overlitdeviation){

                    $lampcheck = 1;
                    $lampcheckresult = 'Delamping';
                } elseif ($capacitydetails->deviation < $lightdeviationdetails->underlitdeviation){
            
                    $lampcheck = 0;
                    $lampcheckresult = 'Daylight availability';
                }

            }

        }

        //controlsystem
        if($subinventorydeails){
            if($subinventorydeails->controlsysten == 'manual'){
                $controlsystem = 0;
                $controlsystemresult  = 'Install control system for exiting lamp';
            } else {
                $controlsystem = 1;
                $controlsystemresult = 'No ECM';
            }
        }

        


        $ecmexist = ECM::where('subinventoryid',$subinventoryid)->first();

        if($ecmexist){
            //exist

            $ecmexist->projectid = $projectid;
            $ecmexist->formid = $formid;
            $ecmexist->subinventoryid = $subinventoryid;
            $ecmexist->luxstandard = $luxstandard;
            $ecmexist->controlsystem = $controlsystem;
            $ecmexist->controlsystemsresult = $controlsystemresult;
            $ecmexist->daylightavailability = $daylightavailability;
            $ecmexist->daylightavailabilityresult = $daylightavailabilityresult;
            $ecmexist->lampcheck = $lampcheck;
            $ecmexist->lampcheckresult = $lampcheckresult;

            $ecmexist->save();

        } else {
            //notexist
            $ecm = new ECM;
            $ecm->projectid = $projectid;
            $ecm->formid = $formid;
            $ecm->subinventoryid = $subinventoryid;
            $ecm->luxstandard = $luxstandard;
            $ecm->controlsystem = $controlsystem;
            $ecm->controlsystemsresult = $controlsystemresult;
            $ecm->daylightavailability = $daylightavailability;
            $ecm->daylightavailabilityresult = $daylightavailabilityresult;
            $ecm->lampcheck = $lampcheck;
            $ecm->lampcheckresult = $lampcheckresult;
            $ecm->status = 'process';

            $ecm->save();

        }

            $details = ECM::where('subinventoryid',$subinventoryid)->first();

            if($details->luxstandard == '1'){
                $temparray = [
                    'id' => $details->id,
                    'subinventoryid' => $details->subinventoryid,
                    'formid' => $details->formid,
                    'projectid' => $details->projectid,
                    'luxstandard' => $details->luxstandard,
                    'luxstandardname' => 'meet recommended standard',
                    'currentinstallation' => $details->currentinstallation,
                    'correctivemeasure' => $details->correctivemeasure,
                    'efficiency' => $details->efficiency,
                    'efficiencyresult' => $details->efficiencyresult,
                    'controlsystem' => $details->controlsystem,
                    'controlsystemresult' => $details->controlsystemresult, 
                ];
            } else {
                $temparray = [
                    'id' => $details->id,
                    'projectid' => $details->projectid,
                    'formid' => $details->formid,
                    'subinventoryid' => $details->subinventoryid,
                    'luxstandard' => $details->luxstandard,
                    'luxstandardname' => 'does not meet recommended standard',
                    'lampcheck' => $details->lampcheck,
                    'lampcheckresult' => $details->lampcheckresult,
                    'daylightavailability' => $details->daylightavailability,
                    'daylightavailabilityresult' => $details->daylightavailabilityresult,
                ];
            }

            return response()->json(['status'=>'success','value'=>$temparray]);

    }

    public function insertinputefficiency(Request $request){

        $ecmid = $request->input('ecmid');
        $currentinstallation = $request->input('currentinstallation');
        $correctivemeasure = $request->input('correctivemeasure');

        $ecm = ECM::find($ecmid);

        if($ecm){

            if($currentinstallation > $correctivemeasure){
                $effieciency = 1;
                $effieciencyresult = 'No ECM';
            } else {
                $effieciency = 0;
                $effieciencyresult = 'Change to higher efficiency';
            }

            $ecm->currentinstallation = $currentinstallation;
            $ecm->correctivemeasure = $correctivemeasure;
            $ecm->effieciency = $effieciency;
            $ecm->effieciencyresult = $effieciencyresult;

            $ecm->save();

            return response()->json(['status'=>'success','value'=>'success save efficiency']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry ecm item not exist']);
        }

    }
}
