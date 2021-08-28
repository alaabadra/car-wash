<?php


namespace App\Http\Controllers\API\Equipment;

use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\AccTransaction;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class EquipmentController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {
            $res= Equipment::with('account:id')->get();
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

    public function show(Equipment $equipment)
    {
        DB::beginTransaction();
        try {

            $res= $equipment->load('account', 'account.details', 'driver', 'repaire_orders');
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
            request()->validate([
                'name' => 'required|unique:cars'
            ]);
            DB::beginTransaction();
            try {
                $equipment = Equipment::create(request()->except('parent_account_id', 'purchase_account_id'));
                $account_id = \request()->parent_account_id . '000' . $equipment->id;
                $equipment->account()->save(new Account(['user_id' => Auth::user()->id, 'id' => $account_id, 'parent_id' => \request()->parent_account_id, 'account_type' => 'sub', 'balance_type' => 'debtor', 'name' => $equipment->name]));
                $equipment->update(['account_id' => $account_id]);
                //add sale transaction
                $tr = AccTransaction::create(['type' => 'شراء اصول', 'date' => date('Y-m-d h:i:s'), 'user_id' => auth()->id()]);
                $tr->details()->create(['account_id' => \request()->purchase_account_id, 'creditor' => request()->purchase_price, 'description' => 'صرف قيمة الاصل']);
                $tr->details()->create(['account_id' => $account_id, 'debtor' => request()->purchase_price, 'description' => 'شراء']);
                DB::commit();
                return $equipment->load('account:id,balance');
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json($th->getMessage(), 404);
            }

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }


    public function update(Equipment $equipment)
    {
        DB::beginTransaction();
        try {

            request()->validate([
                'name' => 'required|unique:cars,name,' . $equipment->id
            ]);
            $equipment->update(request()->only('name', 'type', 'color',  'card_num', 'price', 'km', 'model', 'service_start_date', 'purchase_price', 'purchase_date', 'current_value', 'return_value', 'destruction_value', 'destruction_duration', 'destruction_end_date', 'last_destruction_date', 'default_driver_id'));
            $equipment->account->update(['name' => $equipment->name]);
            return $equipment;

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
    }
}
