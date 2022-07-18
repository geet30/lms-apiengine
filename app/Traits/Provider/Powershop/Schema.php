<?php
namespace App\Traits\Provider\PowerShop;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\EnergyAustralia\Headings;
use Illuminate\Support\Facades\{Storage};
use Carbon\Carbon;
trait Schema
{
    function powerShopSchema($providerLeads, $data,$mail_type = null)
    {  
		try{
			$providerData =  $lead_ids = $reference_key_array = $processed_refNum = [];
			$submit_data_inc = $resubmit_data_inc = $send_schema = 0; 
			$leadIds = [];
			if (isset($providerLeads)) { 
				$refrence_column = array_column($providerLeads->toArray(), 'sale_product_reference_no', 'l_lead_id'); 
				foreach ($providerLeads as $providerLead) { 
					if ($mail_type == "test") {
						$providerLead->spe_sale_status = 4;
					}
					if (empty($providerLead->spe_sale_status)) {
						$providerLead->spe_sale_status = 4;
					}
					//check if reference number is duplicate or not
					if (!in_array($providerLead->spe_sale_status . '_' . $providerLead->sale_product_reference_no, $processed_refNum)) {
						if (in_array($providerLead->sale_product_reference_no, $refrence_column)) {
							$processed_refNum[] = $providerLead->spe_sale_status . '_' . $providerLead->sale_product_reference_no;
							if ($providerLead->spe_sale_status == 4) {
								$reference_key_array[$providerLead->sale_product_reference_no] = $submit_data_inc;
								$submit_data_inc++;
							}
							if ($providerLead->spe_sale_status == 12) {
								$reference_key_array[$providerLead->sale_product_reference_no] = $resubmit_data_inc;
								$resubmit_data_inc++;
							}
							if ($mail_type == "test") {
								$reference_key_array[$providerLead->sale_product_reference_no] = $send_schema;
								$send_schema++;
							}
							array_push($leadIds, $providerLead->l_lead_id);
						}
						// store all leads id
						$lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id; 
						$moving_date = '';
						$fuel_type = '';
						$gas_moving_date = '';
						$card_expiry_date = "";
						$id_number = '';
						$type_id = '';
						$id_expery_date = '';
						$concession_type = '';
						$concession_name = "";
						$concession_card_number = '';
						$type_of_sale = '';
						$state_code = '';
						$billing_state_code = '';
						$Token = "";
						$supply_address = "";
						$mailing_address = "";
						$complete_full_address = "";
						$billing_full_address = "";
						$billing_suburb = "";
						$billing_state = "";
						$billing_postcode = "";
						$connection_suburb = "";
						$connection_state = "";
						$connection_postcode = "";
						$temp_suburb = '';
						$temp_postcode = '';
						$nmi_number = '';
						$dpi_mirn_number = '';
						// medical equipment
						$medical_equipment = '';
						$state_array = ['NSW' => 'New South Wales', 'QLD' => 'Queensland', 'SA' => 'South Australia', 'TAS' => 'Tasmania', 'VIC' => 'Victoria', 'WA' => 'Western Australia', 'ACT' => 'Australian Capital Territory'];

						$customername = $providerLead->vis_first_name . ' ' . $providerLead->vis_last_name;
						/* Start moving address */
						if (isset($providerLead->va_state)) {
							if (array_key_exists($providerLead->va_state, $state_array)) {
								$state_code = $state_array[$providerLead->va_state];
							}
						}
						/*  End */
						
						/* Start concession_type */
						if ($providerLead->journey_energy_type == '1' || $providerLead->vcd_concession_type == 'Not Applicable') {
							$concession_type =  $concession_name =  $concession_card_number =  $card_expiry_date = '';
						} else {
							// concession card number
							$concession_card_number = (isset($providerLead->vcd_card_number) && !empty($providerLead->vcd_card_number)) ? $providerLead->vcd_card_number : '';

							// concession card expiry date
							if (!empty($providerLead->vcd_card_expiry_date)) {
								$card_expiry_date = implode("/", explode("/", $providerLead->vcd_card_expiry_date));
							}

							if (in_array($providerLead->vcd_concession_type, ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'])) {
								$concession_type = 'HCC';
								$concession_name = $customername;
							} else if (in_array($providerLead->vcd_concession_type, ['Pensioner Concession Card', 'Queensland Government Seniors Card'])) {
								$concession_type = 'PCC';
								$concession_name = $customername;
							} else if (in_array($providerLead->vcd_concession_type, ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'])) {
								$concession_type = 'DVAGC';
								$concession_name = $customername;
							} else {
							}
						}
						/* End */ 
						/* Start identity_type */
						if (!empty($providerLead->vie_identity_type) && $providerLead->vi_identification_type == 'Drivers Licence') {
							if (isset($providerLead->vi_licence_number)) {
								$id_number = $providerLead->vi_licence_number;
							}
							if (isset($providerLead->vi_licence_card_expiry_date)) {
								$id_expery_date = \Carbon\Carbon::parse($providerLead->vi_licence_card_expiry_date)->format('d/m/Y');
							}
							$type_id = 'Drivers Licence';
						} else if (!empty($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Passport') {
							$id_number = $providerLead->vi_passport_number;
							if (isset($providerLead->vi_passport_card_expiry_date)) {
								$id_expery_date = \Carbon\Carbon::parse($providerLead->vi_passport_card_expiry_date)->format('d/m/Y');
							}
							$type_id = 'Passport';
						} else if (!empty($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Foreign Passport') {
							$id_number = $providerLead->vi_passport_number;
							if (isset($providerLead->vi_passport_card_expiry_date)) {
								$id_expery_date = \Carbon\Carbon::parse($providerLead->vi_passport_card_expiry_date)->format('d/m/Y');
							}
							$type_id = 'Foreign Passport';
						} else if (!empty($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Medicare Card') {
							$id_number = $providerLead->vi_medicare_number;
							if (isset($providerLead->vi_medicare_card_expiry_date)) {
								$id_expery_date = \Carbon\Carbon::parse($providerLead->vi_medicare_card_expiry_date)->format('m/Y');
							}
							$type_id = 'Medicare Card';
						} else {
						}
						/* End */
						/* Start solor_panels */
						if ($providerLead->journey_moving_house == '0') {
							$type_of_sale = 'In Situ';
						}
						if ($providerLead->journey_moving_house == '1') {
							$type_of_sale = 'Move In';
						}
						/* End */

						/* Start phone */
						$phone = $providerLead->vis_visitor_phone;
						if (substr($phone, 0, 2) == 61) {
							$phone = $phone;
						} else {
							$temp_phn = (string)$phone;
							$phone = '61' . ltrim($temp_phn, '0');
						}
						// life support machine code value if life support is selected
						if ($providerLead->journey_life_support == '1') {
							$medical_equipment =  $providerLead->journey_life_support_value;
						} else {
							$medical_equipment = '';
						}

						if ($providerLead->journey_energy_type == '1') {
							$fuel_type = 'Electricity';
							$nmi_number = $providerLead->vie_nmi_number ? $providerLead->vie_nmi_number : '';
							if ($providerLead->journey_moving_house == "1") {
								$moving_date = implode("/", explode("/", $providerLead->journey_moving_date));
							}
						} else {
							$fuel_type = 'Gas';
							$dpi_mirn_number =  $providerLead->vie_dpi_mirn_number ? $providerLead->vie_dpi_mirn_number : '';
							if ($providerLead->journey_moving_house == "1") {
								$gas_moving_date = implode("/", explode("/", $providerLead->journey_moving_date));
							}
						}

						$Token = (isset($providerLead->vie_token) && !empty($providerLead->ve_token)) ? $providerLead->vie_token : '';

						// connection address
						$complete_address =  $suburb =  $state =  $postcode = '';
						if (isset($providerLead->va_property_name) && !empty($providerLead->property_name)) {
							$complete_address = $complete_address . $providerLead->va_property_name;
						}
						if (isset($providerLead->va_unit_type) && !empty($providerLead->va_unit_type)) {
							if(isset($providerLead->va_property_name) && !empty($providerLead->va_property_name)) {
								$complete_address = $complete_address . ' ' . $providerLead->va_unit_type;
							} else {
								$complete_address = $complete_address . $providerLead->va_unit_type;
							}
						}
						if (isset($providerLead->va_lot_number) && !empty($providerLead->va_lot_number)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_lot_number;
						}
						if (isset($providerLead->va_unit_no) && !empty($providerLead->va_unit_no)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_unit_no;
						}
						if (isset($providerLead->va_house_num) && !empty($providerLead->va_house_num)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_house_num;
						}
						if (isset($providerLead->va_house_number_suffix) && !empty($providerLead->va_house_number_suffix)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_house_number_suffix;
						}
						if (isset($providerLead->va_floor_no) && !empty($providerLead->va_floor_no)) {
							$complete_address = $complete_address . ' ' . $providerLead['floor_no'];
						}
						if (isset($providerLead->va_floor_level_type) && !empty($providerLead->va_floor_level_type)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_floor_level_type;
						}

						if (isset($providerLead->va_street_number) && !empty($providerLead->va_street_number)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_street_number;
						}

						if (isset($providerLead->va_street_number_suffix) && !empty($providerLead->va_street_number_suffix)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_street_number_suffix;
						}
						if (isset($providerLead->va_street_suffix) && !empty($providerLead->va_street_suffix)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_street_suffix;
						}
						if (isset($providerLead->va_street_name) && !empty($providerLead->va_street_name)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_street_name;
						}
						if (isset($providerLead->va_street_code) && !empty($providerLead->va_street_code)) {
							$complete_address = $complete_address . ' ' . $providerLead->va_street_code;
						}
						// extra connection adress code
						/* suburb*/
						if (isset($providerLead->va_suburb) && !empty($providerLead->va_suburb)) {
							$suburb = $providerLead->va_suburb;
						}
						/* state*/
						if (isset($providerLead->va_state) && !empty($providerLead->va_state)) {
							$state = $providerLead->va_state;
						}
						/* postcode*/
						if (isset($providerLead->va_postcode) && !empty($providerLead->va_postcode)) {
							$postcode = $providerLead->va_postcode;
						}
						$complete_full_address = $complete_address;
						$connection_suburb = $suburb;
						$connection_postcode = $postcode;

						/* Billing address */ 
						$billing_address =  $suburb =  $state =  $postcode = '';
						if (isset($providerLead->vba_property_name) && !empty($providerLead->property_name)) {
							$billing_address = $billing_address . $providerLead->vba_property_name;
						}
						if (isset($providerLead->vba_unit_type) && !empty($providerLead->vba_unit_type)) {
							if(isset($providerLead->vba_property_name) && !empty($providerLead->vba_property_name)) {
								$billing_address = $billing_address . ' ' . $providerLead->vba_unit_type;
							} else {
								$billing_address = $billing_address . $providerLead->vba_unit_type;
							}
						}
						if (isset($providerLead->vba_lot_number) && !empty($providerLead->vba_lot_number)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_lot_number;
						}
						if (isset($providerLead->vba_unit_no) && !empty($providerLead->vba_unit_no)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_unit_no;
						}
						if (isset($providerLead->vba_house_num) && !empty($providerLead->vba_house_num)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_house_num;
						}
						if (isset($providerLead->vba_house_number_suffix) && !empty($providerLead->vba_house_number_suffix)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_house_number_suffix;
						}
						if (isset($providerLead->vba_floor_no) && !empty($providerLead->vba_floor_no)) {
							$billing_address = $billing_address . ' ' . $providerLead['floor_no'];
						}
						if (isset($providerLead->vba_floor_level_type) && !empty($providerLead->vba_floor_level_type)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_floor_level_type;
						}

						if (isset($providerLead->vba_street_number) && !empty($providerLead->vba_street_number)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_street_number;
						}

						if (isset($providerLead->vba_street_number_suffix) && !empty($providerLead->vba_street_number_suffix)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_street_number_suffix;
						}
						if (isset($providerLead->vba_street_suffix) && !empty($providerLead->vba_street_suffix)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_street_suffix;
						}
						if (isset($providerLead->vba_street_name) && !empty($providerLead->vba_street_name)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_street_name;
						}
						if (isset($providerLead->vba_street_code) && !empty($providerLead->vba_street_code)) {
							$billing_address = $billing_address . ' ' . $providerLead->vba_street_code;
						}
						// extra connection adress code
						/* suburb*/
						if (isset($providerLead->vba_suburb) && !empty($providerLead->vba_suburb)) {
							$suburb = $providerLead->vba_suburb;
						}
						/* state*/
						if (isset($providerLead->vba_state) && !empty($providerLead->vba_state)) {
							$state = $providerLead->va_state;
						}
						/* postcode*/
						if (isset($providerLead->vba_postcode) && !empty($providerLead->vba_postcode)) {
							$postcode = $providerLead->vba_postcode;
						}
						$billing_full_address = $billing_address;
						$billing_suburb = $suburb;
						$billing_postcode = $postcode; 
						$supply_address = $complete_full_address;

						if ($providerLead->l_billing_preference == '1' || ($complete_full_address == $billing_full_address) || $providerLead->l_billing_preference == '2') {
							$mailing_address = $complete_full_address;
							$temp_suburb = $connection_suburb;
							$temp_postcode = $connection_postcode;
							$billing_state_code = $state_code;
						} else {
							$mailing_address = $billing_full_address;
							$temp_suburb = $billing_suburb;
							$temp_postcode = $billing_postcode;
							if (isset($providerLead->va_state)) {
								if (array_key_exists($providerLead->va_state, $state_array)) {
									$billing_state_code = $state_array[$providerLead->va_state];
								}
							}
						}
						/* End */
						$providerData[$providerLead->spe_sale_status][] = array(
							'Powershop', //A
							'CIMET', //B
							(($providerLead->journey_property_type == '2') ? 'Residential' : 'Business'), //C
							$nmi_number, //D
							$dpi_mirn_number, //E
							$moving_date, //F
							$gas_moving_date, //G
							$type_of_sale, //H
							$fuel_type, //I
							$providerLead->vis_title, //J
							decryptGdprData($providerLead->vis_first_name), //K
							decryptGdprData($providerLead->vis_last_name), //L
							\Carbon\Carbon::parse(decryptGdprData($providerLead->vis_dob))->format('d/m/Y'), //M
							isset($providerLead->business_legal_name) ? $providerLead->vbd_business_legal_name : "", //N
							'', //O
							'', //P
							$phone, //Q
							decryptGdprData($providerLead->vis_email), //R
							(strlen($providerLead->vbd_business_abn) > 9 ? $providerLead->vbd_business_abn : ''), //S
							(strlen($providerLead->vbd_business_abn) <= 9 ? $providerLead->vbd_business_abn : ''), //T
							$id_number, //U
							(!empty($id_expery_date) ? $id_expery_date : ''), //V
							$type_id, //W
							$concession_card_number, //X
							$concession_type, //Y
							$card_expiry_date, //Z
							$concession_name, //AA
							'', //AB
							'', //AC
							'', //AD
							'', //AE
							$supply_address, //AF
							(isset($providerLead->va_suburb) ? $providerLead->va_suburb : ''), //AG
							$state_code, //AH
							(isset($providerLead->va_postcode) ? $providerLead->va_postcode : ''), //AI
							$mailing_address, //AJ
							$temp_suburb, //AK
							$billing_state_code, //AL
							$temp_postcode, //AM
							(isset($providerLead->va_property_ownership) ? $providerLead->va_property_ownership . 'er' : ''), //AN
							'Bulkbargains', //AO
							'Yes', //AP
							'', //AQ
							'', //AR
							'', //AS
							'', //AT
							'', //AU
							'', //AV
							'', //AW
							'', //AX
							$medical_equipment, //AY
							'Yes', //AZ
							'No', //BA
							$Token, //BB
							'', //BC
							'', //BD
							'Other', //BE
							'', //BF
							'', //BG
							'', //BH
							'' //BI
						);
					} else {
						$lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id;

						$fuel_type = 'Two Fuel';
						$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->sale_product_reference_no]][8] = $fuel_type;

						//add values that are not same in both case
						if ($providerLead->journey_energy_type == '1') {
							$nmi_number = $providerLead->vie_nmi_number ? $providerLead->vie_nmi_number : '';
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->sale_product_reference_no]][3] = $nmi_number;
							if ($providerLead->journey_moving_house == "1") {
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->sale_product_reference_no]][5] = implode("/", explode("/", $providerLead->journey_moving_date));
							}
						} elseif ($providerLead->journey_energy_type == '2') {
							$dpi_mirn_number = $providerLead->vie_dpi_mirn_number ? $providerLead->vie_dpi_mirn_number : '';
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->sale_product_reference_no]][4] = $dpi_mirn_number;
							if ($providerLead->journey_moving_house == "1") {
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->sale_product_reference_no]][6] = implode("/", explode("/", $providerLead->journey_moving_date));
							}
						} else {
						}
					}
				}
			}
			// dd($providerData);
			$data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'POWERSHOP_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            
            $providerLeadData = $fileName = $filenameOffset = null;
			$data['leadIds'] = $leadIds;
            if (array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $status = 4;
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'POWERSHOP' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (array_key_exists('12', $providerData)) {
                
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $status = 12;
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'POWERSHOP' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
               
            }
            return false;
	    }
		catch (\Exception $e) {
			return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
		}
	}
}
