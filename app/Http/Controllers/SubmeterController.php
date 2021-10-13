<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SubmetersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Submeter;

class SubmeterController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'submeter engine']);
    }

    public function store(Request $request){

        $projectid = $request->input('projectid');
        $excelfile = $request->file('excelfile');
        $randnumber = rand(11111, 99999) . '-' . $projectid;

        Excel::import(new SubmetersImport($projectid,$randnumber), $excelfile);
        
        $submeterupdate = Submeter::where('randnumber',$randnumber)->first();

        $extension = $excelfile->getClientOriginalExtension();
        $att_name = $excelfile->getClientOriginalName();
        $filename = rand(11111, 99999) . '.' .$extension;
        $destinationPath = 'subtwo';
        
        $excelfile->move($destinationPath,$filename);

        $submeterupdate->filename = $filename;
        $submeterupdate->attachement_filename = $att_name;

        $submeterupdate->save();
        return response()->json(['status'=>'success','value'=>'success upload and import to database']);

    }

    public function list(Request $request){

        //$env = 'http://codeviable.com/engine-audit/public/subtwo/';
        //$env = 'http://206.189.87.64:9292/subtwo/';
        $env = 'http://3.1.83.125:9292/subtwo/';

        $projectid = $request->input('projectid');
        $finalarray = Array();

        if($projectid == null){
            $all = Submeter::all();
        } else {
            $all = Submeter::where('projectid',$projectid)->get();
        }

        foreach($all as $data){
            $excelfile = $env . ''. $data->filename;

            $tempfile = [
                'id' => $data->id,
                'excelfile' => $excelfile,
                'excelname' => $data->attachement_filename,
            ];

            array_push($finalarray,$tempfile);
        }

        return response()->json(['status'=>'success','value'=>$finalarray]);

    }

    public function delete(Request $request){

        $submeter_id = $request->input('submeter_id');

        $submeter = Submeter::find($submeter_id);

        if($submeter){
           
            $route = public_path().'/subtwo/'.$submeter->filename;
  
            if(file_exists($route)){
                $dd = unlink($route);
            } 
            $submeter->delete();

            return response()->json(['status'=>'success','value'=>'success delete submeter']);
        } else {
            return response()->json(['status'=>'failed','value'=>'sorry sub meter id not exist']);
        }

    }
}


