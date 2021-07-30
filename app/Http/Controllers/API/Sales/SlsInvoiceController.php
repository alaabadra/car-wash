<?php

namespace App\Http\Controllers\API\Sales;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccTransaction;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\SlsDelivery;
use App\Models\SlsInvoice;
use App\Models\SlsProductionOrder;
use App\Models\StrProduct;
use App\Models\StrTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SlsInvoiceController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {

            $res= SlsInvoice::whereMode(\request()->mode)->whereIn('type', \request()->types)->whereDate('date', '>=', date('Y-m-d',  strtotime(\request()->date1)))->whereDate('date', '<=', date('Y-m-d', strtotime(\request()->date2)))->with(['user:id,name', 'customer:id,name'])->get();
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

    public function show(SlsInvoice $slsInvoice)
    {
        DB::beginTransaction();
        try {

            $res= $slsInvoice->showFormat();
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

            \request()->validate([
                'date' => 'required',
                'customer_id' => 'required',
                'customer_account_id' => 'required',
                'mode' => 'required',
                'type' => 'required'
            ], ['customer_id.required' => ' يجب اختيار جهة الفاتورة ', 'type.required' => 'يجب اختيار نوع الفاتورة']);
    
            $account = Account::find(\request()->customer_account_id);
            $customer =   Customer::find(\request()->customer_id);
    
            if (\request()->mode == 'sales') {
                $updated_balance = $account->balance - \request()->payment_value;
                //check if customer account permit operation
                if (($updated_balance + \request()->total_price) > $customer->limit_balance) return \response()->json(['error' => 'رصيد العميل لا يسمح'], 404);
            }
    
            DB::beginTransaction();
            try {
                //  save invoice main
                $invoice_num = SlsInvoice::where('type', \request()->type)->count() + 1;
                $invoice = $customer->invoices()->save(new SlsInvoice(\request()->only('mode', 'date', 'type',   'descount_value', 'total_before_taxes', 'taxes_value', 'total_price', 'date', 'payment_value', 'payment_cash_value', 'payment_bank_value') + ['num' => $invoice_num, 'source_balance' => $account->balance, 'state' => 'active', 'user_id' => Auth::user()->id]));
                $invoice->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => ' انشاء فاتورة ' . trans('invoice.' . \request()->mode) . ' رقم ' . $invoice->id, 'state' => $invoice->state]));
    
                //save invoice items
                $invoice_products = collect(request()->items)->map(function ($i) {
                    return \collect($i)->only('str_product_id', 'unite', 'quantity', 'unite_price', 'unite_price_descount', 'unite_final_price', 'taxes_value', 'total_before_taxes', 'total_price');
                });
    
                $invoice->items()->createMany($invoice_products->toArray());
    
                //sales invoices
                if (\request()->mode == 'sales') {
                    $tr = $invoice->transactions()->save(new AccTransaction(['type' => 'استحقاق فاتورة بيع رقم ' . $invoice->id, 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
    
                    $tr->details()->createMany([
                        ['account_id' => $account->id, 'debtor' => request()->total_price],
                        ['account_id' => 4110002, 'creditor' => request()->taxes_value],
                        ['account_id' => 4110001, 'creditor' => request()->total_before_taxes],
                    ]);
    
                    //save invoice transaction payment
                    if (\request()->payment_value > 0) {
                        $tr = $invoice->transactions()->save(new AccTransaction(['type' => 'دفع فاتورة بيع رقم ' . $invoice->id, 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
    
                        $tr->details()->create(['account_id' => $account->id, 'creditor' => request()->payment_value]);
                        if (\request()->payment_cash_value > 0) $tr->details()->create(['account_id' => Auth::user()->cash_account_id, 'description' => \request()->payment_description, 'debtor' => request()->payment_cash_value]);
                        if (\request()->payment_bank_value > 0) $tr->details()->create(['account_id' => Auth::user()->bank_account_id, 'description' => \request()->payment_description, 'debtor' => request()->payment_bank_value]);
                    }
    
                    //add production order
                    if (\request()->production_order) {
    
                        foreach ($invoice->items as $item) {
    
                            $brk = SlsProductionOrder::create(['str_product_id' => $item->str_product_id, 'sls_invoice_item_id' => $item->id, 'mixer_id' => \request()->production_mixer_id, 'quantity' => $item->quantity, 'state' => 'completed', 'start_time' => \request()->production_start_time, 'end_time' => \request()->production_end_time, 'user_id' => auth()->id()]);
    
                            //store transaction
                            $str = $brk->str_transaction()->save(new StrTransaction(['type' => 'امر انتاج ' . trans(\request()->type), 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
    
                            //remove required materials
                            $required_materials = $item->product->materials;
    
    
                            foreach ($required_materials as $material) {
                                $required_ammount = $material->pivot->ammount * $item->quantity;
    
                                if ($material->balance < $required_ammount) {
                                    DB::rollback();
                                    return \response()->json(['error' => 'لا يوجد رصيد كافي من خامة' . $material->name . ' نقص بمقدار  ' . ($required_ammount - $material->balance) . ' ' . $material->unite], 404);
                                }
                                $brk->materials()->attach($material->id, ['quantity' => $required_ammount, 'unite' => $material->unite, 'unite' => $material->unite]);
                                $str->details()->create(['store_id' => 1, 'out' => $required_ammount, 'str_product_id' => $material->id]);
                            }
    
                            //insert pruducted ammount to store
                            $str->details()->create(['store_id' => 1, 'in' => $item->quantity, 'str_product_id' => $item->str_product_id]);
                        }
                    }
    
    
                    //purchases invoices
                } else {
                    $tr = $invoice->transactions()->save(new AccTransaction(['type' => 'استحقاق فاتورة شراء رقم ' . $invoice->id, 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
                    $tr->details()->createMany([
                        ['account_id' => $account->id, 'creditor' => request()->total_price],
                        ['account_id' => 1250004, 'debtor' => request()->taxes_value],
                        ['account_id' => 1250003, 'debtor' => request()->total_before_taxes],
                    ]);
    
                    if (\request()->payment_value > 0) {
                        $tr = $invoice->transactions()->save(new AccTransaction(['type' => 'دفع فاتورة شراء رقم ' . $invoice->id, 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
                        $tr->details()->create(['account_id' => $account->id, 'debtor' => request()->payment_value]);
                        if (\request()->payment_cash_value > 0) $tr->details()->create(['account_id' => Auth::user()->cash_account_id, 'description' => \request()->payment_description, 'creditor' => request()->payment_cash_value]);
                        if (\request()->payment_bank_value > 0) $tr->details()->create(['account_id' => Auth::user()->bank_account_id, 'description' => \request()->payment_description, 'creditor' => request()->payment_bank_value]);
                    }
                }
    
                //delivery 
                //delivery to stores
                if (\request()->delivery_order) {
                    $dleivery_type = 'delivery';
                    if (\request()->mode == 'purchases') $dleivery_type = 'receive';
                    $sls_delivery = SlsDelivery::create(['car_id' => \request()->delivery_car_id, 'driver_id' => \request()->delivery_driver_id, 'type' => $dleivery_type, 'state' => 'record_in', 'sls_invoice_id' => $invoice->id, 'user_id' => Auth::user()->id]);
    
                    $msg = ' سحب كمية من المخزن بامر تحميل رقم' . $sls_delivery->id;
                    $mode = 'out';
    
                    if ($dleivery_type == 'receive') {
                        $msg = 'ايداع منتجات في المخزن بامر استلام رقم ' . $sls_delivery->id;
                        $mode = 'in';
                    }
    
    
                    $store_trs = $sls_delivery->str_transaction()->create(['type' => $msg, 'date' => date('Y-m-d h:i:s'), 'user_id' => auth()->id()]);
    
                    //add delivery items
                    foreach ($invoice->items as $i) {
                        $sls_delivery->items()->create(['str_product_id' => $i->str_product_id, 'quantity' => $i->quantity, 'sls_invoice_item_id' => $i->id, 'delivered' => $i->delivered, 'remain' => 0]);
                        $store_trs->details()->create(['str_product_id' => $i->str_product_id, $mode => $i->quantity, 'store_id' => 1]);
                    }
                }
    
                DB::commit();
                return $invoice->load('customer');
            } catch (\Throwable $th) {
                DB::rollback();
                return \response()->json($th->getMessage(), 500);
            }
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }


        
    }

    public function update(SlsInvoice $slsInvoice)
    {

        DB::beginTransaction();
        try {
            if (\request()->has('flatten_invoice')) {
    
                //check if all items were delivered or not
                if ($slsInvoice->deliveries->where('state', '!=', 'record_in')->count() > 0) return \response()->json(['error' => 'يوجد اوامر تحميل لم يتم تسجيل دخولها'], 404);
    
                //check if invoice need flatten
                if ($slsInvoice->items->sum('remain') == 0)  return \response()->json(['error' => ' هذه الفاتورة لا تقبل التسوية تم تحميل وتوريد جميع المنتجات يمكنك غلق الفاتورة بدون تسوية'], 404);;
    
                //check if production more than delivery ( for concret only )
                if ($slsInvoice->type == 'concret' && $slsInvoice->productions->sum('quantity') > $slsInvoice->deliveries->sum('quantity')) return \response()->json(['error' => 'يجب تحميل جميع المواد المنتجة قبل تسوية الفاتورة  يمكنك اعادة توجيه الكمية المنتجة او اهلاكها'], 404);
    
    
                DB::beginTransaction();
                try {
    
                    foreach ($slsInvoice->items as $item) {
                        $item_total_price = $item->unite_final_price * $item->delivered;
                        $item_total_before_taxes = $item_total_price / 1.15;
                        $item_taxes_value = $item_total_price - $item_total_before_taxes;
                        $item->update(['quantity' => $item->delivered, 'total_price' => $item_total_price, 'total_before_taxes' => $item_total_before_taxes, 'taxes_value' => $item_taxes_value]);
                    }
    
                    //update invoice totals
                    $invoice_total_price = $slsInvoice->total_price;
                    $invoice_total_before_taxes = $slsInvoice->total_before_taxes;
                    $invoice_taxes_value = $slsInvoice->taxes_value;
    
    
                    $slsInvoice->update(['state' => 'closed', 'total_price' => $slsInvoice->items->sum('total_price'), 'total_before_taxes' => $slsInvoice->items->sum('total_before_taxes'), 'taxes_value' => $slsInvoice->items->sum('taxes_value')]);
                    $difference_value = $invoice_total_price - $slsInvoice->total_price;
    
                    //add transaction for flatten value
                    $tr = $slsInvoice->transactions()->save(new AccTransaction(['type' => 'تسوية فاتورة رقم' . $slsInvoice->id, 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));
                    $tr->details()->createMany([
                        ['account_id' => $slsInvoice->customer->account_id, 'creditor' => $difference_value],
                        ['account_id' => 4110001, 'debtor' => $invoice_total_before_taxes - $slsInvoice->total_before_taxes],
                        ['account_id' => 4110002, 'debtor' => $invoice_taxes_value - $slsInvoice->taxes_value],
                    ]);
    
                    $slsInvoice->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => '  تسوية الفاتورة بفارق سعري  ' . $difference_value]));
                    DB::commit();
                    return  $slsInvoice->showFormat();
                } catch (\Throwable $th) {
                    DB::rollback();
                    return \response()->json($th->getMessage(), 500);
                }
            }
    
            if (\request()->has('close_invoise')) {
                //check if all items was delivered or not
                $undelivered_quantity = $slsInvoice->items->sum('remain');
                if ($undelivered_quantity > 0) return \response()->json(['error' => 'لم يتم تحميل وتوريد جميع المنتجات'], 404);
                $slsInvoice->update(['state' => 'closed']);
                $slsInvoice->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تم اغلاق الفاتورة ', 'state' => 'closed']));
                //add payment if not added
    
    
            }
            
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }


}
