<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\ManageEmployees\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use Throwable;

class ManageEmployeesController extends Controller
{
    public function index(){
            
        DB::beginTransaction();
        try {
            // $data=DB::table('employees')
            // ->leftJoin('departments','departments.id','employees.department')
            // ->select('employees.*','departments.name_department as dep_name')
            // ->get();
            $data=Employee::get();     
            DB::commit();
            if($data){
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



    public function employee_show($id){
            
        DB::beginTransaction();
        try {

            $res=DB::table('employees')
            ->leftJoin('departments','departments.id','employees.department')
            ->leftJoin('designations','designations.id','employees.designation')
            ->select('employees.*','departments.name as dep_name','designations.name as des_name')
            ->where('employees.id','=',$id)
            ->get();
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

        $fileNewName='';
       // if($request->emp_picture){
        //    $fileNewName="employee_".time().".jpg";
         //   $path='storage/employees/';
         //   Image::make($request->emp_picture)->save($path.$fileNewName);
       // }

     //   $this->saveData($request,$fileNewName);
     $emp=new Employee;

     $emp->name=$request->name;
     // $emp->name_en=$request->fist_name_en.' '.$request->sir_name_en.' '.$request->last_name_en;
     $emp->emp_picture=$request->emp_picture;
     $emp->notes=$request->notes;
     $emp->email=$request->email;
     $emp->status=$request->status;
     $emp->send_credentials=$request->send_credentials;
     $emp->allow_access=$request->allow_access;
     $emp->role=$request->role;
     $emp->date_of_birth=$request->date_of_birth;
     $emp->gender=$request->gender;
     $emp->country=$request->country;
     $emp->city=$request->city;
     $emp->state=$request->state;
     $emp->mobile_number=$request->mobile_number;
     $emp->designation_id=$request->designation;
     $emp->department_id=$request->department;
     $emp->emp_level=$request->emp_level;
     $emp->join_date=$request->join_date;
     $emp->branch=$request->branch;
     $emp->salary=$request->salary;
     $emp->save();
        DB::commit();
        return response()->json([
            'message'=>'added successfully',
            'status'=>200
        ]);
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    
    }
    }
    public function update(Request $request,$id){
            
        DB::beginTransaction();
        try {
    
            $fileNewName='';
           // if($request->emp_picture){
            //    $fileNewName="employee_".time().".jpg";
             //   $path='storage/employees/';
             //   Image::make($request->emp_picture)->save($path.$fileNewName);
           // }
    
         //   $this->saveData($request,$fileNewName);
         $emp=Employee::where(['id'=>$id])->first();
    
         $emp->name=$request->name;
         // $emp->name_en=$request->fist_name_en.' '.$request->sir_name_en.' '.$request->last_name_en;
         $emp->emp_picture=$request->emp_picture;
         $emp->notes=$request->notes;
         $emp->email=$request->email;
         $emp->status=$request->status;
         $emp->send_credentials=$request->send_credentials;
         $emp->allow_access=$request->allow_access;
         $emp->role=$request->role;
         $emp->date_of_birth=$request->date_of_birth;
         $emp->gender=$request->gender;
         $emp->country=$request->country;
         $emp->city=$request->city;
         $emp->state=$request->state;
         $emp->mobile_number=$request->mobile_number;
         $emp->designation_id=$request->designation;
         $emp->department_id=$request->department;
         $emp->emp_level=$request->emp_level;
         $emp->join_date=$request->join_date;
         $emp->branch=$request->branch;
         $emp->salary=$request->salary;
         $emp->save();
            DB::commit();
            return response()->json([
                'message'=>'updated successfully',
                'status'=>200
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        
        }
        }
    public function saveData($request,$fileNewName){
            
    DB::beginTransaction();
    try {

        DB::commit();
        if($request->id!=null)
            $emp=Employee::find($request->id);
        else
            $emp=new Employee;

        $emp->name=$request->name;
        // $emp->name_en=$request->fist_name_en.' '.$request->sir_name_en.' '.$request->last_name_en;
        $emp->emp_picture=$fileNewName;
        $emp->notes=$request->notes;
        $emp->email=$request->email;
        $emp->status=$request->status;
        $emp->send_credentials=$request->send_credentials;
        $emp->allow_access=$request->allow_access;
        $emp->language=$request->language;
        $emp->role=$request->role;
        $emp->date_of_birth=$request->date_of_birth;
        $emp->gender=$request->gender;
        $emp->country=$request->country;
        $emp->mobile_number=$request->mobile_number;
        $emp->present_address=$request->present_address;
        $emp->present_city=$request->present_city;
        $emp->present_state=$request->present_state;
        $emp->perm_address=$request->perm_address;
        $emp->perm_city=$request->perm_city;
        $emp->perm_state=$request->perm_state;
        $emp->designation_id=$request->designation;
        $emp->department_id=$request->department;
        $emp->emp_level=$request->emp_level;
        $emp->join_date=$request->join_date;
        $emp->branch=$request->branch;
        $emp->salary=$request->salary;
        $emp->attendance_shift=$request->attendance_shift;
        $emp->leave_policy=$request->leave_policy;
        $emp->holiday_lists=$request->holiday_lists;
        $emp->save();
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    
    }

    }

    public function show($id){
            
    DB::beginTransaction();
    try {

        $res= Employee::find($id);
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

    public function destroy($id){
            
    DB::beginTransaction();
    try {
        Employee::find($id)->delete();

        DB::commit();
    } catch (Throwable $err) {
        DB::rollback();
        return \response()->json($err, 500);
    
    }
    }
}
