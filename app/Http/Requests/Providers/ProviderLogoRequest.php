<?php

namespace App\Http\Requests\Providers;

use App\Models\LogoCategory;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Request;

class ProviderLogoRequest extends FormRequest
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
        $categoryId = $request['category_id'];
        $logoCategory = LogoCategory::where('id',$categoryId)->first();
        $rules = [];
        $rules['category_id'] = 'required';
        $rules['provider_id'] = 'required';
        if (isset($request['id']) && !empty($request['id'])) {
            if (isset($request['Logo']) && !empty($request['Logo'])) {
                $rules['Logo'] = 'bail|required|mimes:png,jpg|max:2000|dimensions:width='.$logoCategory->width.',height='.$logoCategory->height.'';    
            }
        } else {
            $rules['Logo'] = 'bail|required|mimes:png,jpg|max:2000|dimensions:width='.$logoCategory->width.',height='.$logoCategory->height.'';
        }
        return $rules;
    }

    public function messages()
    {
        $request = Request::all();
        $categoryId = $request['category_id'];
        $logoCategory = LogoCategory::where('id',$categoryId)->first();
        return [
            'Logo.required' => trans('affiliates.logo_required'),
            'Logo.max' => "Image size should not be more than 2 MB",
            'Logo.dimensions' => "Logo dimension must be of ".$logoCategory->width." * ".$logoCategory->height,
            'category_id.required' => 'Please select Category',
        ];
    }
}
