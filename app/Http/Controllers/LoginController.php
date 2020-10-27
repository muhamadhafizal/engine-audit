<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'login engine']);
    }

    public function main(Request $request){

        $tempuser = array();

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

                $roledetails = Role::where('id',$user->role)->first();
                $rolename = $roledetails->name; 
                
                if($user->role == 2){
                    $name = $user->name;

                    $tempuser = [
                        'id' => $user->id,
                        'name' => $name,
                        'contact' => $user->contact,
                        'email' => $user->email,
                        'role' => $rolename,
                        'username' => $user->username,
                        'address' => $user->address,
                        'postalcode' => $user->postalcode,
                        'location' => $user->location,
                        'area' => $user->area,
    
                    ];
                } else if($user->role == 3){
                    $name = $user->name .' '.$user->lastname;

                    $companydetails = User::where('id',$user->companyid)->first();
                    $companyname = $companydetails->name;

                    $tempuser = [
                        'id' => $user->id,
                        'name' => $name,
                        'contact' => $user->contact,
                        'email' => $user->email,
                        'role' => $rolename,
                        'username' => $user->username,
                        'status' => $user->status,
                        'companyname' => $companyname,
    
                    ];
                }

                

                // $token = $user->createToken('MyApp')-> accessToken;
                return response()->json(['status'=>'success', 'api_key'=>'abcd', 'value'=>$tempuser]);
            } else {
                return response()->json(['status'=>'failed']);
            }

        }

    }

    public function unauthorized(){
        return response()->json(['error'=>'Unauthorised'], 401); 
    }
}

