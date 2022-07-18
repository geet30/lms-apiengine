<?php

namespace App\Http\Requests\MobileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class VariantRequest extends FormRequest
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
       $input = Request::all();

        $rules = [
            'variant_name' => 'required',
            'ram' => 'required',
            'internal_storage' => 'required',
            'color' => 'required',
            's_no.*' => 'required',
            'img_type.*' => 'required',
        ];

        $sno= $this->request->get('s_no');
        $img= $this->request->get('sel_img');

        if (count($sno) > 0) {
            foreach($sno as $key => $val){
                $rules['s_no.'.$key] = ['required','integer','min:1'];
            }

        }

        //Please NOTE DOWN $sno in 1st loop it is required because when no image is uploaded then we will count number of rows by sno
        if ($img == '')
        {
            foreach($sno as $key => $val){
                $rules['sel_img.'.$key] = ['required','dimensions:max_width=auto,max_height=152'];
            }
        }
        else
        {
            foreach($img as $key => $val){
                $rules['sel_img.'.$key] = ['required','dimensions:max_width=auto,max_height=152'];
            }

        }
       
        return $rules;
    }

    public  function  attributes()
    {

        return ['img_type.*' => trans('variants.img_type_required'),
        ];

    }

    public function messages()
    {
        $message['variant_name.required'] = trans('variants.variant_name_required');
        $message['ram.required'] = trans('variants.ram_required');
        $message['internal_storage.required'] = trans('variants.internal_storage_required');
        $message['color.required'] = trans('variants.color_required');
        $message['sel_img.*.required'] = trans('variants.sel_img_required');
        $message['sel_img.*.dimensions'] = trans('variants.sel_img_dimensions');

        if(count($this->request->get('s_no')) > 0)
        {
            foreach($this->request->get('s_no') as $key => $val){
                $message['s_no.'.$key.'.required'] = trans('variants.s_no_required');
                $message['s_no.'.$key.'.min'] = trans('variants.s_no_min');
                $message['s_no.'.$key.'.integer'] = trans('variants.s_no_min');
            }
        }

        return $message;
    }
}
