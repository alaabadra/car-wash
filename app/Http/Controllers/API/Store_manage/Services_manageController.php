<?php

namespace App\Http\Controllers\API\Store_manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store_manage\Material;
use App\Models\Store_manage\Service;

use Illuminate\Support\Facades\DB;
use Throwable;

class Services_manageController extends Controller
{
    public function index(){}

    public function show($id){
        DB::beginTransaction();
        try {
            $res= Material::where('product_id',$id)->paginate(5);
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
    public function showServiceBasedOnTicket($ticketId, $type){
        DB::beginTransaction();
        try {
            $res= Service::where(['ticket_id'=>$ticketId, 'type'=>$type])->get();
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

            $data=new Material;
            $data->product_id=$request->product_id;
            $data->name=$request->name;
            $data->quantity=$request->quantity;
            $data->save();
            DB::commit();
            return response(['success','your data Stored successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function storeService(Request $request){
        DB::beginTransaction();
        try {

            $data=new Service();
            $data->product_id=$request->product_id;
            $data->ticket_id=$request->ticket_id;
            $data->type=$request->type;
            $data->unit_id=$request->unit_id;
            $data->cost=$request->cost;
            $data->extra_cost=$request->extra_cost;
            $data->description=$request->description;
            $data->save();
            DB::commit();
            return response(['success','your data Stored successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function updateService(Request $request,$id){
        DB::beginTransaction();
        try {

            $data=Service::where(['id'=>$id])->first();
            $data->product_id=$request->product_id;
            $data->ticket_id=$request->ticket_id;
            $data->type=$request->type;
            $data->unit_id=$request->unit_id;
            $data->cost=$request->cost;
            $data->extra_cost=$request->extra_cost;
            $data->description=$request->description;
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

            $data=Material::find($id)->delete();
            DB::commit();
            return response(['success','your data deleted successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
