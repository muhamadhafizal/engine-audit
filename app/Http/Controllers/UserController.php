<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'user engine']);
    }

    public function add(Request $request){

        $validator = validator::make($request->all(),
        [

            'name' => 'required',
            'contact' => 'required',
            'email' => 'requred',
            'username' => 'required',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $name = $request->input('name');
            $contact = $request->input('contact');
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $role = $request->input('role');

            if($role == null){
                $role = 'company';
            }

            $userExist = User::where('username',$username)->orWhere('password',$password)->first();
            if($userExist){
                return response()->json(['status'=>'failed', 'value'=>'email or password is exust']);
            } else {

                $user = new User;
                $user->name = $name;
                $user->contact = $contact;
                $user->email = $email;
                $user->username = $username;
                $user->password = $password;
                $user->role = $role;

                $user->save();

                return response()->json(['status'=>'success']);

            }

        }

    }

    public function all(){

        $data = User::all();

        return response()->json(['status'=>'success','value'=>$data]);

    }

    public function profile(Request $request){

        $id = $request->input('id');

        $user = User::find($id);
        if($user){
            return response()->json(['status'=>'success','value'=>$user]);
        } else {
            return response()->json(['status'=>'failed','value'=>'user not exist']);
        }
    }

    public function update(Request $request){

        $id = $request->input('id');
        $name = $request->input('name');
        $contact = $request->input('contact');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role');

        $user = User::find($id);

        if($user){

            if(is_null($name)){
                $name = $user->name;
            }
            if(is_null($contact)){
                $phone = $user->contact;
            }
            if(is_null($email)){
                $email = $user->email;
            }
            if(is_null($username)){
                $username = $user->username;
            }
            if(is_null($password)){
                $password = $user->password;
            }
            if(is_null($role)){
                $role = $user->role;
            }

            $user->name = $name;
            $user->contact = $contact;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->role = $role;

            $user->save();

            return response()->json(['status'=>'success']);
        } else {
            return response()->json(['status'=>'failed','value'=>'user not exist']);
        }

    }

    public function destroy(Request $request) {
		$id = $request->input('id');
		$user = User::find($id);
		$user->delete($user->id);

		return response()->json(['status'=>'success']);

	}


}

