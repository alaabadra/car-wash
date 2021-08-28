<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Throwable;
class ClientController extends Controller
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
            $client=Client::get();

                if($client){
                    DB::commit();
                    return $client;
                 }else{
                   return \response()->json([
                       'data'=>'there is no data',
                       'Client'=>404
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

            $client= new Client();
            $client->name_ar=$request->name_ar;
            $client->name=$request->name;
            $client->phone=$request->phone;
            $client->status=$request->status;
            $client->save();
            DB::commit();
            return \response()->json([
                'message'=>'created successfully',
                'Client'=>200,
                'clientId'=> $client->id
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

            $client= Client::where(['id'=>$id])->first();

            if($client){
                DB::commit();
                return $client;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'Client'=>404
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

            $client= Client::where(['id'=>$id])->first();
            $client->name_ar=$request->name_ar;
            $client->name_en=$request->name_en;
            $client->save();
            DB::commit();
            return \response()->json([
                'message'=>'updated successfully',
                'Client'=>200
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
            $client=Client::where(['id'=>$id])->first();

            $client->delete();
            DB::commit();
            return \response()->json([
                'message'=>'deleted successfully',
                'Client'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
