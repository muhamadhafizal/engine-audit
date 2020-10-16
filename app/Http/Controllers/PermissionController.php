<?php

namespace App\Http\Controllers;
use App\Permission;
use App\User;
use App\Equipment;
use App\Room;
use DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        return response()->json(['status'=>'success','value'=>'index permission']);
    }

    public function store(Request $request){

        $roomid = $request->input('roomid');
        $equipmentid = $request->input('equipmentid');
        $auditorid = $request->input('auditorid');

        $roomdetails = Room::find($roomid);
        $equipmentdetails = Equipment::find($equipmentid);
        $auditordetails = User::find($auditorid);

        if($roomdetails == null || $equipmentdetails == null || $auditordetails == null){
            return response()->json(['status'=>'failed','value'=>'sorry id for room or equipment or auditor not exist']);
        } else {
            
            $existing = Permission::where('roomid',$roomid)->where('equipmentid',$equipmentid)->first();

        if($existing){

            $existing->auditorid = $auditorid;
            $existing->save();

            return response()->json(['status'=>'success','value'=>'success update permission']);

        } else {

            $permission = new Permission;
            $permission->roomid = $roomid;
            $permission->equipmentid = $equipmentid;
            $permission->auditorid = $auditorid;

            $permission->save();

            return response()->json(['status'=>'success','value'=>'success add new permission']);

        }

        }



        

        
    }

    public function destroy(Request $request){

        $permissionid = $request->permissionid;

        $permission = Permission::find($permissionid);

        $permission->delete();

        return response()->json(['status'=>'success','value'=>'success delete permission']);

    }

    public function all(){

        $data = Permission::all();

        return response()->json(['status'=>'success','value'=>$data]);

    }

    public function details(Request $request){

        $equipmentid = $request->input('equipmentid');
        $roomid = $request->input('roomid');

        $data = DB::table('permissions')
                ->join('users','users.id','=','permissions.auditorid')
                ->select('permissions.*','users.name as auditorname','users.id as auditorid')
                ->where('permissions.equipmentid',$equipmentid)
                ->where('permissions.roomid',$roomid)
                ->get();
        
                return response()->json(['status'=>'success','value'=>$data]);

    }

   
}
