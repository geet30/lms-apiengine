<?php

namespace App\Traits\Provider\BlueNRG;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\BlueNRG\Headings;
use Illuminate\Support\Facades\{Storage};
use App\Models\{DistributorPostCode, DmoPrice, UsageLimit,Providers};
use Carbon\Carbon;
trait Schema
{
    function BlueNRGSchema($providerLeads, $data)
    {

        try{
            $data['providerName'] = 'Blue NRG';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $refNo = $providerLeads[0]->sale_product_reference_no;
            $data['requestType'] = 'Fulfilment';
            $submitDataInc = $resubmitDataInc = $sendSchema = 0;

            $providerData = $processedRefNum = $leadIds = $reference_key_array =  [];
            $C = $O = 'N';	
            $partyName = $companyType = $industryType =  $acnNumber = $abnNumber =  $tradingName = $productTypeCode = $custPostalAddr1 = $custPostalAddr2 = $custPostalAddr3 = $custPostalCode =    
            $customerDlicense =  $customerDlicenseExpDa =  $customerPassport =  $passportExpDate =  $medicardNo =  $concStartDate =  $concEndDate =  $cardType =  $concCardNumber =  $concCardCode =  $concCardExpDate = $lifeSupportMachineType = ''; 	//86	 

            foreach($providerLeads as $providerLead){
                if (!in_array($providerLead->spe_sale_status. '_' . $refNo, $processedRefNum)) {

                   
                    $refArray[] = $providerLead->spe_sale_status . '_' . $refNo;
                    if ($providerLead->spe_sale_status == '4') {
                        $reference_key_array[$refNo] = $submitDataInc;
                        $submitDataInc++;
                    }
                    if ($providerLead->spe_sale_status == '12') {
                        $reference_key_array[$refNo] = $resubmitDataInc;
                        $resubmitDataInc++;
                    }

                    if ($data['mailType'] == "test") {
                        $reference_key_array[$refNo] =  $sendSchema;
                        $sendSchema++;
                    }
                    array_push($leadIds, $providerLead->l_lead_id);
                    //get energy type
                    $energy_type = $providerLead->sale_product_product_type ?? '';
                    //get moving house
                    $movin_house = $providerLead->journey_moving_house ?? '';
                    //get property type
                    $property_type = $providerLead->journey_property_type ?? '';
                 

                    $customerType = 'RESIDENT';	
                    if ($energy_type == 1) {
                        $productTypeCode = 'POWER';
                    }

                    if ( $property_type == 2) {
                        $customerType = 'COMPANY';		//2
                        $partyName = $providerLead->vbd_business_legal_name ?? '';
                        $industryType = $providerLead->vbd_business_industry_type ?? 'Unknown';
                        $acnNumber =  (strlen($providerLead->vbd_business_abn) <= 9 ? $providerLead->vbd_business_abn : '');				
                        $abnNumber = (strlen($providerLead->vbd_business_abn) > 9 ? $providerLead->vbd_business_abn : '');	

                        $business_company_type = $providerLead->vbd_business_company_type ?? '';

                        switch ($business_company_type) {
                            case 'Limited Company':
                                $companyType = 'Limited';		//12
                                break;
                            case 'Partnership':
                                $companyType = 'Partnership';
                                break;
                            case 'Sole Trader':
                                $companyType = 'Sole Trader';
                                break;
                            case 'Trust':
                                $companyType = 'Trust';
                                break;
                            case 'Private':
                                $companyType = 'Private';
                                break;
                            case 'Incorporation':
                                $companyType = 'Incorporation';
                                break;
                            default:
                                $companyType = 'NA';
                                break;
                        }

                        $tradingName =$providerLead->vbd_business_legal_name ?? '';
                    }

                    /*po box address*/
                  
                   
                    if ($providerLead->is_po_box  == 1) {
                        foreach ($this->BlueNRGpostalFields as $postalField => $fieldName) {
                            ${$postalField} = $providerLead->{'vpa_' . $fieldName};
                        }
                       
                    } else {
                        /*If Billing option are selected from connection address */
                        if ($providerLead->l_billing_preference == 3) {

                            foreach ($this->BlueNRGpostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'vba_' . $fieldName};
                            }		
                        }
                        else if ($providerLead->l_billing_preference == 2) {
                            foreach ($this->BlueNRGpostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'va_' . $fieldName};
                            }
                        }
                        else if ($providerLead->l_billing_preference == 1) {
                            if ($providerLead->l_email_welcome_pack == 1) {
                                foreach ($this->BlueNRGpostalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                }
                            } else {
                                foreach ($this->BlueNRGpostalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'va_' . $fieldName};
                                }
                            }
                        }
                    }

                    $identity_info_type = $providerLead->vie_identity_type ?? '';
                    if($identity_info_type){
                        switch ($identity_info_type) {
                            case 'Drivers Licence':
                                $customerDlicense =  $providerLead->vie_licence_number ??'';
                                if($providerLead->vie_licence_card_expiry_date){
                                    $customerDlicenseExpDa = Carbon::parse($providerLead->vie_licence_card_expiry_date)->format('d/m/Y');
                                }
                                break;
                            case 'Passport':
                                $customerPassport = $providerLead->vie_passport_number ??'';
                                if($providerLead->vie_passport_card_expiry_date){
                                    $passportExpDate = Carbon::parse($providerLead->vie_passport_card_expiry_date)->format('d/m/Y');
                                }
                                break;
                            case 'Foreign Passport':
                                $customerPassport = $providerLead->vi_foreign_passport_number ??'';
                                
                                if($providerLead->vi_foreign_passport_expiry_date){
                                    $passportExpDate = Carbon::parse($providerLead->vi_foreign_passport_expiry_date)->format('d/m/Y');
                                }
                                break;
                            case 'Medicare Card':
                                $medicardNo = $providerLead->vi_medicare_number ??'';
                                break;
                            default:
                                break;
                        }
                    }

                    $delivery_method_code = 'POST';		//70
                    if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack == 0) {
                        $delivery_method_code = 'EMAIL';
                    }

                    
                    if ($providerLead->journey_property_type != 2 || $providerLead->vcd_concession_type == "Not Applicable") {
                   
                        $C = 'Y'; //
                        $concStartDate = $providerLead->vcd_card_start_date ??'';
                        $concEndDate = $providerLead->vcd_card_expiry_date ??'';
                        $cardType =$providerLead->vcd_concession_type ??'';
                        $concCardNumber = $providerLead->vcd_card_number ??'';
                        $concCardCode = $providerLead->vcd_concession_code ??'';
                        $concCardExpDate =$providerLead->vcd_card_expiry_date ??'';
                    }

                       
                    if ($providerLead->journey_life_support && $providerLead->journey_life_support ==1) {
                        $O = 'Y';		//87
                        $lifeSupportMachineType = $providerLead->journey_life_support_value ?? '';
                    }
                   

                

                    $estAnnKwhs = '';   
                    $postcode = $providerLead->va_postcode;  
                    if ($energy_type == 1) {
                       
                        $distributor_id = $providerLead->journey_distributor_id;
                        
                        if ($distributor_id != 'idontknow') {
                            $distributor_id =  $providerLead->journey_distributor_id;
                        } else {
                            $distributor_id = DistributorPostCode::where('post_code', $postcode)->first()->select('distributor_id');
                            
                        }
                        if ($providerLead->journey_property_type == 2) {
                            $peak_only_data = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 2, 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price', 'annual_usage')->first();
                        } else {
                            $peak_only_data = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 1, 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price', 'annual_usage')->first();
                        }
                        $estAnnKwhs = isset($peak_only_data->peak_only) ? round($peak_only_data->peak_only, 2) : '';  //108


                        if (empty($estAnnKwhs)) {
                            if ($providerLead->journey_property_type == 2) {
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
                            $estAnnKwhs = isset($elec_low_usage->elec_low_range) ? number_format($elec_low_usage->elec_low_range * 365, 2, '.', '') : '';  	//108
                        }
                    }
                    $MovingHouse = ($providerLead->journey_moving_house == 0) ? "N" : "Y";
                    if ($MovingHouse != "N") {
                        $transferType = "MOVEIN";
                    } else {
                        $transferType = "TRANSFER";
                    }
                    $proposedMoveInDate = '';	//131
                    if ($MovingHouse == 'Y' && $providerLead->journey_moving_date) {
                        $proposedMoveInDate  =  Carbon::parse($providerLead->journey_moving_date)->format('d/m/Y');
                    }
                    $FirstName = decryptGdprData($providerLead->vis_first_name) ?? '';  //AC

                    $LastName = decryptGdprData($providerLead->vis_last_name) ?? ''; //AD
                    $Title = $Title = strtoupper($providerLead->vis_title);;  //AB
                    $PhoneMobile = decryptGdprData($providerLead->vis_visitor_phone) ?? '';  //AH
                    
                    $alternatePhoneMobile = decryptGdprData($providerLead->vis_alternate_phone) ?? '';  //AH
                    $EmailAddress = decryptGdprData($providerLead->vis_email) ?? '';  //AI
                    $DateofBirth = $providerLead->vis_dob ? Carbon::parse($providerLead->vis_dob)->format('d/m/Y') : '';  
                    $qaNotes = $providerLead->vie_qa_notes_created_date ? Carbon::parse($providerLead->vie_qa_notes_created_date)->format('d/m/Y') : '';  
                    

                    if ($providerLead->vis_title && $providerLead->vis_title == 'Miss') {
                        $Title = 'MI';
                    } else if ($providerLead->vis_title == 'Sir') {
                        $Title = 'SR';
                    }
                    // set all selected data to respective column.
                    $providerData[$providerLead->spe_sale_status][] = array(
                        $refNo,	//1
                        $customerType,  		//2
                        $productTypeCode,  	//3
                        'Verified',  	//4
                        '',  			//5
                        //'CIMET',		//6
                        env('website_name'), //6 
                        '',  			//7
                        $FirstName,  		//8
                        $LastName,  			//9
                        $Title,  					//10
                        $partyName,  	//11
                        $companyType,  	//12
                        $industryType,  	//13
                        $acnNumber,  	//14
                        $abnNumber,  	//15
                        $providerLead->vie_nmi_number ?? '',
                        $providerLead->va_unit_type ?? '',	
                        $providerLead->va_unit_number ?? '18',	
                        $providerLead->va_floor_level_type ?? '',
                        $providerLead->va_floor_no ?? '20',
                        $providerLead->va_street_number ?? '',
                        $providerLead->va_street_number_suffix  ?? '',	
                        $providerLead->va_street_name ?? '', 
                        $providerLead->va_street_code ?? '', 
                        $providerLead->va_suburb ?? '', 	
                        $providerLead->va_state ?? '', 
                        $providerLead->va_postcode ?? '', 
                        $providerLead->va_property_name ?? '', 	
                        $providerLead->va_site_descriptor ?? '', 
                        $providerLead->vie_meter_hazard ?? '30', 
                        $providerLead->vie_site_access_electricity ?? '', 
                        $custPostalAddr1,       	//32
                        $custPostalAddr2,      	//33
                        $custPostalAddr3,     	//34
                        $custPostalCode,   		//35
                        '',  	//36
                        '',   	//37
                        '',		//38
                        '',		//39
                        '',		//40
                        '',		//41
                        '',  	//42
                        'E',  	//43
                        $providerLead->vie_qa_notes ?? '',  	//44
                        "04",  	//45
                        $PhoneMobile,  	//46
                        '',  	//47
                        $EmailAddress,  	//48
                        '',  	//49
                        '',  	//50
                        '',		//51
                        $DateofBirth, 	//52
                        $FirstName,  //53
                        $LastName,  	//54
                        $Title,  			//55
                        '',		//56
                        '',  	//57
                        '',  	//58
                        '',  	//59
                        $PhoneMobile,  	//60
                        '',		//61
                        $alternatePhoneMobile,  	//62
                        '',  	//63
                        $EmailAddress, 
                        $customerDlicense,			//65
                        $customerDlicenseExpDa,	//66
                        $customerPassport,			//67
                        $passportExpDate,			//68
                        'MONTHDAY3',  				//69
                        $delivery_method_code,  	//70
                        '',		//71
                        '',  	//72
                        '',  	//73
                        '100',  	//74  change27aug
                        'ELEC_VIC',  			//75
                        $providerLead->vie_electricity_network_code ?? '',		//77
                        '36MTH',  				//78
                        
                        $qaNotes,  	//79
                        $C, 					//80
                        $concStartDate, 		//81
                        $concEndDate,	 		//82
                        $cardType, 			//83
                        $concCardNumber,  	//84
                        $concCardCode, 		//85
                        $concCardExpDate, 	//86
                        $O,  	//87
                        '',  	//88
                        '',  	//89
                        $Title,  		//90
                        $transferType,	//91
                        'CHEQUE',  	//92
                        '',  	//93
                        '',  	//94
                        '',  	//95
                        '',		//96
                        '',  	//97
                        '',  	//98
                        '',  	//99
                        '',  	//100
                        $medicardNo,					//101
                        '',  	//102
                        $lifeSupportMachineType,  	//103
                        $providerLead->vie_electricity_code ?? '',
                        $providerLead->plan_plan_campaign_code ?? '',
                        '',			//106
                        '',  		//107
                        $estAnnKwhs,  	//108
                        '',  		//109
                        '',  		//110
                        '',			//111
                        '',  		//112
                        '',  		//113
                        $providerLead->va_lot_number ?? '',			//114
                        '',  		//115
                        $tradingName,		//116
                        '',  		//117
                        '',  		//118
                        '',  		//119
                        '',  		//120
                        '',			//121
                        $providerLead->vie_electricity_network_code ?? '',	//122
                        '',  		//123
                        '',  		//124
                        '',  		//125
                        '',			//126
                        '',  		//127
                        '',  		//128
                        '',  		//129
                        '',  		//130
                        $proposedMoveInDate,		//131
                        $providerLead->vie_qa_notes	?? '',
                        '',  		//133
                        '',  		//134
                        '0',  		//135
                        $providerLead->journey_prefered_move_in_time?? '',	//136
                    );
                }
            }
            
           
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'BlueNRG_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            
            $batchDetails = Providers::where('id', env('blueNRG'))->select('batch_number', 'batch_created_date')->first();
            $batch_number = $batchDetails ? $batchDetails->batch_number : 0;
            $batch_number = $batch_number + 1;
            $provider_update['batch_number'] = $batch_number;
            $provider_update['batch_created_date'] = Carbon::now();

            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                Providers::where('id', env('simply_energy'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'BlueNRG' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'BlueNRG' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
               
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'BlueNRG_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
        }
        catch (\Exception $e) {
           return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
