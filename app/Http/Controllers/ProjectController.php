<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Team;
use App\Information;
use App\Building;
use App\Operation;
use App\Review;
use App\Sumplyinformation;
use App\Sumplytariffstructure;
use App\Reference;
use App\Room;
use App\Singleline;
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
                ->select('projects.id as id','projects.title as title','users.name as companyname','projects.updated_at as update')
                ->where('projects.companyid','=',$companyid)
                ->orderBy('projects.created_at','DESC')
                ->get();

        if($data){
                foreach($data as $dat){
                    $tempArray = [
                        'id' => $dat->id,
                        'projectname' => $dat->title,
                        'lastupdate' => $dat->update,
                        'status' => 'in progress',
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
                    // 'setupteam' => $a,
                    // 'projectinformation' => $data->projectinformation,
                    // 'created_at' => $data->created_at,
                    // 'updated_at' => $data->updated_at,
                    // 'company_id' => $data->companyid,
                    // 'company_name' => $company->name,
                    // 'objective' => $data->objective,
                    // 'scope' => $data->scope,
                    // 'methodology' => $data->methodology,
                    // 'measurementtools' => $data->measurementtools,
                    // 'buildinggeneralinformation' => $b,
                    // 'buildingoperaioninformation' => $c,
                    // 'energymanagementreview' => $finalArray,
                    // 'energygeneralinformation' => $f,
                    // 'energytariffstructure' => $g,
                    // 'lightingregistry' => $j,
                    // 'references' => $k,
                    // 'imagesref' => $dirfile,

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

            $existinginfo = Information::where('projectid',$projectid)->first();

            if($existinginfo){

                if($objective == null){
                    $objective = $existinginfo->objective;
                }
                if($scope == null){
                    $scope = $existinginfo->scope;
                }
                if($methodology == null){
                    $methodology = $existinginfo->methodology;
                }
                if($measurementtools == null){
                    $measurementtools = $existinginfo->measurementtools;
                }

                $existinginfo->objective = $objective;
                $existinginfo->scope = $scope;
                $existinginfo->methodology = $methodology;
                $existinginfo->measurementtools = $measurementtools;

                $existinginfo->save();

                return response()->json(['status'=>'success','value'=>'success update project information']);

            } else {

                $information = new Information;
                $information->projectid = $projectid;
                $information->objective = $objective;
                $information->scope = $scope;
                $information->methodology = $methodology;
                $information->measurementtools = $measurementtools;

                $information->save();

                return response()->json(['status'=>'success','value'=>'success add project information']);

            }
            
        }

    }

    public function viewinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {
            
            $projectid = $request->input('projectid');

            $information = Information::where('projectid',$projectid)->first();

            if($information){
                return response()->json(['status'=>'success','value'=>$information]);
            } else {
                return response()->json(['status'=>'failed', 'value'=>'project information is not exist']);
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
            'companyname' => 'required',
            'companyaddress' => 'required',
            'companyfaxnum' => 'required',
            'companyemail' => 'required',
            'designation' => 'required',
            'picname' => 'required',
            'picphone' => 'required',
            'picfaxnum' => 'required',
            'picemail' => 'required',
            'electricalenergymanage' => 'required',
            'noofstaff' => 'required',
            'electricaltariffcategory' => 'required',
            'buildingage' => 'required',
            'buildingfunction' => 'required',
            'noofblock' => 'required',
            'grossfloorarea' => 'required',
            'percentofgross' => 'required',
            'serverarea' => 'required',
            'parkingarea' => 'required',
            'designedoccupant' => 'required',
            'actualoccupant' => 'required', 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $companyname = $request->input('companyname');
            $companyaddress = $request->input('companyaddress');
            $companyfaxnum = $request->input('companyfaxnum');
            $companyemail = $request->input('companyemail');
            $designation = $request->input('designation');
            $picname = $request->input('picname');
            $picphone = $request->input('picphone');
            $picfaxnum = $request->input('picfaxnum');
            $picemail = $request->input('picemail');
            $electricalenergymanage = $request->input('electricalenergymanage');
            $noofstaff = $request->input('noofstaff');
            $electricaltariffcategory = $request->input('electricaltariffcategory');
            $buildingage = $request->input('buildingage');
            $buildingfunction = $request->input('buildingfunction');
            $noofblock = $request->input('noofblock');
            $grossfloorarea = $request->input('grossfloorarea');
            $percentofgross = $request->input('percentofgross');
            $serverarea = $request->input('serverarea');
            $designedoccupant = $request->input('designedoccupant');
            $actualoccupant = $request->input('actualoccupant');

            $informationexist = Building::where('projectid',$projectid)->first();

            if($informationexist == null){
                //add

                $information = new Building;
                $information->projectid = $projectid;
                $information->companyname = $companyname;
                $information->companyaddress = $companyaddress;
                $information->companyfaxnum = $companyfaxnum;
                $information->companyemail = $companyemail;
                $information->designation = $designation;
                $information->picname = $picname;
                $information->picphone = $picphone;
                $information->picfaxnum = $picfaxnum;
                $information->picemail = $picemail;
                $information->electricalenergymanage = $electricalenergymanage;
                $information->noofstaff = $noofstaff;
                $information->electricaltariffcategory = $electricaltariffcategory;
                $information->buildingage = $buildingage;
                $information->buildingfunction = $buildingfunction;
                $information->noofblock = $noofblock;
                $information->grossfloorarea = $grossfloorarea;
                $information->percentofgross = $percentofgross;
                $information->serverarea = $serverarea;
                $information->designedoccupant = $designedoccupant;
                $information->actualoccupant = $actualoccupant;

                $information->save();

                return response()->json(['status'=>'success','value'=>'success record building general information']);

            } else {
                //update
                if($companyname == null){
                    $companyname = $informationexist->companyname; 
                }
                if($companyaddress == null){
                    $companyaddress = $informationexist->companyaddress;
                }
                if($companyfaxnum == null){
                    $companyfaxnum = $informationexist->companyfaxnum;
                }
                if($companyemail == null){
                    $companyemail = $informationexist->companyemail;
                }
                if($designation == null){
                    $designation = $informationexist->designation;
                }
                if($picname == null){
                    $picname = $informationexist->picname;
                }
                if($picphone == null){
                    $picphone = $informationexist->picphone;
                }
                if($picfaxnum == null){
                    $picfaxnum = $informationexist->picfaxnum;
                }
                if($picemail == null){
                    $picemail = $informationexist->picemail;
                }
                if($electricalenergymanage == null){
                    $electricalenergymanage = $informationexist->electricalenergymaange;
                }
                if($noofstaff == null){
                    $noofstaff = $informationexist->noofstaff;
                }
                if($electricaltariffcategory == null){
                    $electricaltariffcategory = $informationexist->electricaltariffcategory;
                }
                if($buildingage == null){
                    $buildingage = $informationexist->buildingage;
                }
                if($buildingfunction == null){
                    $buildingfunction = $informationexist->buildingfunction;
                }
                if($noofblock == null){
                    $noofblock = $informationexist->noofblock;
                }
                if($grossfloorarea == null){
                    $grossfloorarea = $informationexist->grossfloorarea;
                }
                if($percentofgross == null){
                    $percentofgross = $informationexist->percentofgross;
                }
                if($serverarea == null){
                    $serverarea = $informationexist->serverarea;
                }
                if($designedoccupant == null){
                    $designedoccupant = $informationexist->designedoccupant;
                }
                if($actualoccupant == null){
                    $actualoccupant = $informationexist->actualoccupant;
                }

                $informationexist->companyname = $companyname;
                $informationexist->companyaddress = $companyaddress;
                $informationexist->companyfaxnum = $companyfaxnum;
                $informationexist->companyemail = $companyemail;
                $informationexist->designation = $designation;
                $informationexist->picname = $picname;
                $informationexist->picphone = $picphone;
                $informationexist->picfaxnum = $picfaxnum;
                $informationexist->picemail = $picemail;
                $informationexist->electricalenergymanage = $electricalenergymanage;
                $informationexist->noofstaff = $noofstaff;
                $informationexist->electricaltariffcategory = $electricaltariffcategory;
                $informationexist->buildingage = $buildingage;
                $informationexist->buildingfunction = $buildingfunction;
                $informationexist->noofblock = $noofblock;
                $informationexist->grossfloorarea = $grossfloorarea;
                $informationexist->percentofgross = $percentofgross;
                $informationexist->serverarea = $serverarea;
                $informationexist->designedoccupant = $designedoccupant;
                $informationexist->actualoccupant = $actualoccupant;
                
                $informationexist->save();


                return response()->json(['status'=>'success','value'=>'success update building general information']);
            }

        }

    }

    public function viewgeneralinformation(Request $request){

        $projectid = $request->input('projectid');
        
        $building = Building::where('projectid',$projectid)->first();

        if($building){
            return response()->json(['status'=>'success','value'=>$building]);
        } else {
            return response()->json(['status'=>'failed','value'=>'building general information is not exist']);
        }

    }



    public function operationinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'operationhours' => 'required',
            'averageoperations' => 'required',
            'operationMon' => 'required',
            'startMon' => 'required',
            'endMon' => 'required',
            'timeMon' => 'required',
            'operationTues' => 'required',
            'startTues' => 'required',
            'endTues' => 'required',
            'timeTues' => 'required',
            'operationWed' => 'required',
            'startWed' => 'required',
            'endWed' => 'required',
            'timeWed' => 'required',
            'operationThurs' => 'required',
            'startThurs' => 'required',
            'endThurs' => 'required',
            'timeThurs' => 'required',
            'operationFri' => 'required',
            'startFri' => 'required',
            'endFri' => 'required',
            'timeFri' => 'required',
            'operationSat' => 'required',
            'startSat' => 'required',
            'endSat' => 'required',
            'timeSat' => 'required',
            'operationSun' => 'required',
            'startSun' => 'required',
            'endSun' => 'required',
            'timeSun' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $operationhours = $request->input('operationhours');
            $averageoperations = $request->input('averageoperations');
            $operationMon = $request->input('operationMon');
            $startMon = $request->input('startMon');
            $endMon = $request->input('endMon');
            $timeMon = $request->input('timeMon');
            $operationTues = $request->input('operationTues');
            $startTues = $request->input('startTues');
            $endTues = $request->input('endTues');
            $timeTues = $request->input('timeTues');
            $operationWed = $request->input('operationWed');
            $startWed = $request->input('startWed');
            $endWed = $request->input('endWed');
            $timeWed = $request->input('timeWed');
            $operationThurs = $request->input('operationThurs');
            $startThurs = $request->input('startThurs');
            $endThurs = $request->input('endThurs');
            $timeThurs = $request->input('timeThurs');
            $operationFri = $request->input('operationFri');
            $startFri = $request->input('startFri');
            $endFri = $request->input('endFri');
            $timeFri = $request->input('timeFri');
            $operationSat = $request->input('operationSat');
            $startSat = $request->input('startSat');
            $endSat = $request->input('endSat');
            $timeSat = $request->input('timeSat');
            $operationSun = $request->input('operationSun');
            $startSun = $request->input('startSun');
            $endSun = $request->input('endSun');
            $timeSun = $request->input('timeSun');

            $operation = Operation::where('projectid',$projectid)->first();

            if($operation){

                if($operation->operationhours == null){
                    $operationhours = $operation->operationhours;
                }

                if($operation->averageoperations == null){
                    $averageoperations = $operation->averageoperations;
                }

                if($operation->operationMon == null){
                    $operationMon = $operation->operationMon;
                }

                if($operation->startMon == null){
                    $startMon = $operation->startMon;
                }

                if($operation->endMon == null){
                    $endMon = $operation->endMon;
                }

                if($operation->timeMon == null){
                    $timeMon = $operation->timeMon;
                }

                if($operation->operationTues == null){
                    $operationTues = $operation->operationTues;
                }

                if($operation->startTues == null){
                    $startTues = $operation->startTues;
                }

                if($operation->endTues == null){
                    $endTues = $operation->endTues;
                }

                if($operation->timeTues == null){
                    $timeTues = $operation->timeTues;
                }

                if($operation->operationWed == null){
                    $operationWed = $operation->operationWed;
                }

                if($operation->startWed == null){
                    $startWed = $operation->startWed;
                }

                if($operation->endWed == null){
                    $endWed = $operation->endWed;
                }

                if($operation->timeWed == null){
                    $timeWed = $operation->timeWed;
                }

                if($operation->operationThurs == null){
                    $operationThurs = $operation->operationThurs;
                }

                if($operation->startThurs == null){
                    $startThurs = $operation->startThurs;
                }

                if($operation->endThurs == null){
                    $endThurs = $operation->endThurs;
                }

                if($operation->timeThurs == null){
                    $timeThurs = $operation->timeThurs;
                }

                if($operation->operationFri == null){
                    $operationFri = $operation->operationFri;
                }

                if($operation->startFri == null){
                    $startFri = $operation->startFri;
                }

                if($operation->endFri == null){
                    $endFri = $operation->endFri;
                }

                if($operation->timeFri == null){
                    $timeFri = $operation->timeFri;
                }

                if($operation->operationSat == null){
                    $operationSat = $operation->operationSat;
                }

                if($operation->startSat == null){
                    $startSat = $operation->startSat;
                }

                if($operation->endSat == null){
                    $endSat = $operation->endSat;
                }

                if($operation->timeSat == null){
                    $timeSat = $operation->timeSat;
                }

                if($operation->operationSun == null){
                    $operationSun = $operation->operationSun;
                }

                if($operation->startSun == null){
                    $startSun = $operation->startSun;
                }

                if($operation->endSun == null){
                    $endSun = $operation->endSun;
                }

                if($operation->timeSun == null){
                    $timeSun = $operation->timeSun;
                }

                $operation->operationhours = $operationhours;
                $operation->averageoperations = $averageoperations;
                $operation->operationMon = $operationMon;
                $operation->startMon = $startMon;
                $operation->endMon = $endMon;
                $operation->timeMon = $timeMon;
                $operation->operationTues = $operationTues;
                $operation->startTues = $startTues;
                $operation->endTues = $endTues;
                $operation->timeTues = $timeTues;
                $operation->operationWed = $operationWed;
                $operation->startWed = $startWed;
                $operation->endWed = $endWed;
                $operation->timeWed = $timeWed;
                $operation->operationThurs = $operationThurs;
                $operation->startThurs = $startThurs;
                $operation->endThurs = $endThurs;
                $operation->timeThurs = $timeThurs;
                $operation->operationFri = $operationFri;
                $operation->startFri = $startFri;
                $operation->endFri = $endFri;
                $operation->timeFri = $timeFri;
                $operation->operationSat = $operationSat;
                $operation->startSat = $startSat;
                $operation->endSat = $endSat;
                $operation->timeSat = $timeSat;
                $operation->operationSun = $operationSun;
                $operation->startSun = $startSun;
                $operation->endSun = $endSun;
                $operation->timeSun = $timeSun;

                $operation->save();

                return response()->json(['status'=>'success','value'=>'operation success update']);
            } else {

                $operation = new Operation;
                $operation->projectid = $projectid;
                $operation->operationhours = $operationhours;
                $operation->averageoperations = $averageoperations;
                $operation->operationMon = $operationMon;
                $operation->startMon = $startMon;
                $operation->endMon = $endMon;
                $operation->timeMon = $timeMon;
                $operation->operationTues = $operationTues;
                $operation->startTues = $startTues;
                $operation->endTues = $endTues;
                $operation->timeTues = $timeTues;
                $operation->operationWed = $operationWed;
                $operation->startWed = $startWed;
                $operation->endWed = $endWed;
                $operation->timeWed = $timeWed;
                $operation->operationThurs = $operationThurs;
                $operation->startThurs = $startThurs;
                $operation->endThurs = $endThurs;
                $operation->timeThurs = $timeThurs;
                $operation->operationFri = $operationFri;
                $operation->startFri = $startFri;
                $operation->endFri = $endFri;
                $operation->timeFri = $timeFri;
                $operation->operationSat = $operationSat;
                $operation->startSat = $startSat;
                $operation->endSat = $endSat;
                $operation->timeSat = $timeSat;
                $operation->operationSun = $operationSun;
                $operation->startSun = $startSun;
                $operation->endSun = $endSun;
                $operation->timeSun = $timeSun;

                $operation->save();
                

                return response()->json(['status'=>'success','value'=>'operation success save']);

            }
           
        }
    }

    public function viewoperationinformation(Request $request){

        $projectid = $request->input('projectid');

        $operationdetails = Operation::where('projectid',$projectid)->first();

        if($operationdetails){

            return response()->json(['status'=>'success','value'=>$operationdetails]);

        } else {
            return response()->json(['status'=>'failed','value'=>'operation not exist']);   
        }

    }

    public function managementreview(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $category = $request->input('category');
            $acceptpotentialScore = $request->input('acceptpotentialScore');
            $acceptpotentialRemarks = $request->input('acceptpotentialRemarks');
            $managementCommScore = $request->input('managementCommScore');
            $managementCommRemarks = $request->input('managementCommRemarks');
            $rolesScore = $request->input('rolesScore');
            $rolesRemarks = $request->input('rolesRemarks');
            $seusScore = $request->input('seusScore');
            $seusRemarks = $request->input('seusRemarks');
            $baselineScore = $request->input('baselineScore');
            $baselineRemarks = $request->input('baselineRemarks');
            $enpiScore = $request->input('enpiScore');
            $enpiRemarks = $request->input('enpiRemarks');
            $objectiveScore = $request->input('objectiveScore');
            $objectiveRemarks = $request->input('objectiveRemarks');
            $actionScore = $request->input('actionScore');
            $actionRemarks = $request->input('actionRemarks');
            $internalScore = $request->input('internalScore');
            $internalRemarks = $request->input('internalRemarks');
            $energyScore = $request->input('energyScore');
            $energyRemarks = $request->input('energyRemarks');
            $organizationScore = $request->input('organizationScore');
            $organizationRemarks = $request->input('organizationRemarks');
            $motivationScore = $request->input('motivationScore');
            $motivationRemarks = $request->input('motivationRemarks');
            $informationScore = $request->input('informationScore');
            $informationRemarks = $request->input('informationRemarks');
            $marketingScore = $request->input('marketingScore');
            $marketingRemarks = $request->input('marketingRemarks');
            $investmentScore = $request->input('investmentScore');
            $investmentRemarks = $request->input('investmentRemarks');

            $review = Review::where('projectid',$projectid)->first();

            if($review){

                if($category == null){
                    $category = $review->category;
                }

                if($acceptpotentialScore == null){
                    $acceptpotentialScore = $review->acceptpotentialScore;
                }

                if($acceptpotentialRemarks == null){
                    $acceptpotentialRemarks = $review->acceptpotentialRemarks;
                }

                if($managementCommScore == null){
                    $managementCommScore = $review->managementCommScore;
                }

                if($managementCommRemarks == null){
                    $managementCommRemarks = $review->managementCommRemarks;
                }

                if($rolesScore == null){
                    $rolesScore = $review->roleseScore;
                }

                if($rolesRemarks == null){
                    $rolesRemarks = $review->rolesRemarks;
                }

                if($seusScore == null){
                    $seusScore = $review->seusScore;
                }

                if($seusRemarks == null){
                    $seusRemarks = $review->seusRemarks;
                }

                if($baselineScore == null){
                    $baselineScore = $review->baselineScore;
                }

                if($baselineRemarks == null){
                    $baselineRemarks = $review->baselineRemarks;
                }

                if($enpiScore == null){
                    $enpiScore = $review->enpiScore;
                }

                if($enpiRemarks == null){
                    $enpiRemarks = $review->enpiRemarks;
                }

                if($objectiveScore == null){
                    $objectiveScore = $review->objectiveScore;
                }

                if($objectiveRemarks == null){
                    $objectiveRemarks = $review->objectiveRemarks;
                }

                if($actionScore == null){
                    $actionStore = $review->actionStore;
                }

                if($actionRemarks == null){
                    $actionRemarks = $review->actionRemarks;
                }

                if($internalScore == null){
                    $internalScore = $review->internalScore;
                }

                if($internalRemarks == null){
                    $internalRemarks = $review->internalRemarks;
                }

                if($energyScore == null){
                    $energyScore = $review->energyScore;
                }

                if($energyRemarks == null){
                    $energyRemarks = $review->energyRemarks;
                }

                if($organizationScore == null){
                    $organizationScore = $review->organizationScore;
                }

                if($organizationRemarks == null){
                    $organizationRemarks = $review->organizationRemarks;
                }

                if($motivationScore == null){
                    $motivationScore = $review->motivationScore;
                }

                if($motivationRemarks == null){
                    $motivationRemarks = $review->motivationRemarks;
                }

                if($informationScore == null){
                    $informationScore = $review->informationScore;
                }

                if($informationRemarks == null){
                    $informationRemarks = $review->informationRemarks;
                }

                if($marketingScore == null){
                    $marketingScore = $review->marketingScore;
                }

                if($marketingRemarks == null){
                    $marketingRemarks = $review->marketingRemarks;
                }

                if($investmentScore == null){
                    $investmentScore = $review->investmentScore;
                }

                if($investmentRemarks == null){
                    $investmentRemarks = $review->investmentRemarks;
                }


                $review->category  = $category;
                $review->acceptpotentialScore = $acceptpotentialScore;
                $review->acceptpotentialRemarks = $acceptpotentialRemarks;
                $review->managementCommScore = $managementCommScore;
                $review->managementCommRemarks = $managementCommRemarks;
                $review->rolesScore = $rolesScore;
                $review->rolesRemarks = $rolesRemarks;
                $review->seusScore = $seusScore;
                $review->seusRemarks = $seusRemarks;
                $review->baselineScore = $baselineScore;
                $review->baselineRemarks = $baselineRemarks;
                $review->enpiScore = $enpiScore;
                $review->enpiRemarks = $enpiRemarks;
                $review->objectiveScore = $objectiveScore;
                $review->objectiveRemarks = $objectiveRemarks;
                $review->actionScore = $actionScore;
                $review->actionRemarks = $actionRemarks;
                $review->internalScore = $internalScore;
                $review->internalRemarks = $internalRemarks;
                $review->energyScore = $energyScore;
                $review->energyRemarks = $energyRemarks;
                $review->organizationScore = $organizationScore;
                $review->organizationRemarks = $organizationRemarks;
                $review->motivationScore = $motivationScore;
                $review->motivationRemarks = $motivationRemarks;
                $review->informationScore = $informationScore;
                $review->informationRemarks = $informationRemarks;
                $review->marketingScore = $marketingScore;
                $review->marketingRemarks = $marketingRemarks;
                $review->investmentScore = $investmentScore;
                $review->investmentRemarks = $investmentRemarks;
                
                $review->save();
                return response()->json(['status'=>'success','value'=>'success update review']);

            } else {

                $review = new Review;
                $review->projectid = $projectid;
                $review->category  = $category;
                $review->acceptpotentialScore = $acceptpotentialScore;
                $review->acceptpotentialRemarks = $acceptpotentialRemarks;
                $review->managementCommScore = $managementCommScore;
                $review->managementCommRemarks = $managementCommRemarks;
                $review->rolesScore = $rolesScore;
                $review->rolesRemarks = $rolesRemarks;
                $review->seusScore = $seusScore;
                $review->seusRemarks = $seusRemarks;
                $review->baselineScore = $baselineScore;
                $review->baselineRemarks = $baselineRemarks;
                $review->enpiScore = $enpiScore;
                $review->enpiRemarks = $enpiRemarks;
                $review->objectiveScore = $objectiveScore;
                $review->objectiveRemarks = $objectiveRemarks;
                $review->actionScore = $actionScore;
                $review->actionRemarks = $actionRemarks;
                $review->internalScore = $internalScore;
                $review->internalRemarks = $internalRemarks;
                $review->energyScore = $energyScore;
                $review->energyRemarks = $energyRemarks;
                $review->organizationScore = $organizationScore;
                $review->organizationRemarks = $organizationRemarks;
                $review->motivationScore = $motivationScore;
                $review->motivationRemarks = $motivationRemarks;
                $review->informationScore = $informationScore;
                $review->informationRemarks = $informationRemarks;
                $review->marketingScore = $marketingScore;
                $review->marketingRemarks = $marketingRemarks;
                $review->investmentScore = $investmentScore;
                $review->investmentRemarks = $investmentRemarks;
                
                $review->save();


                return response()->json(['status'=>'success','value'=>'success add review']);
            }

        }

    }

    public function viewmanamgentreview(Request $request){

        $projectid = $request->input('projectid');

        $reviewDetails = Review::where('projectid',$projectid)->first();

        if($reviewDetails){

            if($reviewDetails->category == 'ISO'){

                $tempArray = [
                    'id' => $reviewDetails->id,
                    'category' => $reviewDetails->category,
                    'acceptpotentialScore' => $reviewDetails->acceptpotentialScore,
                    'acceptpotentialRemarks' => $reviewDetails->acceptpotentialRemarks,
                    'managementCommScore' => $reviewDetails->managementCommScore,
                    'managementCommRemarks' => $reviewDetails->managementCommRemarks,
                    'rolesScore' => $reviewDetails->rolesScore,
                    'rolesRemarks' => $reviewDetails->rolesRemarks,
                    'seusScore' => $reviewDetails->seusScore,
                    'seusRemarks' => $reviewDetails->seusRemarks,
                    'baselineScore' => $reviewDetails->baselineScore,
                    'baselineRemarks' => $reviewDetails->baselineRemarks,
                    'enpiScore' => $reviewDetails->enpiScore,
                    'enpiRemarks' => $reviewDetails->enpiRemarks,
                    'objectiveScore' => $reviewDetails->objectiveScore,
                    'objectiveRemarks' => $reviewDetails->objectiveRemarks,
                    'actionScore' => $reviewDetails->actionScore,
                    'actionRemarks' => $reviewDetails->actionRemarks,
                    'internalScore' => $reviewDetails->internalScore,
                    'internalRemarks' => $reviewDetails->internalRemarks,
                ];

            } else {

                $tempArray = [

                    'id' => $reviewDetails->id,
                    'category' => $reviewDetails->category,
                    'energyScore' => $reviewDetails->energyScore,
                    'energyRemarks' => $reviewDetails->energyRemarks,
                    'organizationScore' => $reviewDetails->organizationScore,
                    'organizationRemarks' => $reviewDetails->organizationRemarks,
                    'motivationScore' => $reviewDetails->motivationScore,
                    'motivationRemarks' => $reviewDetails->motivationRemarks,
                    'informationScore' => $reviewDetails->informationScore,
                    'informationRemarks' => $reviewDetails->informationRemarks,
                    'marketingScore' => $reviewDetails->marketingScore,
                    'marketingRemarks' => $reviewDetails->marketingRemarks,
                    'investmentScore' => $reviewDetails->investmentScore,
                    'investmentRemarks' => $reviewDetails->investmentRemarks,

                ];

            }

            return response()->json(['status'=>'success','value'=>$tempArray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'review not exist']);
        }

    }

    public function energygeneralinformation(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'energysourceone' => 'required',
            'energysourcetwo' => 'required',
            'energysourcethree' => 'required',
            'energycategoryone' => 'required',
            'energycategorytwo' => 'required',
            'energycategorythree' => 'required',
            'providercompanyone' => 'required',
            'providercompanytwo' => 'required',
            'providercompanythree' => 'required',
            'applicabletariffone' => 'required',
            'applicabletarifftwo' => 'required',
            'applicabletariffthree' => 'required',
            'tariffvalidityone' => 'required',
            'tariffvaliditytwo' => 'required',
            'tariffvaliditythree' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {


          $sumplyinformations = new Sumplyinformation;
          $sumplyinformations->projectid = $request->input('projectid');
          $sumplyinformations->energysourceone = $request->input('energysourceone');
          $sumplyinformations->energysourcetwo = $request->input('energysourcetwo');
          $sumplyinformations->energysourcethree = $request->input('energysourcethree');
          $sumplyinformations->energycategoryone = $request->input('energycategoryone');
          $sumplyinformations->energycategorytwo = $request->input('energycategorytwo');
          $sumplyinformations->energycategorythree = $request->input('energycategorythree');
          $sumplyinformations->providercompanyone = $request->input('providercompanyone');
          $sumplyinformations->providercompanytwo = $request->input('providercompanytwo');
          $sumplyinformations->providercompanythree = $request->input('providercompanythree');
          $sumplyinformations->applicabletariffone = $request->input('applicabletariffone');
          $sumplyinformations->applicabletarifftwo = $request->input('applicabletarifftwo');
          $sumplyinformations->applicabletariffthree = $request->input('applicabletariffthree');
          $sumplyinformations->tariffvalidityone = $request->input('tariffvalidityone');
          $sumplyinformations->tariffvaliditytwo = $request->input('tariffvaliditytwo');
          $sumplyinformations->tariffvaliditythree = $request->input('tariffvaliditythree');

          $sumplyinformations->save();

          return response()->json(['status'=>'success','value'=>'success record general information energy sumply']);

        }

    }

    public function viewenergygeneralinformation(Request $request){

        $projectid = $request->input('projectid');

        $general = Sumplyinformation::where('projectid',$projectid)->first();

        return response()->json(['status'=>'success','value'=>$general]);

    }

    public function energytariffstructure(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'structurepeak' => 'required',
            'structureoffpeak' => 'required',
            'maxdemand' => 'required',
            'mincharge' => 'required',
            'timezonepeak' => 'required',
            'timezoneoffpeak' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

           $sumplytariffstructure = new Sumplytariffstructure;

           $sumplytariffstructure->projectid = $request->input('projectid');
           $sumplytariffstructure->structurepeak = $request->input('structurepeak');
           $sumplytariffstructure->structureoffpeak = $request->input('structureoffpeak');
           $sumplytariffstructure->maxdemand = $request->input('maxdemand');
           $sumplytariffstructure->mincharge = $request->input('mincharge');
           $sumplytariffstructure->timezonepeak = $request->input('timezonepeak');
           $sumplytariffstructure->timezoneoffpeak = $request->input('timezoneoffpeak');

           $sumplytariffstructure->save();

           return response()->json(['status'=>'success','value'=>'success add energy tariff structure']);

        }

    }

    public function viewenergytariffstructure(Request $request){

        $projectid = $request->input('projectid');

        $data = Sumplytariffstructure::where('projectid',$projectid)->first();

        return response()->json(['status'=>'success','value'=>$data]);

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
            'mainincoming' => 'required',
            'mainswitchboard' => 'required',
            'activesystem' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $mainincoming = $request->input('mainincoming');
            $mainswitchboard = $request->input('mainswitchboard');
            $activesystem = $request->input('activesystem');
            $images = $request->file('images');

            $extension = $images->getClientOriginalExtension();
            $filename = rand(11111, 99999) . '.' .$extension;
            $destinationPath = 'images';

            $images->move($destinationPath, $filename);

            $reference = new Reference;
            $reference->projectid = $projectid;
            $reference->mainincoming = $mainincoming;
            $reference->mainswitchboard = $mainswitchboard;
            $reference->activesystem = $activesystem;
            $reference->image = $filename;

            $reference->save();

            return response()->json(['status'=>'success','value'=>'success add reference']);
            
        }

    }

    public function viewreference(Request $request){

        $env = 'http://engine-audit.test/images/';

        $dataarray = array();

        $projectid = $request->input('projectid');
        
        $data = Reference::where('projectid',$projectid)->first();

        $filename = $env . ''. $data->image;

        $dataarray = [
            'id' => $data->id,
            'projectid' => $data->projectid,
            'mainicoming' => $data->mainincoming,
            'mainswitchboard' => $data->mainswitchboard,
            'activesystem' => $data->activesystem,
            'image' => $filename,
        ];

        return response()->json(['status'=>'success','value'=>$dataarray]);

    }

    public function singleline(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $projectid = $request->input('projectid');
            $name = $request->input('name');
            $level = $request->input('level');
            $levelone = $request->input('levelone');
            $leveltwo = $request->input('leveltwo');
            $levelthree = $request->input('levelthree');
            $levelfour = $request->input('levelfour');
            $levelfive = $request->input('levelfive');

            $data = new Singleline;
            $data->projectid = $projectid;
            $data->name = $name;
            $data->level = $level;
            $data->levelone = $levelone;
            $data->leveltwo = $leveltwo;
            $data->levelthree = $levelthree;
            $data->levelfour = $levelfour;
            $data->levelfive = $levelfive;

            $data->save();

            return response()->json(['status'=>'success','value'=>'succss add singleline']);

           
        }

    }

    public function listsingleline(Request $request){

        $level = $request->input('level');
        $projectid = $request->input('projectid');
        $parentid = $request->input('parentid');

        if($parentid == null){

            $list = Singleline::where('projectid',$projectid)->where('level',$level)->get();

        } else {

            if($level == 'two'){
                $list = Singleline::where('projectid',$projectid)->where('levelone',$parentid)->where('level','two')->get();
            } elseif($level == 'three'){
                $list = Singleline::where('projectid',$projectid)->where('leveltwo',$parentid)->where('level','three')->get();
            } elseif($level == 'four'){
                $list = Singleline::where('projectid',$projectid)->where('levelthree',$parentid)->where('level','four')->get();
            } elseif($level == 'five'){
                $list = Singleline::where('projectid',$projectid)->where('levelfour',$parentid)->where('level','five')->get();
            }

        }

        return response()->json(['status'=>'success','value'=>$list]);

    }

   

    public function registerroom(Request $request){

        $validator = validator::make($request->all(),
        [
            'projectid' => 'required',
            'roomarea' => 'required',
            'block' => 'required',
            'level' => 'required',
            'function' => 'required',
            'area' => 'required',
            'quantity' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $room = new Room;
            $room->projectid = $request->input('projectid');
            $room->roomarea = $request->input('roomarea');
            $room->block = $request->input('block');
            $room->level = $request->input('level');
            $room->function = $request->input('function');
            $room->area = $request->input('area');
            $room->quantity = $request->input('quantity');

            $room->save();


            return response()->json(['status'=>'success','value'=>'success add room']);
        }

    }

    public function listroom(Request $request){

        $projectid = $request->input('projectid');

        $data = Room::where('projectid',$projectid)->get();

        return response()->json(['status'=>'success','value'=>$data]);

    }

}
