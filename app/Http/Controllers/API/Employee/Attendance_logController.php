<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Attendance_log;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon;
use Illuminate\Support\Facades\DB;

use Throwable;

class Attendance_logController extends Controller
{
    public function index(){
        
      DB::beginTransaction();
      try {
          $data = DB::table('attendance_logs')
          ->join('employees','employees.id','=','attendance_logs.employee_name')
          ->select('attendance_logs.*','employees.name as employee_name')
          ->paginate(5);
          DB::commit();
        if($data){
            return $data;
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

    public function session_log($id){
        
      DB::beginTransaction();
      try {
          $res= Attendance_log::where('id',$id)->first();
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

    public function emp_logs($id){
        
      DB::beginTransaction();
      try {
          $data = DB::table('attendance_logs')
          ->join('employees','employees.id','=','attendance_logs.employee_name')
          ->select('attendance_logs.*','employees.name as employee_name')
          ->where('employees.id','=',$id)
          ->get();
          DB::commit();
        if($data){
            return $data;
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

    public function sign_num($id){
        
      DB::beginTransaction();
      try {
          $user=DB::table('attendance_logs')->where('id',$id)->pluck('employee_name')->first();
          DB::commit();
          if($user){
            return Attendance_log::where('employee_name',$user)->count();
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

    public function machine_pull(){
        dd('pull from machine');
    }

    public function store(Request $request){

        DB::beginTransaction();
        try {

            $session_num=Attendance_log::max('session_num')+1;
            $user=DB::table('users')->pluck('name')->first();
            $log=new Attendance_log;
            $log->employee_name=$request->employee;
            $log->session_num=$session_num;
            $log->source_type=$user;
            $log->status=1;
            $log->save();
            return $log;
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        
      DB::beginTransaction();
      try {

          Attendance_log::find($id)->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
