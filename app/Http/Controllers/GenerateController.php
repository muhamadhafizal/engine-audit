<?php

namespace App\Http\Controllers;
use App\Generate;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'generate engine']);
    }

    public function store(Request $request){

        $projectid = $request->input('projectid');
        $name = $request->input('name');
        $level = $request->input('level');
        $levelone = $request->input('levelone');
        $leveltwo = $request->input('leveltwo');
        $levelthree = $request->input('levelthree');
        $levelfour = $request->input('levelfour');
        $levelfive = $request->input('levelfive');

        $generate = new Generate;
        $generate->projectid = $projectid;
        $generate->name = $name;
        $generate->level = $level;
        $generate->levelone = $levelone;
        $generate->leveltwo = $leveltwo;
        $generate->levelthree = $levelthree;
        $generate->levelfour = $levelfour;
        $generate->levelfive = $levelfive;

        $generate->save();

        return response()->json(['status'=>'success','value'=>'success add generate']);

    }

    public function list(Request $request){

        $level = $request->input('level');
        $projectid = $request->input('projectid');
        $parentid = $request->input('parentid');
        $finalArray = array();

        if($parentid == null){

            $list = Generate::where('projectid',$projectid)->where('level',$level)->get();

        } else {

            if($level == 'two'){
                $list = Generate::where('projectid',$projectid)->where('levelone',$parentid)->where('level','two')->get();
            } elseif($level == 'three'){
                $list = Generate::where('projectid',$projectid)->where('leveltwo',$parentid)->where('level','three')->get();
            } elseif($level == 'four'){
                $list = Generate::where('projectid',$projectid)->where('levelthree',$parentid)->where('level','four')->get();
            } elseif($level == 'five'){
                $list = Generate::where('projectid',$projectid)->where('levelfour',$parentid)->where('level','five')->get();
            }

        }

        if($list){

            foreach($list as $data){
                
                $status = 'notavailable';
                //level
                $level = $data->level;

                //query bawah dia
                if($level == 'one'){
                    $exist = Generate::where('level','two')->where('levelone',$data->id)->first();
                } elseif($level == 'two'){
                    $exist = Generate::where('level','three')->where('leveltwo',$data->id)->first();
                } elseif($level == 'three'){
                    $exist = Generate::where('level','four')->where('levelthree',$data->id)->first();
                } elseif($level == 'four'){
                    $exist = Generate::where('level','five')->where('levelfour',$data->id)->first();
                } else {
                    $exist = null;
                }

                if($exist != null){
                    $status = 'available';
                }

                $tempArray = [
                    'id' => $data->id,
                    'projectid' => $data->projectid,
                    'name' => $data->name,
                    'level' => $data->level,
                    'levelone' => $data->levelone,
                    'leveltwo' => $data->leveltwo,
                    'levelthree' => $data->levelthree,
                    'levelfour' => $data->levelfour,
                    'levelfive' => $data->levelfivem,
                    'status' => $status,
                ];

                array_push($finalArray,$tempArray);
            }

            return response()->json(['status'=>'success','value'=>$finalArray]);

        } else {
            return response()->json(['status'=>'error','value'=>'data not exist']);
        }

    }

    public function edit(Request $request){

        $generateid = $request->input('generateid');
        $name = $request->input('name');

        $details = Generate::find($generateid);

        $details->name = $name;

        $details->save();

        return response()->json(['status'=>'success','value'=>'success edit name']);
        
    }

    public function destroy(Request $request){

        $generateid = $request->input('generateid');

        $data = Generate::find($generateid);

        if($data){

            $list = Generate::where('id',$generateid)
                                ->orWhere('levelone', $generateid)
                                ->orWhere('leveltwo', $generateid)
                                ->orWhere('levelthree', $generateid)
                                ->orWhere('levelfour', $generateid)
                                ->orWhere('levelfive', $generateid)
                    ->delete();
            return response()->json(['status'=>'success','value'=>'success deleted']);

        } else {
            return response()->json(['status'=>'error','value'=>'sorry data not exist']);
        }

    }
}
