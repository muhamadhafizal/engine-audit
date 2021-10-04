<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mainincoming;
use App\Generate;

class MainincomingController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'engine mainincoming']);
    }

    public function store(Request $request){

        $projectid = $request->input('projectid');
        $nameid = $request->input('nameid');
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
        $incomingupdate->name = $nameid;

        $incomingupdate->save();
        return response()->json(['status'=>'success','value'=>'success upload and import to database']);

    }

    public function all(Request $request){
        // $env = 'http://codeviable.com/engine-audit/public/subone/';
        //$env = 'http://206.189.87.64:9292/subone/';
        $env = 'http://3.1.83.125:9292/subone/';

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

    public function update(Request $request){

        $mainincomingid = $request->input('mainincomingid');
        $peak = $request->input('peak');
        $name = $request->input('nameid');

        $details = Mainincoming::find($mainincomingid);

        if($details){

            if($peak == null){
                $peak = $details->peak;
            }
            if($name == null){
                $name = $details->name;
            }

            $details->name = $name;
            $details->peak = $peak;

            $details->save();

            return response()->json(['status'=>'success','value'=>'success update mainincoming']);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry mainincoming not exist']);
        }
    }

    public function listmainincoming(Request $request){

        $finalarray = array();
        $projectid = $request->input('projectid');

        $list = Mainincoming::where('projectid',$projectid)->get();

        foreach($list as $data){

           if($data->name != 'main'){
               $generatesdetails = Generate::find($data->name);
               if($generatesdetails){
                    $name = $generatesdetails->name;
               } else {
                   $name = $data->name;
               }
              
           } else {
               $name = $data->name;
           }

            $temparray = [
                'id' => $data->id,
                'name' => $name,
                'peak' => $data->peak,
            ];
            array_push($finalarray,$temparray);
        }

        return response()->json(['status'=>'success','value'=>$finalarray]);

    }

    public function details(Request $request){

        $xarray = array();
        $yarray = array();

        $mainincomingid = $request->input('mainincomingid');
        $details = Mainincoming::find($mainincomingid);

        if($details){

            //generatesname
            if($details->name != 'main'){
                $generatesdetails = Generate::find($details->name);
                if($generatesdetails){
                     $name = $generatesdetails->name;
                } else {
                    $name = $details->name;
                }
               
            } else {
                $name = $details->name;
            }

            $a = json_decode($details->value);
            foreach($a as $data){
                array_push($xarray,$data->date);
                array_push($yarray,$data->power);
            }
            
            $temparray = [
                'id' => $details->id,
                'name' => $name,
                'peak' => $details->peak,
                'x-axis' => $xarray,
                'y-axis' => $yarray,
            ];

            return response()->json(['status'=>'success','value'=>$temparray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry mainincoming not exist']);
        }
    }


    public function submeter(Request $request){

        $projectid = $request->input('projectid');
        $finalarray = array();

        $list = Mainincoming::where('projectid',$projectid)
                              ->where(function($query){
                              $query->where('name',null)
                                ->orWhere('name','!=','main');
                              })
                              ->get();


        $main = Mainincoming::where('projectid',$projectid)->where('name','main')->first();

        if($main){

            $totalsub = 0;
            $otherspeak = 0;
            $otherspercent = 0;
            $totalpercent = 0;

            $mainarray = [
                'id' => $main->name,
                'peak' => $main->peak,
                'percent' => 100,
            ];

            array_push($finalarray,$mainarray);

            foreach($list as $data){

               

                //generatesname
            if($data->name != 'main'){
                $generatesdetails = Generate::find($data->name);
                if($generatesdetails){
                     $name = $generatesdetails->name;
                } else {
                    $name = $data->name;
                }
               
            } else {
                $name = $data->name;
            }

                $temparray =[
                    'name' => $name,
                    'peak' => $data->peak,
                    'percent' => round(($data->peak/$main->peak)*100),
                ];

                array_push($finalarray,$temparray);

                $totalsub = $totalsub + $data->peak;

                $totalpercent = $totalpercent + round(($data->peak/$main->peak)*100);
            }


            

           
            $otherspeak = $main->peak - $totalsub;
            $otherspercent = round(($otherspeak/$main->peak)*100); 

            $totalpercent = $totalpercent + $otherspercent;

            $balance = 100 - $totalpercent;

            if($balance != 0){
                $otherspercent = $otherspercent + $balance;
            }
            

            $othersarray = [
                'name' => 'others',
                'peak' => $otherspeak,
                'percent' => $otherspercent,
            ];
            
            array_push($finalarray,$othersarray);

            return response()->json(['status'=>'success','value'=>$finalarray]);

        } else {
            return response()->json(['status'=>'failed','value'=>'sorry mainincoming not exist']);
        }

        

    }
}
