<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Team;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'product engine']);
    }

    public function addproject(Request $request){

        $validator = validator::make($request->all(),
        [
            'companyid' => 'required',
            'title' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {
            $companyid = $request->input('companyid');
            $title = $request->input('title');

            $project = new Project;
            $project->companyid = $companyid;
            $project->title = $title;

            $project->save();

            return response()->json(['status'=>'success','value'=>'success add project']);
        }

    }

    public function addSetupTeam(Request $request){

        $validator = validator::make($request->all(),
        [   
            'projectid' => 'required',
            'userid' => 'required',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $userid = $request->input('userid');
            $role = $request->input('role');

            $team = new Team;
            $team->projectid = $projectid;
            $team->userid = $userid;
            $team->role = $role;

            $team->save();

            return response()->json(['status'=>'success', 'value'=>'success add team project']);

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
        
        $data =  DB::table('projects')
                ->join('users','users.id','=','projects.companyid')
                ->select('projects.id as id','projects.title as title','users.name as companyname')
                ->where('projects.companyid','=',$companyid)
                ->get();

        if($data){
                return response()->json(['status'=>'success','data'=>$data]);
        } else {
            return response()->json(['status'=>'failure','data'=>'Project not exist']);
        }

    }

    public function details(Request $request){

        $productArray = array();
        $env = 'http://engine-audit.test/images/';
        //$env = 'http://52.74.178.166:82/';

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
                } else {
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

                if($data->energygeneralinformation){
                    $f = json_decode($data->energygeneralinformation);
                } else {
                    $f = $data->energygeneralinformation;
                }

                if($data->energytariffstructure){
                    $g = json_decode($data->energytariffstructure);
                } else {
                    $g = $data->energytariffstructure;
                }

                if($data->lightingregistry){
                    $j = json_decode($data->lightingregistry);
                } else {
                    $j = $data->lightingregistry;
                }

                if($data->refrences){
                    $k = json_decode($data->refrences);
                } else {
                    $k = $data->refrences;
                }

                if($data->imagesref){
                    $dirfile = $env . ''. $data->imagesref;
                } else {
                    $dirfile = $data->imagesref;
                }

 
                $productArray = [

                    'id' => $data->id,
                    'title' => $data->title,
                    'setupteam' => $a,
                    'projectinformation' => $data->projectinformation,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                    'company_id' => $data->companyid,
                    'company_name' => $company->name,
                    'objective' => $data->objective,
                    'scope' => $data->scope,
                    'methodology' => $data->methodology,
                    'measurementtools' => $data->measurementtools,
                    'buildinggeneralinformation' => $b,
                    'buildingoperaioninformation' => $c,
                    'energymanagementreview' => $finalArray,
                    'energygeneralinformation' => $f,
                    'energytariffstructure' => $g,
                    'lightingregistry' => $j,
                    'references' => $k,
                    'imagesref' => $dirfile,

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

    public function energygeneralinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'energygeneralinformation' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $energygeneralinformation = $request->input('energygeneralinformation');

            $project = Project::find($projectid);

            if($project){

                $project->energygeneralinformation = $energygeneralinformation;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add energy general information']);

            } else {

                return response()->json(['status'=>'failed','data'=>'project not exist']);

            }

        }

    }

    public function energytariffstructure(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'energytariffstructure' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $energytariffstructure = $request->input('energytariffstructure');

            $project = Project::find($projectid);

            if($project){

                $project->energytariffstructure = $energytariffstructure;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add energy tariff structure']);

            } else {

                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }

        }

    }

    public function energytarifftimezone(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'energytarifftimezone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $energytarifftimezone = $request->input('energytarifftimezone');

            $project = Project::find($projectid);

            if($project){

                $project->energytarifftimezone = $energytarifftimezone;
                $project->save();

                return response()->json(['status'=>'success','data'=>'success add energy tariff time zone']);

            } else {
                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }

        }

    }

    public function lightingregistry(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'lightingregistry' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $lightingregistry = $request->input('lightingregistry');

            $project = Project::find($projectid);

            if($project){

                $project->lightingregistry = $lightingregistry;

                $project->save();

                return response()->json(['status'=>'success','data'=>'success add lighting registry']);

            } else {
                return response()->json(['status'=>'failed','data'=>'project not exist']);
            }

        }

    }

    public function references(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'refrences' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {
            $projectid = $request->input('projectid');
            $refrences = $request->input('refrences');
            $images = $request->file('images');

            $project = Project::find($projectid);

            if($project){

                $extenstion = $images->getClientOriginalExtension();
                $filename = rand(11111 , 99999) . '.' .$extenstion;
                $destinationPath = 'images';

                $images->move($destinationPath, $filename);

                
                $project->refrences = $refrences;
                $project->imagesref = $filename;
                
                $project->save();

                return response()->json(['status'=>'success','value'=>'success add reference and images']);

            } else {
                return response()->json(['status'=>'failed','value'=>'sorry project not exist']);
            }
        }

    }

    public function singleline(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'singleline' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $singleline = $request->input('singleline');

            $project = Project::find($projectid);
            if($project){

                $project->singline = $singleline;
                $project->save();

                return response()->json(['status'=>'success','value'=>'success add timeline']);
            } else {
                return response()->json(['status'=>'failed','value'=>'project not exist']);
            }

        }

    }

}
