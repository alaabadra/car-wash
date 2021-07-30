<?php


namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\SlsInvoice;
use App\Models\StrProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return [
            'year_sales' => SlsInvoice::whereIn('type', ['break_sales', 'concret_sales'])->select(DB::raw('sum(total_before_taxes)  as `value`'), DB::raw('sum(taxes_value) as `t_value`'), DB::raw("DATE_FORMAT(created_at,'%m-%Y') new_date"))->groupBy('new_date')->get(),
            'month_sales' => SlsInvoice::whereIn('type', ['break_sales', 'concret_sales'])->whereMonth('created_at', date('m'))->select(DB::raw('sum(total_before_taxes) as `value`'), DB::raw('sum(taxes_value) as `t_value`'), DB::raw("DATE_FORMAT(created_at,'%d-%m') new_date"))->groupBy('new_date')->get(),
            'year_purchases' => SlsInvoice::where('mode', 'purchases')->select(DB::raw('sum(total_before_taxes)  as `value`'), DB::raw('sum(taxes_value)  as `t_value`'), DB::raw("DATE_FORMAT(created_at,'%m-%Y') new_date"))->groupBy('new_date')->get(),
            'month_purchases' => SlsInvoice::where('mode', 'purchases')->whereMonth('created_at', date('m'))->select(DB::raw('sum(total_before_taxes) as `value`'), DB::raw('sum(taxes_value) as `t_value`'), DB::raw("DATE_FORMAT(created_at,'%d-%m') new_date"))->groupBy('new_date')->get(),
            'required_materials' => StrProduct::where('alert_limit', '>', 0)->where('type', 'material')->get()->map->only('id', 'name', 'balance', 'alert_limit')->filter(function ($f) {
                return $f['balance'] <= $f['alert_limit'];
            }),
            'required_products' => StrProduct::where('alert_limit', '>', 0)->where('type', 'product')->get()->map->only('id', 'name', 'balance', 'alert_limit')->filter(function ($f) {
                return $f['balance'] <= $f['alert_limit'];
            }),

        ];
    }
}
