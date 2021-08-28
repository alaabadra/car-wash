<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\ManageEmployees\Machine_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MachineSettingController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $machines=Machine_setting::all();
            if(session('lang')=='ar')
                foreach($machines as $mac){
                    $mac->name=$mac->name_ar;
                }
            if($machines){
                DB::commit();
                return $machines;
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

            $data=new Machine_setting;
            $data->name = $request->name;
            $data->name_ar = $request->name_ar;
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

            Machine_setting::find($id)->update([
                'name' => $request->name,
                'name_ar' => $request->name_ar,
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

            $res= Machine_setting::find($id);
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

            Machine_setting::find($id)->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
