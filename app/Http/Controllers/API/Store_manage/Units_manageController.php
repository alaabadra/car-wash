<?php

namespace App\Http\Controllers\API\Store_manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store_manage\Product_manage;
use App\Models\Store_manage\Service;
use App\Models\Store_manage\Custom_unit;
use Illuminate\Support\Facades\DB;
use Throwable;

class Units_manageController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {
            $res= Custom_unit::get();
            if($res){
                DB::commit();
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
    public function show($id){
        DB::beginTransaction();
        try {
            $res= Custom_unit::where('product_id',$id)->paginate(5);
            if($res){
                DB::commit();
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

            $data=new Custom_unit;
            $data->name=$request->name;
            $data->product_id=$request->product_id;
            $data->ar_name=$request->ar_name;
            $data->units=$request->units;
            $data->cost=$request->cost;
            $data->save();
            DB::commit();
            return response(['success','your data Stored successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        DB::beginTransaction();
        try {

            $data=Custom_unit::find($id)->delete();
            DB::commit();
            return response(['success','your data deleted successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
