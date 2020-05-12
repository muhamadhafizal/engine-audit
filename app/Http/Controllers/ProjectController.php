<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'product engine']);
    }
}
