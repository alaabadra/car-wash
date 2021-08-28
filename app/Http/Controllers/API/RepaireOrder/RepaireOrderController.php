<?php

namespace App\Http\Controllers\API\RepaireOrder;

use App\Http\Controllers\Controller;
use App\Models\RepaireOrder;
use App\Models\StrProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RepaireOrderController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $search = \request()->search;
            $res = RepaireOrder::latest()->searchIn(['notes', 'user.name', 'equipment.name', 'driver.name'], $search)->with(['user:id,name', 'equipment:id,name', 'driver:id,name'])->paginate(\request()->items_per_page);
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


    public function show(RepaireOrder $repaireOrder)
    {
        DB::beginTransaction();
        try {

            $res= $repaireOrder->load(['user:id,name', 'equipment:id,name', 'driver:id,name', 'products']);
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


    public function store()
    {
        DB::beginTransaction();
        try {

            $ro = RepaireOrder::create(\request()->only('equipment_id', 'driver_id', 'repaire_person_id', 'price', 'km', 'notes', 'date') + ['user_id' => auth()->id()]);
            foreach (\request()->parts as $part) {
                $str_product = StrProduct::find($part['str_product_id']);
                if ($str_product->balance < $part['quantity']) {
                    DB::rollback();
                    return \response()->json(['error' => 'الرصيد لا يسمح'], 404);
                }
                $ro->parts()->create(['str_product_id' => $part['str_product_id'], 'quantity' => $part['quantity']]);
            }
            DB::commit();
            return $ro;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return \response()->json($th->getMessage(), 404);
        }
    }
}
