<?php

namespace App\Http\Controllers\API\Store;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\StrProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class StrProductController extends Controller
{
    public function index()
    {
        DB::beginTransaction();
        try {

            $res= StrProduct::all()->map->only('id', 'name', 'materials', 'full_name', 'catigory', 'type', 'alert_limit', 'unite', 'name_with_price', 'unite_price', 'custom_unites', 'balance');
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


    public function show(strProduct $strProduct)
    {
        DB::beginTransaction();
        try {

            $res= $strProduct->showFormat();
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


    public function store()
    {
        DB::beginTransaction();
        try {

            \request()->validate(['name' => Rule::unique('str_products')->where('type', \request()->type),]);
            $strProduct = StrProduct::create(\request()->only('name', 'catigory', 'alert_limit', 'type', 'description', 'unite', 'unite_parts', 'part_unite', 'custom_unites', 'unite_price'));
            if (\request()->type == 'product')  $strProduct->materials()->attach(\request()->materials);
            $res= $strProduct->only('id', 'name', 'full_name', 'catigory', 'type', 'unite', 'name_with_price', 'unite_price', 'custom_unites', 'balance');;
            DB::commit();
            return $res;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }


    public function update(strProduct $strProduct)
    {
        DB::beginTransaction();
        try {

            //return request();
            request()->validate([
                'name' => 'required|unique:str_products,name,' . $strProduct->id
            ]);
            $strProduct->update(request()->only('name', 'catigory', 'type', 'details', 'alert_limit',  'unite_price', 'custom_unites'));
    
            $ms = collect(\request()->materials)->map(function ($m) {
                return \collect($m)->only('str_material_id', 'ammount');
            });
    
            $strProduct->materials()->sync($ms);
            $res= $strProduct->only('id', 'name', 'full_name', 'catigory', 'type', 'unite', 'name_with_price', 'unite_price', 'custom_unites', 'balance');;
            DB::commit();
            return $res;
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy(strProduct $strProduct)
    {
        DB::beginTransaction();
        try {

            $strProduct->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
