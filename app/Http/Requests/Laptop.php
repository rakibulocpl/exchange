<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Laptop extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model'=>'required',
            'brand'=>'required',
            'ram'=>'required',
            'ramstatus'=>'required',
            'processor'=>'required',
            'processorstatus'=>'required',
            'battery'=>'required',
            'storage'=>'required',
            'storagestatus'=>'required',
            'display'=>'required',
            'displaystatus'=>'required',
            'graphics'=>'required',
            'graphicsstatus'=>'required',
            'physicalstatus'=>'required',
            'laptoppower'=>'required',
            'frontimage'=>'required',
            'backimage'=>'required'
        ];
    }
}
