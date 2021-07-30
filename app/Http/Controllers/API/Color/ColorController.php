<?php

namespace App\Http\Controllers\API\Color;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Throwable;
class ColorController extends Controller
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
            $color=Color::get();

                if($color){
                    DB::commit();
                    return $color;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'Color'=>404
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

            $color= new Color();
            $color->name_ar=$request->name_ar;
            $color->name_en=$request->name_en;
            $color->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'Color'=>200,
                'colorId'=>$color->id
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
            $color= Color::where(['id'=>$id])->first();

            if($color){
                DB::commit();
                return $color;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'Color'=>404
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

            $color= Color::where(['id'=>$id])->first();
            $color->name_ar=$request->name_ar;
            $color->name_en=$request->name_en;
            $color->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'Color'=>200
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
            $color=Color::where(['id'=>$id])->first();

            $color->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'Color'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
