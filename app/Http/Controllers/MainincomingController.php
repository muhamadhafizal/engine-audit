<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mainincoming;

class MainincomingController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine mainincoming']);
    }

    public function store(Request $request){

        $projectid = $request->input('projectid');
        $excelfile = $request->file('excelfile');
        $randnumber = rand(11111, 99999) . '-' . $projectid;
 
        Excel::import(new ExcelImport($projectid,$randnumber), $excelfile);

        $incomingupdate = Mainincoming::where('randnumber',$randnumber)->first();

        //kita update dekat sini
        $extension = $excelfile->getClientOriginalExtension();
        $filename = rand(11111, 99999) . '.' .$extension;
        $destinationPath = 'subone';
        
        $excelfile->move($destinationPath,$filename);

        $incomingupdate->filename = $filename;

        $incomingupdate->save();
        return response()->json(['status'=>'success','value'=>'success upload and import to database']);

    }

    public function all(Request $request){
        $env = 'http://codeviable.com/engine-audit/public/subone/';
        $projectid = $request->input('projectid');
        $finalarray = array();
     
        if($projectid == null){
            $data = Mainincoming::all();
        } else {
            $data  = Mainincoming::where('projectid',$projectid)->get();
        }

        foreach($data as $value){
            $excelfile = $env . ''. $value->filename;

            $tempfile = [
                'id' => $value->id,
                'excelfile' => $excelfile,
            ];

            array_push($finalarray,$tempfile);
        }
        
        
        return response()->json(['status'=>'success','value'=>$finalarray]);


    }
}
