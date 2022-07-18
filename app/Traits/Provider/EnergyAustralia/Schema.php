<?php

namespace App\Traits\Provider\EnergyAustralia;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\EnergyAustralia\Headings;
use Illuminate\Support\Facades\{Storage};
use Carbon\Carbon;
trait Schema
{
    function energyAustraliaSchema($providerLeads, $data)
    { 
		
		try{
            $key_array = $reference_key_array = $providerData =$providerData = [];
            $submit_data_inc = $resubmit_data_inc = $send_schema = $mail_type = 0;
            $data['providerName'] = 'ENERGY AUSTRALIA';  
			$leadIds = [];
            $reference_column = array_column($providerLeads->toArray(), 'sale_product_reference_no', 'l_lead_id'); 
            foreach ($providerLeads as $providerLead) {  
                $providerData['data'] = $providerLead->l_lead_id; 
					if (!in_array($providerLead->spe_sale_status . '_' . $providerLead->sale_product_reference_no, $key_array)) {
						if (in_array($providerLead->sale_product_reference_no, $reference_column)) {
							$key_array[] = $providerLead->spe_sale_status . '_' . $providerLead->sale_product_reference_no;
							if ($providerLead->spe_sale_status == '4') {
								$reference_key_array[$providerLead->sale_product_reference_no] = $submit_data_inc;
								$submit_data_inc++;
							}
							if ($providerLead->spe_sale_status == '12') {
								$reference_key_array[$providerLead->sale_product_reference_no] = $resubmit_data_inc;
								$resubmit_data_inc++;
							}
							if ($mail_type == "test") {
								$reference_key_array[$providerLead->sale_product_reference_no] = $send_schema;
								$send_schema++;
							}
							array_push($leadIds, $providerLead->l_lead_id);
						}   

						$phone = decryptGdprData($providerLead->vis_alternate_phone);
						if (substr($phone, 0, 2) == 61) {
							$phone = substr($phone, 2);
						}
						$id_first_name = decryptGdprData($providerLead->vis_first_name);
						$id_last_name = decryptGdprData($providerLead->vis_last_name);
						$id_middle_name = '';

						$id_number = '';
						$type_id = '';
						$medicare_exp_date = '';
						if (isset($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Drivers Licence') {
							$id_number = $providerLead->vi_licence_number;
							$type_id = 'Drivers Licence';
						} else if (isset($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Passport') {
							$id_number = $providerLead->vi_passport_number;
							$type_id = 'Passport';
						} else if (isset($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Foreign Passport') {
							$id_number = $providerLead->vi_foreign_passport_number;
							$type_id = 'Passport';
						} else if (isset($providerLead->vi_identification_type) && $providerLead->vi_identification_type == 'Medicare Card') {
							$id_number = $providerLead->vi_medicare_number;
							$id_middle_name = $providerLead->vi_card_middle_name;
							if (isset($providerLead->vi_medicare_card_expiry_date)) { 
								$medicare_exp_date = \Carbon\Carbon::parse($providerLead->vi_medicare_card_expiry_date)->format('m/Y');
							}
							$type_id = 'Medicare Card';
						} 

						$mailing_street_num =  $nmi_number =  $dpi_mirn_number = $elec_plan = $gas_plan  = $product_code_e =  $product_code_g =  $site_electricity_code =  $solar_buypack_rate = '';
						$elec_fuel =  $elec_gas = 'NO';
                         
						//set NMI and MIRN field
						if ($providerLead->journey_property_type == '1') {
							$nmi_number = isset($providerLead->vie_nmi_number) ? $providerLead->vie_nmi_number : '';
							$site_electricity_code = isset($providerLead->vie_electricity_network_code) ? $providerLead->vie_electricity_network_code : '';
							$solar_buypack_rate = isset($providerLead->vie_electricity_code) ? $providerLead->vie_electricity_code : '';
						} else if ($providerLead->journey_property_type == '2') {
							$dpi_mirn_number = isset($providerLead->vie_dpi_mirn_number) ? $providerLead->vie_dpi_mirn_number : '';
						}
						$energy_type = $providerLead->sale_product_product_type ?? '';
						if ($providerLead->journey_is_dual == 1) {
							if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
								// $elec_sale = 1;
								$product_code_e = $providerLead->plan_product_code ?? '';
								$elec_fuel = 'YES';
								$elec_plan = $providerLead->plan_name ?? '';
							} else if ($energy_type ==2 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
								// $gas_sale = 1;
								$product_code_g =  $providerLead->plan_product_code ?? '';
								$elec_gas = 'YES';
								$gas_plan = $providerLead->plan_name ?? '';
							}
						} else {

							if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
								// $elec_sale = 1;
								$product_code_e =  $providerLead->plan_product_code ?? '';
								$elec_fuel = 'YES';
								$elec_plan = $providerLead->plan_name ?? '';
							} else if ($energy_type == 2 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
								// $gas_sale = 1;
								$product_code_g =  $providerLead->plan_product_code ?? '';
								$elec_gas = 'YES';
								$gas_plan = $providerLead->plan_name ?? '';
							}
						} 

						$sale_created_date = (isset($providerLead->vie_qa_notes_created_date) && !empty($providerLead->vie_qa_notes_created_date)) ? $providerLead->vie_qa_notes_created_date : '';

						$supply_street_num = '';
						$supply_street_num = isset($providerLead->va_street_number) ? $providerLead->va_street_number : '';
						$supply_street_num = $supply_street_num . (isset($providerLead) ? $providerLead->va_street_number_suffix : '');
						$mailing_street_num = $supply_street_num;

						if ($providerLead->l_billing_preference == '3') {
							$mailing_street_num = isset($providerLead->vba_street_number) ? $providerLead->vba_street_number : '';
							$mailing_street_num = $mailing_street_num . (isset($providerLead->vba_street_number_suffix) ? $providerLead->vba_street_number_suffix : '');
						}

						$supply_street_suffix = (isset($providerLead->va_street_code) ? $providerLead->va_street_code : '');
						$BUSINESS_TYPE = '';
						$BUSINESS_TYPE = (isset($providerLead->vbd_business_company_type)) ? $providerLead->vbd_business_company_type : '';

						if ($providerLead->journey_property_type == '1') {
							if ($BUSINESS_TYPE == 'Incorporation') {
								$BUSINESS_TYPE = 'Incorporation';
							} elseif ($BUSINESS_TYPE == 'Limited Company') {
								$BUSINESS_TYPE = "Limited Company";
							} elseif ($BUSINESS_TYPE == 'Partnership') {
								$BUSINESS_TYPE = "Partnership";
							} elseif ($BUSINESS_TYPE == 'Private') {
								$BUSINESS_TYPE = "Other";
							} elseif ($BUSINESS_TYPE == 'Sole Trader') {
								$BUSINESS_TYPE = "Sole Trader";
							} elseif ($BUSINESS_TYPE == 'Trust') {
								$BUSINESS_TYPE = "Other";
							} else {
								$BUSINESS_TYPE = "Other";
							}
						}
						$medicare_refrence = $providerLead->vie_medicare_reference_number;
						$drv = '';
						if ($providerLead->vi_identification_type == 'Medicare Card') {
							$card_color = isset($providerLead->vi_card_color) ? $providerLead->vi_card_color : '';
							if ($card_color == 'G') {
								$drv = 'Green';
							} elseif ($card_color == 'B') {
								$drv = 'Blue';
							} elseif ($card_color == 'Y') {
								$drv = 'Yellow';
							}
						} elseif ($providerLead->vi_identification_type == 'Foreign Passport') {
							$drv = $providerLead->vi_foreign_country_name;
						} elseif ($providerLead->vi_identification_type == 'Passport') {
							$drv = "Australia";
						} elseif ($providerLead->vi_identification_type == 'Drivers Licence') {
							$drv = $providerLead->vi_licence_state_code;
						} 
						$mailing_unit_flat_num =  $mailing_strt_num =  $mailing_strt_name =  $mailing_strt_type =  $mailing_suburb =  $mailing_state = $mailing_postcode = '';
						$po_address = [];

						if (isset($providerLead->is_po_box) && $providerLead->is_po_box != 1) {
							// if billing preference is other
							if (isset($providerLead->l_billing_preference) && $providerLead->l_billing_preference == '3') {
								$mailing_unit_flat_num = isset($providerLead->vba_unit_no) ? $providerLead->vba_unit_no : '';
								$mailing_strt_num = isset($providerLead->vba_street_number) ? $providerLead->vba_street_number : '';
								$mailing_strt_name = isset($providerLead->vba_street_name) ? $providerLead->vba_street_name : '';
								$mailing_strt_type = isset($providerLead->vba_street_code) ? $providerLead->vba_street_code : '';
								$mailing_suburb = isset($providerLead->vba_suburb) ? $providerLead->vba_suburb : '';
								$mailing_state = isset($providerLead->vba_state) ? $providerLead->vba_state : '';
								$mailing_postcode = isset($providerLead->vba_postcode) ? $providerLead->vba_postcode : '';
							} else if (isset($providerLead->l_billing_preference) && $providerLead->l_billing_preference == '2') {
								$mailing_unit_flat_num = isset($providerLead->va_unit_no) ? $providerLead->va_unit_no : '';
								$mailing_strt_num = isset($providerLead->va_street_number) ? $providerLead->va_street_number : '';
								$mailing_strt_name = isset($providerLead->va_street_name) ? $$providerLead->va_street_name : '';
								$mailing_strt_type = isset($providerLead->va_street_code) ? $providerLead->va_street_code : '';
								$mailing_suburb = isset($providerLead->va_suburb) ? $providerLead->va_suburb : '';
								$mailing_state = isset($providerLead->va_state) ? $providerLead->va_state : '';
								$mailing_postcode = isset($providerLead->va_postcode) ? $providerLead->va_postcode : '';
							} 
                            else if (isset($providerLead->l_billing_preference) && $providerLead->l_billing_preference == '1') {
								// check email welcome pack is enable or not.
								if (isset($providerLead->l_email_welcome_pack) && $providerLead->l_email_welcome_pack == 1) {
									$mailing_unit_flat_num = isset($providerLead->vba_unit_no) ? $providerLead->vba_unit_no : '';
									$mailing_strt_num = isset($providerLead->vba_street_number) ? $providerLead->vba_street_number : '';
									$mailing_strt_name = isset($providerLead->vba_street_name) ? $providerLead->vba_street_name : '';
									$mailing_strt_type = isset($providerLead->vba_street_code) ? $providerLead->vba_street_code : '';
									$mailing_suburb = isset($providerLead->vba_suburb) ? $providerLead->vba_suburb : '';
									$mailing_state = isset($providerLead->vba_state) ? $providerLead->vba_state : '';
									$mailing_postcode = isset($providerLead->vba_postcode) ? $providerLead->vba_postcode : '';
								} else {
                                    $mailing_unit_flat_num = isset($providerLead->va_unit_no) ? $providerLead->va_unit_no : '';
                                    $mailing_strt_num = isset($providerLead->va_street_number) ? $providerLead->va_street_number : '';
                                    $mailing_strt_name = isset($providerLead->va_street_name) ? $$providerLead->va_street_name : '';
                                    $mailing_strt_type = isset($providerLead->va_street_code) ? $providerLead->va_street_code : '';
                                    $mailing_suburb = isset($providerLead->va_suburb) ? $providerLead->va_suburb : '';
                                    $mailing_state = isset($providerLead->va_state) ? $providerLead->va_state : '';
                                    $mailing_postcode = isset($providerLead->va_postcode) ? $providerLead->va_postcode : '';  
								}
							}
						} else {
							//when po box is enabled 
							$mailing_strt_num = isset($providerLead->vpa_street_number) ? $providerLead->vpa_street_number : '';
							$mailing_suburb = isset($providerLead->vpa_suburb) ? $providerLead->vpa_suburb : '';
                            $mailing_state = isset($providerLead->vpa_state) ? $providerLead->vpa_state : '';
                            $mailing_postcode = isset($providerLead->vpa_postcode) ? $providerLead->vpa_postcode : '';
						} 
						// set all selected data to respective column.
						$is_solar = 'N'; 
						if (isset($providerLead->journey_solar_panel) && $providerLead->journey_solar_panel == '1') {
							$is_solar = 'Y';
						}
						// set for QLD state
						$VisualInspection =  $InspectionTimeframe =  $SpecialInstructionsforAccess = '';
                        $VisualInspection = 'No';
						if (trim($providerLead->va_state) == 'QLD' && $providerLead->sale_product_is_moving == '1') {
							$VisualInspection = 'Yes';
							$SpecialInstructionsforAccess = $providerLead->vie_qa_notes;
							if ($providerLead->journey_prefered_move_in_time ==  '8am - 1pm')
								$InspectionTimeframe = '8am-1pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '9am - 2pm')
								$InspectionTimeframe = '9am-2pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '10am - 3pm')
								$InspectionTimeframe = '10am-3pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '11am - 4pm')
								$InspectionTimeframe = '11am-4pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '12am - 5pm')
								$InspectionTimeframe = '12am-5pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '1pm - 6pm')
								$InspectionTimeframe = '1-6pm';
							elseif ($providerLead->journey_prefered_move_in_time ==  '8am - 11:59am')
								$InspectionTimeframe = '8-11:59am';
							elseif ($providerLead->journey_prefered_move_in_time ==  '12pm - 6pm')
								$InspectionTimeframe = '12-6pm';
						}  
						$providerData[$providerLead->spe_sale_status][] = array(
							'CMT' . $providerLead->sale_product_reference_no, //A 0
							$sale_created_date, //B 1
							$product_code_e, //C 2
							$product_code_g, //D 3
							(($providerLead->journey_property_type == '1') ? 'RESI' : 'SME'), //E 4
							(($providerLead->journey_moving_house == 'yes') ? 'CONNECTION' : 'Change of Retailer'), //F 5
							(($providerLead->journey_moving_house == "yes") ? implode("/", explode("/", $providerLead->sale_product_moving_at)) : ''), //G 6
							$VisualInspection,
							'Y', //I 8
							$InspectionTimeframe, //J 19
							$SpecialInstructionsforAccess, //K 10
							(($providerLead->journey_moving_house == 'yes') ? 'NO' : ''), //L 11
							(($providerLead->journey_moving_house == 'yes') ? 'NO' : ''), //M 12
							(($providerLead->journey_moving_house == 'yes') ? 'OFF' : ''), //N 13
							isset($providerLead->vbd_business_legal_name) ? $providerLead->vbd_business_legal_name : '', //O 14
							(isset($providerLead->vbd_business_abn) && strlen($providerLead->vbd_business_abn) > 9) ? $providerLead->vbd_business_abn : '', //P 15
							$BUSINESS_TYPE, //16
							decryptGdprData($providerLead->vis_title), //Q 17
							decryptGdprData($providerLead->vis_first_name), //R  18
							decryptGdprData($providerLead->vis_last_name), //S 19
							\Carbon\Carbon::parse(decryptGdprData($providerLead->vis_dob))->format('d/m/Y'), //T 20
							'MOBILE', //U 21
							$phone, //V 22
							'Y', //W 23
							'Y', //X 24
							decryptGdprData($providerLead->vis_email), //Y 25
							$id_first_name, //26
							$id_middle_name, //27
							$id_last_name, //28
							$type_id, //Z 29
							$id_number, //AA 30
							$medicare_exp_date, //af 31
							$drv, //32
							$medicare_refrence, //AH 33
							'', //AC 34
							'', //AD 35
							'', //AE 36
							'', //AF 37
							'', //AG 38
                            isset($providerLead->vba_unit_no) ? $providerLead->vab_unit_no : '', //AH 39
							trim($supply_street_num), //AI 40
							isset($providerLead->vba_street_name) ? $providerLead->vba_street_name : '', //AH 39
							trim($supply_street_num), //AK 42
                            isset($providerLead->vba_suburb) ? $providerLead->vba_suburb : '', //AH 39
							trim($supply_street_num), //AL 43
							isset($providerLead->vba_state) ? $providerLead->vba_state : '', //AH 39
							trim($supply_street_num), //AM 44
                            isset($providerLead->vba_postcode) ? $providerLead->vba_postcode : '', //AH 39
							trim($supply_street_num),  //AN  45
							$mailing_unit_flat_num,
							$mailing_strt_num,
							$mailing_strt_name,
							$mailing_strt_type,
							$mailing_suburb,
							$mailing_state,
							$mailing_postcode,
							$nmi_number, //AV  53
							$dpi_mirn_number, //AW   54
							$providerLead->journey_property_type == '1' ? 'RESI' : 'SME', //AX  55
							'', //AY  56
							$elec_fuel, //AZ 57
							$elec_gas, //BA 58
							$elec_plan, //BB 59
							$gas_plan, //BC 60
							'', //BJ 61
							'N', //BD  62
							'AUSPOST', //BE  63
							(isset($providerLead->vie_qa_notes) && !empty($providerLead->vie_qa_notes)) ? $providerLead->vie_qa_notes : '', //BF   64
							'', //BG  65
							'', //BH  66
							'', //BI  67
							'', //BJ  68
							'', //BK  69
							'', //BL  70
							'NO', //BM  71
							$is_solar,   //72
							$site_electricity_code,   //73
							$solar_buypack_rate  //74
						);
					} else { 
						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][59]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][59])) {
							//electricity
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][59] = $providerLead->plan_name;
						} else {
							//gas
							if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][60])) {
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][60] = $providerLead->plan_name;
							}
						} 
						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][57]) && $providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][57] == "NO") { 
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][57] = "YES";
						} else {
							//gas
							if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][58])) {
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][58] = "YES";
							}
						}
 
						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][53]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][53])) {
							//electricity
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][53] = $providerLead->vie_nmi_number;
						} else {
							//gas
							if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][54])) {
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][54] = $providerLead->vie_dpi_mirn_number;
							}
						}

						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][73]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][73])) {
							//electricity
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][73] = $providerLead->vie_electricity_network_code;
						}
						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][74]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][74])) {
							//electricity
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][74] = $providerLead->vie_electricity_code;
						}
						if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][3]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][3])) {
							//gas
							$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][3] = $providerLead->plan_product_code;
						} else {
							if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][2])) {
								//electricity
								$providerData[$providerLead->spe_sale_status][$reference_key_array[$providerLead->reference_no]][2] = $providerLead->plan_product_code;
							}
						}
					}
			}   
			// dd($providerData);
			$data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'EnergyAustralia_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            
            $providerLeadData = $fileName = $filenameOffset = null;
			$data['leadIds'] = $leadIds;
            if (array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $status = 4;
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ENERGY_AUSTRALIA' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (array_key_exists('12', $providerData)) {
                
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $status = 12;
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ENERGY_AUSTRALIA' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
               
            }
            return false;
               
		}
		catch (\Exception $e) {
			return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
		}
	}   
}
