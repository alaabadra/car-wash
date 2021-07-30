<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Throwable;
class CityController extends Controller
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
            $City=City::get();

                if($City){
                    DB::commit();
                    return $City;
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
    public function getCitiesCountry($countryId){
        DB::beginTransaction();
        try {
            $citiesCountry=city::where(['country_id'=>$countryId])->get();

                if($citiesCountry){
                    DB::commit();
                    return $citiesCountry;
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

            $City= new City();
            $City->name_ar=$request->name_ar;
            $City->name=$request->name;
            $City->country_id=$request->country_id;
            $City->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'status'=>200
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

            $City= City::where(['id'=>$id])->first();

            if($City){
                DB::commit();
                return $City;
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

            $City= City::where(['id'=>$id])->first();
            $City->name_ar=$request->name_ar;
            $City->name=$request->name;
            $City->country_id=$request->country_id;
            $City->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'status'=>200
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
            $City=City::where(['id'=>$id])->first();

            $City->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
