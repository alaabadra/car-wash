<?php

namespace App\Http\Controllers\API\WashingMachine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WashingMachine;
use Illuminate\Support\Facades\DB;
use Throwable;
class WashingMachineController extends Controller
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
            $WashingMachine=WashingMachine::get();

                if($WashingMachine){
                    DB::commit();
                    return $WashingMachine;
                 }else{
                   return \response()->json([
                       'message'=>'there is no data',
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
            if(!empty($request->model)&&!empty($request->name)&&!empty($request->purchase_date)&&!empty($request->store_management)&&!empty($request->cash_value)&&!empty($request->paid_up)&&!empty($request->residual_date)){

        DB::beginTransaction();
        try {

            $WashingMachine= new WashingMachine();
            $WashingMachine->name=$request->name;
            $WashingMachine->model=$request->model;
            $WashingMachine->brand=$request->brand;
            $WashingMachine->purchase_date=$request->purchase_date;
            $WashingMachine->store_management=$request->store_management;
            $WashingMachine->cash_value=$request->cash_value;
            $WashingMachine->paid_up=$request->paid_up;
            $WashingMachine->residual_date=$request->residual_date;
            $WashingMachine->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }else{
        return \response()->json([
            'message'=>'you cannot enter field is null',
            'status'=>400
        ]);

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
        if(!empty($id)){
            if(is_numeric($id)){
        DB::beginTransaction();
        try {

            $WashingMachine= WashingMachine::where(['id'=>$id])->first();

            if($WashingMachine){
                DB::commit();
                return $WashingMachine;
             }else{
               return \response()->json([
                   'message'=>'there is no data',
                   'status'=>404
               ]);
             }
            
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }else{
        return \response()->json([
            'message'=>'you must enter number for id for this element',
            'status'=>400
        ]);
    }
}else{
return \response()->json([
    'message'=>' this route not found  because you dont send id for this element',
    'status'=>404
]);
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
        if(!empty($request->model)&&!empty($request->name)&&!empty($request->purchase_date)&&!empty($request->store_management)&&!empty($request->cash_value)&&!empty($request->paid_up)&&!empty($request->residual_date)){

        DB::beginTransaction();
        try {

            $WashingMachine= WashingMachine::where(['id'=>$id])->first();
            $WashingMachine->name=$request->name;
            $WashingMachine->model=$request->model;
            $WashingMachine->brand=$request->brand;
            $WashingMachine->purchase_date=$request->purchase_date;
            $WashingMachine->store_management=$request->store_management;
            $WashingMachine->cash_value=$request->cash_value;
            $WashingMachine->paid_up=$request->paid_up;
            $WashingMachine->residual_date=$request->residual_date;
            $WashingMachine->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }else{
        return \response()->json([
            'message'=>'you cannot enter field is null',
            'status'=>400
        ]);

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
        if(!empty($id)){
            if(is_numeric($id)){
        DB::beginTransaction();
        try {
            $WashingMachine=WashingMachine::where(['id'=>$id])->first();

            $WashingMachine->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }else{
        return \response()->json([
            'message'=>'you must enter number for id for this element',
            'status'=>400
        ]);
    }
}else{
return \response()->json([
    'message'=>' this route not found  because you dont send id for this element',
    'status'=>404
]);
}
    }
}
