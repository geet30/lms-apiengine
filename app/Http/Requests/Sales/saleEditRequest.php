<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SaleProductsEnergy;
use Illuminate\Support\Facades\Request;
class saleEditRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $form_name = $this->request->get('form_name');
        $leadId = $this->request->get('leadId');
        $verticalId = $this->request->get('verticalId');
        $rules = [];
        switch ($form_name) {
            case 'stage_form':
                $rules['sale_source'] = 'required';
                $rules['sale_completed_by'] = 'required';
            break;
            case 'customer_journey_form':
                if($verticalId == 1){
                $leadCount = SaleProductsEnergy::where('lead_id', $leadId)->count();
                if ($leadCount == 2) {
                    $energy_type = 3;
                }
                if ($leadCount == 1) {
                    $energy_type = SaleProductsEnergy::where('lead_id', $leadId)->value('product_type');
                }
                $rules['move_in'] = 'required';
                $rules['life_support'] = 'required';
                $rules['medical_equipment_value'] = 'required_if:life_support,1';
                //$rules['credit_score'] = 'numeric|min:1|max:1000';
                if ($energy_type == 3) {
                    $rules['medical_equipment_energytype'] = 'required_if:life_support,1';
                }

                if ($energy_type == 3 || $energy_type == 1) {
                    $rules['solar'] = 'required';
                    $rules['solar_tarriff_type'] = 'required_if:solar,1';
                    $rules['elec_distributor'] = 'required';
                    $rules['elec_movin_date'] = 'required_if:move_in,1';
                    $rules['elec_provider'] = 'required_if:move_in,0';
                }

                if ($energy_type == 3 || $energy_type == 2) {
                    $rules['gas_distributor'] = 'required';
                    $rules['gas_provider'] = 'required_if:move_in,0';
                    $rules['gas_movin_date'] = 'required_if:move_in,1';
                }
                $rules['control_load_one_off_peak'] = 'nullable|numeric';
                $rules['control_load_one_shoulder'] = 'nullable|numeric';
                $rules['control_load_two_off_peak'] = 'nullable|numeric';
                $rules['control_load_two_shoulder'] = 'nullable|numeric';
                $rules['credit_score'] = 'nullable|numeric';
            }
                break;
                case 'connectioninfo_form':
                $rules['street_name'] = 'required';
                $rules['street_number'] = 'required';
                $rules['state'] = 'required';
                $rules['postcode'] = 'required';
                $rules['suburb'] = 'required';
                break;
                case 'billinginfo_form':
                    $rules['billing_address_option'] = 'required';
                    $billing_preference = $this->request->get('billing_address_option');
                    $email_welcome_pack= $this->request->get('email_welcome_pack');
                if(($billing_preference == 1 && $email_welcome_pack == 'on') || $billing_preference == 3){
                $rules['billing_street_name'] = 'required';
                $rules['billing_street_number'] = 'required';
                $rules['billing_state'] = 'required';
                $rules['billing_postcode'] = 'required';
                $rules['billing_suburb'] = 'required';
                }
                break;
                case 'deliveryinfo_form':
                    $rules['delivery_address_option'] = 'required';
                    $delivery_preference = $this->request->get('delivery_address_option');
                if($delivery_preference == 2){
                $rules['delivery_street_name'] = 'required';
                $rules['delivery_street_number'] = 'required';
                $rules['delivery_state'] = 'required';
                $rules['delivery_postcode'] = 'required';
                $rules['delivery_suburb'] = 'required';
                }
                break;
                case 'pobox_form':
                    $poBoxEnable = $this->request->get('enable_pobox');
                if($poBoxEnable == 'on'){
                $rules['address'] = 'required';
                $rules['state'] = 'required';
                $rules['postcode'] = 'required';
                $rules['suburb'] = 'required';
                }
                break;
                case 'gas_connection_form':
                    $gas_connection = $this->request->get('gas_connection');
                if($gas_connection == 1){
                    $rules['street_name'] = 'required';
                    $rules['street_number'] = 'required';
                    $rules['state'] = 'required';
                    $rules['postcode'] = 'required';
                    $rules['suburb'] = 'required';
                }
                break;
                case 'id_document_form':
                    $rules['document_type'] = 'required';
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'medical_equipment_value.required_if' => trans('Life support equipment required when life support is yes'),
            'medical_equipment_energytype.required_if' => trans('Life support Energy Type required when life support is yes'),
            'elec_movin_date.required_if' => trans('Electricity moving date required when Move In is yes'),
            'gas_movin_date.required_if' => trans('Gas moving date required when Move In is yes'),
            'solar_tarriff_type.required_if' => trans('Solar Options required when Solar Panel is yes'),
            'gas_distributor.required' => trans('Gas Distributor required'),
            'elec_distributor.required' => trans('Electricity Distributor required'),
            'elec_provider.required_if' => trans('Electricity provider required  when Move In is no'),
            'gas_provider.required_if' => trans('Gas provider required  when Move In is no'),
        ];
    }

}
