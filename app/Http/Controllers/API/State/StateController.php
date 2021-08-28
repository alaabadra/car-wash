<?php

namespace App\Http\Controllers\API\State;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Throwable;
class StateController extends Controller
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
            $State=State::get();

                if($State){
                    DB::commit();
                    return $State;
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
    
    public function getStatesCity($cityId){
        DB::beginTransaction();
        try {
            $statesCity=State::where(['city_id'=>$cityId])->get();

                if($statesCity){
                    DB::commit();
                    return $statesCity;
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

            $State= new State();
            $State->name_ar=$request->name_ar;
            $State->name=$request->name;
            $State->country_id=$request->country_id;
            $State->save();
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

            $State= State::where(['id'=>$id])->first();

            if($State){
                DB::commit();
                return $State;
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

            $State= State::where(['id'=>$id])->first();
            $State->name_ar=$request->name_ar;
            $State->name=$request->name;
            $State->country_id=$request->country_id;
            $State->save();
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
            $State=State::where(['id'=>$id])->first();

            $State->delete();
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
