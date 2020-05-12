<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'role index']);
    }

    public function all(){

        $data = Role::all();
        return response()->json(['status'=>'success','value'=>$data]);

    }
}
