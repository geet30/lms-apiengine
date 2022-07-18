<?php

namespace App\Traits\Provider\AlintaEnergy;

use App\Traits\Provider\AlintaEnergy\Headings;
use App\Models\{Lead, PlanTag, VisitorAddress};
use Carbon\Carbon;

trait Schema
{
    function alintaEnergySchema($providerLeads, $data)
    {
        try {
            $data['providerName'] = 'ALINTA ENERGY';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
            $countryCode = $cardColor = $medicareCardColour = $medicareIrn = $medicare_exp_date = $passportIssuingCountry = $identityType = $medicare_middle_name_on_card = $cardStartDate = $cardExpiryDate = $multipleSclerosis = $alterations_prev_deen = $alterations_future = $main_switch_off = $deen_6_months = '';
            $providerData = $leadIds = [];
            foreach ($providerLeads as $providerLead) {
                $deliveryMethodCode = "POST";
                $salesName = $acctMgrName = 'CIMET';
                if ($providerLead->vi_token) {
                    $salesName = $providerLead->vi_token;
                    $acctMgrName = $providerLead->vi_token;
                }

                if ($providerLead->l_billing_preference == 1) {
                    $deliveryMethodCode = "EMAIL";
                }
                array_push($leadIds, $providerLead->l_lead_id);
                $planTags = PlanTag::getTags($providerLead->sale_product_plan_id);
                if (!$planTags->isEmpty()) {
                    $planTags = array_map('strtolower', array_column($planTags->toArray(), 'name'));
                    if ((in_array('GROUPON', $planTags)) || (in_array('groupon', $planTags)) || (in_array('Groupon', $planTags)) || (in_array('GroupOn', $planTags))) {
                        $salesName = 'CIMGROUPON';
                        $acctMgrName = 'CIMGROUPON';
                    }
                }

                if ($providerLead->multiple_sclerosis) {
                    $multipleSclerosis = "Y";
                    if ($providerLead->multiple_sclerosis == 0) {
                        $multipleSclerosis = "N";
                    }
                }

                $concessionType = '';
                if (in_array($providerLead->vcd_concession_type, $this->hcc)) {
                    $concessionType = 'HCC';
                } else if (in_array($providerLead->vcd_concession_type, $this->pcc)) {
                    $concessionType = 'PCC';
                } else if (in_array($providerLead->vcd_concession_type, $this->dvagc)) {
                    $concessionType = 'DVAGC';
                }

                if ($providerLead->vcd_concession_type) {
                    $concessionYesNo = "Y";
                    if ($providerLead->vcd_concession_type == 'Not Applicable') {
                        $concessionYesNo = "N";
                    }
                }

                $movingHouse = 'MOVE_IN';
                if ($providerLead->journey_moving_house == 0 || !$providerLead->journey_moving_house) {
                    $movingHouse = 'TRANSFER';
                }

                $elecMetertype = $providerLead->ebd_meter_type == 'timeofuse' ? 'TOU' : 'BASIC';

                $siteIdentifier = $providerLead->vie_dpi_mirn_number;
                if ($providerLead->vie_nmi_number && $providerLead->sale_product_product_type == 1) {
                    $siteIdentifier = $providerLead->vie_nmi_number;
                }
                $contactMobilePhone = $providerLead->vis_visitor_phone;
                // dd(encryptGdprData('sandeep.bangarh@debutinfotech.com'));

                $identityInfoType = $providerLead->vie_identity_type ?? '';

                switch ($identityInfoType) {
                    case 'Drivers Licence':
                        $dlicenceIssuingState = $providerLead->vie_licence_state_code ?? '';
                        $identityType = 'DRIVERS LICENSE';
                        break;
                    case 'Foreign Passport':
                    case 'Passport':
                        $vieCountryName = $providerLead->vie_country_name ?? '';
                        if ($identityInfoType == 'passport') {
                            $vieCountryName = 'Australia';
                        }
                        if (!empty($vieCountryName)) {
                            $countryCode = array_search($vieCountryName, config('app.country_codes'));
                            if (!empty($countryCode)) {
                                $countryName = $vieCountryName;
                            }
                        }

                        $passportIssuingCountry = $countryName;
                        $identityType = 'PASSPORT';
                        break;
                    case 'Medicare Card':
                        $medicareIrn = $providerLead->vie_medicare_reference_number ?? '';
                        $cardColor = $providerLead->vie_card_color ?? '';

                        if ($cardColor == 'G') {
                            $medicareCardColour = 'GREEN';
                            $medicare_exp_date = isset($identity_info['medicare_card_expiry_date']) ? Carbon::parse($identity_info['medicare_card_expiry_date'])->format('m/Y') : '';
                        } elseif ($cardColor == 'B') {
                            $medicareCardColour = 'BLUE';
                            $medicare_exp_date = isset($identity_info['medicare_card_expiry_date']) ? Carbon::parse($identity_info['medicare_card_expiry_date'])->format('d/m/Y') : '';
                        } elseif ($cardColor == 'Y') {
                            $medicareCardColour = 'YELLOW';
                            $medicare_exp_date = isset($identity_info['medicare_card_expiry_date']) ? Carbon::parse($identity_info['medicare_card_expiry_date'])->format('d/m/Y') : '';
                        }
                        $medicare_middle_name_on_card = isset($identity_info['card_middle_name']) ? $identity_info['card_middle_name'] : '';
                        $identityType = 'MEDICARE CARD';
                        break;
                    default:
                        break;
                }

                if ($providerLead->sale_product_product_type && $providerLead->sale_product_product_type == 1 && $providerLead->vie_electricity_network_code) {
                    $networkCode = $providerLead->vie_electricity_network_code;
                }

                if ($providerLead->sale_product_product_type && $providerLead->sale_product_product_type == 2 && $providerLead->vie_gas_network_code) {
                    $networkCode = $providerLead->vie_gas_network_code;
                }

                if ($providerLead->vcd_card_expiry_date) {
                    $cardExpiryDate = $providerLead->vcd_card_expiry_date;
                }

                if ($providerLead->vcd_card_start_date) {
                    $cardStartDate = Carbon::now()->addDay(1)->format('d/m/Y');
                }



                $cust_postal_addr_1 = $cust_postal_addr_2 = $cust_postal_addr_3 = $cust_postal_code = '';

                if ($providerLead->is_po_box == 1) {
                    //when po box is enabled

                    if ($providerLead->vpa_address) {
                        $cust_postal_addr_1 = 'PO BOX ' . str_replace(',', ' ', $providerLead->vpa_address);
                    }
                    if ($providerLead->vpa_suburb) {
                        $cust_postal_addr_2 = $providerLead->vpa_suburb;
                    }
                    if ($providerLead->vpa_state) {
                        $cust_postal_addr_3 = $providerLead->vpa_state;
                    }
                    if ($providerLead->vpa_postcode) {
                        $cust_postal_code = $providerLead->vpa_postcode;
                    }
                } else {
                    $cust_postal_addr_1 = trim($providerLead->va_unit_number . ' ' . $providerLead->va_street_number . ' ' . $providerLead->va_street_name . ' ' . $providerLead->va_street_suffix . ' ' . $providerLead->va_street_code);
                    $cust_postal_addr_1 = str_replace(',', ' ', $cust_postal_addr_1);

                    if ($providerLead->va_suburb) {
                        $cust_postal_addr_2 = $providerLead->va_suburb;
                    }
                    if ($providerLead->va_state) {
                        $cust_postal_addr_3 = $providerLead->va_state;
                    }
                    if ($providerLead->va_postcode) {
                        $cust_postal_code = $providerLead->va_postcode;
                    }
                }

                $proposed_move_in_date = $providerLead->journey_moving_house == 1 ? $providerLead->journey_moving_date : '';

                $specialInstructions = $providerLead->vie_qa_notes ?? '';
                if ($specialInstructions == 'N/A' || $specialInstructions == 'NA') {
                    $specialInstructions = '';
                }
                $specialInstructions = str_replace(',', ' ', $specialInstructions);

                $cust_notes = '';
                if ($providerLead->l_note) {
                    $cust_notes = $providerLead->l_note;
                    if ($cust_notes == 'N/A' || $cust_notes == 'NA') {
                        $cust_notes = '';
                    }
                }
                $cust_notes = str_replace(',', ' ', $cust_notes);

                $isGasConnection = false;
                if ($providerLead->sale_product_product_type == 2 && $providerLead->vga_is_same_gas_connection) {
                    $isGasConnection = true;
                    foreach ($this->alintaAddressFields as $alintaAddressField => $requestField) {
                        ${$alintaAddressField} = $providerLead->{'vga_' . $requestField};
                    }
                }

                if (!$isGasConnection) {
                    foreach ($this->alintaAddressFields as $alintaAddressField => $requestField) {
                        ${$alintaAddressField} = $providerLead->{'va_' . $requestField};
                    }
                }

                $voice_ver_date = '';
                if ($providerLead->vie_qa_notes_created_date != '') {
                    $voice_ver_date = $providerLead->vie_qa_notes_created_date;
                    $temp_date = explode('/', $providerLead->vie_qa_notes_created_date);
                    if (strlen($temp_date[2]) == 2) {
                        $voice_ver_date = $temp_date[0] . '/' . $temp_date[1] . '/20' . $temp_date[2];
                    }
                }

                // set conset given
                if ($providerLead->vcd_concession_type) {
                    $Consent_given = "Y";
                    if ($providerLead->vcd_concession_type == 'Not Applicable') {
                        $Consent_given = "N";
                    }
                }

                if ($providerLead->sale_product_product_type == 1 && $providerLead->journey_moving_house == 1) {
                    $main_switch_off = 'Y';
                    $deen_6_months = 'N';
                    $alterations_future = 'N';
                    $alterations_prev_deen = 'N';
                    if ($providerLead->vie_is_elec_work) {
                        $deen_6_months = 'Y';
                        $alterations_future = 'Y';
                        $alterations_prev_deen = 'Y';
                    }
                }
                $isMoveIn = ($movingHouse == 'MOVE_IN');
                $appointAvailability = ['0800', '0900', '1000', '1100', '1200', '1300'];
                $appointAvail = ($site_addr_city == 'QLD' && $isMoveIn && in_array($providerLead->note, $appointAvailability) && strlen($providerLead->note) == 4) ? $providerLead->note : '';

                $bookingAttendance = ($appointAvail && !$providerLead->vie_site_access_electricity) ? 'Occupied' : (($appointAvail && $providerLead->vie_site_access_electricity) ? 'Vacant' : '');

                $keyLocation = $bookingAttendance == 'Vacant' ? $providerLead->vie_site_access_electricity : '';

                $preferred_contact_method = '';
                switch ($deliveryMethodCode) {
                    case 'POST':
                        $preferred_contact_method = 'PHONE';
                        break;
                    case 'EMAIL':
                        $preferred_contact_method = 'EMAIL';
                        break;

                    default:
                        # code...
                        break;
                }

                $productCode = $providerLead->plan_product_code ?? '';

                $isJointAccount = ($providerLead->vie_is_connection_joint_account_holder != 0);
                // dd($providerLead);
                $providerData[$providerLead->spe_sale_status][] = [
                    $providerLead->sale_product_reference_no,
                    /** sales_cust_number 1 **/
                    $salesName,
                    /** sales_person 2 **/
                    $acctMgrName,
                    /** sales_channel 3 **/
                    'VERIFIED',
                    /** voice_eic_extn 4 **/
                    $voice_ver_date,
                    /** voice_eic_date 5 **/
                    $providerLead->vie_qa_notes_created_date ?? '',
                    /** contract_date 6 **/
                    $site_addr_unit_type,
                    /** site_addr_unit_type 7 **/
                    $site_addr_unit_no,
                    /** site_addr_unit_no 8 **/
                    $site_addr_floor_type,
                    /** site_addr_floor_type 9 **/
                    $site_addr_floor_no,
                    /** site_addr_floor_no 10 **/
                    $site_addr_street_no,
                    /** site_addr_street_no 11 **/
                    $site_streetno_suffix,
                    /** site_addr_street_no_suffix 12 **/
                    $site_addr_street_name,
                    /** site_addr_street_name 13 **/
                    $site_addr_street_suffix,
                    /** site_addr_street_suffix 14 **/
                    $stype_code,
                    /** site_addr_street_type 15 **/
                    $site_addr_suburb,
                    /** site_addr_suburb 16 **/
                    $site_addr_city,
                    /** site_addr_state 17 **/
                    $spost_code,
                    /** site_addr_postcode 18 **/
                    $site_addr_property_name,
                    /** site_addr_property_name 19 **/
                    $moving_address['site_descriptor'] ?? '',
                    /** site_addr_location_desc 20 **/
                    $lot_number,
                    /** site_addr_lot_number 21 **/
                    '',
                    /** cust_dpid_number 22 **/
                    (($providerLead->journey_property_type == 1) ? 'RESIDENTIAL' : 'BUSINESS'),
                    /** customer_type 23 **/
                    $movingHouse,
                    /** transfer_type 24 **/
                    (($providerLead->sale_product_product_type == 1) ? 'ELECTRICITY' : 'GAS'),
                    /** service_type 25 **/
                    $siteIdentifier,
                    /** site_identifier 26 **/
                    $productCode,
                    /** product_name 27 **/
                    (strlen($providerLead->vbd_business_abn) == 9 ? $providerLead->vbd_business_abn : ''),
                    /** acn_number 28 **/
                    (strlen($providerLead->vbd_business_abn) == 11 ? $providerLead->vbd_business_abn : ''),
                    /** abn_number 29 **/
                    decryptGdprData($providerLead->vbd_business_legal_name),
                    /** trading_name 30 **/
                    $providerLead->vis_title,
                    /** customer_salutation 31 **/
                    decryptGdprData($providerLead->vis_first_name),
                    /** first_name 32 **/
                    decryptGdprData($providerLead->vis_last_name),
                    /** last_name 33 **/
                    Carbon::parse($providerLead->vis_dob)->format('d/m/Y'),
                    /** dob 34 **/
                    decryptGdprData($contactMobilePhone),
                    /** contact_phone_1 35 **/
                    decryptGdprData($providerLead->vis_alternate_phone),
                    /** contact_phone_2 36 **/
                    decryptGdprData($providerLead->vis_email),
                    /** contact_phone_2 37 **/
                    '',
                    /** cur_addr_unit_no 38 **/
                    '',
                    /** cur_addr_street_no 39 **/
                    '',
                    /** cur_addr_street_no_suffix 40 **/
                    '',
                    /** cur_addr_street_name 41 **/
                    '',
                    /** cur_addr_street_type 42 **/
                    '',
                    /** cur_addr_suburb 43 **/
                    '',
                    /** cur_addr_state 44 **/
                    '',
                    /** cur_addr_postcode 45 **/
                    '',
                    /** cur_addr_lot_number 46 **/
                    $identityType ?? '',
                    /** identity_type 47 **/
                    $dlicenceIssuingState,
                    /** dlicence_issuing_state 48 **/
                    $providerLead->vie_licence_number ?? '',
                    /** dlicense_number 49 **/
                    $providerLead->vie_licence_card_expiry_date ? Carbon::parse($providerLead->vie_licence_card_expiry_date)->format('d/m/Y') : '',
                    /** dlicense_exp_date 50 **/
                    $medicareCardColour,
                    /** medicare_card_colour 51 **/
                    $providerLead->vie_medicare_number ?? '',
                    /** medicard_no 52 **/
                    $medicareIrn,
                    /** medicare_irn 53 **/
                    $medicare_exp_date,
                    /** medicare_exp_date 54 **/
                    $passportIssuingCountry,
                    /** passport_issuing_country 55 **/
                    $providerLead->vie_passport_number ?? '',
                    /** passport_number 56 **/
                    $providerLead->vie_passport_card_expiry_date ? Carbon::parse($providerLead->vie_passport_card_expiry_date)->format('d/m/Y') : '',
                    /** ﻿passport_exp_date 57 **/
                    $medicare_middle_name_on_card,
                    /** identity_middle_name 58 **/
                    '',
                    /** bill_group_code 59 **/
                    $deliveryMethodCode,
                    /** delivery_method_code 60 **/
                    $preferred_contact_method,
                    /** preferred_contact_method 61 **/
                    trim($cust_postal_addr_1),
                    /** cust_postal_addr_1 62 **/
                    '',
                    /** cust_postal_addr_2 63 **/
                    $cust_postal_addr_2,
                    /** cust_postal_suburb 64 **/
                    $cust_postal_code,
                    /** cust_postal_code 65 **/
                    $cust_postal_addr_3,
                    /** cust_postal_state 66 **/
                    '',
                    /** occupancy_type 67 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_title : '',
                    /** contact_2_salutation 68 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_first_name : '',
                    /** contact_2_first_name 69 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_last_name : '',
                    /** contact_2_last_name 70 **/
                    ($isJointAccount && $providerLead->vie_joint_acc_holder_dob) ? Carbon::parse($providerLead->vie_joint_acc_holder_dob)->format('d/m/Y') : '',
                    /** contact_2_dob 71 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_phone_no : '',
                    /** contact_2_phone_1 72 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_home_phone_no : '',
                    /** contact_2_phone_2 73 **/
                    $isJointAccount ? $providerLead->vie_joint_acc_holder_email : '',
                    /** contact_2_email 74 **/
                    $concessionYesNo,
                    /** conc_card 75 **/
                    $concessionType,
                    /** conc_card_type 76 **/
                    $Consent_given,
                    /** conc_consent 77 **/
                    $providerLead->vcd_card_number ?? '',
                    /** conc_card_number 78 **/
                    $cardStartDate,
                    /** conc_start_date 79 **/
                    $cardExpiryDate,
                    /** conc_card_exp_date 80 **/
                    $multipleSclerosis,
                    /** conc_med_cool 81 **/
                    $proposed_move_in_date,
                    /** proposed_move_in_date 82 **/
                    $appointAvail,
                    /** appointment_availability 83 **/
                    $bookingAttendance,
                    /** booking_attendance 84 **/
                    $alterations_prev_deen,
                    /** alterations_prev_deen 85 **/
                    $alterations_future,
                    /** alterations_future 86 **/
                    $main_switch_off,
                    /** main_switch_off 87 **/
                    $deen_6_months,
                    /** deen_6_months 88 **/
                    $keyLocation,
                    /** key_location 89 **/
                    '',
                    /** key_location_spec 90 **/
                    '',
                    /** site_hazard_desc 91 **/
                    $identity_info['meter_hazard'] ?? '',
                    /** site_hazard_spec 92 **/
                    '',
                    /** site_access_details 93 **/
                    'NO',
                    /** marketing_consent 94 **/
                    '',
                    /** netwk_code 95 **/
                    ($providerLead->sale_product_product_type == 1 && $movingHouse == 'NEW_CONN') ? $providerLead->vie_electricity_code : '',
                    /** proposed_tariff 96 **/
                    '',
                    /** volume_builder 97 **/
                    '',
                    /** multisite_group 98 **/
                    '',
                    /** contract_number 99 **/

                ];
            }


            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'ALINTA_ENERGY_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ALINTA_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'ALINTA_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'ALINTA_ENERGY_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
