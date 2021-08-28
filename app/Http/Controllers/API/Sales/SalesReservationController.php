<?php

namespace App\Http\Controllers\API\Sales;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\SalesReseravtion;
use App\Models\SalesReservation;
use App\Models\SalesReservationProduct;
use App\Models\StrProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalesReservationController extends Controller
{
    //depricated
    //======================================
    // public function index()
    // {
    //     //DB::table('sales_reservations')->join('str_products','sales_reservations','=','str_products.')

    //     return SalesReservation::with('customer:id,name')->get();
    // }

    // public function products($id)
    // {
    //     $reservation = SalesReservation::find($id);
    //     return  $reservation->products->map->showFormat();
    // }

    // public function show(SalesReservation $salesReservation)
    // {
    //     return $salesReservation->showFormat();
    // }

    // public function store()
    // {

    //     $sr = SalesReservation::create(request()->only('customer_id', 'product_id', 'type', 'state',  'date', 'descount', 'taxes_value', 'total', 'total_with_taxes') + ['user_id' => Auth::user()->id]);
    //     foreach (request()->items as $item) {
    //         $product = StrProduct::find($item['str_product_id']);
    //         $sr->products()->save(new SalesReservationProduct(['str_product_id' => $item['str_product_id'], 'product_name' => $product->name, 'unite_price' => $item['unite_price'], 'unite_price_descount' => $item['unite_price_descount'], 'unite_final_price' => $item['unite_final_price'], 'ammount' => $item['ammount'], 'total_price' => $item['total_price'],]));
    //     }
    //     $sr->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'اضافة حجز جديد']));
    //     DB::commit();
    //     return $sr->load('customer:id,name', 'products');
    // }
}
