<?php

namespace App\Http\Controllers\API\Accounts_manage;

use App\Http\Controllers\Controller;
use App\Models\AccBond;
use App\Models\Bond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccBondController extends Controller
{
    public function index()
    {
        
        
        DB::beginTransaction();
        try {
            $res= AccBond::with('creditor_account:id,name', 'debtor_account:id,name')->get();
            if($res){
                return $res;
            }else{
              return \response()->json([
                  'data'=>'there is no data',
                  'status'=>404
              ]);
            }
              DB::commit();
          } catch (Throwable $err) {
              DB::rollback();
              return \response()->json($err, 500);
          }
  
       
    }

    public function store()
    {
        
      DB::beginTransaction();
      try {
          \request()->validate(
              [
                  'creditor_account_id' => 'different:debtor_account_id',
                  'debtor_account_id' => 'different:creditor_account_id',
              ]
          );
          $bond = AccBond::create(\request()->only('name', 'creditor_account_id', 'debtor_account_id', 'description', 'mode', 'value') + ['user_id' => auth()->id()]);
          return $bond->load('creditor_account:id,name', 'debtor_account:id,name');

          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function update(AccBond $accBond)
    {
        
      DB::beginTransaction();
      try {

          $accBond->update(\request()->only('name', 'creditor_account_id', 'debtor_account_id', 'description', 'mode', 'value'));
          return $accBond->load('creditor_account:id,name', 'debtor_account:id,name');
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function destroy(AccBond $accBond)
    {
      DB::beginTransaction();
      try {
        return  $accBond->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
