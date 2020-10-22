<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'bus engine']);
    }

    
}