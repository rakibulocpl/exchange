<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'=>'required',
            'phone'=>'required|unique:users',
            'email'=>'email|unique:users',
            'city'=>'required',
            'thana'=>'required',
            'gender'=>'required',
        ];
    }

    public function messages()
    {
        return [
                'phone.unique' => 'Phone Number Already exists',
                'email.unique' => 'Email Already Exists',
        ];
    }
}
