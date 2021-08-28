<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Jornal;
use App\Models\Finance\Jornal_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class JornalsController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $res= Jornal::all();
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

    public function get_jornal_id(){
        DB::beginTransaction();
        try {

            $res= Jornal::max('id')+1;
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

    public function jornal_details($id){
        DB::beginTransaction();
        try {

            $res= Jornal_details::where('jornal_id',$id)->get();
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

            $jor=new Jornal;
            $jor->jor_date=$request->jor_date;
            $jor->currency=$request->currency;
            $jor->jor_number=$request->jor_number;
            $jor->description=$request->description;
            $jor->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {
            $jor=Jornal::find($id);
            $jor->jor_date=$request->jor_date;
            $jor->currency=$request->currency;
            $jor->jor_number=$request->jor_number;
            $jor->description=$request->description;
            $jor->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        Jornal::find($id)->delete();
        Jornal_details::where('jornal_id',$id)->delete();
    }

    public function jornal_details_create(Request $request){
        DB::beginTransaction();
        try {
            $jor=new jornal_details;
            $jor->jornal_id=$request->jornal_id;
            $jor->acc_name=$request->acc_name;
            $jor->description=$request->description;
            $jor->depit=$request->depit;
            $jor->credit=$request->credit;
            $jor->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function jornal_details_update(Request $request){
        DB::beginTransaction();
        try {
            $jor=jornal_details::find($request->id);
            $jor->jornal_id=$request->jornal_id;
            $jor->acc_name=$request->acc_name;
            $jor->description=$request->description;
            $jor->depit=$request->depit;
            $jor->credit=$request->credit;
            $jor->save();

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }   

    public function jornal_details_delete($id){
        Jornal_details::find($id)->delete();
    }
}
