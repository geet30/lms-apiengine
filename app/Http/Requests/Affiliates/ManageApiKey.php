<?php

namespace App\Http\Requests\Affiliates;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
class ManageApiKey extends FormRequest
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

        $rules = [];
        $request = Request::all();
    
        $regex ="/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";

        $rules = [
            'name' => "bail|required|regex:/^(?!\d+$)(?:[a-zA-Z0-9][a-zA-Z0-9 !@#$&'()-`.+]*)?+$/|max:100",
            'page_url' => [
                'required', 'url','regex:'.$regex,self::checkUrl(),
             ],
            'origin_url' => 'required|url',

        ];
        return $rules;
    }
    public static function checkUrl(){
        return function($attribute, $value, $fail){
            if (Str::contains($value, 'http:')) {
            
                $fail(' The page url should be https.');
            }
                    
        };
    } 
    public function messages()
    {
        return [
            'name.required' => trans('affiliates.name'),
            'page_url.required' => trans('affiliates.page_url'),
            'page_url.url' => trans('affiliates.valid_url'),
            'origin_url.url' => trans('affiliates.origin_url'),

        ];
    }
}
