<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\AccBond;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{

    public function index()
    {
        DB::beginTransaction();
        try {
            $res= User::select('id', 'name', 'email', 'password2', 'employee_id')->with('roles:name')->get();
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
            request()->validate([
                'email' => 'required|email|unique:users',
            ]);
            $account_id1 = Account::where('parent_id', 1211)->max('id') + 1;
            $account_id2 = Account::where('parent_id', 1212)->max('id') + 1;
            if ($account_id1 == 1) $account_id1 = 12110001;
            if ($account_id2 == 1) $account_id2 = 12120001;
            $user = User::create(request()->only('name', 'email', 'password2', 'employee_id') + ['password' => bcrypt(request()->password2), 'bank_account_id' =>  $account_id1, 'cash_account_id' => $account_id2]);
            $user->update(['name' => $user->employee->name]);
            $user->roles()->sync(request()->roles);
            $user->accounts()->create(['id' =>  $account_id1, 'user_id' => 1, 'parent_id' => 1, 'account_type' => 'sub', 'name' => $user->name . ' بنك ', 'balance_type' => 'debtor']);
            $user->accounts()->create(['id' =>  $account_id2, 'user_id' => 1, 'parent_id' => 1, 'account_type' => 'sub', 'name' => $user->name . ' خزينة ', 'balance_type' => 'debtor']);
            DB::commit();
            return $user->load('roles:name');
        } catch (\Throwable $th) {
            DB::rollback();
            return \response()->json($th->getMessage(), 404);
        }
    }



    public function show(User $user)
    {
        DB::beginTransaction();
        try {

            $res= $user->load(['roles', 'employee', 'employee.person:id,name,address,telephone', 'cash_account:id', 'bank_account:id']);
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
            return \response()->json($err, 500);
        }


    }

    public function update(User $user)
    {
        DB::beginTransaction();
        try {

            if (\request()->has('update_account')) {
    
                $user->update(request()->only('email', 'password2', 'name') + ['password' => bcrypt(request()->password2)]);
                return $user->load('roles:name');
            }
    
            if (request()->has('add_permissions')) {
                $user->update(['perms' => request()->permissions]);
                return ['success' => 'Permissions updated '];
            }
            request()->validate([
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password2' => 'required|min:6',
            ]);
            $user->update(request()->only('email', 'password2', 'employee_id') + ['password' => bcrypt(request()->password2)]);
            $user->update(['name' => $user->employee->name]);
            $user->roles()->sync(request()->roles);
            $res= $user->load('roles:name');
            DB::commit();
            return $res;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }


    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {

            $user->delete();
            DB::commit();
            return ['success' => 'User was Deleted'];
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
