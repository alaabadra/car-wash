<?php

namespace App\Http\Controllers\API\permission;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Employee;
use App\Models\ManageEmployees\Role_has_permission;
use Illuminate\Support\Facades\DB;
use Throwable;

class PermissionController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $emp=Employee::where('id',session('user')->id)->first();
            if($emp){
                $role_id=$emp->role;
                $res= Role_has_permission::where('role_id',$role_id)->get();
                DB::commit();
                if($res){
                    return $res;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'status'=>404
                   ]);
                 }
            }else{
                return \response()->json([
                    'data'=>'there is no data',
                    'status'=>404
                ]);
              }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }


    }
}
