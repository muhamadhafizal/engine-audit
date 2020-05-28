<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
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
        $projectArray = array();
        $tempArray = array();

        $data = Project::where('companyid', $companyid)->orderBy('id','DESC')->get();
        $company = User::where('role','2')->where('id',$companyid)->first();

        if($data){

            foreach($data as $pro){

                $a = json_decode($pro->setupteam);

                if($pro->buildinggeneralinformation){
                    $b = json_decode($pro->buildinggeneralinformation);
                } else {
                    $b = $pro->buildinggeneralinformation;
                }

                if($pro->buildingoperationinformation){
                    $c = json_decode($pro->buildingoperationinformation);
                } else {
                    $c = $pro->buildingoperationinformation;
                }

                if($pro->energymanagementreview){
                    $d = json_decode($pro->energymanagementreview, true);

                    if($d['data'][0]['review'] == 'AEMAS'){
                        $e = ($d['data'][0]['AEMAS']);
                        $finalArray = [
                            'review' => 'AEMAS',
                            'data' => $e,
                        ];
                    } elseif($d['data'][0]['review'] == 'ISO'){
                        $e = ($d['data'][0]['ISO']);
                        $finalArray = [
                            'review' => 'ISO',
                            'data' => $e,
                        ];
                    }

                } else {
                    $finalArray = $pro->energymanagementreview;
                }

                $tempArray = [

                    'id' => $pro->id,
                    'setupteam' => $a,
                    'projectinformation' => $pro->projectinformation,
                    'created_at' => $pro->created_at,
                    'updated_at' => $pro->updated_at,
                    'company_id' => $pro->companyid,
                    'company_name' => $company->name,
                    'objective' => $pro->objective,
                    'scope' => $pro->scope,
                    'methodology' => $pro->methodology,
                    'measurementtools' => $pro->measurementtools,
                    'buildinggeneralinformation' => $b,
                    'buildingoperaioninformation' => $c,
                    'energymanagementreview' => $finalArray,

                ];

                array_push($projectArray,$tempArray);

            }
            
                return response()->json(['status'=>'success','data'=>$projectArray]);
        } else {
            return response()->json(['status'=>'failure','data'=>'Project not exist']);
        }

    }

    public function details(Request $request){

        $productArray = array();

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');

            $data = Project::find($projectid);
            if($data){

                $company = User::where('role','2')->where('id',$data->companyid)->first();
                $a = json_decode($data->setupteam);
                
                if($data->buildinggeneralinformation){
                    $b = json_decode($data->buildinggeneralinformation);
                }else {
                    $b = $data->buildinggeneralinformation;
                }

                if($data->buildingoperationinformation){
                    $c = json_decode($data->buildingoperationinformation);
                } else {
                    $c = $data->buildingoperationinformation;
                }

                if($data->energymanagementreview){
                    $d = json_decode($data->energymanagementreview, true);

                    if($d['data'][0]['review'] == 'AEMAS'){
                        $e = ($d['data'][0]['AEMAS']);
                        $finalArray = [
                            'review' => 'AEMAS',
                            'data' => $e,
                        ];
                    } elseif($d['data'][0]['review'] == 'ISO'){
                        $e = ($d['data'][0]['ISO']);
                        $finalArray = [
                            'review' => 'ISO',
                            'data' => $e,
                        ];
                    }

                } else {
                    $finalArray = $data->energymanagementreview;
                }

 
                $productArray = [

                    'id' => $data->id,
                    'setupteam' => $a,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                    'companyid' => $data->companyid,
                    'companyname' => $company->name,
                    'objective' => $data->objective,
                    'scope' => $data->scope,
                    'methodology' => $data->methodology,
                    'measurementtools' => $data->measurementtools,
                    'buildinggeneralinformation' => $b,
                    'buildingoperationinformation' => $c,
                    'energymanagementreview' => $finalArray,

                ];

                return response()->json(['status'=>'success','data'=>$productArray]);
            } else {
                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }

        }

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

    public function generalinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'generalinformation' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $generalinformation = $request->input('generalinformation');

            $project = Project::find($projectid);

            if($project){

                $project->buildinggeneralinformation = $generalinformation;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add building general information']);

            } else {

                return response()->json(['status'=>'failed','data'=>'project not exist']);

            }

        }

    }

    public function operationinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'operationinformation' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $operationinformation = $request->input('operationinformation');

            $project = Project::find($projectid);

            if($project){
                $project->buildingoperationinformation = $operationinformation;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add building operation information']);
            } else {
                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }
        }
    }

    public function managementreview(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'managementreview' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $managementreview = $request->input('managementreview');

            $project = Project::find($projectid);

            if($project){

                $project->energymanagementreview = $managementreview;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add energy management review']);

            } else {
                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }

        }

    }

}
