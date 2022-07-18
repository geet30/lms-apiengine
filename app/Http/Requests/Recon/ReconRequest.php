<?php

namespace App\Http\Requests\Recon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ReconRequest extends FormRequest
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
        $request = Request::all();
        $rules=[];
        $rules = [
            'status'=>'required',
            'id'=>'required',
            'permission'=>'required|array',
        ];
        return $rules;

    }

    public function messages()
    {
        return [
            'status.required' => trans('recon.statusrequired'),
            'permission.required' => trans('recon.permissionrequired'),
       ];
    }
}
