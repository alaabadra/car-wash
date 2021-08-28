<?php

namespace App\Http\Controllers\API\Sales;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\SalesReservationOrder;
use App\Models\SlsDelivery;
use App\Models\SlsInvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SlsDeliveryController extends Controller
{

    public function index()
    {
        DB::beginTransaction();
        try {
            $res= SlsDelivery::whereDate('created_at', '>=', date('Y-m-d',  strtotime(\request()->date1)))->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->date2)))->with(['driver:id,name', 'car:id,name'])->get();
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



    public function show(SlsDelivery $sls_delivery)
    {
        DB::beginTransaction();
        try {
            $res= $sls_delivery->showFormat();
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

            // todo: check for quantity to be included in production orders or store balance
            $sls_delivery = SlsDelivery::create(\request()->only('care_id', 'sls_invoice_id', 'driver_id', 'car_id', 'pump_id', 'distance', 'location', 'out_time', 'state', 'type') + ['user_id' => Auth::user()->id, 'deliverable_type' => 'App\\Models\\SlsInvoice', 'deliverable_id' => \request()->invoice_id]);
            //add delivery items
    
            $delivery_items = collect(request()->items)->map(function ($i) {
                return \collect($i)->only('str_product_id', 'quantity', 'sls_invoice_item_id', 'delivered', 'remain');
            });
    
            $sls_delivery->items()->createMany($delivery_items->toArray());
    
            $msg = ' سحب كمية من المخزن بامر تحميل رقم' . $sls_delivery->id;
            $mode = 'out';
            if (\request()->type == 'receive') {
                $msg = 'ايداع منتجات في المخزن بامر استلام رقم ' . $sls_delivery->id;
                $mode = 'in';
            }
            //remove ammounts from store
            $store_trs = $sls_delivery->str_transaction()->create(['type' => $msg, 'date' => date('Y-m-d h:i:s'), 'user_id' => auth()->id()]);
    
            //define store according to delivery material type
    
            $store_items = $delivery_items->map(function ($i) use ($mode) {
                return  ['str_product_id' => $i['str_product_id'], $mode => $i['quantity'], 'store_id' => 1];
            });
    
            $store_trs->details()->createMany($store_items->toArray());
    
            $sls_delivery->activities()->create(['state' => \request()->state, 'type' => 'new delivery', 'user_id' => Auth::user()->id]);
            $sls_delivery->car->activities()->save(new Activity(['state' => \request()->state, 'type' => 'new ordr to car', 'user_id' => Auth::user()->id]));
            $sls_delivery->driver->activities()->save(new Activity(['state' => \request()->state, 'type' => 'new ordr to driver', 'user_id' => Auth::user()->id]));
            $sls_delivery->invoice->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تم اضافة امر تحميل برقم ' . $sls_delivery->id, 'state' => $sls_delivery->state]));
    
            DB::commit();
            return $sls_delivery;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }


    public function update(SlsDelivery $sls_delivery)
    {
        DB::beginTransaction();
        try {

            if (\request()->has('change_state')) {
    
                $sls_delivery->update(['state' => \request()->state]);
                $sls_delivery->activities()->create(['state' => \request()->state, 'type' => 'تم تتحديث حالة امر التحميل الي ' . \request()->ar_state, 'user_id' => Auth::user()->id]);
                return $sls_delivery->showFormat();
            }
            $sls_delivery->update(['state' => \request()->state, 'out_time' => \request()->out_time, 'return_time' => \request()->return_time]);
            $sls_delivery->activities()->create(['state' => \request()->state, 'type' => 'delivery state changed', 'user_id' => Auth::user()->id]);
            DB::commit();
            return $sls_delivery;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
