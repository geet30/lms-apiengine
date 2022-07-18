<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use App\Rules\Affiliates\UniqueIp;
use App\Rules\Affiliates\ValidIp;

class WhiteListIpRequest extends FormRequest
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
        $rules = [];
        if (strpos($request['ips'], ',') !== false) {
            $rules = [
                "ips" => ["required",new ValidIp($request),new UniqueIp($request)]
            ];
        }else{
            $rules = [
                "ips" => ["required","ip",new UniqueIp($request)]
            ];
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'ips.required' => trans('affiliates.whitelistiprequired'),
            'ips.ip'  => trans('affiliates.invalidwhitelistip')
        ];
    }
}
