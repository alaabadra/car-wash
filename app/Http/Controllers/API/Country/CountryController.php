<?php

namespace App\Http\Controllers\API\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Throwable;
class CountryController extends Controller
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
            $Country=Country::get();

                if($Country){
                    DB::commit();
                    return $Country;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'Country'=>404
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

            $Country= new Country();
            $Country->name_ar=$request->name_ar;
            $Country->name=$request->name;
            $Country->save();
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

            $Country= Country::where(['id'=>$id])->first();

            if($Country){
                DB::commit();
                return $Country;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'Country'=>404
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

            $Country= Country::where(['id'=>$id])->first();
            $Country->name_ar=$request->name_ar;
            $Country->name=$request->name;
            $Country->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'Country'=>200
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
            $Country=Country::where(['id'=>$id])->first();

            $Country->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'Country'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
