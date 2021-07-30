<?php

namespace App\Http\Controllers\API\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {

            $res= Store::all();
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

    public function show(Store $store)
    {
        DB::beginTransaction();
        try {
                if($store){
                    DB::commit();
                    return $store;
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
                'name' => 'required|unique:stores',
                'type' => 'required'
            ]);
    
            return Store::create(request()->only('id','name', 'type', 'notes','address') + ['user_id' => Auth::user()->id]);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy(Store $store)
    {
        DB::beginTransaction();
        try {

            if ($store->id < 2) return response()->json(['error' => 'لا يمكن حذف هذا المخزن'], 404);
            //       if($store->id==0) return response()->json(['error'=>'لا يمكن حذف هذا المخزن']);
            $store->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
