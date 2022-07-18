<?php

namespace App\Http\Requests\MobileSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class PhoneFormRequest extends FormRequest
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
        $rules['form'] = ['required'];
        
        $request = Request::all();
        $id = decryptGdprData($this->phone_id);
        switch ($request['form']) {
            case 'phone_basic_details_form':
                $rules['name'] = ['bail', 'required', 'max:100', 'unique:handsets,name,'.$id];
                $rules['brand_id'] = ['required'];
                $rules['image'] = ['required','image'];
                if($id){
                    $rules['image'] = ['nullable','image'];
                }
                
                $rules['model'] = ['required'];
                break;
            case 'phone_network_form':
                $rules['technology'] = ['bail', 'required', 'max:100'];
                $rules['network_managebility'] = ['bail', 'required', 'max:1000'];
                $rules['extra_technology'] = ['bail', 'required', 'max:1000'];
                break;

            case 'phone_body_form':
                $rules['dimension'] = ['bail', 'required', 'max:100'];
                $rules['weight'] = ['bail', 'required', 'max:100'];
                $rules['sim_compatibility'] = ['bail', 'required', 'max:100'];
                break;
            case 'phone_screen_display_form':
                $rules['screen_type'] = ['bail', 'required', 'max:100'];
                $rules['screen_size'] = ['bail', 'required', 'max:100'];
                $rules['screen_resolution'] = ['bail', 'required', 'max:100'];
                break;
            case 'phone_os_form':
                $rules['os'] = ['bail', 'required'];
                $rules['version'] = ['bail', 'required', 'max:100'];
                $rules['chipset'] = ['bail', 'required', 'max:100'];
                break;

            case 'mobile_features_form':
                $rules['camera'] = ['bail', 'required','max:10000'];
                $rules['sensors'] = ['bail', 'required', 'max:10000'];
                $rules['technical_specs'] = ['bail', 'required', 'max:10000'];
                $rules['battery_info'] = ['bail', 'required', 'max:10000'];
                $rules['in_the_box'] = ['bail', 'required', 'max:10000'];
                break;
            case 'add_more_info_form':
                $rules['s_no'] = ['bail', 'required'];
                $rules['title'] = ['bail', 'required'];
                $rules['linktype'] = ['bail', 'required'];
                $rules['url'] = ['bail','nullable',"required_if:linktype,url",'active_url'];
                $rules['file'] = ["required_if:linktype,file","mimes:pdf"];
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => trans('handset.formPage.basicDetails.phone_name.errors.required'),
            'name.max' => trans('handset.formPage.basicDetails.phone_name.errors.max'),
            'brand_id.required' => trans('handset.formPage.basicDetails.phone_brand.errors.required'),
            'image.required' => trans('handset.formPage.basicDetails.image.errors.required'),
            'model.required' => trans('handset.formPage.basicDetails.phone_model.errors.required'),
            'technology.required' => trans('handset.formPage.specifications.network.technology.errors.required'),
            'technology.max' => trans('handset.formPage.specifications.network.technology.errors.max'),
            'network_managebility.required' => trans('handset.formPage.specifications.network.network_manageability.errors.required'),
            'network_managebility.max' => trans('handset.formPage.specifications.network.network_manageability.errors.max'),
            'extra_technology.required' => trans('handset.formPage.specifications.network.extra_technologies.errors.required'),
            'extra_technology.max' => trans('handset.formPage.specifications.network.extra_technologies.errors.max'),
            'dimension.required' => trans('handset.formPage.specifications.body.dimensions.errors.required'),
            'dimension.max' => trans('handset.formPage.specifications.body.dimensions.errors.max'),
            'weight.required' => trans('handset.formPage.specifications.body.weight.errors.required'),
            'weight.max' => trans('handset.formPage.specifications.body.weight.errors.max'),
            'sim_compatibility.required' => trans('handset.formPage.specifications.body.sim_compatibility.errors.required'),
            'sim_compatibility.max' => trans('handset.formPage.specifications.body.sim_compatibility.errors.max'),
            'screen_type.required' => trans('handset.formPage.specifications.screen_display.screen_type.errors.required'),
            'screen_type.max' => trans('handset.formPage.specifications.screen_display.screen_type.errors.max'),
            'screen_size.required' => trans('handset.formPage.specifications.screen_display.screen_size.errors.required'),
            'screen_size.max' => trans('handset.formPage.specifications.screen_display.screen_size.errors.max'),
            'screen_resolution.required' => trans('handset.formPage.specifications.screen_display.screen_resolution.errors.required'),
            'screen_resolution.max' => trans('handset.formPage.specifications.screen_display.screen_resolution.errors.max'),
            'os.required' => trans('handset.formPage.specifications.operating_system.operating_system.errors.required'),
            'version.required' => trans('handset.formPage.specifications.operating_system.version.errors.required'),
            'version.max' => trans('handset.formPage.specifications.operating_system.version.errors.max'),
            'chipset.required' => trans('handset.formPage.specifications.operating_system.chipset.errors.required'),
            'chipset.max' => trans('handset.formPage.specifications.operating_system.chipset.errors.max'),
            'camera.required' => trans('handset.formPage.feature.camera.errors.required'),
            'camera.max' => trans('handset.formPage.feature.camera.errors.max'),
            'sensors.required' => trans('handset.formPage.feature.sensor.errors.required'),
            'sensors.max' => trans('handset.formPage.feature.sensor.errors.max'),
            'technical_specs.required' => trans('handset.formPage.feature.technical_specs.errors.required'),
            'technical_specs.max' => trans('handset.formPage.feature.technical_specs.errors.max'),
            'battery_info.required' => trans('handset.formPage.feature.battery_info.errors.required'),
            'battery_info.max' => trans('handset.formPage.feature.battery_info.errors.max'),
            'in_the_box.required' => trans('handset.formPage.feature.in_the_box.errors.required'),
            'in_the_box.max' => trans('handset.formPage.feature.in_the_box.errors.max'),
            's_no.required' => trans('handset.formPage.more_info.s_no.errors.required'),
            'title.required' => trans('handset.formPage.more_info.title.errors.required'),
            'linktype.required' => trans('handset.formPage.more_info.linktype.errors.required'),
            'url.required_if' => trans('handset.formPage.more_info.url.errors.required'),
            'file.required_if' => trans('handset.formPage.more_info.file.errors.required'),
            'file.mimes' => trans('handset.formPage.more_info.file.errors.mimes'),
        ];
    }
}
