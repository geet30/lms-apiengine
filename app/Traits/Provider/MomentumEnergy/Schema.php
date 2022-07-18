<?php

namespace App\Traits\Provider\MomentumEnergy;

use App\Traits\Provider\MomentumEnergy\Headings;
use App\Models\{Lead, UsageLimit, DistributorPostCode, DmoPrice};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait Schema
{
    function momentumEnergySchema($providerLeads, $data)
    {
        try {
            $data['providerName'] = 'MOMENTUM ENERGY';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
            $providerData = $leadIds = [];
            foreach ($providerLeads as $providerLead) {
                $saleStatus = $providerLead->spe_sale_status;
                // store all leads id
                $lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id;
                // set selected energy type
                $energy_type = $providerLead->sale_product_product_type ?? '';
                //set moving house YES/NO
                $moving_house = $providerLead->journey_moving_house ?? '';
                //set selected property type
                $property_type = $providerLead->journey_property_type ?? '';

                $refNo = $providerLead->sale_product_reference_no;
                array_push($leadIds, $providerLead->l_lead_id);
                /* Desc: Set the basic information */
                $sales_cust_number = $refNo ? 'CMT' . $refNo : '';  //->A
                $agreement_date = '';         //->E
                $contract_date = '';        //->CA
                $quote_date = '';            //->FU
                $other_created_date = $providerLead->vie_qa_notes_created_date ? str_replace('/', '-', $providerLead->vie_qa_notes_created_date) : ''; //"27-05-2020 02:41:53"
                $sale_created_time = $providerLead->l_sale_created ? explode(" ", $providerLead->l_sale_created) : '';

                if (!empty($other_created_date)) {
                    $full_date_time = $other_created_date . ' ' . $sale_created_time[1];
                    $new_date_time_format = Carbon::parse($full_date_time)->subHour(10)->format('Y-m-d\TH:i:s') . 'Z';

                    $agreement_date = $new_date_time_format;         //->E
                    $contract_date = $new_date_time_format;         //->CA
                    $quote_date = $new_date_time_format;             //->FU
                }


                $first_name = decryptGdprData($providerLead->vis_first_name) ?? '';   //->H
                $last_name = decryptGdprData($providerLead->vis_last_name) ?? '';      //->I
                $initials =  $providerLead->vis_title ?? '';                //->J
                $cust_phone_no = decryptGdprData($providerLead->vis_visitor_phone) ?? '';           //->AT
                if (substr($cust_phone_no, 0, 2) == 04) {
                    $cust_phone_no = substr($cust_phone_no, 2);      //->AT
                }
                $cust_email_addr = decryptGdprData($providerLead->vis_email) ?? '';         //->AV


                $dob = $providerLead->vis_dob ?? '';     //->AZ
                // $dob2 = $yourmodel = Carbon::createFromFormat('Y-m-d', $dob)->format('Y-m-d'); 	//->AZ
                if (!empty($dob)) {
                    $dt_stamp = strtotime($dob);
                    $gmt_date_format = date('Y-m-d\TH:i:s\Z', $dt_stamp);
                    $dob = $gmt_date_format;     //->AZ
                }



                $contact_first_name = $first_name;            //->BA
                $contact_last_name = $last_name;               //->BB
                $contact_work_ph = $cust_phone_no;                         //->BH
                $contact_home_ph = decryptGdprData($providerLead->vis_alternate_phone) ?? '';   //->BJ
                $contact_mobile_ph = $cust_phone_no;                       //->BK
                $contact_email = $cust_email_addr;                           //->BL
                $customer_salutation =  $initials;                     //->CL

                /*set fields according property type */
                $customer_type = 'RESIDENT';     //->B
                $party_name = '';                //->K
                $Company_type = '';              //->L
                $industry_type = '';             //->M
                $acn_number = '';                //->N
                $abn_number = '';                  //->O
                $trading_name = '';              //->DL
                $trustee_name = '';              //->DM
                if (!empty($property_type) && $property_type == 2) {
                    $customer_type = 'COMPANY';     //->B
                    $party_name = decryptGdprData($providerLead->vbd_business_legal_name) ?? '';    //->K
                    $Company_type = $providerLead->vbd_business_company_type ?? '';     //->L
                    $industry_type = $providerLead->vbd_business_industry_type ?? '';   //->M
                    $acn_number = (strlen($providerLead->vbd_business_abn) <= 9) ? $providerLead->vbd_business_abn : '';      //->N
                    $abn_number = (strlen($providerLead->vbd_business_abn) > 9) ? $providerLead->vbd_business_abn : '';       //->O
                    $trading_name = decryptGdprData($providerLead->vbd_business_legal_name) ?? '';              //->DL
                    $trustee_name = decryptGdprData($providerLead->vbd_business_legal_name) ?? '';              //->DM
                }

                /*set fields according energy type*/
                $site_identifier = $providerLead->vie_nmi_number ?? '';      //->P
                $site_access_details = $providerLead->vie_site_access_electricity ?? '';       //->AE
                if ($energy_type == 2) {
                    $site_identifier = $providerLead->vie_dpi_mirn_number ?? '';      //->P
                    $site_access_details = $providerLead->vie_site_access_gas ?? '';         //->AE
                }


                $product_type_code = '';         //->C
                $offer_with_rate_id = '';       //->FV
                $offer_with_rate_name = '';     //->FW
                /*set fields according energy type and sale status(submit/re-submit)*/
                if ($energy_type == 1 && ($saleStatus == 4 || $saleStatus == 12)) {
                    $product_type_code = 'POWER';     //->C
                    $offer_with_rate_id = $providerLead->vie_electricity_code ?? '';         //->FV
                    $offer_with_rate_name = $providerLead->vie_electricity_network_code ?? '';   //->FW
                } else if ($energy_type == 2 && ($saleStatus == 4 || $saleStatus == 12)) {
                    $product_type_code = 'GAS';       //->C
                    $offer_with_rate_id = $providerLead->vie_gas_code ?? '';        //->FV
                    $offer_with_rate_name = $providerLead->vie_gas_network_code ?? '';        //->FW
                }

                /*connection address*/
                foreach ($this->addressFields as $addressField => $requestField) {
                    ${$addressField} = $providerLead->{'va_' . $requestField};
                }
                if ($energy_type == 2) {
                    if ($providerLead->vga_is_same_gas_connection == 1) {
                        foreach ($this->addressFields as $addressField => $requestField) {
                            ${$addressField} = $providerLead->{'vga_' . $requestField};
                        }
                    }
                }


                /*visitorInformation*/
                $site_hazard_desc =  isset($visitor_other_info['meter_hazard']) ? $visitor_other_info['meter_hazard'] : '';           //->AD

                /*po box address*/
                $cust_postal_addr_1 = '';       //->AF
                $cust_postal_addr_2 = '';       //->AG
                $cust_postal_addr_3 = '';       //->AH
                $cust_postal_post_code = '';    //->AI
                $po_box_address_checked = $providerLead->is_po_box == 1;
                if ($po_box_address_checked) {
                    $cust_postal_addr_1 = $providerLead->vpa_address ?? '';    //->AF
                    $cust_postal_addr_2 = $providerLead->vpa_suburb ?? '';    //->AG
                    $cust_postal_addr_3 = $providerLead->vpa_state ?? '';    //->AH
                    $cust_postal_post_code = $providerLead->vpa_postcode ?? '';   //->AI
                    $delivery_method_code = 'FORM_ONLY';             //->BR
                    $regulatory_communication_preference = 'POST';   //->FX
                } else {
                    /*If Billing option are selected from connection address */
                    if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack != 1) {
                        foreach ($this->billingFields as $billingField => $requestField) {
                            ${$billingField} = $providerLead->{'vba_' . $requestField};
                        }
                        $cust_postal_addr_1 = $lot_number . ' ' . $unit_no . ' ' . $street_number . ' ' . $street_name . ' ' . $street_code;  //->AF
                    }
                    /*If Other option are selected from connection address */ else if ($providerLead->l_billing_preference == 2) {
                        foreach ($this->billingFields as $billingField => $requestField) {
                            ${$billingField} = $providerLead->{'va_' . $requestField};
                        }
                        $cust_postal_addr_1 = $lot_number . ' ' . $unit_no . ' ' . $street_number . ' ' . $street_name . ' ' . $street_code;  //->AF
                    }
                    /*If Email option are selected from connection address and checked 'Yes'*/ else if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack == 1) {
                        foreach ($this->billingFields as $billingField => $requestField) {
                            ${$billingField} = $providerLead->{'va_' . $requestField};
                        }

                        $cust_postal_addr_1 = $lot_number . ' ' . $unit_no . ' ' . $street_number . ' ' . $street_name . ' ' . $street_code;  //->AF

                    }
                }
                $delivery_method_code = 'FORM_ONLY';                  //->BR
                $regulatory_communication_preference = 'POST';        //->FX
                if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack != 1) {
                    $delivery_method_code = 'EDATA';                  //->BR
                    $regulatory_communication_preference = 'EMAIL';   //->FX
                }

                /* Desc : Identity information set in fields*/
                $customer_dlicense = '';            //->BM
                $customer_dlicense_exp_date = '';   //->BN
                $customer_passport = '';            //->BO
                $customer_passport_exp_date = '';   //->BP
                $medicard_no = '';                  //->CW
                $customer_medicard_exp_date = '';   //->DV
                $contact_passport_country_of_birth = '';      //->FZ
                $contact_driving_licence_issuing_state = '';      //->GA
                $contact_medicare_card_reference_number = '';      //->GC

                $visitor_other_info_type = $providerLead->vie_identity_type ?? '';
                switch ($visitor_other_info_type) {
                    case 'Drivers Licence':
                        $customer_dlicense = $providerLead->vie_licence_number ?? '';  //->BM
                        $customer_dlicense_exp_date = $providerLead->vie_licence_card_expiry_date ?? '';  //->BN
                        if (!empty($customer_dlicense_exp_date)) {
                            $dl_exp_date = strtotime($customer_dlicense_exp_date);
                            $dl_date_format_gmt = date('Y-m-d\TH:i:s\Z', $dl_exp_date);
                            $customer_dlicense_exp_date = $dl_date_format_gmt;     //->BN
                        }
                        $contact_driving_licence_issuing_state = $providerLead->vie_licence_state_code ?? '';     //->GA
                        break;
                    case 'Passport':
                        $customer_passport = $providerLead->vie_passport_number ?? '';  //->BO
                        $customer_passport_exp_date = $providerLead->vie_passport_card_expiry_date ?? '';     //->BP
                        if (!empty($customer_passport_exp_date)) {
                            $passport_exp_date = strtotime($customer_passport_exp_date);
                            $passport_date_new_format = date('Y-m-d\TH:i:s\Z', $passport_exp_date);
                            $customer_passport_exp_date = $passport_date_new_format;     //->BP
                        }
                        $contact_passport_country_of_birth = 'AUS';      //->FZ
                        break;
                    case 'Foreign Passport':
                        $customer_passport = $providerLead->vie_passport_number ?? '';  //->BO

                        $customer_passport_exp_date = $providerLead->vie_passport_card_expiry_date ?? '';     //->BP
                        if (!empty($customer_passport_exp_date)) {
                            $fr_passport_exp_date = strtotime($customer_passport_exp_date);
                            $fr_passport_date_new_format = date('Y-m-d\TH:i:s\Z', $fr_passport_exp_date);
                            $customer_passport_exp_date = $fr_passport_date_new_format;     //->BP
                        }
                        $country_name = $providerLead->vie_country_name ?? '';
                        if (!empty($country_name)) {
                            $contact_passport_country_of_birth = array_search($country_name, config('app.country_codes'));      //->FZ
                            if (empty($contact_passport_country_of_birth)) {
                                $contact_passport_country_of_birth = $providerLead->vie_country_code ?? '';      //->FZ
                            }
                        }
                        break;
                    case 'Medicare Card':
                        $medicard_no = $providerLead->vie_medicare_number ?? '';  //->CW

                        $customer_medicard_exp_date = $providerLead->vie_medicare_card_expiry_date ?? '';  //->DV
                        if (!empty($customer_medicard_exp_date)) {
                            $med_card_exp_date = strtotime($customer_medicard_exp_date);
                            $med_card_date_new_format = date('Y-m-d\TH:i:s\Z', $med_card_exp_date);
                            $customer_medicard_exp_date = $med_card_date_new_format;     //->DV
                        }
                        $contact_medicare_card_reference_number = $providerLead->vie_medicare_reference_number ?? '';  //->GC
                        break;
                    default:
                        break;
                }

                /* Desc : Set the Concession details in fields */
                $concession = 'N';           //->CB
                $conc_start_date = '';       //->CC
                $conc_card_type_code = '';   //->CE
                $conc_card_number = '';      //->CF
                $conc_card_code = '';        //->CG
                $conc_card_exp_date = '';    //->CH
                $concession_consent_obtained = 'N';       //->EC
                $concession_card_first_name = '';        //->ED
                $concession_card_last_name = '';         //->EF
                $concession_type = $providerLead->vcd_concession_type ?? '';
                if ($property_type != 2 && $concession_type != 'Not Applicable') {
                    $concession = 'Y';            //->CB
                    $conc_start_date = $providerLead->vcd_card_start_date ? str_replace('/', '-', $providerLead->vcd_card_start_date) : '';             //->CC
                    if (!empty($conc_start_date)) {
                        $concession_start_date = strtotime($conc_start_date);
                        $conn_date_new_format = date('Y-m-d\TH:i:s\Z', $concession_start_date);
                        $conc_start_date = $conn_date_new_format;     //->CC
                    }

                    if (in_array($concession_type, $this->momentumHcc)) {
                        $conc_card_type_code = 'HCC';
                    } else if (in_array($concession_type, $this->momentumPcc)) {
                        $conc_card_type_code = 'PCC';
                    } else if (in_array($concession_type, $this->momentumDva)) {
                        $conc_card_type_code = 'DVAGC';
                    }

                    $conc_card_number = $providerLead->vcd_card_number ?? '';     //->CF
                    $conc_card_code = $providerLead->vcd_concession_code ?? '';        //->CG
                    $conc_card_exp_date = $providerLead->vcd_card_expiry_date ? str_replace('/', '-', $providerLead->vcd_card_expiry_date) : '';    //->CH
                    if (!empty($conc_card_exp_date)) {
                        $conn_exp_date = strtotime($conc_card_exp_date);
                        $conn_exp_date_new_format = date('Y-m-d\TH:i:s\Z', $conn_exp_date);
                        $conc_card_exp_date = $conn_exp_date_new_format;     //->CH
                    }
                    $concession_consent_obtained = 'Y';     //->EC
                    $concession_card_first_name = $first_name;    //->ED
                    $concession_card_last_name = $last_name;    //->EF
                }

                /*life support medical_equipment*/
                $conc_on_life_support = 'N';              //->CI
                if ($providerLead->journey_life_support == 1 && $providerLead->journey_life_support_energy_type == 1) {
                    $conc_on_life_support = "Y";        //->CI
                }

                /*sale type get from mail content*/
                $transfer_type = 'MOVE IN';  //->CM
                if ($data['salesType'] == 'cor') {
                    $transfer_type = 'Transfer';
                }


                /* Desc : Campaign code and contract details set in fields*/
                $price_plan_code = $providerLead->plan_name ?? '';           //->CZ
                $campaign_name = 'NONE';             //->DA

                /* bill cycle code field*/
                $bill_cycle_code = 1;              //->BQ
                if ($energy_type == 1) {
                    $plan_data = DB::table('plans_energy')->select('name', 'billing_options', 'energy_type')->where('energy_type', $energy_type)->where('provider_id', $providerLead->sale_product_provider_id)->where('name', $providerLead->plan_name)->get()->toArray();
                    //->BQ

                    foreach ($plan_data as $plan_info) {
                        if (strtolower($plan_info['billing_options']) == 'monthly') {
                            $bill_cycle_code = 1;     //->BQ
                        } else if (strtolower($plan_info['billing_options']) == 'quarterly') {
                            $bill_cycle_code = 'TOU_QUART';     //->BQ
                        }
                    }
                } else {
                    $bill_cycle_code = 'Gas';
                }
                $est_ann_kwhs = '';              //->DD
                if ($energy_type == 1) {
                    $postcode = $providerLead->va_postcode;
                    // get distributor id for energy type electricity
                    $distributor_id = $providerLead->journey_distributor_id;
                    if ($property_type == 2) {
                        $peak_only_data = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 'business', 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price', 'annual_usage')->first();
                    } else {
                        $peak_only_data = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 'residential', 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price', 'annual_usage')->first();
                    }
                    $est_ann_kwhs = isset($peak_only_data->peak_only) ? round($peak_only_data->peak_only, 2) : '';  //->DD
                    if (empty($est_ann_kwhs)) {
                        if ($property_type == 2) {
                            $elec_low_usage = UsageLimit::whereHas('post_codes', function ($q) use ($postcode) {
                                $q->where('usage_type', 1)->where('post_code', $postcode);
                            })
                                ->with(['post_codes' => function ($q) use ($postcode) {
                                    $q->where('usage_type', 1)->where('post_code', $postcode);
                                }])
                                ->select('elec_low_range')->first();
                        } else {
                            $elec_low_usage = UsageLimit::whereHas('post_codes', function ($q) use ($postcode) {
                                $q->where('usage_type', 2)->where('post_code', $postcode);
                            })
                                ->with(['post_codes' => function ($q) use ($postcode) {
                                    $q->where('usage_type', 2)->where('post_code', $postcode);
                                }])
                                ->select('elec_low_range')->first();
                        }
                        $est_ann_kwhs = isset($elec_low_usage->elec_low_range) ? number_format($elec_low_usage->elec_low_range * 365, 2, '.', '') : '';
                    }
                }

                $movein_date_special_read_date = '';     //->EA
                if ($moving_house == 1) {
                    $moveInDate = $providerLead->journey_moving_date ?? '';
                    if (!empty($moveInDate)) {
                        $change_format = str_replace('/', '-', $moveInDate);
                        $special_read_date = strtotime($change_format);
                        $special_read_date_new_format = date('Y-m-d\TH:i:s\Z', $special_read_date);
                        $moveInDate = $special_read_date_new_format;
                    }
                    $movein_date_special_read_date = $moveInDate;           //->EA
                }
                $note = $providerLead->l_note ?? '';
                $special_instructions = $note;      //->EB

                /* Desc : Joint Account details set in fields */
                $secondary_contact_salutation = '';       //->EP
                $secondary_contact_first_name = '';        //->EQ
                $secondary_contact_last_name = '';        //->ER
                $secondary_contact_date_of_birth = '';    //->ET
                $secondary_contact_mobile_phone = '';     //->FD
                if ($providerLead->vie_is_connection_joint_account_holder != 0) {

                    $secondary_contact_salutation = $providerLead->vie_joint_acc_holder_title ?? '';  //EP
                    $secondary_contact_first_name = $providerLead->vie_joint_acc_holder_first_name ?? '';  //EQ
                    $secondary_contact_last_name = $providerLead->vie_joint_acc_holder_last_name ?? '';  //ER
                    $secondary_contact_date_of_birth = $providerLead->vie_joint_acc_holder_dob ?? ''; //ET
                    if (!empty($secondary_contact_date_of_birth)) {
                        $joint_acc_dob_date = strtotime($secondary_contact_date_of_birth);
                        $joint_acc_date_new_format = date('Y-m-d\TH:i:s\Z', $joint_acc_dob_date);
                        $secondary_contact_date_of_birth = $joint_acc_date_new_format;     //->ET
                    }
                    $secondary_contact_mobile_phone = $providerLead->vie_joint_acc_holder_phone_no ?? '';     //FD
                }


                $existing_customer = 'N';       //->FY
                $current_provider = $providerLead->journey_previous_provider_id ?? '';
                if (!empty($current_provider) && $current_provider == '​Momentum Energy' && $moving_house == 0) {
                    $existing_customer = 'Y';           //->FY
                }
                $providerData[$saleStatus][] = array(
                    $sales_cust_number,             //->A
                    $customer_type,                 //->B
                    $product_type_code,             //->C
                    'SALE',     //->D
                    $agreement_date,                //->E
                    'CIMET',    //->F
                    '',         //->G
                    $first_name,                    //->H
                    $last_name,                     //->I
                    $initials,                      //->J
                    $party_name,                    //->K
                    $Company_type,                  //->L
                    $industry_type,                 //->M
                    $acn_number,                    //->N
                    $abn_number,                    //->O
                    $site_identifier,               //->P
                    $site_addr_unit_type,           //->Q
                    $site_addr_unit_no,             //->R
                    $site_addr_floor_type,          //->S
                    $site_addr_floor_no,            //->T
                    $site_addr_street_no,           //->U
                    $site_addr_street_no_suffix,    //->V
                    $site_addr_street_name,         //->W
                    $site_street_type_code,         //->X
                    $site_addr_suburb,              //->Y
                    $site_addr_city,                //->Z
                    $site_addr_postcode,            //->AA
                    $site_addr_property_name,       //->AB
                    '',         //->AC
                    $site_hazard_desc,              //->AD
                    $site_access_details,           //->AE
                    $cust_postal_addr_1,            //->AF
                    $cust_postal_addr_2,            //->AG
                    $cust_postal_addr_3,            //->AH
                    $cust_postal_post_code,         //->AI
                    '',         //->AJ
                    '',         //->AK
                    '',         //->AL
                    '',         //->AM
                    '',         //->AN
                    '',         //->AO
                    '',         //->AP
                    'Y',        //->AQ
                    '',         //->AR
                    '04',       //->AS
                    $cust_phone_no,                 //->AT
                    '',         //->AU
                    $cust_email_addr,               //->AV
                    '',         //->AW
                    '',         //->AX
                    '',         //->AY
                    $dob,                           //->AZ
                    $contact_first_name,            //->BA
                    $contact_last_name,             //->BB
                    '',         //->BC
                    '',         //->BD
                    '',         //->BE
                    '',         //->BF
                    'Authorised Contact',           //->BG
                    $contact_work_ph,               //->BH
                    '',         //->BI
                    $contact_home_ph,               //->BJ
                    $contact_mobile_ph,             //->BK
                    $contact_email,                 //->BL
                    $customer_dlicense,             //->BM
                    $customer_dlicense_exp_date,    //->BN
                    $customer_passport,             //->BO
                    $customer_passport_exp_date,    //->BP
                    $bill_cycle_code,               //->BQ   (yellow empty)
                    $delivery_method_code,          //->BR
                    '',         //->BS
                    '',         //->BT
                    '',         //->BU
                    '',         //->BV
                    '',         //->BW
                    '',         //->BX
                    '',         //->BY
                    'open',     //->BZ
                    $contract_date,             //->CA
                    $concession,                //->CB
                    $conc_start_date,           //->CC
                    '',         //->CD
                    $conc_card_type_code,       //->CE
                    $conc_card_number,          //->CF
                    $conc_card_code,            //->CG
                    $conc_card_exp_date,        //->CH
                    $conc_on_life_support,      //->CI
                    'N',        //->CJ
                    '',         //->CK
                    $customer_salutation,       //->CL
                    $transfer_type,             //->CM
                    'CHEQUE',   //->CN
                    '',         //->CO
                    '',         //->CP
                    '',         //->CQ
                    '',         //->CR
                    '',         //->CS
                    '',         //->CT
                    '',         //->CU
                    '',         //->CV
                    $medicard_no,               //->CW
                    '',         //->CX
                    '',         //->CY
                    $price_plan_code,           //->CZ
                    $campaign_name,             //->DA
                    '',         //->DB
                    '',         //->DC
                    $est_ann_kwhs,              //->DD (yellow)
                    '',         //->DE
                    '',         //->DF
                    '',         //->DG
                    '',         //->DH
                    '',         //->DI
                    '',         //->DJ
                    '',         //->DK
                    $trading_name,              //->DL
                    $trustee_name,              //->DM
                    '',         //->DN
                    '',         //->DO
                    '',         //->DP
                    '',         //->DQ
                    '',         //->DR
                    '',         //->DS
                    '',         //->DT
                    '',         //->DU
                    $customer_medicard_exp_date,        //->DV
                    '',         //->DW
                    '',         //->DX
                    '',         //->DY
                    '',         //->DZ
                    $movein_date_special_read_date,     //->EA
                    $special_instructions,              //->EB
                    $concession_consent_obtained,       //->EC
                    $concession_card_first_name,        //->ED
                    '',         //->EE
                    $concession_card_last_name,         //->EF
                    '',         //->EG
                    '',         //->EH
                    '',         //->EI
                    '',         //->EJ
                    '',         //->EK
                    '',         //->EL
                    '',         //->EM
                    '',         //->EN
                    '',         //->EO
                    $secondary_contact_salutation,      //->EP
                    $secondary_contact_first_name,      //->EQ
                    $secondary_contact_last_name,       //->ER
                    '',         //->ES
                    $secondary_contact_date_of_birth,   //->ET
                    '',         //->EU
                    '',         //->EV
                    '',         //->EW
                    '',         //->EX
                    '',         //->EY
                    '',         //->EZ
                    '',         //->FA
                    '',         //->FB
                    '',         //->FC
                    $secondary_contact_mobile_phone,    //->FD
                    '',         //->FE
                    '',         //->FF
                    '',         //->FG
                    '',         //->FH
                    '',         //->FI
                    '',         //->FJ
                    '',         //->FK
                    '',         //->FL
                    '',         //->FM
                    '',         //->FN
                    '',         //->FO
                    '',         //->FP
                    '',         //->FQ
                    '',         //->FR
                    '',         //->FS
                    '',         //->FT
                    $quote_date,                        //->FU
                    $offer_with_rate_id,                //->FV
                    $offer_with_rate_name,              //->FW
                    $regulatory_communication_preference,       //->FX
                    $existing_customer,                         //->FY
                    $contact_passport_country_of_birth,         //->FZ
                    $contact_driving_licence_issuing_state,     //->GA
                    '',         //->GB
                    $contact_medicare_card_reference_number,    //->GC
                );
            }
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'MOMENTUM_ENERGY_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'MOMENTUM_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'MOMENTUM_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'MOMENTUM_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
