<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Attendance_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class Attendance_permissionController extends Controller
{
    public function index(){
        
        DB::beginTransaction();
        try {
        $res= Attendance_permission::join('employees',function($join){
            $join->on('employees.id','=','attendance_permissions.employee_id');
        })->paginate(5);
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
          return \response()->json($err, 404);
      }

    }

    public function store(Request $request){
        
      DB::beginTransaction();
      try {
          $att=new Attendance_permission;
          $att->employee_id=$request->employee_id;
          $att->att_date_type=$request->att_date_type;
          $att->from_date=$request->from_date;
          $att->to_date=$request->to_date;
          $att->att_type=$request->att_type;
          $att->notes=$request->notes;
          $att->leave_type=$request->leave_type;
          $att->app_date=$request->app_date;
          $att->save();

          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function update(Request $request,$id){
        
      DB::beginTransaction();
      try {
          $att=Attendance_permission::find($id);
          $att->employee_id=$request->employee_id;
          $att->att_date_type=$request->att_date_type;
          $att->from_date=$request->from_date;
          $att->to_date=$request->to_date;
          $att->att_type=$request->att_type;
          $att->notes=$request->notes;
          $att->leave_type=$request->leave_type;
          $att->app_date=$request->app_date;
          $att->save();

          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function destroy($id){
        
      DB::beginTransaction();
      try {

          Attendance_permission::find($id)->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
