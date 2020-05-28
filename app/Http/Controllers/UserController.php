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
            $roleid = $request->input('roleid');
            $userid = $request->input('userid');

            if($roleid == null){
                $roleid = '2';
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
                $user->role = $roleid;
                $user->userid = $userid;

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
    
    public function listofstaff(Request $request){

        $companyid = $request->input('companyid');

        $companyArray = array();
        $leadArray = array();
        $auditorsArray = array();
        $finalArray = array();

        $company = User::find($companyid);
        $auditors = User::where('role','3')->where('userid',$companyid)->get();

        if($company){
            $companyArray = [
                'id' => $company->id,
                'name' => $company->name,
            ];
        }

        if($auditors){
            foreach($auditors as $data){

                $tempArray = [
                    'id' => $data->id,
                    'name' => $data->name,
                ];

                array_push($auditorsArray,$tempArray);

            }
        }

        $finalArray = [

            'company' => $companyArray,
            'auditors' => $auditorsArray,

        ];

        return response()->json(['status'=>'success','value'=>$finalArray]);
    }

    public function listuserrole(Request $request){

        $roleid = $request->input('roleid');

        $data = User::where('role',$roleid)->get();

        return response()->json(['status'=>'success','value'=>$data]);

    }


}

