<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class EmployeeController extends Controller
{

  public function index()
  {
    
    DB::beginTransaction();
    try {
      
      //todo add pagination to this query
      $res= Employee::with(['account', 'person:id,name'])->get();
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

  public function show(Employee $employee)
  {
    
    DB::beginTransaction();
    try {

      $res= $employee->load('accounts', 'accounts.parent:id,name', 'person');
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

    DB::beginTransaction();
    try {

        DB::commit();
        request()->validate([
          'people_id' => 'required|unique:employees'
        ]);
    
        //save employee
        $employee = Employee::create(request()->all());
        $employee->update(['name' => $employee->person->name]);
        //add account to employee
        //todo:use account directions to direct employee accounts
        $account_id1 = Account::where('parent_id', 123)->max('id') + 1; //عهد
        $account_id2 = Account::where('parent_id', 124)->max('id') + 1; //زمة
        $account_id3 = Account::where('parent_id', 2125)->max('id') + 1; //مصروف مستحق
        if ($account_id1 == 1) $account_id1 = 1230001;
        if ($account_id2 == 1) $account_id2 = 1240001;
        if ($account_id3 == 1) $account_id3 = 21250001;
    
        $employee->accounts()->createMany([
          ['id' => $account_id1, 'user_id' => Auth::user()->id, 'parent_id' => 123, 'account_type' => 'sub', 'name' => $employee->person->name . ' (عهدة) ', 'balance_type' => 'creditor'],
          ['id' => $account_id2, 'user_id' => Auth::user()->id, 'parent_id' => 124, 'account_type' => 'sub', 'name' => $employee->person->name . ' (زمة) ', 'balance_type' => 'creditor'],
          ['id' => $account_id3, 'user_id' => Auth::user()->id, 'parent_id' => 1212, 'account_type' => 'sub', 'name' => $employee->person->name . ' (مصروف مستحق) ', 'balance_type' => 'creditor']
    
        ]);
        return $employee;
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    }

  }

  public function update(Employee $employee)
  {

    DB::beginTransaction();
    try {
      // if (\request()->has('reset_accounts')) {

      //   $employee->accounts()->updateOrCreate(['id' => 1230 . $employee->id], ['user_id' => Auth::user()->id, 'parent_id' => 123, 'account_type' => 'sub', 'name' => $employee->person->name . ' (عهدة) ', 'balance_type' => 'creditor']);
      //   $employee->accounts()->updateOrCreate(['id' => 1240 . $employee->id], ['user_id' => Auth::user()->id, 'parent_id' => 124, 'account_type' => 'sub', 'name' => $employee->person->name . ' (زمة) ', 'balance_type' => 'creditor']);
      //   $employee->accounts()->updateOrCreate(['id' => 21250 . $employee->id], ['user_id' => Auth::user()->id, 'parent_id' => 2125, 'account_type' => 'sub', 'name' => $employee->person->name . ' (مصروف مستحق) ', 'balance_type' => 'creditor']);
      //   return $employee->load('accounts', 'accounts.parent:id,name');
      // }
      $employee->update(request()->except('account', 'person'));
      $employee->update(['name' => $employee->person->name]); //to update name from person table can be deleted
      return $employee;
        DB::commit();
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    

  }
}






  public function destroy(Employee $employee)
  {
    
    DB::beginTransaction();
    try {

      if ($employee->id == 1000 || $employee->id == 1001) return response()->json(['error' => 'Error this record cannot ber deleted'], 404);
      $employee->delete();
        DB::commit();
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    
    }
  }
}
