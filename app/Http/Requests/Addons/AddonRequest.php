<?php

namespace App\Http\Requests\Addons;

use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
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
        switch ($request['category']) {
            case '3':
                return [
                    'provider_id' => 'required',
                    'name' => 'required|min:3|max:50',
                    'cost_type_id' => 'required',
                    'cost' => 'required|numeric',
                    'order' => 'required|numeric',
                    'inclusion' => 'required',
                    'description' => 'required',
                    'script' => 'required',
                ];
                break;
            case '4':
                return [
                    'name' => 'required|min:3|max:50',
                    'connection_type' => 'required',
                    'order' => 'required|numeric',
                    'description' => 'required',
                ];
                break;
            case '5':
                return [
                    'name' => 'required|min:3|max:50',
                    'order' => 'required|numeric',
                    'description' => 'required',
                ];
                break;
        }
    }
}
