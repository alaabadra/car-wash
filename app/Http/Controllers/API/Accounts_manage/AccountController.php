<?php


namespace App\Http\Controllers\API\Accounts_manage;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccountController extends Controller
{


    public function index()
    {
        
      DB::beginTransaction();
      try {
          $res= Account::where('id', '>', 0)->get()->map->only('id', 'cost_center', 'account_type', 'account_type', 'balance_type', 'final_account', 'debtor2', 'creditor2', 'name', 'full_name', 'cascade_name', 'parent_id', 'balance'); //(['children' => function ($c) {
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

    public function show(Account $account)
    {

        DB::beginTransaction();
        try {
            $res= $account->load(['parent:id,name', 'accounts', 'account_cost_centers', 'details' => function ($q) {
                $q->whereDate('created_at', '>=', date('Y-m-d', strtotime(\request()->date1)))->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->date2)));
            }, 'details.transaction']);
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

    public function mainIndex() //main accounts only
    {
        
      DB::beginTransaction();
      try {
          //todo:move this query to index function
          $res= Account::where('id', '>', 0)->where('account_type', 'main')->get();
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

    public function subIndex() //sub accounts only
    {
        
      DB::beginTransaction();
      try {
          //todo:move this query to index function
          $res= Account::where('id', '>', 0)->where('account_type', 'sub')->get();
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

            $item =  Account::create(request()->only('id', 'parent_id', 'name', 'account_type', 'cost_center', 'balance_type', 'fianl_account') + ['user_id' => auth()->id()]);
    
            if (\request()->accounts) {
                foreach (\request()->accounts as $account) {
                    $item->accounts()->attach($account['account_id'], ['percent' => $account['percent'], 'auto' => $account['auto']]);
                }
            }
    
            $item->children = [];
            $item->full_name = $item->id . ' || ' . $item->name; //return full name for page reactivity
            DB::commit();
            return $item;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Account $account)
    {
        
      DB::beginTransaction();
      try {

          if (\request()->has('add_cost_center')) {
              $account->cost_centers()->attach(\request()->id, ['percent' => \request()->percent, 'auto' => \request()->auto]);
              return $account;
          }
          if (\request()->has('add_account')) {
              $account->accounts()->attach(\request()->id, ['percent' => \request()->percent, 'auto' => \request()->auto]);
              return $account;
          }
    
          $account->update(\request()->only('id', 'name', 'account_type', 'balance_type', 'final_account'));
          DB::commit();
          return $account;
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }


    }

    public function destroy(Account $account)
    {
        DB::beginTransaction();
        try {

            if ($account->parent_id == 0) return;
            $account->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }


    }
}
