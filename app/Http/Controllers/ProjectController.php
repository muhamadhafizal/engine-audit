<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'product engine']);
    }

    public function addSetupTeam(Request $request){

        $validator = validator::make($request->all(),
        [   
            'companyid' => 'required',
            'team' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $team = $request->input('team');
            $companyid = $request->input('companyid');
            
            $project = new project;
            $project->setupteam = $team;
            $project->companyid = $companyid;

            $project->save();

            return response()->json(['status'=>'success','data'=>'success team project']);

        }

    }

    public function all(){

        $data = Project::all();

        return response()->json(['status'=>'success', 'data'=>$data]);

    }

    public function projectbycompany(Request $request){
        
        $companyid = $request->input('companyid');

        $data = Project::where('companyid', $companyid)->orderBy('id','DESC')->get();

        if($data){
            return response()->json(['status'=>'success','data'=>$data]);
        } else {
            return response()->json(['status'=>'failure','data'=>'Project not exist']);
        }

    }

    public function details(Request $request){

        $projectid = $request->input('projectid');

        $data = Project::find($projectid);

        return response()->json(['status'=>'success','data'=>$data]);

    }

    public function destroy(Request $request){
        $projectid = $request->input('projectid');

        $project = Project::find($projectid);
        $project->delete($project->id);

        return response()->json(['status'=>'success']);
    }

    public function information(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'objective' => 'required',
            'scope' => 'required',
            'methodology' => 'required',
            'measurementtools' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $objective = $request->input('objective');
            $scope = $request->input('scope');
            $methodology = $request->input('methodology');
            $measurementtools = $request->input('measurementtools');

            $project = Project::find($projectid);
            if($project){

                $project->objective = $objective;
                $project->scope = $scope;
                $project->methodology = $methodology;
                $project->measurementtools = $measurementtools;

                $project->save();

                return response()->json(['status'=>'success']);

            } else {
                return response()->json(['status'=>'failure','data'=>'project not exist']);
            }
        }

    }

    public function update(Request $request){

        $projectid = $request->input('projectid');
        $team = $request->input('team');
        $objective = $request->input('objective');
        $scope = $request->input('scope');
        $methodology = $request->input('methodology');
        $measurementtools = $request->input('measurementtools');

        $project = Project::find($projectid);

        if($project){

            if($team == null){
                $team = $project->setupteam;
            }
            if($objective == null){
                $objective = $project->objective;
            }
            if($scope == null){
                $scope = $project->scope;
            }
            if($methodology == null){
                $methodology = $project->methodology;
            }
            if($measurementtools == null){
                $measurementtools = $project->measurementtools;
            }

            $project->setupteam = $team;
            $project->objective = $objective;
            $project->scope = $scope;
            $project->methodology = $methodology;
            $project->measurementtools = $measurementtools;

            $project->save();

            return response()->json(['status'=>'success']);

        } else {
            return response()->json(['status'=>'failure','data'=>'project not exist']);
        }

    }

}