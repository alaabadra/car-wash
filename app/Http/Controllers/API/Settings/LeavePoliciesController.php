<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\ManageEmployees\Leave_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LeavePoliciesController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {
            $leaves=Leave_policy::all();
            if(session('lang')=='ar')
                foreach($leaves as $leave){
                    $leave->name=$leave->name_ar;
                }
                DB::commit();
            if($leaves){
                return $leaves;
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

    public function get_leaves(){
        DB::beginTransaction();
        try {
            $leaves=Leave_policy::all();
            if(session('lang')=='ar')
                foreach($leaves as $leave){
                    $leave->name=$leave->name_ar;
                }
                DB::commit();
            if($leaves){
                return $leaves;
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

    public function leave_show($id){
        DB::beginTransaction();
        try {
            $res= Leave_policy::find($id);
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

            $data=new Leave_policy;
            $data->name = $request->name;
            $data->name_ar = $request->name_ar;
            $data->colour = $request->colour;
            $data->description = $request->description;
            $data->max_days = $request->max_days;
            $data->max_applicable_days = $request->max_applicable_days;
            $data->applicable_after = $request->applicable_after;
            $data->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {

            Leave_policy::find($id)->update([
                'name' => $request->name,
                'name_ar' => $request->name_ar,
                'colour' => $request->colour,
                'description' => $request->description,
                'max_days' => $request->max_days,
                'max_applicable_days' => $request->max_applicable_days,
                'applicable_after' => $request->applicable_after,
            ]);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function show($id){
        DB::beginTransaction();
        try {
            
            $res= Leave_policy::find($id);
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

    public function destroy($id){
        DB::beginTransaction();
        try {

            Leave_policy::find($id)->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
