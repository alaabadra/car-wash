<?php
namespace App\Http\Controllers\API\Purchase;

use App\Http\Controllers\Controller;
//depracted

use App\Models\AccRecevable;
use App\Models\AccTransaction;
use App\Models\AccTransactionDetail;
use App\Models\Activity;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StrBalance;
use App\Models\StrTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // ========================================
    //depricated
    //=====================================

    // public function index()
    // {
    //     return Purchase::all();
    // }

    // public function show(Purchase $purchase)
    // {
    //     return $purchase->showFormat();
    // }


    // public function store()
    // {

    //     \request()->validate([
    //         'store_id' => 'required'
    //     ], ['store_id.required' => 'يجب اختيار المخزون']);
    //     //  حفظ ماستر الفاتورة
    //     $purchase = Purchase::create(\request()->only('supplier_id', 'payment_type', 'payment_method', 'payement_state', 'delivery_state', 'taxes_value', 'total_price_before_taxes', 'final_price', 'descount', 'date', 'payment_value') + ['store_id' => 1, 'user_id' => Auth::user()->id]);
    //     $purchase->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'انشاء فاتورة شراء']));

    //     //حفظ تفاصيل الفاتورة

    //     $purchase_items = collect(request()->items)->map(function ($i) {
    //         return \collect($i)->only('str_material_id', 'unite', 'quantity', 'unite_price', 'final_price');
    //     });

    //     $purchase->items()->createMany($purchase_items->toArray());

    //     $tr = $purchase->transaction()->save(new AccTransaction(['type' => 'purcahse', 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));

    //     $tr->details()->createMany([
    //         ['account_id' => 11, 'creditor' => request()->payment_value],
    //         ['account_id' =>  request()->supplier_account_id, 'creditor' => request()->final_price - request()->payment_value],
    //         ['account_id' => 51, 'debtor' => request()->taxes_value],
    //         ['account_id' => 52, 'debtor' => request()->final_price - request()->taxes_value],
    //     ]);

    //     AccTransactionDetail::where('debtor', 0)->where('creditor', 0)->delete();

    //     if (\request()->delivery_state == 'performed') {
    //         //حفظ  ماستر حركة المخزن
    //         $str = $purchase->store_transaction()->save(new StrTransaction(['type' => 'delivery', 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));

    //         //حفظ  تفاصيل حركة المخزن
    //         //  $store_items = collect($purchase_items)->map(fn ($i) =>  ['in' => $i->quantity, 'store_id' => \request()->store_id, 'purchase_id' => $i->id, 'str_material_id' => $i->str_material_id],);
    //         $store_items = $purchase_items->map(function ($i) use ($purchase, $str) {
    //             return  ['in' => $i['quantity'], 'store_id' => 1, 'purchase_id' => $purchase->id, 'str_product_id' => $i['str_material_id']];
    //         });

    //         $str->details()->createMany($store_items->toArray());

    //         //update store balance table
    //         $balance_items = $purchase_items->map(function ($i) use ($purchase) {
    //             return  ['purchase_id' => $purchase->id, 'balance' => $i['quantity'], 'store_id' => 1, 'str_product_id' => $i['str_material_id']];
    //         });

    //         // $balance_items = collect($purchase_items)->map(fn ($i) =>  ['purchase_id' => $purchase->id, 'balance' => $i->quantity, 'store_id' => \request()->store_id, 'str_material_id' => $i->str_material_id],);
    //         $purchase->balance()->createMany($balance_items->toArray());
    //         $purchase->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تسليم الفاتورة الي المخزن']));
    //     }


    //     return $purchase;
    // }

    // public function update(Purchase $purchase)
    // {
    //     if (\request()->perform_delivery == true) {
    //         $purchase->store_transaction()->delete();

    //         $str = $purchase->store_transaction()->save(new StrTransaction(['type' => 'delivery', 'date' => date('Y-m-d H:i:s'), 'user_id' => Auth::user()->id]));

    //         $store_items = $purchase->items->map(function ($i) use ($purchase, $str) {
    //             return  ['in' => $i->quantity, 'store_id' => $purchase->store_id, 'purchase_id' => $purchase->id, 'str_material_id' => $i->str_material_id];
    //         });

    //         $str->details()->createMany($store_items->toArray());

    //         $balance_items = $purchase->items->map(function ($i) use ($purchase) {
    //             return  ['purchase_id' => $purchase->id, 'balance' => $i->quantity, 'store_id' => $purchase->store_id, 'str_material_id' => $i->str_material_id];
    //         });
    //         $purchase->balance()->createMany($balance_items->toArray());
    //         $purchase->update(['delivery_state' => 'performed']);
    //         $purchase->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تسليم الفاتورة الي المخزن']));
    //         return $purchase;
    //     }
    // }

    // public function destroy(Purchase $purchase)
    // {
    //     $purchase->delete();
    // }
}
