<?php

namespace App\Http\Controllers;
use App\Team;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'team engine']);
    }

    public function teambyproject(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            
            //$team = Team::where('projectid',$projectid)->get();

            $team = DB::table('teams')
                      ->join('users','users.id','=','teams.userid')
                      ->join('projects','projects.id','=','teams.projectid')
                      ->select('teams.id as id','teams.projectid as projectid','projects.title as projecttitle','users.name as name','teams.role as role','teams.permission as permission')
                      ->where('teams.projectid','=',$projectid)
                      ->get();

            return response()->json(['status'=>'success','value'=>$team]);

        }

    }

    public function detailsteam(Request $request){

        $validator = validator::make($request->all(),
        [
            'userid' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $id = $request->input('userid');

            $details = Team::find($id);

            return response()->json(['status'=>'success','value'=>$details]);

        }

    }

    public function updateteam(Request $request){

        $teamid = $request->input('teamid');
        $role = $request->input('role');
        $permission = $request->input('permission');

        $team = Team::find($teamid);

        if($role == null){
            $role = $team->role;
        }

        if($permission == null){
            $permission = $team->permission;
        }

        $team->role = $role;
        $team->permission = $permission;
        $team->save();

        return response()->json(['status'=>'success','value'=>'success update']);

    }

    public function destroy(Request $request){
        $id = $request->input('id');
        $team = Team::find($id);
        $team->delete($team->id);

        return response()->json(['status'=>'success','value'=>'success delete']);
    }
}