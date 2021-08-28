<?php

namespace App\Http\Controllers\API\Accounts_manage;

use App\Http\Controllers\Controller;
use App\Models\AccTransactionDetail;
use App\Models\AccRecevable;
use App\Models\AccTransaction;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccTransactionController extends Controller
{

    public function index()
    {
        
      DB::beginTransaction();
      try {
          $res= AccTransaction::whereDate('created_at', '>=', date('Y-m-d', strtotime(\request()->date1)))->whereDate('created_at', '<=', date('Y-m-d', strtotime(\request()->date2)))->get();
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

    public function show(AccTransaction $acc_transaction)
    {
        
      DB::beginTransaction();
      try {
          $res= $acc_transaction->showFormat();
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
            $transaction = AccTransaction::create(request()->only('type', 'date', 'notes', 'value') + ['user_id' => Auth::user()->id]);
            $transaction->details()->createMany(\request()->details);
            $transaction->activities()->save(new Activity(['user_id' => Auth::user()->id, 'type' => 'اضافة سند جديد ']));
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
        return $transaction;
    }

    public function destroy(AccTransaction $acc_transaction)
    {
        
      DB::beginTransaction();
      try {

          foreach ($acc_transaction->details as $detail) {
              $detail->delete();
          }
          $acc_transaction->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
