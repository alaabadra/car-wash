<?php

namespace App\Http\Controllers\API\Accounts_manage;

use App\Http\Controllers\Controller;
use App\Models\AccCostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccCostCenterController extends Controller
{
    public function index()
    {
      DB::beginTransaction();
      try {
        $res=  AccCostCenter::withCount('accounts')->get();
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

    public function show(AccCostCenter $accCostCenter)
    {
        
      DB::beginTransaction();
      try {

          $res= $accCostCenter->showFormat();
          if($res){
            DB::commit();
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
        
      DB::beginTransaction();
      try {

          return AccCostCenter::create(\request()->only('name', 'type', 'notes') + ['user_id' => auth()->id()]);
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function update(AccCostCenter $accCostCenter)
    {
        
      DB::beginTransaction();
      try {

          if (\request()->has('add_account')) {
              $accCostCenter->accounts()->syncWithoutDetaching([\request()->account_id => ['percent' => \request()->percent,  'auto' => \request()->auto]]);
              return $accCostCenter->showFormat();
          } elseif (\request()->has('detach_account')) {
              $accCostCenter->accounts()->detach(\request()->account_id);
              return $accCostCenter->showFormat();
          }
    
          return $accCostCenter->update(\request()->only('name', 'type', 'notes') + ['user_id' => auth()->id()]);
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
