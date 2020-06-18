<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'login engine']);
    }

    public function main(Request $request){

        $validator = validator::make($request->all(),
        [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $username = $request->input('username');
            $password = $request->input('password');
            
            $user = User::where('password',$password)
                ->where(function($a) use ($username){
                    $a->where('username',$username)
                      ->orWhere('email',$username);
                })
                ->first();

            if($user){
                $token = $user->createToken('MyApp')-> accessToken;
                return response()->json(['status'=>'success', 'api_key'=>$token, 'value'=>$user]);
            } else {
                return response()->json(['status'=>'failed']);
            }

        }

    }

    public function unauthorized(){
        return response()->json(['error'=>'Unauthorised'], 401); 
    }
}

