<?php

namespace App\Http\Controllers\API\Sales;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\SlsProductionOrder;
use App\Models\StrProduct;
use App\Models\StrTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SlsProductionOrderController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {

            $res= SlsProductionOrder::whereDate('created_at', '>=', date('Y-m-d',  strtotime(\request()->date1)))->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->date2)))->with(['product:id,name'])->get();
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

    public function show(SlsProductionOrder $slsProductionOrder)
    {
        DB::beginTransaction();
        try {

            $res= $slsProductionOrder->showFormat();
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

        \request()->validate([
            'mixer_id' => 'required',
            'quantity' => 'required|min:1',
            'str_product_id' => 'required'
        ]);

        //check if stores include required materials
        $required_materials = StrProduct::find(\request()->str_product_id)->materials;
        foreach ($required_materials as $material) {
            $required_quantity = $material->pivot->ammount * \request()->quantity;
            if ($material->balance < $required_quantity) return \response()->json(['error' => 'لا يوجد رصيد كافي للخامات الاوليه المطلوبة لامر الانتاج'], 404);
        }
        DB::beginTransaction();
        try {
            $brk = SlsProductionOrder::create(\request()->only('str_product_id', 'sls_invoice_item_id', 'mixer_id', 'quantity', 'destroyed_quantity', 'final_quantity', 'state', 'start_time', 'end_time',  'unite_price') + ['user_id' => auth()->id()]);

            //store transaction
            $str = $brk->str_transaction()->save(new StrTransaction(['type' => 'امر انتاج بلوك', 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));

            //remove used materials
            $required_materials = StrProduct::find(\request()->str_product_id)->materials;


            foreach ($required_materials as $material) {
                $required_ammount = $material->pivot->ammount * \request()->quantity;

                if ($material->balance < $required_ammount) {
                    DB::rollback();
                    return \response()->json(['error' => 'لا يوجد رصيد كافي من خامة' . $material->name . ' نقص بمقدار  ' . ($required_ammount - $material->balance) . ' ' . $material->unite], 404);
                }

                $brk->materials()->attach($material->id, ['quantity' => $required_ammount]);
                $str->details()->create(['store_id' => 1, 'out' => $required_ammount, 'str_product_id' => $material->id]);
            }

            //add product to store
            $str->details()->create(['store_id' => 1, 'in' => \request()->final_quantity, 'str_product_id' => \request()->str_product_id]);


            DB::commit();
            return $brk->load('product:id,name');
        } catch (\Throwable $th) {
            DB::rollback();
            return \response()->json($th, 500);
        }
    }

    public function update(SlsProductionOrder $slsProductionOrder)
    {
        DB::beginTransaction();
        try {

            if (\request()->has('finish_production')) {
                $slsProductionOrder->update(['state' => 'completed', 'end_time' => date('Y-m-d h:i:s')]);
                $slsProductionOrder->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تحديث حالة امر الانتاج الي تم الانتهاء', 'state' => 'completed']));
                //to do
                //in proccessing pull ammount from store
                return '';
            }
            if (\request()->has('start_production')) {
                $slsProductionOrder->update(['state' => 'active', 'start_time' => date('Y-m-d h:i:s')]);
                $slsProductionOrder->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تحديث حالة امر الانتاج الي نشط', 'state' => 'active']));
                //to do
                //in proccessing pull ammount from store
                return '';
            }
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
