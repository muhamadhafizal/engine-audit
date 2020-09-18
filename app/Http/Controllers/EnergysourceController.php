<?php

namespace App\Http\Controllers;
use App\Energysource;

use Illuminate\Http\Request;

class EnergysourceController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','engine'=>'Energy source engine']);
    }

    public function all(){

        $data = Energysource::all();

        return response()->json(['status'=>'success','value'=>$data]);

    }

    public function details(Request $request){

        $id = $request->input('id');

        $data = Energysource::find($id);

        return response()->json(['status'=>'success','value'=>$data]);

    }
}
