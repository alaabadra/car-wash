<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeLevel;
use App\Models\ManageEmployees\Department;
use App\Models\ManageEmployees\Designation;
use App\Models\ManageEmployees\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class Organization_structureController extends Controller
{
    public function getDesignations(){
            
    DB::beginTransaction();
    try {

        $design=Designation::get();

        DB::commit();
        if($design){
            return $design;
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

    public function getDepartments(){
            
    DB::beginTransaction();
    try {
        $depts=Department::all();

        DB::commit();
        if($depts){
            return $depts;
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

    public function getEmployments(){
        
      DB::beginTransaction();
      try {

          $emp_levs=Designation::where('type',2)->get();
          if(session('lang')=='ar')
              foreach($emp_levs as $emp_lev){
                  $emp_lev->name=$emp_lev->name_ar;
              }
            DB::commit();
         if($emp_levs){
            return $emp_levs;
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
    public function getEmplyeesLevels(){
        // dd(DB::table('employees_levels')->get());
        DB::beginTransaction();
        try {
  
            $emp_levs=EmployeeLevel::get();

              DB::commit();
           if($emp_levs){
              return $emp_levs;
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

    public function getEmployees(){
        DB::beginTransaction();
        try {

            $emps= Employee::all();
                foreach($emps as $emp){
                    if(session('lang')=='ar')
                        $emp->name_en=$emp->name;
                    else
                        $emp->name=$emp->name_en;
                }

            DB::commit();
            if($emps){
                return $emps;
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

    public function data_show($id,$type){
        DB::beginTransaction();
        try {

            if($type==2)
                $res= Department::find($id);
            else
                $res= Designation::find($id);
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

    public function get_month_days($month){
        DB::beginTransaction();
        try {

            $year=date("Y");
            if($month==2&&$year%4==0&&$year%100!=0)
                $res= 29;
            else if($month==2)
                $res= 28;
            else if($month==1||$month==3||$month==5||$month==7||$month==8||$month==10||$month==12)
                $res= 31;
            $res= 30;
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

    public function storeDesignation(Request $request){
        DB::beginTransaction();
        try {

                $designation=new Designation();
                $designation->name_designation=$request->name_designation;
                $designation->status_designation=$request->status_designation;
                $designation->description_designation=$request->description_designation;
                $designation->notes_designation=$request->notes_designation;
                $designation->type_designation=$request->type_designation;
                $designation->save();
                DB::commit();
                return \response()->json([
                    'data'=>'added successfully',
                    'status'=>200
                ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function storeDepartment(Request $request){
        DB::beginTransaction();
        try {

            
            
            
            $department=new Department();
            $department->name_department=$request->name_department;
            $department->status_department=$request->status_department;
            $department->description_department=$request->description_department;
            $department->notes_department=$request->notes_department;
            $department->type_department=$request->type_department;
            $department->save();
            DB::commit();
                return \response()->json([
                    'data'=>'added successfully',
                    'status'=>200
                ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function storeEmployeeLevel(Request $request){
        DB::beginTransaction();
        try {

            $employee_level=new EmployeeLevel();
            $employee_level->name_employee_level=$request->name_employee_level;
            $employee_level->status_employee_level=$request->status_employee_level;
            $employee_level->description_employee_level=$request->description_employee_level;
            $employee_level->notes_employee_level=$request->notes_employee_level;
            $employee_level->type_employee_level=$request->type_employee_level;
            $employee_level->save();
            DB::commit();
            return \response()->json([
                'data'=>'added successfully',
                'status'=>200
            ]);

               
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    
    public function updateDesignation(Request $request,$id){
        DB::beginTransaction();
        try {

            
            $designation=Designation::where(['id'=>$id])->first();

            $designation->name_designation=$request->name_designation;
            $designation->status_designation=$request->status_designation;
            $designation->description_designation=$request->description_designation;
            $designation->notes_designation=$request->notes_designation;
            $designation->type_designation=$request->type_designation;
            $designation->save();
            DB::commit();
            return \response()->json([
                'data'=>'added successfully',
                'status'=>200
            ]);
               
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function updateDepartment(Request $request,$id){
        DB::beginTransaction();
        try {

            $department=Department::where(['id'=>$id])->first();
            
            $department->name_department=$request->name_department;
            $department->status_department=$request->status_department;
            $department->description_department=$request->description_department;
            $department->notes_department=$request->notes_department;
            $department->type_department=$request->type_department;
            $department->save();
            DB::commit();
            return \response()->json([
                'data'=>'added successfully',
                'status'=>200
            ]);
               
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function updateEmployeeLevel(Request $request,$id){
        DB::beginTransaction();
        try {

            
            $employee_level=EmployeeLevel::where(['id'=>$id])->first();
            $employee_level->name_employee_level=$request->name_employee_level;
            $employee_level->status_employee_level=$request->status_employee_level;
            $employee_level->description_employee_level=$request->description_employee_level;
            $employee_level->notes_employee_level=$request->notes_employee_level;
            $employee_level->type_employee_level=$request->type_employee_level;
            $employee_level->save();
            DB::commit();
                return \response()->json([
                    'data'=>'added successfully',
                    'status'=>200
                ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }



    public function destroyDepartment($id){
        DB::beginTransaction();
        try {
                Department::find($id)->delete();

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function destroyDesignation($id){
        DB::beginTransaction();
        try {
                Designation::find($id)->delete();

            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function destroyEmployeeLevel($id){
        DB::beginTransaction();
        try {
            EmployeeLevel::find($id)->delete();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
