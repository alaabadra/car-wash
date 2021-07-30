<?php

namespace App\Http\Controllers\API\Store_manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store_manage\Product_manage;
use App\Models\Store_manage\Service;
use App\Models\Store_manage\Custom_unit;
use Illuminate\Support\Facades\DB;
use Throwable;

class Products_manageController extends Controller
{
    public function getAllServices(){
        DB::beginTransaction();
        try {
            $services=Product_manage::where('type', 'service')->get();
        if($services){
            DB::commit();
            return $services;
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
    public function index(){
        DB::beginTransaction();
        try {

            $products=Product_manage::all();
            $services=Service::all();
            foreach($services as $ser){
                $x=1;
                foreach($products as $pro){
                    if($ser->product_id==$pro->id){
                        $x=2;
                        break;
                    }
                }
                if($x==1)
                    $ser->delete();
            }
            $units=Custom_unit::all();
            foreach($units as $unit){
                $x=1;
                foreach($products as $pro){
                    if($unit->product_id==$pro->id){
                        $x=2;
                        break;
                    }
                }
                if($x==1)
                    $unit->delete();
            }
            $prs=Product_manage::paginate(5);
            if(session('lang')=='ar')
                foreach($prs as $pr){
                    $pr->name=$pr->name_ar;
                }
            if($prs){
                DB::commit();
                return $prs;
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

            $data=new Product_manage;
            $data->name =$request->name;
            $data->name_ar = $request->name_ar;
            $data->classifications = $request->classifications;
            $data->type = $request->type;
            $data->part_unit =$request->part_unit;
            $data->default_unit =$request->default_unit;
            $data->unit_parts = $request->unit_parts;
            if($request->unit_price)
                $data->unit_price = $request->unit_price;
            else
                $data->unit_price = 0;
            $data->save();
            DB::commit();
            $id= $data->id;
            return response(['success','your data Stored successfully','id'=> $id ],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Request $request,$id){
        DB::beginTransaction();
        try {

            $data=Product_manage::find($id);
            $data->name =$request->name;
            $data->name_ar = $request->name_ar;
            $data->classifications = $request->classifications;
            $data->type = $request->type;
            $data->part_unit =$request->part_unit;
            $data->default_unit =$request->default_unit;
            $data->unit_parts = $request->unit_parts;
            if($request->unit_price)
                $data->unit_price = $request->unit_price;
            $data->save();
            DB::commit();
            return response(['success','your data Updated successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy($id){
        DB::beginTransaction();
        try {

            Product_manage::find($id)->delete();
            Service::where('product_id',$id)->delete();
            Custom_unit::where('product_id',$id)->delete();
            DB::commit();
            return response(['success','your data deleted successfully'],200);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function getId(){
        return Product_manage::max('id')+1;
    }
}
