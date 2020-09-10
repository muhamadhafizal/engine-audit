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
}


