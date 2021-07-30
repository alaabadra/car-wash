<?php

namespace App\Http\Controllers\API\Person;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PersonController extends Controller
{


    public function index()
    {
        DB::beginTransaction();
        try {
            //return Person::all()->append('full_name');
            $res= Person::all();
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

    public function show(Person $person)
    {
        try {

            if($person){
                return $person;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'status'=>404
               ]);
             }
        } catch (Throwable $err) {
            return \response()->json($err, 500);
        }


    }

    public function store()
    {
        DB::beginTransaction();
        try {

            request()->validate([
                'name' => 'required',
                'national_id' => 'required|unique:people'
            ]);
            DB::beginTransaction();
            try {
                $person = Person::create(request()->except('image'));
                DB::commit();
                return $person->append('full_name');
            } catch (\Throwable $th) {
                DB::rollBack();
                return \response()->json($th->getMessage(), 404);
            }
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function update(Person $person)
    {
        DB::beginTransaction();
        try {

            request()->validate([
                'national_id' => 'unique:people,national_id,' . $person->id,
            ]);
            $img = '';
            if (request()->hasFile('image')) $img = request()->image->store('/person_progiles', ['disk' => 'public']);
            $person->update(request()->except('full_name', 'image'));
            if ($img) $person->update(['img' => $img]);
            return $person;
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }

    public function destroy(Person $person)
    {
        DB::beginTransaction();
        try {
            $person->delete();
            return ['success' => 'Person was deleted'];
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
}
