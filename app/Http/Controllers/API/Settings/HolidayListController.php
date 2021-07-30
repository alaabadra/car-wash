<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\ManageEmployees\Holiday_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class HolidayListController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {
            $res=Holiday_list::all();
            if(session('lang')=='ar')
                foreach($res as $holi){
                    $holi->name=$holi->name_ar;
                }
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

    public function holiday_show($id){
        DB::beginTransaction();
        try {

            $res=Holiday_list::find($id);
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

    public function get_holidays(){
        DB::beginTransaction();
        try {

            $holidays=Holiday_list::all();
             if(session('lang')=='ar')
                 foreach($holidays as $holi){
                     $holi->name=$holi->name_ar;
                 }
                 DB::commit();
                 if($holidays){
                     return $holidays;
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

            $data=new Holiday_list;
            $data->name = $request->name;
            $data->name_ar = $request->name_ar;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
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

            $holidays=  Holiday_list::where(['id'=>$id])->update([
                  'name' => $request->name,
                  'name_ar' => $request->name_ar,
                  'start_date' => $request->start_date,
                  'end_date' => $request->end_date,
              ]);
            DB::commit();
            return $holidays;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }


    }

    public function show($id){
        DB::beginTransaction();
        try {
            
            $res= Holiday_list::find($id);
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
            
            Holiday_list::find($id)->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }


    }
}
