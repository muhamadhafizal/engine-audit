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
use App\Sumplytariffstructure;
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

            if($form != null){
                
                $listsub = Subinventory::where('formid',$form->id)->get();

                $temparray = [
                    'projectid' => $projectid,
                    'formid' => $form->id,
                    'formname' => $form->formname,
                    'roomid' => $form->roomid,
                    'roomname' => $form->roomname,
                    'listsub' => $listsub,
                ];
    
                array_push($ecmitem,$temparray);

            }

        }

        return response()->json(['status'=>'success','value'=>$ecmitem]);

    }

    public function details(Request $request){

        $subinventoryid = $request->input('subinventoryid');
        //$formid = $request->input('formid');
        //$projectid = $request->input('projectid');

        //genraldeclare
        $luxstandard = null;
        $controlsystem = null;
        $controlsystemresult = null;
        $daylight = null;
        $daylightresult = null;
        $lampcheck = 'no action required';
        $lampcheckresult = 'no action required';

        $ref_average = null;
        $ref_recommendedlux = null;
        $ref_potentialfornaturallighting = null;
        $ref_deviation = null;
        $ref_overlit = null;
        $ref_underlit = null;
        $ref_controlsystem = null;

        $subinventorydeails = Subinventory::find($subinventoryid);

        if($subinventorydeails){

            $formid = $subinventorydeails->formid;

            $formdetails = Form::find($formid);

            $roomdetails = Room::where('id',$formdetails->roomid)->first();

            $projectid = $roomdetails->projectid;
        

        
        //luxstandard & daylight availability & lampcheck

        if($formdetails){

            $ref_average = $formdetails->average;
            $ref_recommendedlux = $formdetails->recommendedlux;
            $ref_potentialfornaturallighting = $formdetails->potentialfornaturallighting;

            //luxstandard (main checking)
            if($formdetails->average >= $formdetails->recommendedlux){
                $luxstandard = 1;
            } else {
                $luxstandard = 0;
            }

            //daylight availability (2C / 2D)
            if($formdetails->potentialfornaturallighting == 'yes'){
                $daylightavailability = 1;
                $daylightavailabilityresult = 'Maximise daylight usage';
            } else {
                $daylightavailability = 0;
                $daylightavailabilityresult = 'Install more lamp';
            }

            //lampcheck (2A / 2B)
            $capacitydetails = Capacity::where('projectid',$projectid)->where('roomid',$formdetails->roomid)->first();
            $lightdeviationdetails = Lightdeviation::where('projectid',$projectid)->first();

            if($capacitydetails != null && $lightdeviationdetails != null){

                $ref_deviation = $capacitydetails->deviation;
                $ref_overlit = $lightdeviationdetails->overlitdeviation;
                $ref_underlit = $lightdeviationdetails->underlitdeviation;
     
                if($capacitydetails->deviation > $lightdeviationdetails->overlitdeviation){

                    $lampcheck = 1;
                    $lampcheckresult = 'Delamping';
                } elseif ($capacitydetails->deviation < $lightdeviationdetails->underlitdeviation){
            
                    $lampcheck = 0;
                    $lampcheckresult = 'Daylight availability';
                }

            }

        }

        //controlsystem (1C / 1D)
        if($subinventorydeails){

            $ref_controlsystem = $subinventorydeails->controlsysten;

            if($subinventorydeails->controlsysten == 'manual'){
                $controlsystem = 0;
                $controlsystemresult  = 'Install control system for exiting lamp';
            } else {
                $controlsystem = 1;
                $controlsystemresult = 'No ECM';
            }
        }

        // Efficiency (1A / 1B)
        //input current installation and corrective measure

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

            if($details->lampcheck == '0'){
                $lampcategory = 'Underlit';
            } elseif($details->lampcheck == '1') {
                $lampcategory = 'Overlit';
            } else {
                $lampcategory = 'unknown';
            }

            if($details->luxstandard == '1'){
                $temparray = [
                    'id' => $details->id,
                    'subinventoryid' => $details->subinventoryid,
                    'status' => $details->status,
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
                    'category' => 'Wellit',
                ];
            } else {
                $temparray = [
                    'id' => $details->id,
                    'projectid' => $details->projectid,
                    'formid' => $details->formid,
                    'subinventoryid' => $details->subinventoryid,
                    'status' => $details->status,
                    'luxstandard' => $details->luxstandard,
                    'luxstandardname' => 'does not meet recommended standard',
                    'lampcheck' => $details->lampcheck,
                    'lampcheckresult' => $details->lampcheckresult,
                    'daylightavailability' => $details->daylightavailability,
                    'daylightavailabilityresult' => $details->daylightavailabilityresult,
                    'category' => $lampcategory,
                ];
            }

            //formarray
            $formrray = [
                'id' => $formdetails->id,
                'roomid' => $formdetails->roomid,
                'equipmentid' => $formdetails->equipmentid,
                'roomname' => $formdetails->roomname,
                'roomfunction' => $formdetails->roomfunction,
                'roomarea' => $formdetails->roomarea,
                'generalobservation' => $formdetails->generalobservation,
                'potentialfornaturallighting' => $formdetails->potentialfornaturallighting,
                'windowsorientation' => $formdetails->windowsorientation,
                'recommendedlux' => $formdetails->recommendedlux,
                'samplingpoints' => json_decode($formdetails->samplingpoints),
                'average' => $formdetails->average,
                'category' => $formdetails->category,
                'grandtotalenergyconsumption' => $formdetails->grandtotalenergyconsumption,
                'grandtotalannualenergycost' => $formdetails->grandtotalannualenergycost,
                'formname' => $formdetails->formname,

            ];

            //referencearray
            $referencearray = [
                'ref_average' => $ref_average,
                'ref_recommendedlux' => $ref_recommendedlux,
                'ref_potentialfornaturallighting' => $ref_potentialfornaturallighting,
                'ref_deviation' => $ref_deviation,
                'ref_overlit' => $ref_overlit,
                'ref_underlit' => $ref_underlit,
                'ref_controlsystem' => $ref_controlsystem,
            ];

            $finalarray = [
                'result' => $temparray,
                'reference' => $referencearray,
                'forminformation' => $formrray,
                'subinventoryinformation' => $subinventorydeails,
            ];

            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry subinventory id not exist']);
        }

        

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

    public function calculation(Request $request){

        $ecm_id = $request->input('ecm_id');

        $detailsecm = Ecm::find($ecm_id);

        $resultdescone = '-';
        $resultecmone = '-';

        if($detailsecm){

            if($detailsecm->luxstandard == '0'){
                
                if($detailsecm->lampcheck == '0'){
                    if($detailsecm->daylightavailability == '0'){
                        $resultecm = '2D';
                        $resultdesc = 'install more lamp';

                    } elseif($detailsecm->daylightavailability == '1') {
        
                        $resultecm = '2C';
                        $resultdesc = 'maximise daylight usage';

                    } else {

                        $resultecm = 'E';
                        $resultdesc = 'no action required';

                    }

                } elseif($detailsecm->lampcheck == '1') {

                    $resultdesc = 'delamping';
                    $resultecm = '2A';

                } else {

                    $resultdesc = 'no action required';
                    $resultecm = 'E';

                }

            } else {
          
                if($detailsecm->effieciency == '0'){
                    $resultdesc = 'change to higher efficiency';
                    $resultecm = '1B';
                } elseif($detailsecm->effieciency == '1'){
                    $resultdesc = 'No ECM';
                    $resultecm = '1A';
                } else {
                    $resultdesc = 'no action required';
                    $resultecm = 'E';
                }

                if($detailsecm->controlsystem == '0'){
                    $resultdescone = 'install control system for existing lamp';
                    $resultecmone = '1D';
                } elseif($detailsecm->controlsystem == '1'){
                    $resultdescone = 'No ECM';
                    $resultecmone = '1C';
                }

            }

            if($resultecm == 'E'){
                return response()->json(['status'=>'success','value'=>'no calculation required']);
            } else {

                if($resultecm == '2D'){

                    $formdetails = Form::find($detailsecm->formid);
                    $subinventorydetails = Subinventory::find($detailsecm->subinventoryid);
                    $sumplytariff = Sumplytariffstructure::where('projectid',$detailsecm->projectid)->first();

                    //difference in lux
                    $difference_lux = $formdetails->recommendedlux - $formdetails->average;

                    //number of lamp required
                    if($detailsecm->underlit_lumen_of_lamp == null){
                        $lumen_of_lamp = 0;
                    } else{
                        $lumen_of_lamp = $detailsecm->underlit_lumen_of_lamp;
                    }
                    if($difference_lux > 0){
                       $number_of_lamp = $difference_lux * $formdetails->roomarea / $lumen_of_lamp;
                    } else {
                        $number_of_lamp = 0;
                    }

                    //investment cost
                    if($detailsecm->underlit_unit_price_of_lamp == null){
                        $unit_price_lamp = 0;
                    } else {
                        $unit_price_lamp = $detailsecm->underlit_unit_price_of_lamp;
                    }

                    $investment_cost = $number_of_lamp * $unit_price_lamp;

                    //annual energy consumption
                    if($detailsecm->underlit_power_rating_of_lamp == null){
                        $power_rating_of_lamp = 0;
                    } else {
                        $power_rating_of_lamp = $detailsecm->underlit_power_rating_of_lamp;
                    }
 
                    $annual_energy_consumption = (($power_rating_of_lamp / 1000 * $number_of_lamp) * $subinventorydetails->loadfactory) * $subinventorydetails->consumptionduration * $subinventorydetails->annualoperationdays;
                    
                    //annual energy cost

                    $annual_energy_cost = (($power_rating_of_lamp / 1000 * $subinventorydetails->loadfactory) * $number_of_lamp * $subinventorydetails->peakdurationcostoperation * $sumplytariff->structurepeak + ($power_rating_of_lamp * $subinventorydetails->loadfactory / 1000) * $number_of_lamp * $subinventorydetails->offpeakduration * $sumplytariff->structureoffpeak) * $subinventorydetails->annualoperationdays;

                    $detailsecm->underlit_difference_in_lux = $difference_lux;
                    $detailsecm->underlit_number_of_lamp_required = $number_of_lamp;
                    $detailsecm->underlit_investment_cost = $investment_cost;
                    $detailsecm->underlit_annual_energy_consumption = $annual_energy_consumption;
                    $detailsecm->underlit_annual_energy_cost = $annual_energy_cost;

                    $detailsecm->save();

                    $finalresult = [
                        'type_of_lamp' => $detailsecm->underlit_type_of_lamp,
                        'unit_price_of_lamp' => $detailsecm->underlit_unit_price_of_lamp,
                        'lumen_of_lamp' => $detailsecm->underlit_lumen_of_lamp,
                        'power_rating_of_lamp' => $detailsecm->underlit_power_rating_of_lamp,
                        'difference_in_lux' => $detailsecm->underlit_difference_in_lux,
                        'number_of_lamp_required' => $detailsecm->underlit_number_of_lamp_required,
                        'investment_cost' => $detailsecm->underlit_investment_cost,
                        'annual_energy_consumption' => $detailsecm->underlit_annual_energy_consumption,
                        'annual_energy_cost' => $detailsecm->underlit_annual_energy_cost,
                    ];

                } elseif($resultecm == '2C'){
                    echo 'calculation 4';
                } elseif($resultecm == '2A'){
                    echo 'calculation 1 overlit';
                } elseif($resultecm == '1B'){
                    echo 'calculation 2';
                }

                if($resultecmone == '1D'){
                    echo 'calculation 3';
                }

                $finalarray = array();

                $finalarray = [
                    'ecm_id' => $detailsecm->id,
                    'result_ecm' => $resultecm,
                    'result_ecmdesc' => $resultdesc,
                    'result_ecmone' => $resultecmone,
                    'result_ecmonedesc' => $resultdescone,
                    'finalresult' => $finalresult,
                    'ecm_calculation_desc' => 'calculation 1 underlit',
                ];

            }

            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry ecm id not exist']);
        }

    }
}
