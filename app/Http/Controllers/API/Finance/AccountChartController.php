<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Account;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccountChartController extends Controller
{
    public function index(){
        DB::beginTransaction();
        try {

            $res = Account::all();
            // ->with('ancestors')
            // ->get()
            // ->toTree();
            DB::commit();
            if($res){
                return $res;
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

    public function store(Request $request){

        DB::beginTransaction();
        try {

            $user=DB::table('users')->pluck('id')->first();
            $dept = new Account;
            $dept->name=$request->name;
            $dept->name_ar=$request->name_ar;
            $dept->account_type=$request->account_type;
            $dept->balance_type=$request->balance_type;
            $dept->final_account=$request->final_account;
            $dept->accountable_type=$request->account_number;
            $dept->user_id=$user;
            if($request->parent_account && $request->parent_account !== 0) {
                $parent_account=Account::find($request->parent_account);
                $parent_account->appendNode($dept);
            }
            $dept->save();
            return response()->json(['success'=>'Setup saved successfully.'],200);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function get_full_path(){
        DB::beginTransaction();
        try {

            $lang=session('lang');
                if($lang=='ar'){//arabic
                    $name_lang='name_ar';
                }else{//english
                    $name_lang='name';
                }
            $depts=Account::all();
            $xx=[];
           // dd($depts);
            foreach($depts as $dept){
                $str='';
                if($dept->parent_id!=0){
                    $ids=explode('-',$dept->parent_id);
    
                    foreach($ids as $index=>$id){
                        $dept1=Account::where(['parent_id'=>$id])->first();
                        if($dept1!=null){
                            if($index==0)
                                $str.=$dept1->$name_lang;
                            else
                                $str.='/ '.$dept1->$name_lang;
                        }
                    }
                    if($str!='')
                        array_push($xx,[
                            'name'=>$str,
                            'parent_id'=>$dept1->parent_id,
                            'id'=>$dept1->id,
                        ]);
                }else{
                    $dept1=Account::where(['parent_id'=>$dept->parent_id])->first();
                    if($dept1!=null){
                        $str=$dept1->name;
                        array_push($xx,[
                            'name'=>$str,
                            'parent_id'=>$dept1->parent_id,
                            'id'=>$dept1->id,
                        ]);
                    }
                }
            }
            DB::commit();
            if($xx){
                return $xx;
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
