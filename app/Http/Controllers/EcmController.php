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

        $finalresult = array();

        $resultdescone = '-';
        $resultecmone = '-';

        if($detailsecm){

            if($detailsecm->luxstandard == '0'){
                
                if($detailsecm->lampcheck == '0'){
                    if($detailsecm->daylightavailability == '0'){
                        $resultecm = '2D';
                        $resultdesc = '(underlit area) install more lamp';

                    } elseif($detailsecm->daylightavailability == '1') {
        
                        $resultecm = '2C';
                        $resultdesc = '(underlit) maximise daylight usage';

                    } else {

                        $resultecm = 'E';
                        $resultdesc = 'no action required';

                    }

                } elseif($detailsecm->lampcheck == '1') {

                    $resultdesc = '(overlit area) delamping';
                    $resultecm = '2A';

                } else {

                    $resultdesc = 'no action required';
                    $resultecm = 'E';

                }

            } else {
                //luxstandard = 1
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

            if($resultecm == 'E' || $resultecm == '1A' || $resultecm == '1C'){
                return response()->json(['status'=>'success','value'=>'no calculation required or NO ECM']);
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
                        'ecm_calculation_desc' => 'calculation 1 underlit',
                    ];

                } elseif($resultecm == '2C'){
                    // echo 'calculation 4';
                    // echo $resultdesc;
                    $formdetails = Form::find($detailsecm->formid);
                    $subinventorydetails = Subinventory::find($detailsecm->subinventoryid);
                    $tariffstructure = Sumplytariffstructure::where('projectid',$detailsecm->projectid)->first();

                    if($subinventorydetails != null && $formdetails != null){
                        $annual_energy_saving = ($subinventorydetails->powerratingperfixture/1000) * $subinventorydetails->totalnumberoffixtures * $detailsecm->maximize_duration_of_daylight_usage * $subinventorydetails->annualoperationdays;
                    } else {
                        $annual_energy_saving = 0;
                    }

                    if($subinventorydetails != null && $formdetails != null && $tariffstructure != null){
                        $annual_energy_cost_saving = ($subinventorydetails->powerratingperfixture/1000) * $subinventorydetails->totalnumberoffixtures * $detailsecm->maximize_duration_of_daylight_usage * $tariffstructure->structurepeak;
                    } else {
                        $annual_energy_cost_saving = 0;
                    }

                    $detailsecm->maximize_annual_energy_saving = $annual_energy_saving;
                    $detailsecm->maximize_annual_energy_cost_saving = $annual_energy_cost_saving;

                    $detailsecm->save();

                    $finalresult = [
                        'duration_of_daylight' => $detailsecm->maximize_duration_of_daylight_usage,
                        'annual_energy_saving' => $detailsecm->maximize_annual_energy_saving,
                        'annual_energy_cost_saving' => $detailsecm->maximize_annual_energy_cost_saving,
                    ];

                    

                } elseif($resultecm == '2A'){
                    //echo 'calculation 1 overlit';
                    $formdetails = Form::find($detailsecm->formid);
                    $subinventorydetails = Subinventory::find($detailsecm->subinventoryid);
                    $sumplytariff = Sumplytariffstructure::where('projectid',$detailsecm->projectid)->first();
                    
                    //difference in lux
                    $difference_lux = $formdetails->recommendedlux - $formdetails->average;

                    //number of delamping
                    if($detailsecm->overlit_lumen_of_lamp == null){
                        $number_of_delamping = 0;
                    } else {
                        $number_of_delamping = $difference_lux * $formdetails->roomarea / $detailsecm->overlit_lumen_of_lamp; 
                    }

                    //Annual enery consumption
                   if($subinventorydetails){
                        $annual_energy_consumption = (( $detailsecm->overlit_power_rating_for_lamp / 1000 * $number_of_delamping) * $subinventorydetails->loadfactory) * $subinventorydetails->consumptionduration * $subinventorydetails->annualoperationdays;
                   } else {
                       $annual_energy_consumption = 0;
                   }
                   
                   //Annual energy cost
                   if($subinventorydetails != null && $sumplytariff != null){
                    $annual_energy_cost = (( $detailsecm->overlit_power_rating_for_lamp / 1000 * $subinventorydetails->loadfactory) * $number_of_delamping * $subinventorydetails->peakdurationcostoperation * $sumplytariff->structurepeak + ($detailsecm->overlit_power_rating_of_lamp * $subinventorydetails->loadfactory / 1000) * $number_of_delamping * $subinventorydetails->offpeakduration * $sumplytariff->structureoffpeak) * $subinventorydetails->annualoperationdays;    
                   } else {
                    $annual_energy_cost = 0;
                   }

                   //Annual energy saving
                   if($subinventorydetails){
                        $annual_energy_saving = $subinventorydetails->consumptionduratin - $annual_energy_consumption;
                   } else {
                       $annual_energy_saving = 0;
                   }

                   //Annual cost saving
                   if($subinventorydetails){
                        $annual_cost_saving = $subinventorydetails->annualenergycost - $annual_energy_cost;
                   } else {
                       $annual_cost_saving = 0;
                   }

                   //Payback Period
                   if($detailsecm->overlit_investment_cost == null || $annual_cost_saving == 0){
                       $payback_period = 0;
                   } else {
                       $payback_period = $detailsecm->overlit_investment_cost / $annual_cost_saving;
                   }

                   $detailsecm->overlit_difference_in_lux = $difference_lux;
                   $detailsecm->overlit_number_of_delamping = $number_of_delamping;
                   $detailsecm->overlit_annual_energy_consumption = $annual_energy_consumption;
                   $detailsecm->overlit_annual_energy_cost = $annual_energy_cost;
                   $detailsecm->overlit_annual_energy_saving = $annual_energy_saving;
                   $detailsecm->overlit_annual_cost_saving = $annual_cost_saving;
                   $detailsecm->overlit_payback_period = $payback_period;
                   $detailsecm->save();
                    
                   $finalresult = [
                       'type_of_lamp' => $detailsecm->overlit_type_of_lamp,
                       'unit_price_of_lamp' => $detailsecm->overlit_unit_price_of_lamp,
                       'lumen_of_lamp' => $detailsecm->overlit_lumen_of_lamp,
                       'power_rating_for_lamp' => $detailsecm->overlit_power_rating_for_lamp,
                       'difference_lux' => $detailsecm->overlit_difference_in_lux,
                       'number_of_delamping' => $detailsecm->overlit_number_of_delamping,
                       'annual_energy_consumption' => $detailsecm->overlit_annual_energy_consumption,
                       'annual_energy_cost' => $detailsecm->overlit_annual_energy_cost,
                       'annual_energy_saving' => $detailsecm->overlit_annual_energy_saving,
                       'annual_cost_saving' => $detailsecm->overlit_annual_cost_saving,
                       'investment_cost' => $detailsecm->overlit_investment_cost,
                       'payback_period' => $detailsecm->overlit_payback_period,
                       'ecm_calculation_desc' => 'calculation 1 overlit',
                   ];

                    

                } elseif($resultecm == '1B'){
                    // echo 'calculation 2';
                    // echo $resultdesc;

                    $formdetails = Form::find($detailsecm->formid);
                    $subinventorydetails = Subinventory::find($detailsecm->subinventoryid);
                    $tariffstructure = Sumplytariffstructure::where('projectid',$detailsecm->projectid)->first();

                    if($formdetails != null && $subinventorydetails != null){
                        $total_lumen_required_for_room = $formdetails->roomarea * $formdetails->average;                        
                    } else {
                        $total_lumen_required_for_room = 0;
                    }

                    if($detailsecm->efficacy_corrective_lumen_of_lamp != null){
                        $number_of_lamp_required = $total_lumen_required_for_room / $detailsecm->efficacy_corrective_lumen_of_lamp;
                    } else {
                        $number_of_lamp_required = 0;
                    }

                    if($subinventorydetails != null && $tariffstructure != null){
                        $annual_energy_consumption_after_ecm = (($detailsecm->efficacy_corrective_power_rating * $subinventorydetails->loadfactory / 1000) * $number_of_lamp_required * $subinventorydetails->consumptionduration) * $subinventorydetails->annualoperationdays;
                    } else {
                        $annual_energy_consumption_after_ecm = 0;
                    }

                    if($subinventorydetails != null){
                        $annual_energy_cost_after_ecm = (($detailsecm->efficacy_corrective_power_rating * $subinventorydetails->loadfactory / 1000) * $number_of_lamp_required * $subinventorydetails->peakdurationcostoperation * $tariffstructure->structurepeak + ($detailsecm->efficacy_corrective_power_rating * $subinventorydetails->loadfactory / 1000) * $number_of_lamp_required * $subinventorydetails->offpeakduration * $tariffstructure->structureoffpeak)* $subinventorydetails->annualoperationdays;
                    } else {
                        $annual_energy_cost_after_ecm = 0;
                    }

                    if($subinventorydetails != null){
                        $annual_energy_saving = $subinventorydetails->annualenergycost - $annual_energy_consumption_after_ecm;
                    } else {
                        $annual_energy_saving = 0;
                    }

                    if($subinventorydetails != null){
                        $annual_cost_saving = $subinventorydetails->annualenergycost - $annual_energy_cost_after_ecm;
                    } else {
                        $annual_cost_saving = 0;
                    }

                    $investment_cost = $number_of_lamp_required * $detailsecm->efficacy_corrective_unit_price_of_lamp;
                    $payback_period = $investment_cost/$annual_cost_saving;

                    $detailsecm->efficacy_corrective_number_of_lamp_required = $number_of_lamp_required;
                    $detailsecm->efficacy_corrective_annual_energy_consumption = $annual_energy_consumption_after_ecm;
                    $detailsecm->efficacy_corrective_annual_energy_cost = $annual_energy_cost_after_ecm;
                    $detailsecm->efficacy_corrective_annual_energy_saving = $annual_energy_saving;
                    $detailsecm->efficacy_corrective_investment_cost = $annual_cost_saving;
                    $detailsecm->efficacy_corrective_investment_cost = $investment_cost;
                    $detailsecm->efficacy_corrective_payback_period = $payback_period;

                    $detailsecm->save();

                    $finalresult = [
                        'total_lumen_required_for_room' => $total_lumen_required_for_room,
                        'power_rating_of_existing_lemp' => $detailsecm->efficacy_current_power_rating,
                        'current_efficacy_of_lamp' => $detailsecm->efficacy_current_efficacy_lamp,
                        'total_number_of_lamp' => $detailsecm->efficacy_current_total_number_of_lamp,
                        'type_of_lamp' => $detailsecm->efficacy_corrective_type_of_lamp,
                        'corrective_efficacy_of_lamp' => $detailsecm->efficacy_corrective_efficacy_of_lamp,
                        'unit_price_of_lamp' => $detailsecm->efficacy_corrective_unit_price_of_lamp,
                        'lumen_of_lamp' => $detailsecm->efficacy_corrective_lumen_of_lamp,
                        'power_rating' => $detailsecm->efficacy_corrective_power_rating,
                        'number_of_lamp_required' => $number_of_lamp_required,
                        'annual_energy_consumption_after_ecm' => $annual_energy_consumption_after_ecm,
                        'annual_energy_cost_after_ecm' => $annual_energy_cost_after_ecm,
                        'annual_energy_saving' => $annual_energy_saving,
                        'annual_cost_saving' => $annual_cost_saving,
                        'investment_cost' => $investment_cost,
                        'payback_period' => $payback_period,
                    ];

                }

                if($resultecmone == '1D'){
                   //no calcution
                }

                $finalarray = array();

                $finalarray = [
                    'ecm_id' => $detailsecm->id,
                    'result_ecm' => $resultecm,
                    'result_ecmdesc' => $resultdesc,
                    'result_ecmone' => $resultecmone,
                    'result_ecmonedesc' => $resultdescone,
                    'finalresult' => $finalresult,
                ];

            }

            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry ecm id not exist']);
        }

    }

    public function inputvalueecm(Request $request){

        $ecmid = $request->input('ecm_id');
        $ecmdetails = ECM::find($ecmid);

        if($ecmdetails){
            //underlit
            $underlit_type_of_lamp = $request->input('underlit_type_of_lamp');
            $underlit_unit_price_of_lamp = $request->input('underlit_unit_price_of_lamp');
            $underlit_lumen_of_lamp = $request->input('underlit_lumen_of_lamp');
            $underlit_power_rating_of_lamp = $request->input('underlit_power_rating_of_lamp');

            $ecmdetails->underlit_type_of_lamp = $underlit_type_of_lamp;
            $ecmdetails->underlit_unit_price_of_lamp = $underlit_unit_price_of_lamp;
            $ecmdetails->underlit_lumen_of_lamp = $underlit_lumen_of_lamp;
            $ecmdetails->underlit_power_rating_of_lamp = $underlit_power_rating_of_lamp;

            //overlit
            $overlit_type_of_lamp = $request->input('overlit_type_of_lamp');
            $overlit_unit_price_of_lamp = $request->input('overlit_unit_price_of_lamp');
            $overlit_lumen_of_lamp = $request->input('overlit_lumen_of_lamp');
            $overlit_power_rating_for_lamp = $request->input('overlit_power_rating_for_lamp');
            $overlit_investment_cost = $request->input('overlit_investment_cost');

            $ecmdetails->overlit_type_of_lamp = $overlit_type_of_lamp;
            $ecmdetails->overlit_unit_price_of_lamp = $overlit_unit_price_of_lamp;
            $ecmdetails->overlit_lumen_of_lamp = $overlit_lumen_of_lamp;
            $ecmdetails->overlit_power_rating_for_lamp = $overlit_power_rating_for_lamp;
            $ecmdetails->overlit_investment_cost = $overlit_investment_cost;
            $ecmdetails->overlit_power_rating_for_lamp;

            //maximise daylight usage
            $maximize_duration_of_daylight_usage = $request->input('maximize_duration_of_daylight_usage');

            $ecmdetails->maximize_duration_of_daylight_usage = $maximize_duration_of_daylight_usage;

            //efficacy lamp
            $efficacy_current_power_rating = $request->input('efficacy_current_power_rating');
            $efficacy_current_efficacy_lamp = $request->input('efficacy_current_efficacy_lamp');
            $efficacy_current_total_number_of_lamp = $request->input('efficacy_current_total_number_of_lamp');
            $efficacy_corrective_type_of_lamp = $request->input('efficacy_corrective_type_of_lamp');
            $efficacy_corrective_efficacy_of_lamp = $request->input('efficacy_corrective_efficacy_of_lamp');
            $efficacy_corrective_unit_price_of_lamp = $request->input('efficacy_corrective_unit_price_of_lamp');
            $efficacy_corrective_lumen_of_lamp = $request->input('efficacy_corrective_lumen_of_lamp');
            $efficacy_corrective_power_rating = $request->input('efficacy_corrective_power_rating');

            $ecmdetails->efficacy_current_power_rating = $efficacy_current_power_rating;
            $ecmdetails->efficacy_current_efficacy_lamp = $efficacy_current_efficacy_lamp;
            $ecmdetails->efficacy_current_total_number_of_lamp = $efficacy_current_total_number_of_lamp;
            $ecmdetails->efficacy_corrective_type_of_lamp = $efficacy_corrective_type_of_lamp;
            $ecmdetails->efficacy_corrective_efficacy_of_lamp = $efficacy_corrective_efficacy_of_lamp;
            $ecmdetails->efficacy_corrective_unit_price_of_lamp = $efficacy_corrective_unit_price_of_lamp;
            $ecmdetails->efficacy_corrective_lumen_of_lamp = $efficacy_corrective_lumen_of_lamp;
            $ecmdetails->efficacy_corrective_power_rating = $efficacy_corrective_power_rating;

            $ecmdetails->save();

            return response()->json(['status'=>'success','value'=>'success save ecm info']);

        } else {
            return response()->json(['status'=>'failed','value'=>'ecm id not exist']);
        }
        


    }
}
