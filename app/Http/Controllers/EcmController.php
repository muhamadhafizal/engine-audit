<?php

namespace App\Http\Controllers;

use App\Project;
use App\Room;
use App\Equipment;
use App\Form;
use App\Subinventory;
use App\Setup;
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

            $temparray = [
                'formid' => $form->id,
                'formname' => $form->formname,
                'roomid' => $form->roomid,
                'listsub' => $listsub,
            ];

            array_push($ecmitem,$temparray);

        }

        return response()->json(['status'=>'success','value'=>$ecmitem]);

    }
}
