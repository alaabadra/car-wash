<?php

namespace App\Http\Controllers\API\Sales;

use App\Http\Controllers\Controller;
use App\Models\AccTransactionDetail;
use App\Models\AccTransaction;
use App\Models\Activity;
use App\Models\SalesReservationOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalesReservationOrderController extends Controller
{
    //depricated
    //======================================

    // public function index()
    // {
    //     return SalesReservationOrder::all()->map->only('id', 'sales_reservation_id', 'customer_name', 'product_name', 'ammount', 'state', 'date');
    // }

    // public function indexByDateRange($date1, $date2)
    // {

    //     return SalesReservationOrder::whereDate('date', '>=', date('Y-m-d', strtotime($date1)))->whereDate('date', '<=', date('Y-m-d', strtotime($date2)))->get()->map->only('id', 'sales_reservation_id', 'customer_name', 'product_name', 'ammount', 'state', 'date');
    // }

    // public function show(SalesReservationOrder $sales_reservation_order)
    // {
    //     return  $sales_reservation_order->showFormat();
    // }

    // public function store()
    // {

    //     // return request();
    //     $order = SalesReservationOrder::create(request()->only('sales_reservation_id', 'sales_reservation_product_id', 'ammount', 'date', 'location') + ['user_id' => Auth::user()->id]);
    //     $order->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'اضافة   طلب  جديد', 'state' => 'waiting']));
    //     $order->reservation->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'اضافة   طلب  جديد', 'state' => 'waiting']));
    //     return $order->only('id', 'sales_reservation_id', 'customer_name', 'product_name', 'ammount', 'state');;
    // }

    // public function update(SalesReservationOrder $sales_reservation_order)
    // {

    //    if(Auth::user()->check(['admin'])){

    //    }
    //     if (\request()->has('change_state')) {
    //         $sales_reservation_order->update(\request()->only('state'));
    //         $sales_reservation_order->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تحديث حالة امر التحميل والتوريد ', 'state' => \request()->state]));
    //         //to do
    //         //in proccessing pull ammount from store
    //         return '';
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $sales_reservation_order->update(\request()->only('state'));
    //         $sales_reservation_order->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'تعديل حالة امر التعديل', 'state' => \request()->state]));

    //         if ($sales_reservation_order->payed == 0) {
    //             $trs = $sales_reservation_order->transactions()->save(new AccTransaction(['type' => 'pay order', 'user_id' => Auth::user()->id]));
    //             $trs->entries()->save(new AccTransactionDetail(['account_id' => $sales_reservation_order->reservation->customer->account_id, 'debtor' => $sales_reservation_order->total_price + $sales_reservation_order->taxes_value]));
    //             $trs->entries()->save(new AccTransactionDetail(['account_id' => 2121, 'creditor' => $sales_reservation_order->taxes_value]));
    //             $trs->entries()->save(new AccTransactionDetail(['account_id' => 2125, 'creditor' => $sales_reservation_order->total_price]));
    //             $sales_reservation_order->update(['payed' => 1]);
    //         }
    //         DB::commit();
    //         return   $sales_reservation_order;
    //     } catch (Throwable $t) {
    //         DB::rollback();
    //         return \response()->json($t->getMessage(), 404);
    //     }
    // }

    // public function destroy(SalesReservationOrder $sales_reservation_order)
    // {
    //     $sales_reservation_order->delete();
    // }
}
