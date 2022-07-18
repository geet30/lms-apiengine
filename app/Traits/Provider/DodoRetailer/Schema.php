<?php

namespace App\Traits\Provider\DodoRetailer;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\DodoRetailer\Headings;
use Illuminate\Support\Facades\{Storage};
use App\Models\{Providers,Lead};
use Carbon\Carbon;
trait Schema
{
    function dodoRetailerSchema($providerLeads, $data)
    {
		
        try{
            $data['providerName'] = "DODO RETAILER";
            $data['mailType'] = 'test';
            $data['referenceNo'] = $refNo = $providerLeads[0]->sale_product_reference_no;
            $data['requestType'] = 'Fulfilment';

            $providerData =  $leadIds = [];
            $concession = 'N';	
			$salesName = $qaNotesCreatedDate = $agreementDate = $winterGasUsage = $summerGasUsage = $siteAddressPostcode =$kWhUsagePerDay = 	$SiteUnitNumber = $SiteUnitType = $SiteFloorNo = $SiteFloorTypeCode = $SiteSiteDescriptor = $SiteStreetName =$SiteStreetNumber = $SiteStreetCode = $SiteStreetNumberSuffix = $SiteSuburb = $SiteState = $SitePostCode=
			$concessionFirstName = $FirstName = $LastName =$concessionCardType = $concessionCardNo = $concessionLastName = $concessionStartDate = $concessionExpDate = $concessionMiddleName = $solarOutput = $solarPower = $referralCode= $meterType = $solarType =$customerSalutation = $DateofBirth = $secondaryDateOfBirth = $secondaryFirstName  =$secondaryLastName = $secondaryEmail =$secondarySalutation = $hearingImpaired = $connectionDate = $time =$DateofSale= $siteAccess = $siteLessThan12Months = $billingAddress =$billingPreferenceAddress =$newPassword = $newUsername = $customerDlicense =$customerDlicenseState = $customerDlicenseExp = $customerPassport = $customerPassportExp =  $positionAtCurrentEmployer = $greenEnergy = $lifeSupport =$lifeSupportMachineType = $lifeSupportNotes= $NMI = $NMISource =$MIRN = $MIRNSource =$electricityConnection = $gasConnection = $explicitInformedConsent = $monthDisconnection =$certElectricalSafety = $invoiceMethod =$EmailAddress = $PhoneMobile =$secondaryContact =  $billingAddress =$billingSuburb = $billingState  = $billingPostCode ='';
            foreach($providerLeads as $providerLead){
				$salesName = "CIMET";
				$energy_type = $providerLead->sale_product_product_type; 
				$qaNotesCreatedDate = Carbon::parse($providerLead->vie_qa_notes_created_date)->format('d/m/Y');
				
				$time = explode(" ", $providerLead->l_sale_created);
				if(isset($time[1]))
					$DateofSale = $qaNotesCreatedDate . "T" . $time[1];

				else
					$DateofSale = $qaNotesCreatedDate;

                $sameCurrentProvider = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.current_provider_id' => $providerLead->journey_current_provider_id,'lead_journey_data_energy.is_dual'=>1],['sale_products_energy.sale_status'])->count();
				// echo "<pre>";print_r($sameCurrentProvider);die('tets');
			
				if ($energy_type == 1) {
					$sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>2], ['lead_journey_data_energy.current_provider_id'])->first();
					
				} else {
					$sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>1], ['lead_journey_data_energy.current_provider_id'])->first();
					
				}

				array_push($leadIds, $providerLead->l_lead_id);
				if ($sameCurrentProvider == 2) {
				
					$productCode = "Power & Gas";
					if ($providerLead->journey_is_dual == 1) {
						if ($providerLead->plan_offer_code) {
							$referralCode = $providerLead->plan_offer_code ?? '';
						}
						
						if ($energy_type == 2 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12) && ($sale_other_record->sale_status != 4 && $sale_other_record->sale_status != 12)) {
					
							$productCode = "Gas";
						} elseif ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12) && ($sale_other_record->sale_status != 4 && $sale_other_record->sale_status != 12)) {
					
							$productCode = "Power";
						} else {
					
							$productCode = "Power & Gas";
							if (($energy_type == 2 || $energy_type == 1) && ($providerLead->spe_sale_status== 4 || $providerLead->spe_sale_status == 12) && ($sale_other_record->sale_status == 4 || $sale_other_record->sale_status == 12)) {
								
								if ($providerLead->plan_offer_code) {
									$referralCode = $providerLead->plan_offer_code ?? '';
								}
							}
						}
					}else{
						$referralCode = $providerLead->plan_offer_code ?? '';
					}
				
				} // if end
				else {
					if ($providerLead->journey_is_dual == 1) {
						if ($sale_other_record->current_provider_id != $providerLead->journey_current_provider_id) {
							$productCode = "Power";
							if ($energy_type == 2) {
								$productCode = "Gas";
							}
						} else {
							$productCode = "Power & Gas";
							if (($energy_type == 2) && ($providerLead->spe_sale_status== 4 || $providerLead->spe_sale_status == 12) && ($sale_other_record->sale_status != 4 || $sale_other_record->sale_status != 12)) {

								$productCode = "Gas";
							}elseif (($energy_type == 1) && ($providerLead->spe_sale_status== 4 || $providerLead->spe_sale_status == 12) && ($sale_other_record->sale_status != 4 || $sale_other_record->sale_status != 12)) {

								$productCode = "Power";
							}
						}
					} else {
						$productCode = "Power";
						if ($energy_type == 2) {
							$productCode = "Gas";
						}
						if ($providerLead->plan_offer_code) {
							$referralCode = $providerLead->plan_offer_code;
						}
					}
				}  //else end
				if ($providerLead->journey_property_type!= 2 || $providerLead->vcd_concession_type  != "Not Applicable") {

						
					$concession = "Y";
					$concessionFirstName = decryptGdprData($providerLead->vis_first_name);
					$concessionLastName = decryptGdprData($providerLead->vis_last_name);
					if (in_array($providerLead->vcd_concession_type, $this->hcc)) {
						$concessionCardType = 'HCC';
					}else if (in_array($providerLead->vcd_concession_type, $this->pcc)) {
						$concessionCardType = 'PCC';
					}else{
						$concessionCardType = "Veteran Affairs Card";
					}

					if ($providerLead->vcd_card_number) {

						$concessionCardNo = $providerLead->vcd_card_number;
					}
					
					if ($providerLead->vcd_card_start_date) {

						$concessionStartDate =  $providerLead->vcd_card_start_date ?? '';
					}

					if ($providerLead->vcd_card_expiry_date) {

						$concessionExpDate =   $providerLead->vcd_card_expiry_date ??'';
					}
				}
				if ($energy_type == 1) {
					$solarPower = "No";
					if ($providerLead->journey_solar_panel == 1) {
						$solarPower = "Yes";
					}
					if ($providerLead->journey_moving_house == 1 || $providerLead->journey_bill_available == 0) {
						$solarOutput = "100 kWh";
					} else {
						$solarOutput = $providerLead->ebd_solar_usage . " kWh";
					}
				}
				else{
					$solarPower = "";
				}
				
				$meterType = $providerLead->ebd_tariff_type ?? 'Unsure - Peak (Standard Residential GD)';

				$customerSalutation =  strtoupper($providerLead->vis_title);
				$FirstName = decryptGdprData($providerLead->vis_first_name) ?? '';  //AC
				$LastName = decryptGdprData($providerLead->vis_last_name) ?? ''; //AD
				$DateofBirth =  $providerLead->vis_dob ? Carbon::parse($providerLead->vis_dob)->format('d/m/Y') : '';

				$PhoneMobile = decryptGdprData($providerLead->vis_visitor_phone) ?? '';  //AH
				$EmailAddress = decryptGdprData($providerLead->vis_email) ?? '';  //AI
				$hearingImpaired = $secondaryContact = "No";
				
				if ($providerLead->vie_is_connection_joint_account_holder && $providerLead->vie_is_connection_joint_account_holder != 0) {
					$secondaryContact = "Yes";
					if ($providerLead->vie_joint_acc_holder_dob) {
						$secondaryDateOfBirth = $providerLead->vie_joint_acc_holder_dob;
					}
					if ($providerLead->vie_joint_acc_holder_first_name) {
						$secondaryFirstName = $providerLead->vie_joint_acc_holder_first_name;
					}
					if ($providerLead->vie_joint_acc_holder_last_name) {
						$secondaryLastName = $providerLead->vie_joint_acc_holder_last_name;
					}
					if ($providerLead->vie_joint_acc_holder_email) {
						$secondaryEmail = $providerLead->vie_joint_acc_holder_email;
					}
					if ($providerLead->vie_joint_acc_holder_title) {
						$secondarySalutation = $providerLead->vie_joint_acc_holder_title;
					}
					
				}
				
				
				$siteLessThan12Months = "No";
				if ($providerLead->l_billing_preference == 1 && ($providerLead->l_email_welcome_pack == 0 || $providerLead->l_billing_preference == 2)) {

					$billingPreferenceAddress = "No";
				} else {

					$billingPreferenceAddress = "Yes";
				}
				$year = Carbon::parse($providerLead->vis_dob)->format('d/m/Y');
				$year = explode("/", $year);
				$user_dob = "";
				if (!empty($year)) {
					$user_dob = $year[2] . $year[1] . $year[0];
				}

				$newUsername = ucfirst(strtolower($FirstName)) . $user_dob;

				$newPassword = ucfirst(strtolower(str_replace(' ', '', $LastName))) .$PhoneMobile;
				$identity_info_type = $providerLead->vie_identity_type ?? '';
				if ($identity_info_type && ($identity_info_type == 'Passport' || $identity_info_type == 'Foreign Passport')) {
					if ($providerLead->vie_passport_number) {
						$customerPassport = $providerLead->vie_passport_number;
					}
					if($providerLead->vie_passport_card_expiry_date){
						$customerPassportExp = Carbon::parse($providerLead->vie_passport_card_expiry_date)->format('d/m/Y');
					}
				}
				if ($identity_info_type && $identity_info_type == 'Drivers Licence') {
					
					$customerDlicense = $providerLead->vie_licence_number;
					$customerDlicenseState = $providerLead->vie_licence_state_code;
					if($providerLead->vie_licence_card_expiry_date){
						$customerDlicenseExp =Carbon::parse($providerLead->vie_licence_card_expiry_date)->format('d/m/Y');
					}
				}
				
				


				$electricityConnection = $gasConnection = $explicitInformedConsent = "Yes";
				$monthDisconnection = $certElectricalSafety = "No";
				if ($energy_type == 2) {
					$winterGasUsage = "100Mj";
					$summerGasUsage = "100Mj";
					$siteAccess = $providerLead->vie_site_access_electricity ?? '';
					if ($providerLead->vga_is_same_gas_connection != 0) {
						if ($providerLead->vga_postcode) {
							$siteAddressPostcode = $providerLead->vga_postcode;
						}
					} else {

						if ($providerLead->va_postcode) {
							$siteAddressPostcode = $providerLead->va_postcode;
						}
					}
				} else {

					$kWhUsagePerDay  = "10kWh";
					$siteAccess = $providerLead->vie_site_access_gas ?? '';
					if ($providerLead->va_postcode) {
						$siteAddressPostcode = $providerLead->va_postcode;
					}
				}
				$positionAtCurrentEmployer = "Other";
			
				$MovingHouse = ($providerLead->journey_moving_house == 0) ? "N" : "Y";
				if ($MovingHouse == 'Y' && $providerLead->journey_moving_date) {
					$connectionDate  =  Carbon::parse($providerLead->journey_moving_date)->format('d/m/Y');
				}

				if ($energy_type  ==1) {
					$NMI =  $providerLead->vie_nmi_number ?? '';
					$NMISource = "Search MSATs Address";
					$electricityConnection = "Yes";
					$gasConnection = "";
				}
				else{

					$MIRN = $providerLead->vie_dpi_mirn_number ?? '';
					$MIRNSource = "Search MSATs Address";
					$electricityConnection = "";
					$gasConnection = "Yes";
				}
				$greenEnergy = $lifeSupport = "No";
				$lifeSupportNotes = $lifeSupportMachineType = "";
				if ($providerLead->journey_life_support && $providerLead->journey_life_support == 1) {
					$lifeSupport = "Y";
					$lifeSupportNotes = $providerLead->vie_life_support_notes ?? '';
					$lifeSupportMachineType = $providerLead->journey_life_support_value ?? '';
				}
				if ($providerLead->vga_is_same_gas_connection == 1 && $providerLead->journey_is_dual == 1) {

					if ($energy_type == 1) {

						foreach ($this->dodopostalFields as $postalField => $fieldName) {
							${$postalField} = $providerLead->{'va_' . $fieldName};
						}	
					} else {
						foreach ($this->dodopostalFields as $postalField => $fieldName) {
							${$postalField} = $providerLead->{'vga_' . $fieldName};
						}	
						
					}
				} else {

					foreach ($this->dodopostalFields as $postalField => $fieldName) {
						${$postalField} = $providerLead->{'va_' . $fieldName};
					}
					
				}
				
				if ($energy_type != 2) {

					if ($providerLead->is_po_box == 1) {
						foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
							${$postalField} = $providerLead->{'vpa_' . $fieldName};
						}
					}
					else{

						if ($providerLead->l_billing_preference == 3) {
							foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
								${$postalField} = $providerLead->{'vba_' . $fieldName};
							}
						
						}
						else if ($providerLead->l_billing_preference == 2) {//2
							foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
								${$postalField} = $providerLead->{'va_' . $fieldName};
							}  
							
						}
						else if ($providerLead->l_billing_preference == 1) {
							if ($providerLead->l_email_welcome_pack == 1) {
								foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
									${$postalField} = $providerLead->{'vba_' . $fieldName};
								}
							} else {
								foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
									${$postalField} = $providerLead->{'va_' . $fieldName};
								}                                                  
							}                
						}

					}
				} else {

					if ($providerLead->is_po_box == 1) {
						foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
							${$postalField} = $providerLead->{'vpa_' . $fieldName};
						}
					} else{
						if ($providerLead->l_billing_preference == 3) {
							foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
								${$postalField} = $providerLead->{'vba_' . $fieldName};
							}
						
						}

						else if ($providerLead->l_billing_preference == 2) {//2
							if($providerLead->va_is_same_gas_connection  == 1){
								foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
									${$postalField} = $providerLead->{'vga_' . $fieldName};
								}
							} else {
								foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
									${$postalField} = $providerLead->{'va_' . $fieldName};
								}
							}
						}
						else if ($providerLead->l_billing_preference == 1) {
							if ($providerLead->l_email_welcome_pack == 1) {
								foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
									${$postalField} = $providerLead->{'vba_' . $fieldName};
								}
							} else {
								if($providerLead->va_is_same_gas_connection  == 1){
									foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
										${$postalField} = $providerLead->{'vga_' . $fieldName};
									}
								
								} else {
									foreach ($this->dodoBillingpostalFields as $postalField => $fieldName) {
										${$postalField} = $providerLead->{'va_' . $fieldName};
									}
			
									
								}               
								
							}                
						}
					}
				}

				if ($energy_type == 1 || $providerLead->journey_solar_panel == 1 && $providerLead->ebd_solar_tariff == "normal") {
					$solarType = "General Feed in Tariff - 12.0 cent rate";
				} 
				elseif ($energy_type == 1 || $providerLead->journey_solar_panel == 1 && $providerLead->ebd_solar_tariff == "premium") {
					$solarType = "Premium Solar Feed in Tariff - 60 cents";
				} 
				elseif ($energy_type == 1 || $providerLead->journey_solar_panel == 1  && $providerLead->journey_bill_available == 0) {
					$solarType = "General Feed in Tariff - 12.0 cent rate ";
				} 
				else {
					$solarType = "General Feed in Tariff - 12.0 cent rate ";
				}

				if ($providerLead->l_billing_preference == 1) {

					$invoiceMethod = "Online Account Management";
				} else {

					$invoiceMethod = "Post - $2.20 charge per invoice";
				}
		
				$providerData[$providerLead->spe_sale_status][] = array(
					$salesName,
					$refNo,
					$DateofSale,
					$SitePostCode,
					$concession,
					$concessionCardType,
					$concessionCardNo,
					$concessionStartDate,
					$concessionExpDate,
					$concessionFirstName,
					$concessionMiddleName,
					$concessionLastName,
					$productCode,
					$meterType,
					$kWhUsagePerDay,
					'',
					'',
					$solarPower,
					$solarType,
					$solarOutput,
					$greenEnergy,
					$winterGasUsage,
					$summerGasUsage,
					'',
					'',
					$invoiceMethod,
					$customerSalutation,
					$FirstName,
					$LastName,
					$DateofBirth,
					$EmailAddress,
					$PhoneMobile,
					$hearingImpaired,
					$secondaryContact,
					$secondarySalutation,
					$secondaryFirstName,
					$secondaryLastName,
					$secondaryDateOfBirth,
					$secondaryEmail,
					$SiteUnitType,
					$SiteUnitNumber,
					$SiteFloorTypeCode,
					$SiteFloorNo,
					$SiteStreetNumber,
					$SiteStreetNumberSuffix,
					$SiteStreetName,
					$SiteStreetCode,
					$SiteSuburb,
					$SiteState,
					$siteAddressPostcode,
					$SiteSiteDescriptor,
					$siteAccess,
					$siteLessThan12Months,
					'',
					'',
					'',
					'',
					$billingPreferenceAddress,
					$billingAddress,
					$billingSuburb,
					$billingState,
					$billingPostCode,
					$referralCode,
					$newUsername,
					$newPassword,
					$customerDlicense,
					$customerDlicenseState,
					$customerDlicenseExp,
					$customerPassport,
					$customerPassportExp,
					$positionAtCurrentEmployer,
					'Contract',
					'ACME',
					'0390000000',
					'4',
					'4',
					"Yes",
					$lifeSupport,
					$lifeSupportMachineType,
					$lifeSupportNotes,
					$NMI,
					$NMISource,
					$MIRN,
					$MIRNSource,
					$connectionDate,
					$electricityConnection,
					$gasConnection,
					$monthDisconnection,
					$certElectricalSafety,
					'',
					'',
					$explicitInformedConsent

				);
            }//end foreach

            
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = '​DODO_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            
            $batchDetails = Providers::where('id', env('​DODO_Sales'))->select('batch_number', 'batch_created_date')->first();
            $batch_number = $batchDetails ? $batchDetails->batch_number : 0;
            $batch_number = $batch_number + 1;
            $provider_update['batch_number'] = $batch_number;
            $provider_update['batch_created_date'] = Carbon::now();

            $providerLeadData = $fileName = $filenameOffset = null;

            $data['leadIds'] = $leadIds;
			if (array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                Providers::where('id', env('​DODO_Sales'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'DODO_Sales' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
				return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (array_key_exists('12', $providerData)) {
                
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = '​DODO_Sales' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
               
            }
            return false;
        }
        catch (\Exception $e) {
			// echo "<pre>";print_r($e->getMessage());echo "<br>";print_r($e->getFile());echo "<br>";print_r($e->getLine());die;
           return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
