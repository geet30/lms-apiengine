<?php

namespace App\Repositories\Lead\SaleSubmissions\EA; 
use App\Models\{
        Lead 
    };
use DB;
use App\Repositories\Lead\SaleSubmissions\EA\CountryCodes;
use App\Traits\SaleSubmission\EaSubmitSaleTrait;

class EASaleSubmissionRepo
{
    use CountryCodes,EaSubmitSaleTrait;
    function submitEASale($leadId,$energy,$groupDetails)
    {       
        $data['gasSale'] = $data['StreetPostcode'] = $data['StreetState'] = $data['StreetStreetName'] = $data['StreetStreetNumber'] = $data['StreetStreetType'] = $data['StreetSuburb'] = $data['gasSale'] = $data['offerElecPlanId'] = $data['offerElecSourceCode'] = $data['offerGasPlanId'] = $data['offerGasSourceCode'] = '';
         
            if ($energy == 3) { 
                $sale = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
                $gasSale = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null; 
            } else { 
                $sale = isset($groupDetails[$energy][0]) ? $groupDetails[$energy][0] : null;
            }  
            //get batch no to create unique vendor ID
            $data['vendorID'] = $sale->sale_product_reference_no;
            settype($data['vendorID'], "string");
            $saleSubAttempt = $sale->l_sale_submission_attempt;
            $data['vendorID'] .= $saleSubAttempt;
            $data['vendorCode'] = 'CMT';
            $businessCodes = [
                '2' => 'BUS',
                '1' => 'RES'
            ];
            $errors = [];
            $data['saleDate'] = '';
            if (isset($sale->vie_qa_notes_created_date) && $sale->vie_qa_notes_created_date != '') {
                $qa_saleDate = strtotime(str_replace('/', '-', $sale->vie_qa_notes_created_date));
                $data['saleDate'] = date('Y-m-d\T10:i:s\Z', $qa_saleDate);
            }
            if ($data['saleDate'] == '' || $data['saleDate'] == null) {
                array_push($errors, ['Sale Date' => 'Sale date field is required']);
            }
            
            $data['customerType'] = isset($businessCodes[$sale->journey_property_type])?$businessCodes[$sale->journey_property_type] :'';
            if ($data['customerType'] == '' || $data['customerType'] == null) {
                array_push($errors, ['Customer Type' => 'Customer type field is required']);
            }
            
            $data['transactionType'] = 'PS';
            if ($sale->journey_moving_house == 1) {
                $data['transactionType'] = 'ENE';
            } else if ($sale->Resale_type == 1) {
                $data['transactionType'] = 'COR';
            }
            
            $data['customerTitle'] = $sale->v_title;
            $data['customerFirstName'] = decryptGdprData($sale->v_first_name);
            $data['customerLastName'] = decryptGdprData($sale->v_last_name);
            $data['customerEmail'] = decryptGdprData($sale->v_email);
            $data['customerDOB'] = decryptGdprData($sale->v_dob);
            
            if ($data['customerTitle'] == '' || $data['customerTitle'] == null) {
                array_push($errors, ['Title' => 'Customer title field is required']);
            }
            if ($data['customerFirstName'] == '' || $data['customerFirstName'] == null) {
                array_push($errors, ['First Name' => 'Customer first name field is required']);
            }
            if ($data['customerLastName'] == '' || $data['customerLastName'] == null) {
                array_push($errors, ['Last Name' => 'Customer last name field is required']);
            }
            if ($data['customerEmail'] == '' || $data['customerEmail'] == null) {
                array_push($errors, ['Email' => 'Customer email field is required']);
            }
            if ($data['customerDOB'] == '' || $data['customerDOB'] == null) {
                array_push($errors, ['DOB' => 'Customer DOB field is required']);
            }

            $data['customerPhoneType'] = 'MOBILE';
            $data['customerPhoneNumber'] = decryptGdprData($sale->v_phone);
            if ($data['customerPhoneNumber'] == '' || $data['customerPhoneNumber'] == null) {
                array_push($errors, ['Mobile' => 'Customer Mobile field is required']);
            } else if (!preg_match('/^[0][23478][0-9]{8}$/', $data['customerPhoneNumber'])) {
                array_push($errors, 'Customer Mobile should be in correct format');
            }

            $data['customerAlternatePhoneNumber'] = decryptGdprData($sale->v_alternate_phone);
            if (isset($data['customerAlternatePhoneNumber']) && $data['customerAlternatePhoneNumber'] != '') {
                if (!preg_match('/^[0][23478][0-9]{8}$/', $data['customerAlternatePhoneNumber'])) {
                    array_push($errors, 'Customer alternate mobile no should be in correct format');
                }
            }

            $data['preferredContactMethod'] = 'EMAIL';
            $data['premiseRelationship'] = 'TENANT'; 
            $data['customerIdType'] = $sale->vi_identification_type;
            if ($data['customerIdType'] == "Drivers Licence") {
                $data['customerIdType'] = 'DL';
                $data['customerIdNumber'] = $sale->vi_licence_number;
                $data['customerIdExpiry'] = $sale->vi_licence_expiry_date;
            } else if ($data['customerIdType'] == "Medicare Card") {
                $data['customerIdType'] = 'MEDICARE';
                $data['customerIdNumber'] = $sale->vi_medicare_number;
                $data['customerIdExpiry'] = $sale->vi_medicare_card_expiry_date;
            } else {
                $data['customerIdType'] = 'PASSPORT';
                $data['customerIdNumber'] = $sale->vi_passport_number;
                $data['customerIdExpiry'] = $sale->vi_passport_expiry_date;
            }
            $data['customerIdMedicareCardColour'] = $sale->vi_card_color;
            $data['customerIdmedicareReferenceNumber'] = $sale->vi_reference_number;
            $data['customerIdFirstName'] = decryptGdprData($sale->v_first_name);
            $data['customerIdMiddleName'] = decryptGdprData($sale->v_middle_name);
            $data['customerIdLastName'] = decryptGdprData($sale->v_last_name);
            if ($data['customerIdFirstName'] == null  || $data['customerIdFirstName'] == '') {
                $data['customerIdFirstName'] = $data['customerFirstName'];
            }
            if ($data['customerIdLastName'] == null  || $data['customerIdLastName'] == '') {
                $data['customerIdLastName'] = $data['customerLastName'];
            }
            $data['customerIdStateOfIssue'] = $sale->vi_licence_state_code;

            $data['customerIdCountryOfIssue'] = 'AUS';

            if ($sale->vi_identification_type == "Foreign Passport") {
                $data['customerIdCountryOfIssue'] = $sale->vi_foreign_country_code;
            }
             
            $countryOfIssueCodes = self::getCountryCode();
            if (strlen($data['customerIdCountryOfIssue']) == 2) {
                $data['customerIdCountryOfIssue'] = isset($countryOfIssueCodes[$data['customerIdCountryOfIssue']]) ? $countryOfIssueCodes[$data['customerIdCountryOfIssue']] : '';
            }

            $cardCodes = [
                'G' => 'GREEN',
                'B' => 'BLUE',
                'Y' => 'YELLOW'
            ];

            $data['customerIdMedicareCardColour'] = isset($cardCodes[$data['customerIdMedicareCardColour']]) ? $cardCodes[$data['customerIdMedicareCardColour']] : '';
 

            //Identification fields is required when Customer type is RESIDENTIAL
            if ($data['customerType'] == 'RES') {
                if ($data['customerIdNumber'] == '' || $data['customerIdNumber'] == null) {
                    array_push($errors, ['Customer ID Number' => 'Customer ID number field is required']);
                }
                if ($data['customerIdFirstName'] == '' || $data['customerIdFirstName'] == null) {
                    array_push($errors, ['Identification First Name' => 'Customer ID first name field is required']);
                }
                if ($data['customerIdLastName'] == '' || $data['customerIdLastName'] == null) {
                    array_push($errors, ['Identification Last Name' => 'Customer ID last name field is required']);
                }
                if ($data['customerIdType'] == '' || $data['customerIdType'] == null) {
                    array_push($errors, ['Identification Id Type' => 'Customer ID type field is required']);
                } else if ($data['customerIdType'] == 'DL') {
                    if ($data['customerIdStateOfIssue'] == '' || $data['customerIdStateOfIssue'] == null) {
                        array_push($errors, ['State Of Issue' => 'State of issue field is required for DL']);
                    }
                } else if ($data['customerIdType'] == 'PASSPORT') {
                    if ($data['customerIdCountryOfIssue'] == '' || $data['customerIdCountryOfIssue'] == null) {
                        array_push($errors, ['Country Of Issue' => 'Country of issue field is required for passport']);
                    }
                } else {
                    if ($data['customerIdmedicareReferenceNumber'] == '' || $data['customerIdmedicareReferenceNumber'] == null) {
                        array_push($errors, ['Reference No' => 'Medicare reference no field is required for medicare']);
                    }
                    if ($data['customerIdMedicareCardColour'] == '' || $data['customerIdMedicareCardColour'] == null) {
                        array_push($errors, ['Medicare Card Colour' => 'Medicare card colour field is required for medicare']);
                    }
                    if ($data['customerIdExpiry'] == '' || $data['customerIdExpiry'] == null) {
                        array_push($errors, ['Medicare Expiry Date' => 'Medicare Expiry date field is required for medicare']);
                    }
                }
            }
             
            $data['businessName'] =  isset($sale->vbd_business_legal_name) ? $sale->vbd_business_legal_name : '';
            $data['businessIdType'] =  'ABN';
            $data['businessIdValue'] =  isset($sale->vbd_business_abn) ? $sale->vbd_business_abn : '';
            $data['businessType'] =  isset($sale->vbd_business_industry_type) ? $sale-vbd_business_industry_type : '';
            if ($data['businessType'] == 'Incorporation') {
                $data['businessType'] = 'INCORPORATED';
            } elseif ($data['businessType'] == 'Limited Company') {
                $data['businessType'] = "LIMITED_COMPANY";
            } elseif ($data['businessType'] == 'Partnership') {
                $data['businessType'] = "PARTNERSHIP";
            } elseif ($data['businessType'] == 'Private') {
                $data['businessType'] = "OTHERS";
            } elseif ($data['businessType'] == 'Sole Trader') {
                $data['businessType'] = "SOLE_TRADER";
            } elseif ($data['businessType'] == 'Trust') {
                $data['businessType'] = "OTHERS";
            } else {
                $data['businessType'] = "OTHERS";
            }
            $data['businessAnzsic'] =  isset($sale->vbd_anzsic) ? $sale->vbd_anzsic : '';

             
            //Business fields is required when Customer type is BUSINESS
            if ($data['customerType'] == 'BUS') {
                if ($data['businessName'] == '' || $data['businessName'] == null) {
                    $errors['Business Name'] = 'Business name field is required';
                }
                if ($data['businessIdValue'] == '' || $data['businessIdValue'] == null) {
                    $errors['Business ID Value'] = 'Business id value field is required';
                }
                if ($data['businessType'] == '' || $data['businessType'] == null) {
                    $errors['Business type'] = 'Business type field is required';
                }
                if ($data['businessAnzsic'] == '' || $data['businessAnzsic'] == null) {
                    $errors['Business Anzsic'] = 'Business anzsic field is required';
                }
            }

            $data['AccountHolderFirstName'] =  $sale->vie_joint_acc_holder_first_name;
            $data['AccountHolderLastName'] =  $sale->vie_joint_acc_holder_last_name;
            $data['AccountHolderEmail'] =  $sale->vie_joint_acc_holder_email;
            $data['AccountHolderAccessLevel'] =  'BASIC_READ_WRITE';

            $data['energisationConnectionDate'] = date('Y-m-d', strtotime(str_replace('/', '-', $sale->journey_moving_date)));
            $data['energisationVisualInspection'] = 'false';
            if (trim($sale->va_state) == 'OLD' || trim($sale->va_state) == 'NSW') {
                $data['energisationVisualInspection'] = 'true';
            }
 
            $data['energisationAccessDetails'] = '';
            if ($energy == 3) {
                $data['energisationAccessDetails'] = $sale->vie_site_access_electricity . ' ' . $sale->vie_site_access_gas;
            } else if ($energy == 1) {
                $data['energisationAccessDetails'] = $sale->vie_site_access_electricity;
            } else {
                $data['energisationAccessDetails'] = $sale->vie_site_access_gas;
            }
            $data['energisationInspectionTime'] = $sale->vie_qa_notes;
            $data['energisationRenovationsSinceDeenergisation'] = 'false';
            $data['energisationRenovationsInProgressOrPlanned'] = 'false';
            $data['energisationAfterHoursServiceOrder'] = 'false';
            
            //Energisation fields are required when transactionType is ENE (Moving)
            if ($data['transactionType'] == 'ENE') {
                if ($data['energisationConnectionDate'] == '' || $data['energisationConnectionDate'] == null) {
                    $errors['Connection Date'] = 'Connection date field is required';
                }
                if (trim($sale->va_state) == 'OLD' || trim($sale->va_state) == 'NSW') {
                    if (trim($data['energisationAccessDetails']) == '') {
                        $errors['Access Detail'] = 'Access detail field is required';
                    }
                    if ($data['energisationInspectionTime'] == '' || $data['energisationInspectionTime'] == null) {
                        $errors['Inspection Time'] = 'Inspection time field is required';
                    } else if (!preg_match('/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])$/', $data['energisationInspectionTime'])) {
                        $errors['Insepection time'] = 'Insepection time field should be in ISO 8601 time-only format (hh:mm) format';
                    }
                } else if ($data['energisationInspectionTime'] != '' && $data['energisationInspectionTime'] != null) {
                    if (!preg_match('/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])$/', $data['energisationInspectionTime'])) {
                        $errors['Insepection time'] = 'Insepection time field should be in ISO 8601 time-only format (hh:mm) format';
                    }
                }
            }

 
            $data['premiseNmi'] =  $sale->vie_nmi_number;
            $data['premiseMirn'] =  $sale->vie_dpi_mirn_number;
            $data['premiseUnitNumber'] = $sale->va_unit_no;
            $data['premiseUnitType'] = $sale->va_unit_type_code;
            $data['premiseFloorNumber'] = $sale->va_floor_no;
            $data['premiseFloorType'] = $sale->va_floor_type_code;
            $data['premiseStreetNumber'] = $sale->va_street_number;
            $data['premiseStreetName'] = $sale->va_street_name;
            $data['premiseStreetType'] = $sale->va_street_code;
            $data['premiseSuburb'] = $sale->va_suburb;
            $data['premiseState'] = $sale->va_state;
            $data['premisePostcode'] = $sale->va_postcode;
            $data['premiseDpid'] = $sale->va_dpid;
            $data['premiseSolarPower'] = 'false';
            if ($sale->journey_solar_panel == 'yes') {
                $data['premiseSolarPower'] = 'true';
            }
            $data['premiseNetworkTariffCode'] = $sale->vie_electricity_network_code;
            $data['premiseTimeOfUse'] = 'false';

            if ($sale->vie_nmi_skip == 0 && ($energy == 1 || $energy == 3)) {
                if (!preg_match('/^[a-zA-Z0-9]{10,11}$/', $data['premiseNmi'])) {
                    $errors['NMI'] = 'NMI should contain 10 to 11 characters';
                }
            }
            if ($sale->vie_mirn_skip == 0  && ($energy == 2 || $energy == 'both')) {
                if (!preg_match('/^[a-zA-Z0-9]{10,11}$/', $data['premiseMirn'])) {
                    $errors['MIRN'] = 'MIRN should contain 10 to 11 characters';
                }
            }

            if ($data['premiseStreetNumber'] == '' || $data['premiseStreetNumber'] == null) {
                $errors['Premise Street Number'] = 'Premise street number field is required';
            }
            if ($data['premiseStreetName'] == '' || $data['premiseStreetName'] == null) {
                $errors['Premise Street Name'] = 'Premise street name field is required';
            }
            if ($data['premiseStreetType'] == '' || $data['premiseStreetType'] == null) {
                $errors['Premise Street Type'] = 'Premise street type field is required';
            }
            if ($data['premiseSuburb'] == '' || $data['premiseSuburb'] == null) {
                $errors['Premise Suburb'] = 'Premise suburb field is required';
            }
            if ($data['premiseState'] == '' || $data['premiseState'] == null) {
                $errors['Premise state'] = 'Premise state field is required';
            }
            if ($data['premisePostcode'] == '' || $data['premisePostcode'] == null) {
                $errors['Premise postcode'] = 'Premise postcode field is required';
            }
            if (($data['premiseDpid'] != '' && $data['premiseDpid'] != null) && !is_numeric($data['premiseDpid'])) {
                $errors['Premise Address DPID'] = 'Premise address DPID fields should be numeric';
            } 
            if($energy == 1)
            {
                $data['offerElecPlanId'] = $sale->plan_campaign_code;
                $data['offerElecSourceCode'] = $sale->plan_product_code;
                if ($data['offerElecPlanId'] == '' || $data['offerElecPlanId'] == null) {
                    $errors['Electricty Plan ID'] = 'Electricty plan ID field is required';
                }
                if ($data['offerElecSourceCode'] == '' || $data['offerElecSourceCode'] == null) {
                    $errors['Electricty source code'] = 'Electricty source code field is required';
                }
            } else if ($energy == 2) {
                $data['offerGasPlanId'] = $sale->plan_campaign_code;
                $data['offerGasSourceCode'] =  $sale->plan_product_code;
                if ($data['offerGasPlanId'] == '' || $data['offerGasPlanId'] == null) {
                    $errors['Gas Plan ID'] = 'Gas plan ID field is required';
                }
                if ($data['offerGasSourceCode'] == '' || $data['offerGasSourceCode'] == null) {
                    $errors['Gas source code'] = 'Gas source code field is required';
                }
            } else {
                $data['offerElecPlanId'] = $sale->plan_campaign_code;
                $data['offerElecSourceCode'] = $sale->plan_product_code;
                $data['offerGasPlanId'] = $gasSale->plan_campaign_code;
                $data['offerGasSourceCode'] =  $gasSale->plan_product_code;

                if ($data['offerElecPlanId'] == '' || $data['offerElecPlanId'] == null) {
                    $errors['Electricty Plan ID'] = 'Electricty plan ID field is required';
                }
                if ($data['offerElecSourceCode'] == '' || $data['offerElecSourceCode'] == null) {
                    $errors['Electricty source code'] = 'Electricty source code field is required';
                }
                if ($data['offerGasPlanId'] == '' || $data['offerGasPlanId'] == null) {
                    $errors['Gas Plan ID'] = 'Gas plan ID field is required';
                }
                if ($data['offerGasSourceCode'] == '' || $data['offerGasSourceCode'] == null) {
                    $errors['Gas source code'] = 'Gas source code field is required';
                }
            } 
            $data['postalDeliveryNumber'] =  $data['postalDeliveryType'] = $data['postalSuburb'] = $data['postalState'] = $data['postalPostcode'] = $data['postalDpid'] = '';
            $addressDetails = DB::table('visitor_addresses')->whereIn('id', [  $sale->l_billing_address_id, $sale->l_billing_po_box_id])->get();

            $billingAddress = $poBoxAddress = [];
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
            $data['billDeliveryMethod'] = 'EMAIL';
            if (isset($sale->billing_option_selected) && $sale->billing_option_selected != 'email_billing') {
                $data['billDeliveryMethod'] = 'POST';
            }
            
            if ($sale->l_save_po_box == 1) {
                $data['mailingAddressType'] = 'POSTAL';
                $data['preferredContactMethod'] = 'POSTAL';
                $data['postalDeliveryNumber'] = $poBoxAddress->address;
                $data['postalDeliveryType'] = 'PO_BOX';
                $data['postalSuburb'] = isset($poBoxAddress) ? $poBoxAddress->suburb : '';
                $data['postalState'] = isset($poBoxAddress) ? $poBoxAddress->state : '';
                $data['postalPostcode'] = isset($poBoxAddress) ? $poBoxAddress->postcode : '';
                $data['postalDpid'] = isset($sale->VisitorPoBoxAddress) ? $poBoxAddress->dpid : '';
                if ($data['postalDeliveryNumber'] == '' || $data['postalDeliveryNumber'] == null) {
                    $errors['Postal Address Delivery Number'] = 'Postal address delivery number field is required';
                }
                if ($data['postalSuburb'] == '' || $data['postalSuburb'] == null) {
                    $errors['Postal Address Suburb'] = 'Postal address suburb field is required';
                }
                if ($data['postalState'] == '' || $data['postalState'] == null) {
                    $errors['Postal Address state'] = 'Postal address state field is required';
                }
                if ($data['postalPostcode'] == '' || $data['postalPostcode'] == null) {
                    $errors['Postal Address postcode'] = 'Postal address postcode field is required';
                }
                if (($data['postalDpid'] != '' && $data['postalDpid'] != null) && !is_numeric($data['postalDpid'])) {
                    $errors['Postal Address DPID'] = 'Postal address DPID fields should be numeric';
                }
            } else {
                $data['mailingAddressType'] = 'STREET';
                if (isset($sale->l_billing_preference) && $sale->l_billing_preference == 3) {
                    $data['preferredContactMethod'] = 'EMAIL';
                    $data['StreetUnitNumber'] = $billingAddress->unit_number;
                    $data['StreetUnitType'] = $billingAddress->unit_type_code;
                    $data['StreetFloorNumber'] = $billingAddress->floor_number;
                    $data['StreetFloorType'] = $billingAddress->floor_type_code;
                    $data['StreetStreetNumber'] = $billingAddress->street_number;
                    $data['StreetStreetName'] = $billingAddress->street_name;
                    $data['StreetStreetType'] = $billingAddress->street_code;
                    $data['StreetSuburb'] = $billingAddress->suburb;
                    $data['StreetState'] = $billingAddress->state;
                    $data['StreetPostcode'] = $billingAddress->postcode;
                    $data['StreetDpid'] = $billingAddress->dpid;
                } else if (isset($sale->l_billing_preference) && $sale->l_billing_preference == 1 && $sale->l_email_welcome_pack == 1) {
                    $data['preferredContactMethod'] = 'POSTAL';
                    $data['StreetUnitNumber'] = $billingAddress->unit_number;
                    $data['StreetUnitType'] = $billingAddress->unit_type_code;
                    $data['StreetFloorNumber'] = $billingAddress->floor_number;
                    $data['StreetFloorType'] = $billingAddress->floor_type_code;
                    $data['StreetStreetNumber'] = $billingAddress->street_number;
                    $data['StreetStreetName'] = $billingAddress->street_name;
                    $data['StreetStreetType'] = $billingAddress->street_code;
                    $data['StreetSuburb'] = $billingAddress->suburb;
                    $data['StreetState'] = $billingAddress->state;
                    $data['StreetPostcode'] = $billingAddress->postcode;
                    $data['StreetDpid'] = $billingAddress->dpid;
                } else {
                    $data['preferredContactMethod'] = 'EMAIL';
                    $data['StreetUnitNumber'] = $sale->va_unit_no;
                    $data['StreetUnitType'] = $sale->va_unit_type_code;
                    $data['StreetFloorNumber'] = $sale->va_floor_no;
                    $data['StreetFloorType'] = $sale->va_floor_type_code;
                    $data['StreetStreetNumber'] = $sale->va_street_number;
                    $data['StreetStreetName'] = $sale->va_street_name;
                    $data['StreetStreetType'] = $sale->va_street_code;
                    $data['StreetSuburb'] = $sale->va_suburb;
                    $data['StreetState'] = $sale->va_state;
                    $data['StreetPostcode'] = $sale->va_postcode;
                    $data['StreetDpid'] = $sale->va_dpid;
                }

                if ($data['StreetStreetNumber'] == '' || $data['StreetStreetNumber'] == null) {
                    $errors['Street Address Street Number'] = 'Street address street number fields is required';
                }
                if ($data['StreetStreetName'] == '' || $data['StreetStreetName'] == null) {
                    $errors['Street Address Street Name'] = 'Street address street name fields is required';
                }
                if ($data['StreetStreetType'] == '' || $data['StreetStreetType'] == null) {
                    $errors['Street Address Street Type'] = 'Street address street type fields is required';
                }
                if ($data['StreetSuburb'] == '' || $data['StreetSuburb'] == null) {
                    $errors['Street Address Suburb'] = 'Street address suburb fields is required';
                }
                if ($data['StreetState'] == '' || $data['StreetState'] == null) {
                    $errors['Street Address State'] = 'Street address state fields is required';
                }
                if ($data['StreetPostcode'] == '' || $data['StreetPostcode'] == null) {
                    $errors['Street Address Postcode'] = 'Street address postcode fields is required';
                }
                if (($data['StreetDpid'] != '' && $data['StreetDpid'] != null) && !is_numeric($data['StreetDpid'])) {
                    $errors['Street Address DPID'] = 'Street address DPID fields is numeric';
                }
            }
            $data['carbonNeutralOptIn'] = 'false';
            $data['lifeSupport'] = 'false';
            if ($sale->journey_life_support == 1) {
                $data['lifeSupport'] = 'true';
            }
            $data['safetyFlag'] = 'false';

            //making grapghQL data
            $startGraphQL = '{ "query": "mutation { submitSale(input: { ';

            //Mobile number
            $phoneString = 'phone: [ ';
            $firstMobile = '{ type: ' . $data['customerPhoneType'] . ' number: \"' . $data['customerPhoneNumber'] . '\" } ';

            $alternateMobile = ' ';
            if (isset($data['customerAlternatePhoneNumber']) && $data['customerAlternatePhoneNumber'] != '') {
                $data['alternateMobile'] = '{ type: ' . $data['customerPhoneType'] . ' number: \"' . $data['customerAlternatePhoneNumber'] . '\" } ';
            }
            $phoneString = $phoneString . $firstMobile . $alternateMobile . ' ]';

            //customer detail start
            $customer = ' customer: { title: \"' . $data['customerTitle'] . '\" firstName: \"' . $data['customerFirstName'] . '\" lastName: \"' . $data['customerLastName'] . '\" emailAddress: \"' . $data['customerEmail'] . '\" dateOfBirth: \"' . $data['customerDOB'] . '\" ' . $phoneString . ' preferredContactMethod: ' . $data['preferredContactMethod'] . ' ';

            $premiseRelString = ' ';
            $identification = ' ';
            if ($data['customerType'] == 'RES') {
                $premiseRelString = 'premiseRelationship: ' . $data['premiseRelationship'] . ' ';

                //identification start
                $identification = '  identification: { type: ' . $data['customerIdType'] . ' number: \"' . $data['customerIdNumber'] . '\" firstName: \"' . $data['customerIdFirstName'] . '\" lastName: \"' . $data['customerIdLastName'] . '\" ';

                $stateOfIssue = 'stateOfIssue: ' . $data['customerIdStateOfIssue'];
                $countryOfIssue = 'countryOfIssue: \"' . $data['customerIdCountryOfIssue'] . '\"';

                $customerMidNameStr = '';
                if ($data['customerIdMiddleName'] != null && $data['customerIdMiddleName'] != '') {
                    $customerMidNameStr = ' middleName: \"' . $data['customerIdMiddleName'] . '\"';
                }
                $medicalIdDetail = $customerMidNameStr . ' medicareReferenceNumber: \"' . $data['customerIdmedicareReferenceNumber'] . '\" medicareCardColour: ' . $data['customerIdMedicareCardColour'] . ' expiry: \"' . $data['customerIdExpiry'] . '\" ';

                if ($data['customerIdType'] == 'DL') {
                    $countryOfIssue = ' ';
                    $medicalIdDetail = ' ';
                } else if ($data['customerIdType'] == 'PASSPORT') {
                    $stateOfIssue = ' ';
                    $medicalIdDetail = ' ';
                } else {
                    $stateOfIssue = ' ';
                    $countryOfIssue = ' ';
                }
                $identification = $identification . $stateOfIssue . $countryOfIssue . $medicalIdDetail . ' } ';
                //identification  
            }
            $customer = $customer . $premiseRelString . $identification . ' } ';

            //customer detail end

            //join account info start
            $accountHolder = ' ';
            if ($sale->vie_is_connection_joint_account_holder == 1) {
                $accountHolder = ' additionalAccountHolder: { firstName: \"' . $data['AccountHolderFirstName'] . '\" lastName: \"' . $data['AccountHolderLastName'] . '\" emailAddress: \"' . $data['AccountHolderEmail'] . '\" accessLevel: ' . $data['AccountHolderAccessLevel'] . ' }';
            }
            //join account info end

            //business detail start
            $buisnessDetail = ' ';
            if ($data['customerType'] == 'BUS') {
                $buisnessDetail = ' business: { name: \"' . $data['businessName'] . '\" idType: ' . $data['businessIdType'] . ' idValue: \"' . $data['businessIdValue'] . '\" businessType: ' . $data['businessType'] . ' anzsic: ' . $data['businessAnzsic'] . ' } ';
            }
            //business detail end

            //energisation(moving) detail start
            $energisation = ' ';
            if ($data['transactionType'] == 'ENE') {
                $energisation = ' energisation: { connectionDate: \"' . $data['energisationConnectionDate'] . '\" visualInspection: ' . $data['energisationVisualInspection'] . ' accessDetails: \"' . $data['energisationAccessDetails'] . '\" inspectionTime: \"' . $data['energisationInspectionTime'] . '\" renovationsSinceDeenergisation: ' . $data['energisationRenovationsSinceDeenergisation'] . ' renovationsInProgressOrPlanned: ' . $data['energisationRenovationsInProgressOrPlanned'] . ' afterHoursServiceOrder: ' . $data['energisationAfterHoursServiceOrder'] . ' }';
            }
            //energisation(moving) detail end

            //premise start
            $premise = ' premise: { ';
            $premiseNMIString = ' ';
            $premiseMIRNString = ' ';
            //NMI 
            if ($sale->vie_nmi_skip == 0 && ($energy == 1 || $energy == 3)) {
                $premiseNMIString = ' nmi: \"' . $data['premiseNmi'] . '\" ';
            }
            //MIRN
            if ($sale->vie_mirn_skip == 0  && ($energy == 2 || $energy == 'both')) {
                $premiseMIRNString = 'mirn: \"' . $data['premiseMirn'] . '\" ';
            }
            //Address
            $premiseDpidString = ' ';
            if (isset($data['premiseDpid']) && $data['premiseDpid'] != '') {
                $premiseDpidString = 'dpid: ' . $data['premiseDpid'];
            }
            $premiseUnitTypeStr = '';
            if (isset($data['premiseUnitType']) && $data['premiseUnitType'] != '') {
                $premiseUnitTypeStr = 'unitType: \"' . $data['premiseUnitType'] . '\"';
            }
            $premiseUnitNumStr = '';
            if (isset($data['premiseUnitNumber']) && $data['premiseUnitNumber'] != '') {
                $premiseUnitNumStr = 'unitNumber: \"' . $data['premiseUnitNumber'] . '\"';
            }
            $premiseFloorNumStr = '';
            if (isset($data['premiseFloorNumber']) && $data['premiseFloorNumber'] != '') {
                $premiseFloorNumStr = 'floorNumber: \"' . $data['premiseFloorNumber'] . '\"';
            }
            $premiseFloorTypeStr = '';
            if (isset($data['premiseFloorType']) && $data['premiseFloorType'] != '') {
                $premiseFloorTypeStr = 'floorType: \"' . $data['premiseFloorType'] . '\"';
            }

            $premiseAddress = 'address: { ' . $premiseUnitTypeStr . $premiseUnitNumStr . $premiseFloorNumStr . $premiseFloorTypeStr . ' streetNumber: \"' . $data['premiseStreetNumber'] . '\" streetName: \"' . $data['premiseStreetName'] . '\" streetType: \"' . $data['premiseStreetType'] . '\" suburb: \"' . $data['premiseSuburb'] . '\" state: ' . $data['premiseState'] . ' postcode: \"' . $data['premisePostcode'] . '\" ' . $premiseDpidString . ' } ';

            //Solar detail
            $premiseNetTariffStr = ' ';
            if ($data['premiseSolarPower'] == 'true') {
                $premiseNetTariffStr = ' networkTariffCode: \"' . $data['premiseNetworkTariffCode'] . '\"';
            }
            $premiseSolar = ' solarDetails: { solarPower: ' . $data['premiseSolarPower'] . $premiseNetTariffStr . ' timeOfUse: ' . $data['premiseTimeOfUse'] . ' } ';

            $premise = $premise . $premiseNMIString . $premiseMIRNString . $premiseAddress . $premiseSolar . ' } ';
            //premise end

            //Offer starts
            $offer = ' offers: [ ';
            $offerElec = '';
            $offerGas = '';
            if ($energy == 3) {
                $offerElec = '{ fuel: ELE planId: \"' . $data['offerElecPlanId'] . '\" sourceCode: \"' . $data['offerElecSourceCode'] . '\" greenEnergyPercentage: 0 }';
                $offerGas = ' { fuel: GAS planId: \"' . $data['offerGasPlanId'] . '\" sourceCode: \"' . $data['offerGasSourceCode'] . '\" } ';
            } else if ($energy == 1) {
                $offerElec = '{ fuel: ELE planId: \"' . $data['offerElecPlanId'] . '\" sourceCode: \"' . $data['offerElecSourceCode'] . '\" greenEnergyPercentage: 0 }';
            } else {
                $offerGas = ' { fuel: GAS planId: \"' . $data['offerGasPlanId'] . '\" sourceCode: \"' . $data['offerGasSourceCode'] . '\" } ';
            }
            $offer = $offer . $offerElec . $offerGas . ' ]';
            //Offer ends

            //postal address or street address start
            $postalDpidString = ' ';
            if (isset($data['postalDpid']) && $data['postalDpid'] != '') {
                $postalDpidString = ' dpid: ' . $data['postalDpid'];
            }
            $StreetDpidString = ' ';
            if (isset($data['StreetDpid']) && $data['StreetDpid'] != '') {
                $StreetDpidString = 'dpid: ' . $data['StreetDpid'];
            }
            $postalAddress = ' ';
            $streetAddress = ' ';
            if ($data['mailingAddressType'] == 'POSTAL') {
                $postalAddress = ' postalMailingAddress: { postalDeliveryNumber: \"' . $data['postalDeliveryNumber'] . '\" postalDeliveryType: ' . $data['postalDeliveryType'] . ' suburb: \"' . $data['postalSuburb'] . '\" state: ' . $data['postalState'] . ' postcode: \"' . $data['postalPostcode'] . '\"';
                $postalAddress = $postalAddress . $postalDpidString . ' }';
            } else if ($data['mailingAddressType'] == 'STREET') {
                $StreetUnitNumStr = '';
                if (isset($data['StreetUnitNumber']) && $data['StreetUnitNumber'] != '') {
                    $StreetUnitNumStr = 'unitNumber: \"' . $data['StreetUnitNumber'] . '\"';
                }
                $StreetUnitTypeStr = '';
                if (isset($data['StreetUnitType']) && $data['StreetUnitType'] != '') {
                    $StreetUnitTypeStr = 'unitType: \"' . $data['StreetUnitType'] . '\"';
                }
                $StreetFloorNumStr = '';
                if (isset($data['StreetFloorNumber']) && $data['StreetFloorNumber'] != '') {
                    $StreetFloorNumStr = 'floorNumber: \"' . $data['StreetFloorNumber'] . '\"';
                }
                $StreetFloorTypeStr = '';
                if (isset($data['StreetFloorType']) && $data['StreetFloorType'] != '') {
                    $StreetFloorTypeStr = 'floorType: \"' . $data['StreetFloorType'] . '\"';
                }

                $streetAddress = ' streetMailingAddress: { ' . $StreetUnitNumStr . $StreetUnitTypeStr . $StreetFloorNumStr . $StreetFloorTypeStr . ' streetNumber: \"' . $data['StreetStreetNumber'] . '\" streetName: \"' . $data['StreetStreetName'] . '\" streetType: \"' . $data['StreetStreetType'] . '\" suburb: \"' . $data['StreetSuburb'] . '\" state: ' . $data['StreetState'] . ' postcode: \"' . $data['StreetPostcode'] . '\" ' . $StreetDpidString . ' } ';
            } 
            //postal address or street address end 
            if (!empty($errors)) {
                return ['code' => 400, 'header' => 'EA Sale Submission API', 'output' => json_encode($errors), 'data' => 'Validation Error'];
            }
            $endGrapghQL = ' }) { id version vendorCode submitted quotes { id lastUpdated fuel status rejectionReasons { code detail } } } }" }';

            //combine all detail to make full graphQL structure
            $graphQLquery = $startGraphQL . ' id: \"' . $data['vendorID'] . '\" vendorCode: \"' . $data['vendorCode'] . '\" version: \"1\" saleDate: \"' . $data['saleDate'] . '\" customerType: ' . $data['customerType'] . ' transactionType: ' . $data['transactionType'] . $customer . $accountHolder . $buisnessDetail . $energisation . $premise . $offer . ' mailingAddressType: ' . $data['mailingAddressType'] . $postalAddress . $streetAddress . ' billDeliveryMethod: ' . $data['billDeliveryMethod'] . ' carbonNeutralOptIn: ' . $data['carbonNeutralOptIn'] . ' lifeSupport: ' . $data['lifeSupport'] . ' safetyFlag: ' . $data['safetyFlag'] . ' ' . $endGrapghQL;
 
            //get okta token and use as bearer in sale submission API
            $accessToken = self::getOktaToken(); 
            //submit sale to API
            $response =  self::submitSaleToProvider($accessToken,$graphQLquery);
            $jsonResponse = json_encode($response); 
            //store api response in Database
            $apirequest['lead_id'] = $leadId;
            $apirequest['api_name'] = 'EA Sale Submission API';
            $apirequest['api_response'] = $jsonResponse;
            $apirequest['header_data'] = 'EA API Response';
            $apirequest['api_reference'] = $data['vendorID'];
            $apirequest['api_request'] = $graphQLquery;
            
            DB::connection('sale_logs')->table('sale_submission_api_responses')->insert($apirequest); 
            //return api response  if validation error
            if (isset($response['errors'])) {
                return ['code' => 400, 'header' => 'EA Sale Submission API', 'output' => $jsonResponse, 'data' => $graphQLquery];
            }

            //increament batch no
            Lead::where('lead_id', $leadId)->update(['sale_submission_attempt' => $saleSubAttempt + 1]);
            
            //return api response
            if ($energy == 3 && ($response['data']['submitSale']['quotes'][0]['status'] == 'REJECTED' || $response['data']['submitSale']['quotes'][1]['status'] == 'REJECTED')) {
                return ['code' => 400, 'header' => 'EA Sale Submission API', 'output' => $jsonResponse, 'data' => $graphQLquery];
            }
            else if ($energy != 3 && $response['data']['submitSale']['quotes'][0]['status'] == 'REJECTED') {
                return ['code' => 400, 'header' => 'EA Sale Submission API', 'output' => $jsonResponse, 'data' => $graphQLquery];
            }
            return ['code' => '200', 'header' => 'EA Sale Submission API', 'output' => $jsonResponse, 'data' => $graphQLquery];
    }

}
