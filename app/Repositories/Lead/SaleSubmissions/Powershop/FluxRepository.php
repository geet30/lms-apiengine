<?php
namespace App\Repositories\Lead\SaleSubmissions\Powershop;

use App\Models\{
    Lead,
    SaleProductsEnergy
};
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use App\Traits\SaleSubmission\CommonGuzzelTrait;
class FluxRepository
{
    use CommonGuzzelTrait;
    public function getFluxData($sale_id, $energy_type = null, $type = null, $groupDetails)
    {   
        if ($energy_type == 3) { 
            $sale = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
            $gasSale = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null; 
        } else { 
            $sale = isset($groupDetails[$energy_type][0]) ? $groupDetails[$energy_type][0] : null;
        } 

        $data = array();
        $elec_cost = rand(300, 400);
        $gas_cost = (30 / 100) * $elec_cost;

        $createdDateArr = explode('/', $sale->vie_qa_notes_created_date);
        if (count($createdDateArr) == 3) {
            $createdDate = Carbon::createFromDate($createdDateArr[2],$createdDateArr[1],$createdDateArr[0], config('app.timezone'))->toIso8601String();
        } else {
            $createdDate = \Carbon\Carbon::parse($sale->l_sale_created)->toIso8601String();
        }
         
        $data['sale_id'] = $sale_id;
        $data['type'] = $type;
        $data['account_setup']['account_type'] = $sale->journey_property_type;
        $data['account_holder']['title'] = $sale->v_title;
        $data['account_holder']['first_name'] = decryptGdprData($sale->v_first_name);
        $data['account_holder']['last_name'] = decryptGdprData($sale->v_last_name);
        $data['account_holder']['date_of_birth'] = decryptGdprData($sale->v_phone);
        $data['account_holder']['phone_number'] = decryptGdprData($sale->v_dob);
        $data['login']['email'] = decryptGdprData($sale->v_email);

        //Property type = Business
        if ($sale->journey_property_type == '2') {
            $data['business_details​']['name'] = $sale->vbd_business_legal_name;
            $data['business_details​']['registered_business_number​'] = $sale->vbd_business_abn;
            $data['business_details​']['anzsic_code​'] = isset($sale->vbd_anzsic) ? $sale->vbd_anzsic : '';
            $data['business_details​']['phone_number'] = decryptGdprData($sale->v_phone);
            $data['business_details​']['is_tax_registered​'] = true;
        }
        $data['property_information']['current_situation'] = "existing";

        if ($sale->journey_moving_house == 1)
            $data['property_information']['current_situation'] = "moving";

        $flat_number = "";
        if ($sale->va_unit_no != null)
            $flat_number = $sale->va_unit_no;

        $flat_type = "";
        if ($sale->va_unit_no != null)
            $flat_type = $sale->va_unit_type_code;

        $floor_number = "";
        if ($sale->va_unit_no != null)
            $floor_number = $sale->va_floor_no;

        $floor_type = "";
        if ($sale->va_unit_no != null)
            $floor_type = $sale->va_floor_type_code;

        $data['property_information']['supply_address']['house_number_suffix'] = $sale->va_house_number_suffix;
        $data['property_information']['supply_address']['flat_number'] = $flat_number; //
        $data['property_information']['supply_address']['flat_type'] = $flat_type;
        $data['property_information']['supply_address']['floor_number'] = $floor_number;
        $data['property_information']['supply_address']['floor_type'] = $floor_type;
        $data['property_information']['supply_address']['house_number'] = '';

        if (!empty($sale->va_house_num)) {
            $data['property_information']['supply_address']['house_number'] = $sale->va_house_num;
        } else {
            if (!empty($sale->va_street_number)) {
                $data['property_information']['supply_address']['house_number'] = $sale->va_street_number;
            }
        }
        $data['property_information']['supply_address']['street_name'] = $sale->va_street_name;
        $data['property_information']['supply_address']['street_type'] = strtoupper($sale->va_street_code);

        $data['property_information']['supply_address']['street_suffix​'] = $sale->va_street_suffix;
        $data['property_information']['supply_address']['postcode'] = $sale->va_postcode;
        $data['property_information']['supply_address']['suburb'] = $sale->va_suburb;
        $data['property_information']['supply_address']['region'] = $sale->va_state;

        $addressDetails = DB::table('visitor_addresses')->whereIn('id', [  $sale->l_billing_address_id, $sale->l_billing_po_box_id])->get();
        if (isset($addressDetails)) {
            foreach ($addressDetails as $addressDetail) { 
                if (isset($sale->l_billing_address_id) && $sale->l_billing_address_id == $addressDetail->id) {
                    $billingAddress = $addressDetail;
                }
                if (isset($sale->l_billing_po_box_id) && $sale->l_billing_po_box_id == $addressDetail->id) {
                    $poBoxAddress = $addressDetail;
                }
            }
        } 
        
        if ($sale->l_billing_preference == 1) { 
            if ($sale->l_email_welcome_pack == 1) {
                //visitor_email_welcome_address
                $flat_number = "";
                if ($billingAddress->unit_number != null)
                    $flat_number = $billingAddress->unit_number;

                $flat_type = "";
                if ($billingAddress->unit_type_code != null)
                    $flat_type = $billingAddress->unit_type_code;

                $floor_number = "";
                if ($billingAddress->floor_number != null)
                    $floor_number = $billingAddress->floor_number;

                $floor_type = "";
                if ($billingAddress->floor_type_code != null)
                    $floor_type = $billingAddress->floor_type_code;


                $data['property_information']['postal_address']['flat_number'] = $flat_number; //
                $data['property_information']['postal_address']['flat_type'] = $flat_type;
                $data['property_information']['postal_address']['floor_number'] = $floor_number;
                $data['property_information']['postal_address']['floor_type'] = $floor_type;
                $data['property_information']['postal_address']['house_number'] = '';
                if (!empty($leads[0]['visitor_email_welcome_address']['house_num'])) {
                    $data['property_information']['postal_address']['house_number'] = $billingAddress->house_num;
                } else {
                    if (!empty($billingAddress->street_number)) {
                        $data['property_information']['postal_address']['house_number'] = $billingAddress->street_number;
                    }
                }

                $data['property_information']['postal_address']['house_number_suffix'] = $billingAddress->house_number_suffix;
                $data['property_information']['postal_address']['street_name'] = $billingAddress->street_name;
                $data['property_information']['postal_address']['street_type'] = strtoupper($billingAddress->street_code);
                $data['property_information']['postal_address']['postcode'] = $billingAddress->postcode;
                $data['property_information']['postal_address']['suburb'] = $billingAddress->suburb;
                $data['property_information']['postal_address']['region'] = $billingAddress->state;
            } else {
                //visitor_connection_address

                $flat_number = "";
                if ($sale->va_unit_no != null)
                    $flat_number = $sale->va_unit_no;

                $flat_type = "";
                if ($sale->va_unit_type_code != null)
                    $flat_type = $sale->va_unit_type_code;

                $floor_number = "";
                if ($sale->va_floor_no != null)
                    $floor_number = $sale->va_floor_no;

                $floor_type = "";
                if ($sale->va_floor_type_code != null)
                    $floor_type = $sale->va_floor_type_code;


                $data['property_information']['postal_address']['flat_number'] = $flat_number; //
                $data['property_information']['postal_address']['flat_type'] = $flat_type;
                $data['property_information']['postal_address']['floor_number'] = $floor_number;
                $data['property_information']['postal_address']['floor_type'] = $floor_type;
                $data['property_information']['postal_address']['house_number'] = '';

                if (!empty($sale->va_house_num)) {
                    $data['property_information']['postal_address']['house_number'] = $sale->va_house_num;
                } else {
                    if (!empty($sale->va_street_number)) {
                        $data['property_information']['postal_address']['house_number'] = $sale->va_street_number;
                    }
                }
                $data['property_information']['postal_address']['house_number_suffix'] = $sale->va_house_number_suffix;
                $data['property_information']['postal_address']['street_name'] = $sale->va_street_name;
                $data['property_information']['postal_address']['street_type'] = strtoupper($sale->va_street_code);
                $data['property_information']['postal_address']['postcode'] = $sale->va_postcode;
                $data['property_information']['postal_address']['suburb'] = $sale->va_suburb;
                $data['property_information']['postal_address']['region'] = $sale->va_state;
            }
        } else {
            if ($sale->l_billing_preference == 3) { 
                $flat_number = "";
                if ($billingAddress->unit_number != null)
                    $flat_number = $billingAddress->unit_number;

                $flat_type = "";
                if ($billingAddress->unit_type_code != null)
                    $flat_type = $billingAddress->unit_type_code;

                $floor_number = "";
                if ($billingAddress->floor_number != null)
                    $floor_number = $billingAddress->floor_number;

                $floor_type = "";
                if ($billingAddress->floor_type_code != null)
                    $floor_type = $billingAddress->floor_type_code;

                $data['property_information']['postal_address']['flat_number'] = $flat_number; //
                $data['property_information']['postal_address']['flat_type'] = $flat_type;
                $data['property_information']['postal_address']['floor_number'] = $floor_number;
                $data['property_information']['postal_address']['floor_type'] = $floor_type;
                $data['property_information']['postal_address']['house_number'] =  '';
                if (!empty($billingAddress->house_num)) {
                    $data['property_information']['postal_address']['house_number'] = $billingAddress->house_num;
                } else {
                    if (!empty($leads[0]['visitor_billing_address']['street_number'])) {
                        $data['property_information']['postal_address']['house_number'] = $billingAddress->street_number;
                    }
                }
                $data['property_information']['postal_address']['house_number_suffix'] = $billingAddress->house_number_suffix;
                $data['property_information']['postal_address']['street_name'] = $billingAddress->street_name;
                $data['property_information']['postal_address']['street_type'] = strtoupper($billingAddress->street_code);
                $data['property_information']['postal_address']['postcode'] = $billingAddress->postcode;
                $data['property_information']['postal_address']['suburb'] = $billingAddress->suburb;
                $data['property_information']['postal_address']['region'] = $billingAddress->state;
            } else {
                //billing preference = connection address
                //visitor_connection_address 
                $flat_number = "";
                if ($sale->va_unit_no != null)
                    $flat_number = $sale->va_unit_no;

                $flat_type = "";
                if ($sale->va_unit_type_code != null)
                    $flat_type = $sale->va_unit_type_code;

                $floor_number = "";
                if ($sale->va_floor_no != null)
                    $floor_number = $sale->va_floor_no;

                $floor_type = "";
                if ($sale->va_floor_type_code != null)
                    $floor_type = $sale->va_floor_type_code;

                $data['property_information']['postal_address']['flat_number'] = $flat_number; //
                $data['property_information']['postal_address']['flat_type'] = $flat_type;
                $data['property_information']['postal_address']['floor_number'] = $floor_number;
                $data['property_information']['postal_address']['floor_type'] = $floor_type;

                $data['property_information']['postal_address']['flat_number'] = $sale->va_unit_no;
                $data['property_information']['postal_address']['flat_type'] = $sale->va_unit_type_code;
                $data['property_information']['postal_address']['floor_number'] = $sale->va_floor_no;
                $data['property_information']['postal_address']['floor_type'] = $sale->va_floor_type_code;

                $data['property_information']['postal_address']['house_number'] =  '';

                if (!empty($sale->va_house_num)) {
                    $data['property_information']['postal_address']['house_number'] = $sale->va_house_num;
                } else {
                    if (!empty($sale->va_street_number)) {
                        $data['property_information']['postal_address']['house_number'] = $sale->va_street_number;
                    }
                }

                $data['property_information']['postal_address']['house_number_suffix'] = $sale->va_house_number_suffix;
                $data['property_information']['postal_address']['street_name'] = $sale->va_street_name;
                $data['property_information']['postal_address']['street_type'] = strtoupper($sale->va_street_code);
                $data['property_information']['postal_address']['postcode'] = $sale->va_postcode;
                $data['property_information']['postal_address']['suburb'] = $sale->va_suburb;
                $data['property_information']['postal_address']['region'] = $sale->va_state;
            }
        }
 
        //======= Utility details = energy type 
        $meterElecNotes​ = $meterGasNotes​ = '';
        if ($sale && $sale->vie_meter_number_e) {
            $meterElecNotes​ = $sale->vie_meter_number_e;
        }

        if (isset($gasSale) && $gasSale->vie_meter_number_g) {
            $meterGasNotes​ = $gasSale->vie_meter_number_g;
        }

        if ($sale->journey_energy_type == '1') {
            $data['utility_details'][0]['meter_details​']['meter_location_notes​'] = $meterElecNotes​;
        } else {
            $data['utility_details'][0]['meter_details​']['meter_location_notes​'] = $meterGasNotes​;
        }

        $current_supplier​ = '';
        //If movin no set current supplier       
        if ($sale->journey_moving_house != 1) {
            $current_supplier​ = $sale->journey_previous_provider_id;
            if ($sale->journey_previous_provider_id== null)
                $current_supplier​ = '';
        }
 

        $proposed_start_date​ = "";
        if ($sale->journey_moving_house == 1)
        {
            $proposed_start_date​ = str_replace('/', '-', $sale->journey_moving_date);
            $proposed_start_date​ = date("Y-m-d", strtotime($proposed_start_date​));
        }

        $connection_number​ = '';
        if ($sale->journey_energy_type == 2)
            $connection_number​ = $sale->vie_dpi_mirn_number;
        else
            $connection_number​ = $sale->vie_nmi_number;


        $data['utility_details'][0]['utility_type'] = $sale->journey_energy_type;

        $data['utility_details'][0]['connection_number​'] = $connection_number​;

        $data['utility_details'][0]['current_supplier​'] = $current_supplier​;
        $data['utility_details'][0]['proposed_start_date​'] = $proposed_start_date​;
        
        //estimated billing should be according to energy type
        if ($sale->journey_energy_type == 2)
            $data['utility_details'][0]['estimated_billing']['cost'] = round($gas_cost);
        else
            $data['utility_details'][0]['estimated_billing']['cost'] = $elec_cost;

        $data['utility_details'][0]['estimated_billing']['period'] = strtolower($sale->plan_billing_options);

        /** Promotion Code **/
        if (config('app.flux_promotion')) {
            if(isset($sale))
            {
                if($sale->journey_energy_type == 1)
                {
                    $data['utility_details'][0]['promotion​']['promotion_code​'] = $sale->plan_offer_code??config('app.flux_elec_promotion');
                }
                else
                {
                    $data['utility_details'][0]['promotion​']['promotion_code​'] = $sale->plan_offer_code??config('app.flux_gas_promotion');
                }
            }
            $data['utility_details'][0]['promotion​']['promotion_terms_and_conditions_accepted_at​'] = $createdDate;
            if(isset($gasSale))
            {
                $data['utility_details'][1]['promotion​']['promotion_code​'] = $gasSale->plan_offer_code??config('app.flux_gas_promotion');
                $data['utility_details'][1]['promotion​']['promotion_terms_and_conditions_accepted_at​'] = $createdDate;
            }
             
        }
        /** End Promotion Code **/
        
        if (count($groupDetails) > 1) {

            if ($sale->ebd_current_provider_id == $gasSale->ebd_current_provider_id && $sale->ebd_current_provider_id == 8) {

                if ($gasSale->journey_energy_type == '1') {
                    $data['utility_details'][1]['meter_details​']['meter_location_notes​'] = $meterElecNotes​;
                } else {
                    $data['utility_details'][1]['meter_details​']['meter_location_notes​'] = $meterGasNotes​;
                }

                $current_supplier_gas​ = '';
                //If movin no set current supplier       
                if ($gasSale->journey_moving_date != 1) {
                    $current_supplier_gas​ = $sale->journey_previous_provider_id;
                    if ($sale->journey_previous_provider_id == null)
                        $current_supplier_gas​ = '';
                } 

                $connection_number​ = '';
                if ($gasSale->journey_energy_type == '2')
                    $connection_number​ = $sale->vie_dpi_mirn_number;
                else
                    $connection_number​ = $sale->vie_nmi_number;

                $data['utility_details'][1]['utility_type'] = $gasSale->journey_energy_type;

                $data['utility_details'][1]['connection_number​'] = $connection_number​;

                $data['utility_details'][1]['current_supplier​'] = $current_supplier_gas​;
                $data['utility_details'][1]['proposed_start_date​'] = $proposed_start_date​;


                //estimated billing should be according to energy type
                if ($gasSale->journey_energy_type == '2')
                    $data['utility_details'][1]['estimated_billing']['cost'] = round($gas_cost);
                else
                    $data['utility_details'][1]['estimated_billing']['cost'] = $elec_cost;


                $data['utility_details'][1]['estimated_billing']['period'] = strtolower($sale->plan_billing_options);
            }
        }
 
        if ($sale->journey_life_support == 1){
            $medical_reason = '';
            if (isset($sale->vie_life_support_notes)) {
                $medical_reason = $sale->vie_life_support_notes;
                if ($sale->vie_life_support_notes == null) {
                    $medical_reason = '';
                }
            }

            $data['vulnerabilities']['dependency_type'] = "Life Support";
            $data['vulnerabilities']['medical_reason'] = $medical_reason;
            $data['vulnerabilities']['medical_details_disclaimer_accepted_at'] = date(DATE_ISO8601, strtotime($sale->l_sale_created));
        } 

        if (isset($sale->vdi_card_type)) {

            if ($sale->vdi_type == 1) {

                if (strlen($sale->vdi_exp_month) > 1) {
                    $exp_month_ = $sale->vdi_exp_month;
                } else {
                    $exp_month_ = '0' . $sale->vdi_exp_month;
                }

                if ($sale->vdi_card_type == 'Master Card' || $sale->vdi_card_type == 'master card' || $sale->vdi_card_type == 'master card') {
                    $sale->vdi_card_type = 'mastercard';
                }
                if ($sale->vdi_card_type == 'American Express') {
                    $sale->vdi_card_type = 'amex';
                }
 
                $masked_card_no = substr($sale->vdi_card_number, -4);
                if (($sale->vdi_card_number == '' || !$sale->vdi_card_number) && $sale->vdi_last_four) {
                    $masked_card_no = $sale->vdi_last_four;
                }

                $data['payment_details']['card'] = [
                    'card_type' => strtolower($sale->vdi_card_type),
                    'masked_card_number​' => "**** **** **** " . $masked_card_no,
                    'expiry_date​' => $exp_month_ . $sale->vdi_exp_year,
                    'cardholder_name' => $sale->vdi_name_on_card,
                    'token' => $sale->vie_token,
                    'terms_and_conditions_accepted_at​' => $createdDate,
                    'preferred' => true,
                ];
            } else {
                $data['payment_details​']['direct_debit​'] = [
                    'account_name​' => $sale->vdi_name_on_card,
                    'bank_number​' => substr($sale->bsb, 0, 3),
                    'branch_number​' => substr($sale->bsb, -3),
                    'account_number​' =>  $sale->vdi_account_number,
                    'terms_and_conditions_accepted_at​' => $createdDate,
                ];
            }

            if (count($groupDetails) > 1) {
                if ($gasSale->journey_current_provider_id == $gasSale->journey_current_provider_id && $gasSale->journey_current_provider_id == 8) {

                    if ($gasSale->vdi_type == 1) {

                        if (strlen($gasSale->vdi_exp_month) > 1) {
                            $exp_month_ = $gasSale->vdi_exp_month;
                        }else {
                            $exp_month_ = $gasSale->vdi_exp_month;
                        }

                        if ($gasSale->vdi_card_type == 'Master Card' || $gasSale->vdi_card_type == 'master card' || $gasSale->vdi_card_type == 'master card') {

                            $gasSale->vdi_card_type = 'mastercard';
                        }

                        if ($gasSale->vdi_card_type == 'American Express') {

                            $gasSale->vdi_card_type = 'amex';
                        }
 
                        $masked_card_no = substr($gasSale->vdi_card_number, -4);
                        if (($gasSale->vdi_card_number == '' || !$gasSale->vdi_card_number) && $gasSale->vdi_last_four) {
                            $masked_card_no = $gasSale->vdi_last_four;
                        }
                        
                        $data['payment_details']['card'] = [
                            'card_type' => strtolower($gasSale->vdi_card_type),
                            'masked_card_number​' => "**** **** **** " . $masked_card_no,
                            'expiry_date​' => $exp_month_ . $gasSale->vdi_exp_year,
                            'cardholder_name' => $gasSale->vdi_name_on_card,
                            'token' => $gasSale->vie_token,
                            'terms_and_conditions_accepted_at​' => $createdDate,
                            'preferred' => true,
                        ];
                    } else {
                        $data['payment_details​']['direct_debit​'] = [
                            'account_name​' => $gasSale->vdi_name_on_card,
                            'bank_number​' => substr($gasSale->bsb, 0, 3),
                            'branch_number​' => substr($gasSale->bsb, -3),
                            'account_number​' =>  $gasSale->vdi_account_number,
                            'terms_and_conditions_accepted_at​' => $createdDate,
                        ]; 
                    }
                }
            }
        } 
        if (isset($sale->vcd_concession_type) && $sale->vcd_concession_type != "Not Applicable") 
        {
            $dva = array(
                "DVA Pension Concession Card", "DVA Gold Card(Extreme Disablement Adjustment)", "DVA Gold Card(TPI)", "DVA Gold Card(War Widow)", "DVA Gold Card"
            );

            if (!in_array($sale->vcd_concession_type, $dva)) {

                $data['concession_cards'][0]['customer_reference_number​'] = '';

                $centre = array("Centrelink Healthcare Card", "Commonwealth Senior Health Card");

                $pens = array("Pensioner Concession Card");
                $que = array("Queensland Government Seniors Card");

                $concession_type = '';
                if (in_array($sale->vcd_concession_type, $centre)) {
                    $concession_type = 'HEALTH_CARE';
                }
                if (in_array($sale->vcd_concession_type, $pens)) {
                    $concession_type = 'PENSIONER_CONCESSION';
                }

                if (in_array($sale->vcd_concession_type, $que)) {
                    $concession_type = 'QLD_SENIORS';
                }

                $data['concession_cards'][0]['concession_evidence_type​'] = $concession_type;

                $data['concession_cards'][0]['first_name​'] = '';
                $data['concession_cards'][0]['last_name​'] = '';

                $card_start_date = $sale->vcd_card_start_date;
                $card_start_date = str_replace('/', '-', $card_start_date);

                $card_expiry_date = $sale->vcd_card_expiry_date;
                $card_expiry_date = str_replace('/', '-', $card_expiry_date);

                $card_start_date = date("Y-m-d", strtotime($card_start_date));
                $card_expiry_date = date("Y-m-d", strtotime($card_expiry_date));

                $data['concession_cards'][0]['start_date​'] =  '';

                $data['concession_cards'][0]['end_date​'] = '';

                $data['concession_cards'][0]['agreed_to_cces_validation​'] = true;
                $data['concession_cards'][0]['confirmed_residence​'] = true;
            }
        } 
        $support_request​ = '';
        if (isset($sale->vie_qa_notes)) { 
                $support_request​ = $sale->vie_qa_notes; 
        }
        $data['eligible_for_concessions'] = true;
        $data['support_request​'] = $support_request​;
        $data['terms_and_conditions_accepted_at'] = $createdDate; 
        $data = self::saveFluxData($data,$energy_type,$sale);
        return $data;
    
    }

    //Create Flux Response using Sale Data
    function saveFluxData($sale_data,$energy_type,$sale)
    {  
        $sale_id = $sale_data['sale_id'];
        $flux_type = $sale_data['type'];
        unset($sale_data['sale_id']);
        unset($sale_data['type']);
        $data = str_replace("\u200b", "", json_encode($sale_data));
        $token  = config('app.flux_token');
        $url = config('app.flux_url');
        $headers = [
            'Authorization' => 'Token token='.$token,
            'Content-Type'=>'application/json',
            'Accept' => 'application/json'
        ]; 
        $response = self::submitJsonDataToProvider($headers,$url,$data,'POST');
        if(isset($response['status']) && $response['status'] == 400)
        {
            return $response = ['message' => "Something went wrong.", 'output' => $response['message'],'data' => $data, 'header' => "Powershop Sale Submission", 'code' => 400];
        } 
        $result = json_decode((string) $response->getBody(), true); 
        if ($energy_type == 3) {
            SaleProductsEnergy::where('lead_id', $sale_id)->update(['correlation_id' => $sale->sale_product_reference_no]);
        } else {
            SaleProductsEnergy::where('lead_id', $sale_id)->where('product_type', $energy_type)->update(['correlation_id' => $sale->sale_product_reference_no]);
        }  
        if (!empty($result))
        { 
            if (isset($result->data)) {
                $response = ['success' => true, 'flux' => true, 'message' => 'Flux API Response Successfully.', 'data' => $result->data->reference, 'request' => $data];
                $status = 200;
                if (array_key_exists("errors", (array) $result->data)) {
                    $response = ['success' => false, 'flux' => true, 'message' => 'Something Went Wrong', 'data' => $result, 'request' => $data];
                    $status = 422;
                }  
                //Create apiResponse for Save In ApiResponse Table  
                $apiResponse['lead_id'] = $sale_id;
                $apiResponse['api_name'] = 'Flux API';
                $apiResponse['api_reference'] = 'test';
                $apiResponse['response_text'] = 'connected';
                $apiResponse['api_response'] = $result;
                $apiResponse['api_request'] = $data;
                //Save API Response
                DB::connection('sale_logs')->table('sale_submission_api_responses')->insert($apiResponse);
            } else {
                $response = ['success' => false, 'flux' => false, 'message' => 'Did not get response from Flux API ', 'request' => $data, 'data' => $result];
                $status = 422;
            }
            return response()->json($response,$status);  
        }
        return $response = ['message' => "Something went wrong.", 'code' => 400];
    }
}
