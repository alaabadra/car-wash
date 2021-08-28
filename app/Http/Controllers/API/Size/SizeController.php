<?php

namespace App\Http\Controllers\API\Size;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Throwable;
class SizeController extends Controller
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
            $size=Size::get();

                if($size){
                    DB::commit();
                    return $size;
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

            $size= new Size();
            $size->name_ar=$request->name_ar;
            $size->name_en=$request->name_en;
            $size->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'status'=>200,
                'sizeId'=>$size->id
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

            $size= Size::where(['id'=>$id])->first();

            if($size){
                DB::commit();
                return $size;
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

            $size= Size::where(['id'=>$id])->first();
            $size->name_ar=$request->name_ar;
            $size->name_en=$request->name_en;
            $size->save();
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
            $size=Size::where(['id'=>$id])->first();

            $size->delete();
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
