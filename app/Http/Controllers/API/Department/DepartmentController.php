<?php


namespace App\Http\Controllers\API\Department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DepartmentController extends Controller
{
    public function index()
    {
        
      DB::beginTransaction();
      try {
          if (\request()->type == 'nationalities') return Department::where('parent_id', 9)->get()->pluck('name');
          $res= Department::where('id', '>', 0)->get();
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
          return \response()->json($err, 404);
      }

    }

    public function unitesIndex($id)
    {
      DB::beginTransaction();
      try {
          //todo:move this query to index function
          $res= Department::where('id', '>', 0)->where('parent_id', $id)->pluck('name');
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
          return \response()->json($err, 404);
      }

    }

    public function store()
    {
        
      DB::beginTransaction();
      try {

          return Department::create(\request()->only('id', 'parent_id', 'name', 'type'));
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function update(Department $department)
    {
        
      DB::beginTransaction();
      try {

          $department->update(\request()->only('name', 'type'));
          return $department;
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }

    public function destroy(Department $department)
    {
        
      DB::beginTransaction();
      try {

          $department->delete();
          DB::commit();
      } catch (Throwable $err) {
          DB::rollback();
          return \response()->json($err, 500);
      }

    }
}
