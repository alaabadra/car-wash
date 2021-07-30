<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SlsInvoice;
use App\Models\SlsProductionOrder;
use App\Models\StrProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __invoke()
    {

        if (\request()->report_type == 'sales') {

            return SlsInvoice::where('mode', \request()->mode)->whereIn('type', \request()->types)
                ->whereDate('date', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                ->get()->map->reportFormat();
        } elseif (\request()->report_type == 'materials') {
            $data1 = DB::table('sls_production_orders')
                ->join('str_products', 'sls_production_orders.str_product_id',  'str_products.id')
                ->whereDate('sls_production_orders.created_at', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                ->whereDate('sls_production_orders.created_at', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                ->select('str_products.name as product_name', 'str_products.catigory', 'str_products.unite', 'str_products.id as product_id', DB::raw('sum(sls_production_orders.quantity)  as `quantity`'))
                ->groupBy('product_name', 'product_id', 'str_products.unite', 'str_products.catigory')
                ->get();


            foreach ($data1 as $p) {
                $data = DB::table('sls_production_order_materials')
                    ->join('str_products', 'sls_production_order_materials.str_product_id',  'str_products.id')
                    ->join('sls_production_orders', 'sls_production_order_materials.sls_production_order_id',  'sls_production_orders.id')
                    ->whereDate('sls_production_orders.created_at', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                    ->whereDate('sls_production_orders.created_at', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                    ->where('sls_production_orders.str_product_id', $p->product_id)
                    ->select('str_products.name',   DB::raw('sum(sls_production_order_materials.quantity)  as `quantity`'))
                    ->groupBy('str_products.name')
                    ->get();
                $p->details = $data;
            }
            return $data1;
        } elseif (\request()->report_type == 'sales2') {

            $data1 = DB::table('sls_invoice_items')
                ->join('sls_invoices', 'sls_invoice_items.sls_invoice_id',  'sls_invoices.id')
                ->join('str_products', 'sls_invoice_items.str_product_id',  'str_products.id')
                ->whereDate('sls_invoices.date', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                ->whereDate('sls_invoices.date', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                ->whereIn('str_products.catigory', \request()->types)
                ->where('sls_invoices.mode', 'sales')
                ->select('str_products.name as product_name', 'str_products.catigory', 'str_products.unite', 'str_products.id as product_id', DB::raw('sum(sls_invoice_items.quantity)  as `quantity`'), DB::raw('sum(sls_invoice_items.total_price)  as `total_price`'))
                ->groupBy('product_name', 'product_id', 'str_products.unite', 'str_products.catigory')
                ->get();


            foreach ($data1 as $p) {
                $data = DB::table('sls_production_order_materials')
                    ->join('str_products', 'sls_production_order_materials.str_product_id',  'str_products.id')
                    ->join('sls_production_orders', 'sls_production_order_materials.sls_production_order_id',  'sls_production_orders.id')
                    ->whereDate('sls_production_orders.created_at', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                    ->whereDate('sls_production_orders.created_at', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                    ->where('sls_production_orders.str_product_id', $p->product_id)
                    ->select('str_products.name', 'str_products.unite_price',     DB::raw('sum(sls_production_order_materials.quantity)  as `quantity`'), DB::raw('sum(sls_production_order_materials.quantity) * str_products.unite_price  as `total_price`'))
                    ->groupBy('str_products.name', 'str_products.unite_price')
                    ->get();
                $p->details = $data;
                $p->total_cost = round($data->sum('total_price'), 2);
            }
            return $data1;
        } elseif (\request()->report_type == 'taxes') {



            $data =  SlsInvoice::select('id', 'mode', 'type', 'date', 'total_before_taxes', 'taxes_value')
                ->whereDate('date', '>=', date('Y-m-d', strtotime(\request()->start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->end_date)))
                ->get();
            return [
                'details' => $data,
                'total_break_purchases' => $data->where('mode', 'purchases')->where('type', 'break')->sum('total_before_taxes'),
                'total_concret_purchases' => $data->where('mode', 'purchases')->where('type', 'concret')->sum('total_before_taxes'),
                'total_purchases' => $data->where('mode', 'purchases')->sum('total_before_taxes'),
                'total_concret_purchases_taxes' => $data->where('mode', 'purchases')->where('type', 'concret')->sum('taxes_value'),
                'total_break_purchases_taxes' => $data->where('mode', 'purchases')->where('type', 'break')->sum('taxes_value'),
                'total_purchase_taxes' => $data->where('mode', 'purchases')->sum('taxes_value'),
                'total_concret_sales' => $data->where('mode', 'sales')->where('type', 'concret')->sum('total_before_taxes'),
                'total_break_sales' => $data->where('mode', 'sales')->where('type', 'break')->sum('total_before_taxes'),
                'total_sales' => $data->where('mode', 'sales')->sum('total_before_taxes'),
                'total_sales_taxes' => $data->where('mode', 'sales')->sum('taxes_value'),
                'total_concret_sales_taxes' => $data->where('mode', 'sales')->where('type', 'concret')->sum('taxes_value'),
                'total_break_sales_taxes' => $data->where('mode', 'sales')->where('type', 'break')->sum('taxes_value'),
            ];





            // ->select('str_product_id', DB::raw('sum(quantity)  as `quantity`'))->groupBy('str_product_id')
            // ->get();
        } elseif (\request()->report_type == 'review_test') {

            return Account::where('id', '>', 0)->get()->map->only('id', 'account_type', 'debtor2', 'creditor2', 'name', 'full_name', 'cascade_name', 'parent_id', 'balance'); //(['children' => function ($c) {

        }
    }
}
