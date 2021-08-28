<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{

    public function index()
    {

        DB::beginTransaction();
        try {

            //todo:update query to support pagination
            return Customer::get();
            if (\request()->search) {
                return Customer::where('name', 'LIKE', '%' . request()->search . '%')->orWhere('id', 'LIKE', '%' . request()->search . '%')->with(['account', 'person:id,name'])->get();
            }
            if (\request()->find) {
                return Customer::find('id',  request()->find)->load(['account', 'person:id,name']);
            }
            return Customer::all()->map->only('id', 'account_id', 'name', 'type', 'balance');
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 404);
        }
    }

    public function show(Customer $customer)
    {

        DB::beginTransaction();
        try {
            $res= $customer->load(['account', 'person'])->append('balance');
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
            return \response()->json($err, 404);
        }
    }

    public function store()
    {
        request()->validate([
            'people_id' => 'required|unique:customers'
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::create(request()->all());
            //todo use account directions settings to select parent account for customer or supplier
            if (\request()->type == 'customer') {
                $account_id = Account::where('parent_id', 126)->max('id') + 1;
                if ($account_id == 1) $account_id = 1260001;
                $customer->account()->save(new Account(['id' =>  $account_id, 'user_id' => Auth::user()->id, 'parent_id' => 126, 'account_type' => 'sub', 'name' => $customer->person->name . ' (عميل) ', 'balance_type' => 'debtor']));
            } else {
                $account_id = Account::where('parent_id', 211)->max('id') + 1;
                if ($account_id == 1) $account_id = 2110001;
                $customer->account()->save(new Account(['id' => $account_id, 'user_id' => Auth::user()->id, 'parent_id' => 211, 'account_type' => 'sub', 'name' =>  $customer->person->name . '(مورد)', 'balance_type' => 'creditor']));
            }
            $customer->update(['name' => $customer->person->name, 'account_id' => $account_id]);
            DB::commit();
            return $customer->load(['account:id', 'person:id,name']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 500);
        }
    }



    public function update(Customer $customer)
    {
        
      DB::beginTransaction();
      try {

          request()->validate([
              'people_id' => 'required|unique:employees,people_id,' . $customer->id
          ]);
          $customer->update(request()->only('type', 'taxe_num', 'trade_num'));
          // if (!$customer->account)
          //     if ($customer->account->id != request()->account_id) {
          //         if ($customer->account->id) {
          //             $customer->account->update(['parent_id' => request()->account_id]);
          //         } else {
          //             $account = Account::find(request()->account_id);
          //             $id = $account->children->max('id') ? $account->children->max('id') + 1 : request()->account_id . '1';
          //             $customer->account()->save(new Account(['id' => $id, 'user_id' => Auth::user()->id, 'parent_id' => request()->account_id, 'account_type' => 'sub', 'name' => $customer->name, 'balance_type' => 'مدين']));
          //         }
          //     }
          return $customer->load(['account:id,parent_id', 'person:id,name']);
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }




    public function destroy(Customer $customer)
    {
        
      DB::beginTransaction();
      try {

          $customer->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
