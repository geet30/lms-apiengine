<?php

namespace App\Http\Requests\Affiliates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ManageUserRequest extends FormRequest
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

        if (isset($request['request_from']) && $request['request_from'] == 'providerFilter') {
            $rules = [
                'providerservice' => "bail|required",
                'providers' => "bail|required|array",
            ];
            return $rules;
        }

        if (isset($request['request_from']) && $request['request_from'] == 'distributorFilter') {
            $rules = [
                'distributorservice' => "bail|required",
                'distributors' => "bail|required|array",
            ];
            return $rules;
        }

        $rules = [
            'userservice' => "bail|required",
            'users' => "bail|required|array",
        ];

        return $rules;
    }

    public function messages()
    {
        $request = Request::all();
        if (isset($request['request_from']) && $request['request_from'] == 'providerFilter') {
            return [
                'providerservice.required' => trans('affiliates.providerservicerequired'),
                'providers.required' => trans('affiliates.providersrequired'),
            ];
        }

        if (isset($request['request_from']) && $request['request_from'] == 'distributorFilter') {
            return [
                'distributorservice.required' => trans('affiliates.distributorservicerequired'),
                'distributors.required' => trans('affiliates.distributorsrequired'),
            ];
        }

        return [
            'userservice.required' => trans('affiliates.userservicerequired'),
            'users.required' => trans('affiliates.usersrequired'),
        ];
    }
}
