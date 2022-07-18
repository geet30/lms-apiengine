<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreVhaCodeRequest extends FormRequest
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
        $errors = [];
        if($this->request->get('provider_id')!= ''){
            $variant_id= decryptGdprData($this->request->get('variant_id'));
            $provider_id = $this->request->get('provider_id');
            $errors['vha_code']  = ['required',Rule::unique('provider_variants','vha_code')->where('provider_id',$provider_id)->whereNotIn('variant_id', [$variant_id])];
        }
        return $errors;
    }
}
