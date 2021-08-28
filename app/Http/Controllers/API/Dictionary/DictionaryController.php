<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DictionaryController extends Controller
{
    public function index(){
        
      DB::beginTransaction();
      try {
        $lang=session('lang');
        if ($lang=='ar')
            $data=Dictionary::select('dic_id','name_ar')->pluck('name_ar','dic_id');
        else
            $data=Dictionary::select('dic_id','name')->pluck('name','dic_id');
        if($data){
            DB::commit();
            return $data;
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
}
