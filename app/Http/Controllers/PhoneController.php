<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success']);
    }
}
