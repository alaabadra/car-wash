<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ShiftController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {
            $shifts=Shift::all();
            foreach($shifts as $shift){
                if($shift->week_days=="")
                    $shift->week_days=[];
                else
                    $shift->week_days=explode(',', $shift->week_days);
            }
            if(session('lang')=='ar')
                foreach($shifts as $sh){
                    $sh->name=$sh->name_ar;
                }
                DB::commit();
            if($shifts){
                return $shifts;
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

    public function shift_show($id){
        DB::beginTransaction();
        try {

            $res= Shift::find($id); 
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

    public function store(Request $request){
        DB::beginTransaction();
        try {

            $days=implode(',',$request->week_days);
            $shift=new Shift;
            $shift->name=$request->name;
            $shift->name_ar=$request->name_ar;
            $shift->on_duty_time1=$request->on_duty_time1;
            $shift->off_duty_time1=$request->off_duty_time1;
            $shift->begin1=$request->begin1;
            $shift->end1=$request->end1;
            $shift->on_duty_time2=$request->on_duty_time2;
            $shift->off_duty_time2=$request->off_duty_time2;
            $shift->begin2=$request->begin2;
            $shift->end2=$request->end2;
            $shift->assign_another_shift=$request->assign_another_shift;
            $shift->week_days=$days;
            $shift->start_late=$request->start_late;
            $shift->late_minutes=$request->late_minutes;
            $shift->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {

            $days=implode(',',$request->week_days);
            $shift=Shift::find($id);
            $shift->name=$request->name;
            $shift->name_ar=$request->name_ar;
            $shift->on_duty_time1=$request->on_duty_time1;
            $shift->off_duty_time1=$request->off_duty_time1;
            $shift->begin1=$request->begin1;
            $shift->end1=$request->end1;
            $shift->on_duty_time2=$request->on_duty_time2;
            $shift->off_duty_time2=$request->off_duty_time2;
            $shift->begin2=$request->begin2;
            $shift->end2=$request->end2;
            $shift->assign_another_shift=$request->assign_another_shift;
            $shift->week_days=$request->week_days;
            $shift->start_late=$request->start_late;
            $shift->late_minutes=$request->late_minutes;
            $shift->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        Shift::find($id)->delete();
    }

    public function get_shifts(){
        DB::beginTransaction();
        try {

            $shifts=Shift::all();
            if(session('lang')=='ar')
                foreach($shifts as $sh){
                    $sh->name=$sh->name_ar;
                }
                DB::commit();
            if($shifts){
                return $shifts;
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
