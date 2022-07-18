<?php

namespace App\Traits\Provider\EnergyLocals;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\EnergyLocals\Headings;
use Illuminate\Support\Facades\{Storage};
use Carbon\Carbon;
trait Schema
{
    function energyLocalsSchema($providerLeads, $data)
    {
        try{
            $data['providerName'] = 'Energy Locals';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $refNo = $providerLeads[0]->sale_product_reference_no;
            $data['requestType'] = 'Fulfilment';
            $submitDataInc = $resubmitDataInc = $sendSchema = 0;

            $providerData = $processedRefNum = $leadIds = $reference_key_array =  [];
            $C = $O = 'N';	
        	$idNumber =$concessionYesNo =  $concessionType = $cardStartDate = $cardExpiryDate = $FirstName = $LastName = $proposedMoveInDate = $lifeSupportMachineType =  $saleCreated = $idExpiryDate = $billingFloorNo = $billingFloorLevelType = $billingUnitNumber =$billingUnitType = $billingStreetNumber = $billingStreetName = $billingStreetCode = $billingSuburb = $billingState = $billingPostCode = $passportExpiry = $medicalNumber= $offeringCode = '';
					
			foreach($providerLeads as $providerLead){
                $energy_type = $providerLead->sale_product_product_type ?? '';;
                if (in_array($providerLead->vcd_concession_type, $this->hcc)) {
                    $concessionType = 'HCC';
                } else if (in_array($providerLead->vcd_concession_type, $this->pcc)) {
                    $concessionType = 'PCC';
                } else if (in_array($providerLead->vcd_concession_type, $this->dvagc)) {
                    $concessionType = 'DVAGC';
                }else {
                    if ($providerLead->vcd_concession_type && $providerLead->vcd_concession_type == 'Not Applicable') {
                        $concessionType = '';
                    }
                }
                if ($providerLead->vcd_concession_type && $providerLead->vcd_concession_type == 'Not Applicable') {
                    $concessionYesNo = "N";
                       
                } else {
                    $FirstName = decryptGdprData($providerLead->vis_first_name) ?? '';  //AC
                    $LastName = decryptGdprData($providerLead->vis_last_name) ?? ''; //AD
                    $concessionYesNo = "Y";
                    
                }
                array_push($leadIds, $providerLead->l_lead_id);
                $MovingHouse = ($providerLead->journey_moving_house == 0) ? "N" : "Y";
                if ($MovingHouse != "N") {
                    $moving_house = "MOVEIN";
                } else {
                    $moving_house = "TRANSFER";
                }
                if ($MovingHouse == 'Y' && $providerLead->journey_moving_date) {
                    $proposedMoveInDate  =  Carbon::parse($providerLead->journey_moving_date)->format('d/m/Y');
                }
                 
               

                if ($providerLead->vcd_card_expiry_date) {
                    $cardExpiryDate =  Carbon::parse($providerLead->vcd_card_expiry_date)->format('d/m/Y');
                }
                /* End */
                /* Start conc_start_date */
                if ($providerLead->vcd_card_start_date) {
                    $cardStartDate = $providerLead->vcd_card_start_date ??'';
                }
                if ($providerLead->l_sale_created) {
                    $saleCreated = Carbon::parse($providerLead->l_sale_created)->format('d/m/Y');
                }
                /* End */
                $identity_info_type = $providerLead->vie_identity_type ?? '';

                if ($identity_info_type && $identity_info_type == 'Drivers Licence') {
                    if($providerLead->vie_licence_card_expiry_date){
                        $idExpiryDate =Carbon::parse($providerLead->vie_licence_card_expiry_date)->format('d/m/Y');
                    }
                }
                if ($identity_info_type && ($identity_info_type == 'Passport' || $identity_info_type == 'Foreign Passport')) {
                    if ($providerLead->vie_passport_number) {
                        $idNumber = $providerLead->vie_passport_number;
                    }
                    if($providerLead->vie_passport_card_expiry_date){
                        $passportExpiry = Carbon::parse($providerLead->vie_passport_card_expiry_date)->format('d/m/Y');
                    }
                }
                if ($identity_info_type && $identity_info_type == 'Medicare Card') {
                    if ($providerLead->vi_medicare_number) {
                        $medicalNumber = $providerLead->vi_medicare_number ??'';
                    }
                }
                str_replace("month", "MTH", $providerLead->plan_contract_length, $count);
                str_replace("months", "MTH", $providerLead->plan_contract_length, $count1);
                str_replace("Month", "MTH", $providerLead->plan_contract_length, $count2);
                str_replace("Months", "MTH", $providerLead->plan_contract_length, $count3);

                if ($providerLead->journey_property_type == 1) {
                    $customerSubTypeCode = "MMRES";
                } else {
                    $customerSubTypeCode = "MMCOM";
                }
                /* End*/

                $lifeSupportOnSite = $multipleSclerosis =  "N";
                

                if ($providerLead->multiple_sclerosis) {
                    if ($providerLead->multiple_sclerosis == 1) {
                        $multipleSclerosis = "Y";
                    }
                }
             
                
                
                if ($providerLead->journey_life_support) {
                    if ($providerLead->journey_life_support == 1) {
                        $lifeSupportOnSite = "Y";
                        $lifeSupportMachineType = $providerLead->journey_life_support_value ?? '';
                    }
                }
               
                $temp_full_address = ' ';
                if ($providerLead->is_po_box  == 1) {
                  
                    foreach ($this->energylocalspostalFields as $postalField => $fieldName) {
                        ${$postalField} = $providerLead->{'vpa_' . $fieldName};
                        $temp_full_address .=  ${$postalField};
                    }

                }
                else {
                    /*If Billing option are selected from connection address */
                    if ($providerLead->l_billing_preference == 3) {
                        foreach ($this->energylocalspostalFields as $postalField => $fieldName) {
                            ${$postalField} = $providerLead->{'vba_' . $fieldName};
                            $temp_full_address .=  ${$postalField};
                        }		
                    }
                    else if ($providerLead->l_billing_preference == 2) {
                        foreach ($this->energylocalspostalFields as $postalField => $fieldName) {
                            ${$postalField} = $providerLead->{'va_' . $fieldName};
                            $temp_full_address .= ${$postalField};
                        }
                    }
                    else if ($providerLead->l_billing_preference == 1) {
                        if ($providerLead->l_email_welcome_pack == 1) {
                            foreach ($this->energylocalspostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                $temp_full_address .= ${$postalField};
                            }
                        } else {
                            foreach ($this->energylocalspostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'va_' . $fieldName};
                                $temp_full_address .= ${$postalField};
                            }
                        }
                    }
                }
                $temp_full_address = preg_replace('/[ ,]+/', ' ', trim($temp_full_address));
                $offeringCode = '';
                if ($providerLead->plan_plan_campaign_code) {
                    $offeringCode = $providerLead->plan_plan_campaign_code;
                }
  
                $Title  = strtoupper($providerLead->vis_title);  //AB
                $PhoneMobile = decryptGdprData($providerLead->vis_visitor_phone) ?? '';  //AH
                $EmailAddress = decryptGdprData($providerLead->vis_email) ?? '';  //AI
                $DateofBirth = $providerLead->vis_dob ? Carbon::parse($providerLead->vis_dob)->format('d/m/Y') : ''; 
                $providerData[$providerLead->spe_sale_status][] = array(
                    (($providerLead->journey_property_type == 2) ? 'RESIDENT' : 'COMPANY'), //A:customer_type_code
                    $Title, //B:contact1_title
                    $FirstName, //C:contact1_first_name
                    $LastName, //D:contact1_last_name
                    $PhoneMobile, //E:contact1_mobile_no
                    '', //F:contact1_phone_std
                    '', //G:contact1_phone_no
                    $EmailAddress, //H:email_address
                    $EmailAddress, //I:contact1_email_address
                    $providerLead->vbd_business_legal_name ?? '',
                    (strlen($providerLead->vbd_business_abn) > 9 ? $providerLead->vbd_business_abn : ''),
                    $billingFloorNo, //L:site_floor_no
                    $billingFloorLevelType, //M:site_floor_type
                    $billingUnitNumber, //N:site_unit_no
                    $billingUnitType, //O:site_unit_type
                    $billingStreetNumber, //P:site_street_no
                    $billingStreetName, //Q:site_street_name
                    $billingStreetCode, //R:site_street_type_code
                    $billingSuburb, //S:site_suburb
                    $billingState,//T:site_state
                    $billingPostCode, //U:site_post_code
                    $moving_house, //V:transfer_type
                    //"ENERGEXP",//W:site_network_code
                    $proposedMoveInDate, //X:transfer_move_in_date
                    '', //Y:previous_supplier_code
                    $providerLead->vie_nmi_number ?? '', //Z:site_identifier
                    ($providerLead->journey_solar_panel == 1) ? "SOLAR YES" : "SOLAR NO", //AA:user_defined_1
                    $concessionYesNo, //AB:concession_flag
                    $concessionType, //AC:conc_card_type_code
                    $providerLead->vcd_card_number ??'',
                    "", //AE:conc_end_date
                    $cardExpiryDate, //AF:conc_expiry_date
                    'N', //AG:conc_group_home_flag
                    $cardStartDate, //AH:conc_start_date
                    $FirstName, //AI:conc_first_name
                    $LastName, //AJ:conc_last_name
                    $lifeSupportOnSite,
                    $lifeSupportMachineType, //AL:conc_life_support_machine_type
                    $saleCreated,
                    $DateofBirth, //AN:contact1_date_of_birth
                    $providerLead->vi_licence_number ?? '', //AO:contact1_drivers_licence
                    $idExpiryDate, //AP:contact1_drivers_expiry
                    $idNumber, //AQ:contact1_passport
                    $passportExpiry, //AR:contact1_passport_expiry
                    $medicalNumber, //AS:contact1_medicard_no
                    'CHEQUE', //AT:payment_method_type
                    '', //AU:direct_debit_bank_code
                    '', //AV:direct_debit_number
                    '', //AW:credit_card_no
                    '', //AX:credit_card_expiry_date
                    '', //AY:credit_card_verif_no
                    '', //AZ:credit_card_type_code
                    '', //BA:smoothpay_amount
                    '', //BB:User_Defined_3
                    '0.00', //BC:green_percent
                    '', //BD:user_defined_4
                    '', //BE:user_defined_2
                    'N', //BF:promo_allowed
                    $offeringCode, //BG:offering_code
                    'DAILY', //BH:bill_cycle_code
                    'CIMET_2000_X', //BI:brand_code
                    trim($temp_full_address), //BJ:post_addr_1
                    $billingSuburb, //BK:post_addr_2
                    $billingState, //BL:post_addr_3
                    $billingPostCode, //BM:post_post_code
                    (($energy_type == 1) ? 'POWER' : 'GAS'), //BN:product_type_code
                    $concessionYesNo, //BO:conc_consent_flag
                    'OPEN', //BP:contract_term_code
                    $customerSubTypeCode,
                    'EMAIL', //BQ:invoice_delivery_class
                    'EMAIL', //BR:letter_delivery_class
                    $providerLead->vbd_business_company_type ?? '', //BS:company_type
                    '0000', //BT:industry_type_code
                    (strlen($providerLead->vbd_business_abn) <= 9 ? $providerLead->vbd_business_abn : ''),
                    $providerLead->vbd_business_legal_name ?? '',
                    '', //BW:direct_debit_branch
                    '', //BX:direct_debit_name
                    '', //BY:credit_card_name
                    $multipleSclerosis, //BZ:conc_ms_flag
                    $cardExpiryDate, //CA:conc_ls_end_date
                    $PhoneMobile, //CB:business_phone_no
                    'STDRESID', //CC:contracted_capacity_code
                    "ENERGEXP",
                    $lifeSupportOnSite, //CD:life_support_on_site
                );
                



               
            
            } // end foreach loop
            
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'ENERGYLOCALS_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ENERGY_LOCALS' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ENERGY_LOCALS' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
               
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'ENERGY_LOCALS_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
               
       
            
        }
        catch (\Exception $e) {
           return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
