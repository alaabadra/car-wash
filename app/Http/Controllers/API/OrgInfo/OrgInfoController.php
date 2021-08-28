<?php

namespace App\Http\Controllers\API\OrgInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgInfo;
use Illuminate\Support\Facades\DB;
use Throwable;
class OrgInfoController extends Controller
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
            $OrgInfo=OrgInfo::get();

                if($OrgInfo){
                    DB::commit();
                    return $OrgInfo;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'OrgInfo'=>404
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

            $OrgInfo= new OrgInfo();
            $OrgInfo->name=$request->name;
            $OrgInfo->address=$request->address;
            $OrgInfo->logo=$request->logo;
            $OrgInfo->tax_number=$request->tax_number;
            $OrgInfo->contact_number1=$request->contact_number1;
            $OrgInfo->contact_number2=$request->contact_number2;
            $OrgInfo->sentence_below_bill=$request->sentence_below_bill;
            $OrgInfo->save();
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

            $OrgInfo= OrgInfo::where(['id'=>$id])->first();

            if($OrgInfo){
                DB::commit();
                return $OrgInfo;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'OrgInfo'=>404
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

            $OrgInfo= OrgInfo::where(['id'=>$id])->first();
            $OrgInfo->name=$request->name;
            $OrgInfo->address=$request->address;
            $OrgInfo->logo=$request->logo;
            $OrgInfo->tax_number=$request->tax_number;
            $OrgInfo->contact_number1=$request->contact_number1;
            $OrgInfo->contact_number2=$request->contact_number2;
            $OrgInfo->sentence_below_bill=$request->sentence_below_bill;
            $OrgInfo->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'OrgInfo'=>200
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
            $OrgInfo=OrgInfo::where(['id'=>$id])->first();

            $OrgInfo->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'OrgInfo'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
