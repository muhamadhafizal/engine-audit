<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;
use App\Setup;
use Illuminate\Support\Facades\Validator;


class EquipmentController extends Controller
{
    public function addequipment(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'equipments' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $data = new Equipment;
            $data->projectid = $request->input('projectid');
            $data->equipments = $request->input('equipments');

            $data->save();

            return response()->json(['status'=>'success','value'=>'success add equipments']);

        }

    }

    public function listequipment(Request $request){

        $projectid = $request->input('projectid');

        $data = Equipment::where('projectid',$projectid)->get();

        return response()->json(['status'=>'success','value'=>$data]);

    }

    //editequipment
    public function updateequipment(Request $request){

        $equipmentid = $request->input('equipmentid');
        $projectid = $request->input('projectid');
        $equipments = $request->input('equipments');

        $exist = Equipment::find($equipmentid);

        if($exist){

            if($projectid == null){
                $projectid = $exist->projectid;
            }
            if($equipments == null){
                $equipments = $exist->equipments;
            }

            $exist->projectid = $projectid;
            $exist->equipments = $equipments;

            $exist->save();

            return response()->json(['status'=>'success','value'=>'success update equipments']);

        } else {

            return response()->json(['status'=>'error','value'=>'equipment not exist']);

        }


    }

    //deleteequipment
    public function deleteequipment(Request $request){

        $equipmentid = $request->input('equipmentid');

        $equip = Equipment::find($equipmentid);
        $equip->delete();

        Setup::where('equipmentid',$equipmentid)->delete();

        return response()->json(['status'=>'success','value'=>'success delete equipment']);

    }

    public function addsetup(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'equipmentid' => 'required',
            'lightingid' => 'required',
            'type' => 'required',
            'powerrating' => 'required',
            'lumen' => 'required',
            'average' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $setup = new Setup;
            $setup->projectid = $request->input('projectid');
            $setup->equipmentid = $request->input('equipmentid');
            $setup->lightingid = $request->input('lightingid');
            $setup->type = $request->input('type');
            $setup->powerrating = $request->input('powerrating');
            $setup->lumen = $request->input('lumen');
            $setup->average = $request->input('average');

            $setup->save();

            return response()->json(['status'=>'success','value'=>'success add setup equipments']);

        }

    }   

    public function listsetup(Request $request){

        $projectid = $request->input('projectid');
        $equipmentid = $request->input('equipmentid');

        $data = Setup::where('projectid',$projectid)->where('equipmentid',$equipmentid)->get();

        return response()->json(['status'=>'success','value'=>$data]);

    }

    public function detailssetup(Request $request){

        $setupid = $request->input('setupid');

        $data = Setup::find($setupid);

        return response()->json(['status'=>'success','value'=>$data]);

    }

    //edit setup
    public function editsetup(Request $request){

        $setupid = $request->input('setupid');
        $projectid = $request->input('projectid');
        $equipmentid = $request->input('equipmentid');
        $lightingid = $request->input('lightingid');
        $type = $request->input('type');
        $powerrating = $request->input('powerrating');
        $lumen = $request->input('lumen');
        $average = $request->input('average');

        $exist = Setup::find($setupid);
        if($exist){

            if($projectid == null){
                $projectid = $exist->projectid;
            }
            if($equipmentid == null){
                $equipmentid = $exist->equipmentid;
            }
            if($lightingid == null){
                $lightingid = $exist->lightingid;
            }
            if($type == null){
                $type = $exist->type;
            }
            if($powerrating == null){
                $powerrating = $exist->powerrating;
            }
            if($lumen == null){
                $lumen = $exist->lumen;
            }
            if($average == null){
                $average = $exist->average;
            }

            $exist->projectid = $projectid;
            $exist->equipmentid = $equipmentid;
            $exist->lightingid = $lightingid;
            $exist->type = $type;
            $exist->powerrating = $powerrating;
            $exist->lumen = $lumen;
            $exist->average = $average;

            $exist->save();

            return response()->json(['status'=>'success','value'=>'success update equipment setup']);

        } else {

            return response()->json(['status'=>'failed','value'=>'equipment setup is not exist']);

        }


    }

    //delete setup
    public function destroysetup(Request $request){

        $setupid = $request->input('setupid');

        $data = Setup::find($setupid);

        $data->delete();

        return response()->json(['status'=>'success','value'=>'success delete equipment setup']);

    }
}


