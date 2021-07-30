<?php

namespace App\Http\Controllers\API\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Throwable;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();
        try {
            $brand=Brand::get();

                if($brand){
                    DB::commit();
                    return $brand;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'Brand'=>404
                   ]);
                 }

        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $brand= new Brand();
            $brand->name_ar=$request->name_ar;
            $brand->name_en=$request->name_en;
            $brand->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'Brand'=>200,
                'brandId'=>$brand->id
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::beginTransaction();
        try {

            $brand= Brand::where(['id'=>$id])->first();

            if($brand){
                DB::commit();
                return $brand;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'Brand'=>404
               ]);
             }
            
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $brand= Brand::where(['id'=>$id])->first();
            $brand->name_ar=$request->name_ar;
            $brand->name_en=$request->name_en;
            $brand->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'Brand'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $brand=Brand::where(['id'=>$id])->first();

            $brand->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'Brand'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
