<?php

namespace App\Http\Controllers;
use App\Form;
use App\Subinventory;
use App\Room;
use App\Setup;
use App\Equipment;
use App\Sumplytariffstructure;
use App\Operation;
use DB;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine form']);
    }

    public function store(Request $request){

        $roomid = $request->input('roomid');
        $equipmentid = $request->input('equipmentid');

        $roomdetails = Room::find($roomid);
        $equipmentdetails = Equipment::find($equipmentid);

        if($roomdetails == null || $equipmentdetails == null){
            return response()->json(['status'=>'failed','value'=>'sorry id room pr equipment not exist']);
        } else {

            $existingform = Form::where('roomid',$roomid)->where('equipmentid',$equipmentid)->first();

            if($existingform){
                return response()->json(['status'=>'success', 'value'=>'success update master form']);
            } else {

                $roominformation = Room::where('id',$roomid)->first();
                if($roominformation){
                    $roomname = $roominformation->roomarea;
                    $roomfunction = $roominformation->function;
                    $roomarea = $roominformation->area;
                } else {
                    $roomname = null;
                    $roomfunction = null;
                    $roomarea = null;
                }

                $recommendedlux = '400';

                $form = new Form;
                $form->roomid = $roomid;
                $form->equipmentid = $equipmentid;
                $form->roomname = $roomname;
                $form->roomfunction = $roomfunction;
                $form->roomarea = $roomarea;
                $form->recommendedlux = $recommendedlux;
                $form->category = 'master';
                $form->save();
                return response()->json(['status'=>'success','value'=>'success generate new master form']);
            }

        }

    }

    public function details(Request $request){

        $roomid = $request->input('roomid');
        $equipmentid = $request->input('equipmentid');
        $temparray = array();
        $subArray = array();
        $finalArray = array();
        $timezonepeak = null;
        $timezoneoffpeak = null;
        $structurepeak = null;
        $structureoffpeak = null;
        $averageoperation = null;

        $detailsform = Form::where('roomid',$roomid)->where('equipmentid',$equipmentid)->first();
       
        if($detailsform){
            
            $roomdetails = Room::where('id',$detailsform->roomid)->first();
            $detailstariff = Sumplytariffstructure::where('projectid',$roomdetails->projectid)->first();
            $detailsoperation = Operation::where('projectid',$roomdetails->projectid)->first();
            
            if($detailstariff){
                $timezonepeak = $detailstariff->timezonepeak;
                $timezoneoffpeak = $detailstariff->timezoneoffpeak;
                $structurepeak = $detailstariff->structurepeak;
                $structureoffpeak = $detailstariff->structureoffpeak;
            } 

            if($detailsoperation){
                $averageoperation = $detailsoperation->averageoperations;
            }

            

            if($detailsform->samplingpoints != null){
                $formatpoints = json_decode($detailsform->samplingpoints);
            } else {
                $formatpoints = $detailsform->samplingpoints;
            }

            $temparray = [
                'id' => $detailsform->id,
                'roomid' => $detailsform->roomid,
                'equipmentdid' => $detailsform->equipmentid,
                'roomname' => $detailsform->roomname,
                'roomfunction' => $detailsform->roomfunction,
                'roomarea' => $detailsform->roomarea,
                'generalobservation' => $detailsform->generalobservation,
                'potentialfornaturallighting' => $detailsform->potentialfornaturallighting,
                'windowsorientation' => $detailsform->windowsorientation,
                'recommendedlux' => $detailsform->recommendedlux,
                'samplingpoints' => $formatpoints,
                'average' => $detailsform->average,
                'category' => $detailsform->category,
                'masterid' => $detailsform->masterid,
                'timezonepeak' => $timezonepeak,
                'timezoneoffpeak' => $timezoneoffpeak,
                'structurepeak' => $structurepeak,
                'structureoffpeak' => $structureoffpeak,
                'averageoperation' => $averageoperation,
            ];

            //ade subequipment dekat sini
            $sub = Subinventory::where('formid',$detailsform->id)->get();
    
            if($sub){
                foreach($sub as $data){
                    array_push($subArray,$data);
                }
            }

            $finalArray = [
                'main' => $temparray,
                'sub' => $subArray,
            ];

            return response()->json(['status'=>'success','value'=>$finalArray]);
        } else {
           return response()->json(['status'=>'failed','value'=>'master form not exist']);
        }

        

    }

    public function save(Request $request){

        $formid = $request->input('formid');
        $roomname = $request->input('roomname');
        $roomfunction = $request->input('roomfunction');
        $roomarea = $request->input('roomarea');
        $generalobservation = $request->input('generalobservation');
        $potentialfornaturallighting = $request->input('potentialfornaturallighting');
        $windowsorientation = $request->input('windowsorientation');
        $recommendedlux = $request->input('recommendedlux');
        $samplingpoints = $request->input('samplingpoints');
        $average = $request->input('average');
        $grandtotalenergyconsumption = $request->input('grandtotalenergyconsumption');
        $grandtotalannualenergycost = $request->input('grandtotalannualenergycost');

        $detailsform = Form::find($formid);

        if($detailsform){

            if($roomname == null){
                $roomname = $detailsform->roomname;
            }
            if($roomfunction == null){
                $roomfunction = $detailsform->roomfunction;
            }
            if($roomarea == null){
                $roomarea = $detailsform->roomarea;
            }
            if($generalobservation == null){
                $generalobservation = $detailsform->generalobservation;
            }
            if($potentialfornaturallighting == null){
                $potentialfornaturallighting = $detailsform->potentialfornaturallighting;
            }
            if($windowsorientation == null){
                $windowsorientation = $detailsform->windowsorientation;
            }
            if($recommendedlux == null){
                $recommendedlux = $detailsform->recommendedlux;
            }
            if($samplingpoints == null){
                $samplingpoints = $detailsform->samplingpoints;
            }
            if($average == null){
                $average = $detailsform->average;
            }
            if($grandtotalenergyconsumption == null){
                $grandtotalenergyconsumption = $detailsform->grandtotalenergyconsumption;
            }
            if($grandtotalannualenergycost == null){
                $grandtotalannualenergycost = $detailsform->grandtotalannualenergycost;
            }

            $detailsform->roomname = $roomname;
            $detailsform->roomfunction = $roomfunction;
            $detailsform->roomarea = $roomarea;
            $detailsform->generalobservation = $generalobservation;
            $detailsform->potentialfornaturallighting = $potentialfornaturallighting;
            $detailsform->windowsorientation = $windowsorientation;
            $detailsform->recommendedlux = $recommendedlux;
            $detailsform->samplingpoints = $samplingpoints;
            $detailsform->average = $average;
            $detailsform->grandtotalenergyconsumption = $grandtotalenergyconsumption;
            $detailsform->grandtotalannualenergycost = $grandtotalannualenergycost;

            $detailsform->save();
            return response()->json(['status'=>'success','value'=>'success save master from']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry room master not exist']);
        }

    }

    public function subequipment(Request $request){

        $subequipmentid = $request->input('subequipmentid');
        $formid = $request->input('formid');
        $setuparray = array();

        $a = json_decode($subequipmentid);
        $total = count($a);

        $exist = 'no';
        for($j = 0; $j< $total; $j++){
           $existdata = Setup::find($a[$j]->id);
           if($existdata == null){
               $exist = 'yes';
           }
        }
        
        $formdetails = Form::find($formid);

        if($formdetails == null || $exist == 'yes'){
            return response()->json(['status'=>'failed','value'=>'sorry id form or subequipment not exist']);
        } else {

            for($i = 0; $i < $total; $i++){
            
                $exist = Subinventory::where('formid',$formid)->where('subequipmentid',$a[$i]->id)->first();
            
                if(empty($exist)){  
                    
                    //kite buat dekat sini
                    $subequipmentinfo = Setup::where('id',$a[$i]->id)->first();
    
                    if($subequipmentinfo){
    
                        $lightingidentification = $subequipmentinfo->lightingid;
                        $typeoflighting = $subequipmentinfo->type;
                        $powerrating = $subequipmentinfo->powerrating;
                        $lighting = $subequipmentinfo->lightingid;
    
                    } else {
    
                        $lightingidentification = null;
                        $typeoflighting = null;
                        $powerrating = null;
                        $lighting = null;
    
                    }
    
                    $sub = new Subinventory;
                    $sub->formid = $formid;
                    $sub->subequipmentid = $a[$i]->id;
                    $sub->lightingidentification = $lightingidentification;
                    $sub->typeoflighting = $typeoflighting;
                    $sub->powerrating = $powerrating;
                    $sub->lighting = $lighting;
                    $sub->save();
    
                } 
            }
            return response()->json(['status'=>'success','value'=>'success save subequipment selection']);

        }

    }

    //function save by subequipment;
    public function savesubequipment(Request $request){

        $subid = $request->input('subid');
        $lightingidentification = $request->input('lightingidentification');
        $typeoflighting = $request->input('typeoflighting');
        $powerrating = $request->input('powerrating');
        $frominventory = $request->input('frominventory');
        $actual = $request->input('actual');
        $loadfactory = $request->input('loadfactory');
        $totalnumberoffixtures = $request->input('totalnumberoffixtures');
        $numberoflightbulbperfixtures = $request->input('numberoflightbulbperfixtures');
        $totalnumberoflightbulb = $request->input('totalnumberoflightbulb');
        $lightingreflector = $request->input('lightingreflector');
        $controlsystem = $request->input('controlsystem');
        $switchontime = $request->input('switchontime');
        $switchofftime = $request->input('switchofftime');
        $consumptionduration = $request->input('consumptionduration');
        $peakdurationcostoperation = $request->input('peakdurationcostoperation');
        $offpeakduration = $request->input('offpeakduration');
        $annualoperationdays = $request->input('annualoperationdays');
        $lighting = $request->input('lighting');
        $powerratingperfixture = $request->input('powerratingperfixture');
        $dailyenergyconsumtion = $request->input('dailyenergyconsumption');
        $dailyenergycost = $request->input('dailyenergycost');
        $peakdurationcostenergy = $request->input('peakdurationcostenergy');
        $offpeakdurationcost = $request->input('offpeakdurationcost');
        $annualenergycost = $request->input('annualenergycost');
        $grandtotalannualenergyconsumption = $request->input('grandtotalannualenergyconsumption');
        $grandtotalannualenergycost = $request->input('grandtotalannualenergycost');

        $subexist = Subinventory::find($subid);
        if($subexist)
        {
        
            if($lightingidentification == null){
                $lightingidentification = $subexist->lightingidentification;
            }
            if($typeoflighting == null){
                $typeoflighting = $subexist->typeoflighting;
            }
            if($powerrating == null){
                $powerrating = $subexist->powerrating;
            }
            if($frominventory == null){
                $frominventory = $subexist->frominventory;
            }
            if($actual == null){
                $actual = $subexist->actual;
            }
            if($loadfactory == null){
                $loadfactory = $subexist->loadfactory;
            }
            if($totalnumberoffixtures == null){
                $totalnumberoffixtures = $subexist->totalnumberoffixtures;
            }
            if($numberoflightbulbperfixtures == null){
                $numberoflightbulbperfixtures = $subexist->numberoflightbulbperfixtures;
            }
            if($totalnumberoflightbulb == null){
                $totalnumberoflightbulb = $subexist->totalnumberoflightbulb;
            }
            if($lightingreflector == null){
                $lightingreflector = $subexist->lightingreflector;
            }
            if($controlsystem == null){
                $controlsystem = $subexist->controlsystem;
            }
            if($switchontime == null){
                $switchontime = $subexist->switchontime;
            }
            if($switchofftime == null){
                $switchofftime = $subexist->switchofftime;
            }
            if($consumptionduration == null){
                $consumptionduration = $subexist->consumptionduration;
            }
            if($peakdurationcostoperation == null){
                $peakdurationcostoperation = $subexist->peakdurationcostoperation;
            }
            if($offpeakduration == null){
                $offpeakduration = $subexist->offpeakduration;
            }
            if($annualoperationdays == null){
                $annualoperationdays = $subexist->annualoperationdays;
            }
            if($lighting == null){
                $lighting = $subexist->lighting;
            }
            if($powerratingperfixture == null){
                $powerratingperfixture = $subexist->powerratingperfixture;
            }
            if($dailyenergyconsumtion == null){
                $dailyenergyconsumtion = $subexist->dailyenergyconsumtion;
            }
            if($dailyenergycost == null){
                $dailyenergycost = $subexist->dailyenergycost;
            }
            if($peakdurationcostenergy == null){
                $peakdurationcostenergy = $subexist->peakdurationcostenergy;
            }   
            if($offpeakdurationcost == null){
                $offpeakdurationcost = $subexist->offpeakdurationcost;
            } 
            if($annualenergycost == null){
                $annualenergycost = $subexist->annualenergycost;
            }    
            if($grandtotalannualenergyconsumption == null){
                $grandtotalannualenergyconsumption = $subexist->grandtotalannualenergyconsumption;
            }
            if($grandtotalannualenergycost == null){
                $grandtotalannualenergycost = $subexist->grandtotalannualenergycost;
            }

            $subexist->lightingidentification = $lightingidentification;
            $subexist->typeoflighting = $typeoflighting; 
            $subexist->powerrating = $powerrating;
            $subexist->frominventory = $frominventory;
            $subexist->actual = $actual;
            $subexist->loadfactory = $loadfactory;
            $subexist->totalnumberoffixtures = $totalnumberoffixtures; 
            $subexist->numberoflightbulbperfixtures = $numberoflightbulbperfixtures;
            $subexist->totalnumberoflightbulb = $totalnumberoflightbulb;
            $subexist->lightingreflector = $lightingreflector;
            $subexist->controlsystem = $controlsystem;
            $subexist->switchontime  = $switchontime;
            $subexist->switchofftime = $switchofftime;
            $subexist->consumptionduration = $consumptionduration;
            $subexist->peakdurationcostoperation = $peakdurationcostoperation; 
            $subexist->offpeakduration = $offpeakduration;
            $subexist->annualoperationdays = $annualoperationdays;
            $subexist->lighting = $lighting; 
            $subexist->powerratingperfixture = $powerratingperfixture; 
            $subexist->dailyenergyconsumtion = $dailyenergyconsumtion;
            $subexist->dailyenergycost = $dailyenergycost; 
            $subexist->peakdurationcostenergy = $peakdurationcostenergy;
            $subexist->offpeakdurationcost = $offpeakdurationcost;
            $subexist->annualenergycost = $annualenergycost;
            $subexist->grandtotalannualenergyconsumption = $grandtotalannualenergyconsumption; 
            $subexist->grandtotalannualenergycost = $grandtotalannualenergycost;
            $subexist->save();
            
            return response()->json(['status'=>'success','value'=>'success save']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry data not exist']);
        }
    }

    public function generatedependentform(Request $request){

        $masterid = $request->input('masterid');

        $forminfo = Form::find($masterid);
        if($forminfo){

            //quantity
            $roominfo = Room::find($forminfo->roomid);
            $quantity = $roominfo->quantity;

            $tempdata = [

                'roomid' => $forminfo->roomid,
                'equipmentid' => $forminfo->equipmentid,
                'roomname' => $forminfo->roomname,
                'roomfunction' => $forminfo->roomfunction,
                'roomarea' => $forminfo->roomarea,
                'generalobservation' => $forminfo->generalobservation,
                'potentialfornaturallighting' => $forminfo->potentialfornaturallighting,
                'windowsorientation' => $forminfo->windowsorientation,
                'recommendedlux' => $forminfo->recommendedlux,
                'samplingpoints' => $forminfo->samplingpoints,
                'average' => $forminfo->average,
                'category' => 'dependent',
                'masterid' => $forminfo->id,

            ];
            
            for($i = 0; $i < $quantity; $i++){
                $form = DB::table('forms')
                ->insert($tempdata);
            }

            return response()->json(['status'=>'success','value'=>'success generate dependent form']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry masterid at form not exist']);
        }

    }

    // list dependent by master id
    public function listdependent(Request $request){

        $masterid = $request->input('masterid');
        $generalarray = array();

        $dependent = Form::where('masterid',$masterid)->where('category','dependent')->get();

        foreach($dependent as $data){

            if($data->samplingpoints != null){
                $formatpoints = json_decode($data->samplingpoints);
            } else {
                $formatpoints = $data->samplingpoints;
            }

            $temparray = [
                'id' => $data->id,
                'roomid' => $data->roomid,
                'equipmentdid' => $data->equipmentid,
                'roomname' => $data->roomname,
                'roomfunction' => $data->roomfunction,
                'roomarea' => $data->roomarea,
                'generalobservation' => $data->generaloberservation,
                'potentialfornaturallighting' => $data->potentialfornaturallighting,
                'windowsorientation' => $data->windowsorientation,
                'recommendedlux' => $data->recommendedlux,
                'samplingpoints' => $formatpoints,
                'average' => $data->average,
                'category' => $data->category,
                'masterid' => $data->masterid,
            ];

            array_push($generalarray,$temparray);

        }

        return response()->json(['status'=>'success','value'=>$generalarray]);

    }

    //post method for sub based on form je then tarik master punya sub then copy macam biasa
    public function generatedependentsub(Request $request){

        $formid = $request->input('formid');

        $formdetails = Form::find($formid);

        if($formdetails){

            $masterdetails = Form::where('id',$formdetails->masterid)->first();
            $submaster = Subinventory::where('formid',$masterdetails->id)->get();

            //dekat sini buat looping satu2 then set kan dia punya satu2 based on quantity
            foreach($submaster as $data){

                $subexist = Subinventory::where('formid',$formid)->where('subequipmentid',$data->subequipmentid)->first();

                if($subexist == null){

                    $tempdata = [
                        'formid' => $formid,
                        'subequipmentid' => $data->subequipmentid,
                        'lightingidentification' => $data->lightingidentification,
                        'typeoflighting' => $data->typeoflighting,
                        'powerrating' => $data->powerrating,
                        'frominventory' => $data->frominventory,
                        'actual' => $data->actual,
                        'loadfactory' => $data->loadfactory,
                        'totalnumberoffixtures' => $data->totalnumberoffictures,
                        'numberoflightbulbperfixtures' => $data->numberoflightbulbperfixtures,
                        'totalnumberoflightbulb' => $data->totalnumberoflightbulb,
                        'lightingreflector' => $data->lightingreflector,
                        'controlsystem' => $data->controlsystem,
                        'switchontime' => $data->switchontime,
                        'switchofftime' => $data->switchofftime,
                        'consumptionduration' => $data->consumptionduration,
                        'peakdurationcostoperation' => $data->peakdurationcostoperation,
                        'offpeakduration' => $data->offpeakduration,
                        'annualoperationdays' => $data->annualoperationdays,
                        'lighting' => $data->lighting,
                        'powerratingperfixture' => $data->powerratingperfixture,
                        'dailyenergyconsumtion' => $data->dailyenergyconsumtion,
                        'dailyenergycost' => $data->dailyenergycost,
                        'peakdurationcostenergy' => $data->peakdurationcostenergy,
                        'offpeakdurationcost' => $data->offpeakdurationcost,
                        'annualenergycost' => $data->annualenergycost,
                        'grandtotalannualenergyconsumption' => $data->grandtotalannualenergyconsumption,
                        'grandtotalannualenergycost' => $data->grandtotalannualenergycost,
                    ];
    
                    $form = DB::table('subinventories')
                    ->insert($tempdata);

                }

            }
            
            return response()->json(['status'=>'success','value'=>'success generate sub dependent form']);
            
        } else {
            return response()->json(['status'=>'error','value'=>'sorry form id not exist']);
        }
        
    }

    public function detailsdependent(Request $request){
        
        $formid = $request->input('formid');

        $temparray = array();
        $subArray = array();
        $finalArray = array();
        $detailsform = Form::find($formid);

        if($detailsform){

            if($detailsform->samplingpoints != null){
                $formatpoints = json_decode($detailsform->samplingpoints);
            } else {
                $formatpoints = $detailsform->samplingpoints;
            }

            $temparray = [
                'id' => $detailsform->id,
                'roomid' => $detailsform->roomid,
                'equipmentdid' => $detailsform->equipmentid,
                'roomname' => $detailsform->roomname,
                'roomfunction' => $detailsform->roomfunction,
                'roomarea' => $detailsform->roomarea,
                'generalobservation' => $detailsform->generalobservation,
                'potentialfornaturallighting' => $detailsform->potentialfornaturallighting,
                'windowsorientation' => $detailsform->windowsorientation,
                'recommendedlux' => $detailsform->recommendedlux,
                'samplingpoints' => $formatpoints,
                'average' => $detailsform->average,
                'category' => $detailsform->category,
                'masterid' => $detailsform->masterid,
            ];

            //ade subequipment dekat sini
            $sub = Subinventory::where('formid',$detailsform->id)->get();
    
            if($sub){
                foreach($sub as $data){
                    array_push($subArray,$data);
                }
            }

            $finalArray = [
                'main' => $temparray,
                'sub' => $subArray,
            ];

            return response()->json(['status'=>'success','value'=>$finalArray]);
        } else {
            return response()->json(['status'=>'failed','value'=>'sorry form not exist']);
        }
   

    }
}



