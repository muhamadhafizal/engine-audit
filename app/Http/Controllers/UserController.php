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
            'email' => 'required',
            'address' => 'required',
            'postalcode' => 'required',
            'location' => 'required',
            'area' => 'required',
            'username' => 'required',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $name = $request->input('name');
            $contact = $request->input('contact');
            $email = $request->input('email');
            $address = $request->input('address');
            $postalcode = $request->input('postalcode');
            $location = $request->input('location');
            $area = $request->input('area');
            $username = $request->input('username');
            $password = $request->input('password');
            $roleid = '2';
 
            $userExist = User::where('username',$username)->orWhere('password',$password)->first();
            if($userExist){
                return response()->json(['status'=>'failed', 'value'=>'email or password is exist']);
            } else {

                $user = new User;
                $user->name = $name;
                $user->contact = $contact;
                $user->email = $email;
                $user->address = $address;
                $user->postalcode = $postalcode;
                $user->location = $location;
                $user->area = $area;
                $user->username = $username;
                $user->password = $password;
                $user->role = $roleid;

                $user->save();

                return response()->json(['status'=>'success', 'value'=>'company success register']);

            }

        }

    }

    public function addauditors(Request $request){

        $validator = validator::make($request->all(),
        [
            'companyid' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        } else {

            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email = $request->input('email');
            $contact = $request->input('contact');
            $username = $request->input('username');
            $password = $request->input('password');
            $companyid = $request->input('companyid');
            $roleid = '3';
            $status = 'pending';

            $userExist = User::where('username',$username)->orWhere('password',$password)->first();
            if($userExist){
                return response()->json(['status'=>'failed', 'value'=>'email or password is exist']);
            } else {

                $user = new User;
                $user->name = $firstname;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->contact = $contact;
                $user->username = $username;
                $user->password = $password;
                $user->companyid = $companyid;
                $user->role = $roleid;
                $user->status = $status;

                $user->save();

                return response()->json(['status'=>'success', 'value'=>'success invite auditors']);
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

        $userExist = null;

        $id = $request->input('id');
        $name = $request->input('fistname');
        $lastname = $request->input('lastname');
        $contact = $request->input('contact');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role');
        $status = $request->input('status');

        if($username != null || $password != null ){
            $userExist = User::where('username',$username)->orWhere('password',$password)->first();
        } 

        if($userExist){

            return response()->json(['status'=>'failed','value'=>'username or password is exist']);

        } else {

            $user = User::find($id);

            if($user){

                if(is_null($name)){
                    $name = $user->name;
                }
                if(is_null($lastname)){
                    $lastname = $user->lastname;
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
                if(is_null($status)){
                    $status = $user->status;
                }

                $user->name = $name;
                $user->lastname = $lastname;
                $user->contact = $contact;
                $user->email = $email;
                $user->username = $username;
                $user->password = $password;
                $user->role = $role;
                $user->status = $status;

                $user->save();

                return response()->json(['status'=>'success','value'=>'success update user']);
            } else {
                return response()->json(['status'=>'failed','value'=>'user not exist']);
            }

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
        $auditors = User::where('role','3')->where('companyid',$companyid)->get();

        if($company){
            $companyArray = [
                'id' => $company->id,
                'name' => $company->name,
                'email' => $company->email,
            ];
        }

        if($auditors){
            foreach($auditors as $data){

                $tempArray = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'lastname' => $data->lastname,
                    'email' => $data->email,
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

    public function verification(Request $request){

        $userid = $request->input('userid');

        $user = User::find($userid);

        $status = 'active';
        $user->status = $status;

        $user->save();

        return response()->json(['status'=>'success','value'=>'user success verified']);

    }


}

