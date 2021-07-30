<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'=>'required',
            'email'=>'required',
            'status'=>'required',
            'language'=>'required',
            'role'=>'required',
            'date_of_birth'=>'required',
            'country'=>'required',
            'join_date'=>'required',
            'branch'=>'required',
        ];
    }
}
