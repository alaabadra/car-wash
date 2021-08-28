<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Employee;
use App\Models\ManageEmployees\Role;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RoleController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $res= Role::get();
            DB::commit();
            if($res){
                return $res;
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
    
        public function getRoles($role_name){
            DB::beginTransaction();
            try {
                $roles=Role::where(['name'=>$role_name])->get();                
                DB::commit();
                if($roles){
                    return $roles;
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


        public function permissionsRole($role_name,$module_name){
            DB::beginTransaction();
            try {
                $operations=DB::table('roles')->where(['role_name'=>$role_name,'module_name'=>$module_name])->get();
                
                DB::commit();
                if($operations){
                    return $operations;
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
    
    public function store(Request $request){
        DB::beginTransaction();
        try {
            $Role= new Role();
            $Role->name_ar=$request->name_ar;
            $Role->name=$request->name;
            $Role->status=$request->status;
            $Role->operation_create=$request->operation_create;
            $Role->operation_update=$request->operation_update;
            $Role->operation_delete=$request->operation_delete;
            $Role->operation_read=$request->operation_read;
            $Role->save();
            

            DB::commit();
            return \response()->json([
                'data'=>'added successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {
            $Role= Role::where(['id'=>$id])->first();
            $Role->name_ar=$request->name_ar;
            $Role->name=$request->name;
            $Role->status=$request->status;
            $Role->operation_create=$request->operation_create;
            $Role->operation_update=$request->operation_update;
            $Role->operation_delete=$request->operation_delete;
            $Role->operation_read=$request->operation_read;
            $Role->save();
            
            DB::commit();
            return \response()->json([
                'data'=>'updated successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        $Role= Role::where(['id'=>$id])->first();
        $Role->delete();
        return \response()->json([
            'data'=>'deleted successfully',
            'status'=>200
        ]);
    }
}
