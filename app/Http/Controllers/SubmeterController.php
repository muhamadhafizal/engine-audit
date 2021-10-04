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
        $filename = rand(11111, 99999) . '.' .$extension;
        $destinationPath = 'subtwo';
        
        $excelfile->move($destinationPath,$filename);

        $submeterupdate->filename = $filename;

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
            ];

            array_push($finalarray,$tempfile);
        }

        return response()->json(['status'=>'success','value'=>$finalarray]);

    }
}


