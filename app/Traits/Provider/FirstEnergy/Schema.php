<?php

namespace App\Traits\Provider\FirstEnergy;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\FirstEnergy\Headings;
use Illuminate\Support\Facades\{Storage};
use Carbon\Carbon;
use App\Models\{ ProviderSftp, SaleProductsEnergy, ProviderSaleEmail};
trait Schema
{
    function firstEnergySchema($providerLeads, $data)
    {
      
        try{
            $data['providerName'] = 'First ENERGY';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
            $data['requestType'] = 'Fulfilment';
            $salesName = $acctMgrName = 'CIMET';
            $billCycleCode = 'Daily';
            $invoiceDeliveryClass = 'Email';
            $paymentMethodType = 'CHEQUE';
            $providerData = [];
            $contractTermCode = 'OPEN';
            $transferType = 'TRANSFER';
            $leadIds = [];
            
            $medicalNumber = $idNumber = $lifeSupportOnSite= $concessionYesNo = $networkCode = $idExpiryDate =  $postAddr1 =  $siteIdentifier = $contactDateOfBirth = $contactFirstName = $contactLastName =  $contactMobileNo = $contactTitle = $contactPhoneNo =  $concessionCardTypeCode =  $cardExpiryDate = $concessionCardNumber =  $cardStartDate = $concessionFirstName = $concessionLastName = ''; 

            foreach($providerLeads as $providerLead){
                if($providerLead->vi_identification_type && $providerLead->vi_identification_type=='Medicare Card'){
                    if (isset($providerLead->vi_medicare_number)) {
                        $medicalNumber = $providerLead->vi_medicare_number;
                    }

                }
                array_push($leadIds, $providerLead->l_lead_id);
                if($providerLead->vi_passport_number && $providerLead->vi_identification_type=='Passport' || $providerLead->vi_identification_type == 'Foreign Passport'){
                    $idNumber = $providerLead->vi_passport_number;

                }
                
                if($providerLead->vi_identification_type && $providerLead->vi_identification_type=='Drivers Licence'){
                    if (isset($providerLead->vi_licence_expiry_date)) {
                        $idExpiryDate = Carbon::parse($providerLead->vi_licence_expiry_date)->format('d/m/Y');
                    }

                }
        
                if ($providerLead->sale_product_product_type && $providerLead->sale_product_product_type == 1 && $providerLead->vie_electricity_network_code) {
                    $networkCode = $providerLead->vie_electricity_network_code;
                }
                if ($providerLead->sale_product_product_type && $providerLead->sale_product_product_type == 2 && $providerLead->vie_gas_network_code) {
                    $networkCode = $providerLead->vie_gas_network_code;
                }
            
                if($providerLead->va_address){
                    $movingAddress = $providerLead->va_address;
                    if (!empty($movingAddress)) {
                        
                        $postAddr1 = $providerLead->va_unit_type . ' ' . $providerLead->va_unit_number . ' ' . $providerLead->va_street_number . ' ' . $providerLead->va_street_name . ' ' . $providerLead->va_street_code;
                    }
                }
                
            
                if($providerLead->vie_nmi_number && $providerLead->sale_product_product_type==1){
                    $siteIdentifier = $providerLead->vie_nmi_number;

                }else if($providerLead->vie_dpi_mirn_number && $providerLead->sale_product_product_type==2){
                    $siteIdentifier = $providerLead->vie_dpi_mirn_number;
                }

            
                

                if ($providerLead->vie_is_connection_joint_account_holder && $providerLead->vie_is_connection_joint_account_holder != 0) {
                    if ($providerLead->vie_joint_acc_holder_dob) {
                        $contactDateOfBirth = $providerLead->vie_joint_acc_holder_dob;
                    }
                    if ($providerLead->vie_joint_acc_holder_first_name) {
                        $contactFirstName = $providerLead->vie_joint_acc_holder_first_name;
                    }
                    if ($providerLead->vie_joint_acc_holder_last_name) {
                        $contactLastName = $providerLead->vie_joint_acc_holder_last_name;
                    }
                    if ($providerLead->vie_joint_acc_holder_phone_no) {
                        $contactMobileNo = $providerLead->vie_joint_acc_holder_phone_no;
                    }
                    if ($providerLead->vie_joint_acc_holder_title) {
                        $contactTitle = $providerLead->vie_joint_acc_holder_title;
                    }
                    if ($providerLead->vie_joint_acc_holder_home_phone_no) {
                        $contactPhoneNo = $providerLead->vie_joint_acc_holder_home_phone_no;
                    }
                }
        
                ##################### not found ##################################
                

                if ($providerLead->journey_life_support) {
                    $lifeSupportOnSite = "N";
                    if ($providerLead->journey_life_support == 1) {
                        $lifeSupportOnSite = "Y";
                    }
                }
                ##################### not found ##################################
                
                if ($providerLead->vcd_concession_type) {
                    $concessionYesNo = "Y";
                    if ($providerLead->vcd_concession_type == 'Not Applicable') {
                        $concessionYesNo = "N";
                    }
                }

                if ($providerLead->journey_property_type != 2 && $providerLead->vcd_concession_type != 'Not Applicable') {

                    if (in_array($providerLead->vcd_concession_type, $this->hcc)) {
                        $concessionCardTypeCode = 'HCC';
                    } else if (in_array($providerLead->vcd_concession_type, $this->firstEnergypcc)) {
                        $concessionCardTypeCode = 'PCC';
                    } else if (in_array($providerLead->vcd_concession_type, $this->dvagc)) {
                        $concessionCardTypeCode = 'DVAGC';
                    }
                    
                    if($providerLead->vis_first_name){
                        $concessionFirstName = $providerLead->vis_first_name;
                    }
                    if($providerLead->vis_last_name){
                        $concessionLastName = $providerLead->vis_last_name;
                    }
                    if($providerLead->vcd_card_expiry_date){
                        $cardExpiryDate = $providerLead->vcd_card_expiry_date;
                    }
                    if($providerLead->vcd_card_number){
                        $concessionCardNumber = $providerLead->vcd_card_number;
                    }
                    if($providerLead->vcd_card_start_date){
                        $cardStartDate = $providerLead->vcd_card_start_date;
                    }
                }
            
            
                // $providerData[$exports['sale_text_status']] sale_text_status means submit or resubmit
                $providerData[$providerLead->spe_sale_status][] = [
                    
                    $providerLead->sale_product_reference_no ?? '',
                    /** 1 **/
                    $salesName,
                    /** 2 **/
                    $providerLead->vie_qa_notes_created_date ?? '',
                    /** 3 **/
                    '',
                    /** 4 **/
                    (strlen($providerLead->vbd_business_abn) > 9 ? $providerLead->vbd_business_abn : ''),
                    /** 5 **/
                    (strlen($providerLead->vbd_business_abn) <= 9 ? $providerLead->vbd_business_abn : ''),
                    /** 6 **/
                    decryptGdprData($providerLead->vbd_business_legal_name),
                    /** 7 **/
                    $acctMgrName, 
                    /** 8 **/
                    decryptGdprData($providerLead->vis_first_name) . ' ' .  decryptGdprData($providerLead->vis_last_name), 
                    /** 9 **/
                    $billCycleCode, 
                    /** 10 **/
                    (($providerLead->journey_property_type == 1) ? 'RESIDENTIAL' : 'BUSINESS'),
                    /** 11 **/
                    decryptGdprData($providerLead->vis_email),
                    /** 12 **/
                    $invoiceDeliveryClass, 
                    /** 13 **/
                    $paymentMethodType,
                    /** 14 **/
                    trim($postAddr1),
                    /** 15 **/
                    
                    $providerLead->va_suburb ?? '',
                    /** 16 **/
                    $providerLead->va_state ?? '',
                    /** 17 **/
                    $providerLead->va_postcode ?? '',
                    /** 18 **/
                    '',
                    /** 19 **/
                    
                    $providerLead->vis_dob ? Carbon::parse($providerLead->vis_dob)->format('d/m/Y') : '',
                    /** 20 **/
                    $providerLead->vi_licence_number ? $providerLead->vi_licence_number : '',
                    /** 21 **/
                    decryptGdprData($providerLead->vis_email),
                    /** 22 **/
                    decryptGdprData($providerLead->vis_first_name), 
                    /** 23 **/
                    '',
                    /** 24 **/
                    decryptGdprData($providerLead->vis_last_name),
                    /** 25 **/
                    $medicalNumber,
                    /** 26 **/
                    decryptGdprData($providerLead->vis_visitor_phone),
                    /** 27 **/
                    $idNumber,
                    /** 28 **/
                    '',
                    /** 29 **/
                    '',
                    /** 30 **/
                    trim($postAddr1),
                    /** 31 **/
                    $providerLead->va_street_name ?? '',
                    /** 32 **/
                    $providerLead->va_state ?? '',
                    /** 33 **/
                    $providerLead->va_postcode ?? '',
                    /** 34 **/
                    trim($postAddr1), 
                    /** 35 **/
                    $providerLead->va_street_name ?? '',
                    /** 36 **/
                    $providerLead->va_state ?? '',
                    /** 37 **/
                    $providerLead->va_postcode ?? '',
                    /** 38 **/
                    decryptGdprData($providerLead->vis_title),
                    /** 39 **/
                    
                    $providerLead->vbd_customer_work_contact ? $providerLead->vbd_customer_work_contact : '',          
                    /** 40 **/

                    /** New caf changes 28 oct 2021 **/
                    $contactDateOfBirth,
                    /** 41 **/
                    $contactFirstName,
                    /** 42 **/
                    '',
                    /** 43 **/
                    $contactLastName,
                    /** 44 **/
                    '',
                    /** 45 **/
                    $contactMobileNo,
                    /** 46 **/
                    '',
                    /** 47 **/
                    $contactPhoneNo,
                    /** 48 **/
                    '',
                    /** 49 **/
                    '',
                    /** 50 **/
                    '',
                    /** 51 **/
                    '',
                    /** 52 **/
                    '',
                    /** 53 **/
                    '',
                    /** 54 **/
                    '',
                    /** 55 **/
                    '',
                    /** 56 **/
                    '',
                    /** 57 **/
                    $contactTitle,
                    /** 58 **/
                    '',
                    /** 59 **/
                    $lifeSupportOnSite,
                    /** 60 **/
                    /** End */

                    $concessionYesNo, 
                    /** 61 **/
                    $concessionFirstName,
                    /** 62 **/
                    $concessionLastName,
                    /** 63 **/
                    $concessionCardTypeCode,
                    /** 64 **/
                    $cardExpiryDate,
                    /** 65 **/
                    $concessionCardNumber,
                    /** 66 **/
                    $cardStartDate,
                    /** 67 **/
                    '',
                    /** 68 **/
                    $providerLead->vie_qa_notes_created_date ?? '',
                    /** 69 **/
                    $contractTermCode,
                    /** 70 **/
                    $providerLead->plan_plan_campaign_code ?? '',
                    /** 71 **/
                    (($providerLead->sale_product_product_type == 1) ? 'POWER' : 'GAS'),
                    /** 72 **/
                    $siteIdentifier,
                    /** 73 **/
                    $networkCode,
                    /** 74 **/
                    $providerLead->ebd_demand_tariff ?? '',
                    /** 75 **/
                    $providerLead->va_postcode ?? '',
                    /** 76 **/
                    $providerLead->va_state ?? '',
                    /** 77 **/
                    $providerLead->va_street_name ?? '',
                    /** 78 **/
                    $providerLead->va_street_number ?? '',
                    
                    /** 79 **/
                    $providerLead->va_street_code ?? '',
                    /** 80 **/
                    $providerLead->va_suburb ?? '',
                    /** 81 **/
                    $providerLead->va_unit_number ?? '',
                    /** 82 **/
                    $transferType,
                    /** 83 **/
                    '',
                    /** 84 **/
                    $idExpiryDate,
                    /** 85 **/
                    ''
                    /** 86 **/
                ];
            
            
            }   
        
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'FIRST_ENERGY_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            

            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'FIRST_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'FIRST_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }
            
            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'FIRST_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
        }
        catch (\Exception $e) {
           return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
