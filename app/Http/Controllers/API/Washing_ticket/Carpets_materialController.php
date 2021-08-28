<?php

namespace App\Http\Controllers\API\Washing_ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store_manage\Service;
use App\Models\Washing_tickets\Carpet_washing;
use Throwable;
use Illuminate\Support\Facades\DB;

class Carpets_materialController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $res=  Carpet_washing::get();
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
    public function show($id,$type){
        DB::beginTransaction();
        try {

            $data=DB::table('services')
            ->join('custom_units','services.unit_id','custom_units.id')
            ->join('products_manages','services.product_id','products_manages.id')
            ->select('services.id as id','services.extra_cost as extra_cost','services.description as descr','custom_units.name as units','products_manages.name as name','products_manages.name_ar',
                     'custom_units.cost')
            ->where(['ticket_id'=>$id,'services.type'=>$type])
            ->paginate(5);
            if($data){
                DB::commit();
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

    public function store(Request $request){


        DB::beginTransaction();
        try {
            $data=new Service;
            $data->ticket_id=$request->ticket_id;
            $data->product_id=$request->product_id;
            $data->unit_id=$request->unit_id;
            $data->cost=$request->cost;
            $data->extra_cost=$request->extra_cost;
            $data->description=$request->description;
            $data->type=$request->type;
            $data->save();
            return response(['success','your data created successfully'],200);

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        
    DB::beginTransaction();
    try {

        $data=Service::find($id)->delete();
        return response(['success','your data deleted successfully'],200);
        DB::commit();
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    }

    }
}
