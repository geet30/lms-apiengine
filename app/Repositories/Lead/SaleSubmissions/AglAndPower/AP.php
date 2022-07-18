<?php

namespace App\Repositories\Lead\SaleSubmissions\AglAndPower;

use App\Models\{Providers};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AP
{
    static function submitData($sale_id, $sale_type, $single_both, $request)
    {
        try {
            $addressDetails = DB::table('visitor_addresses')->whereIn('id', [$request[0]->l_connection_address_id, $request[0]->l_billing_address_id, $request[0]->l_billing_po_box_id])->get();
            $billingAddress    = null;
            $poBoxAddress      = null;
            if (isset($addressDetails)) {
                foreach ($addressDetails as $addressDetail) {
                    if (isset($request[0]->l_billing_address_id) && $request[0]->l_billing_address_id == $addressDetail->id) {
                        $billingAddress = $addressDetail;
                    }
                    if (isset($request[0]->l_billing_po_box_id) && $request[0]->l_billing_po_box_id == $addressDetail->id) {
                        $poBoxAddress = $addressDetail;
                    }
                }
            }
            $data = [];
            $data['header']['apiName'] = "SalesOrder";
            $data['header']['vendorBusinessPartnerNumber'] = '130580989';
            $data['header']['vendorName'] = "CMT";
            $data['header']['channel'] = "broker";
            $data['header']['retailer'] = "AGL";


            /*personal Details Start*/
            $data['payload']['personDetail']['title']       = $request[0]->v_title;
            $data['payload']['personDetail']['firstName']   = $request[0]->v_first_name;
            $data['payload']['personDetail']['middleName']  = isset($request[0]->v_middle_name) ? $request[0]->v_middle_name : "";
            $data['payload']['personDetail']['lastName']    = $request[0]->v_last_name;
            $data['payload']['personDetail']['dateOfBirth'] = Carbon::parse($request[0]->v_dob)->format('Y-m-d');
            /*personal Details End*/
            /*data contactDetail Start*/
            $data['payload']['contactDetail']['emailAddress'] = $request[0]->v_email;
            $data['payload']['contactDetail']['mobilePhone'] = $request[0]->v_phone;
            $data['payload']['contactDetail']['homePhone'] =  isset($request[0]->v_alternate_phone) ? $request[0]->v_alternate_phone : "";
            $data['payload']['contactDetail']['workPhone'] =  isset($request[0]->v_alternate_phone) ? $request[0]->v_alternate_phone : "";
            /*data contactDetail End*/
            //businessDetail details
            $data['payload']['businessDetail']['name'] = ''; //$BUSINESS_NAME;
            $data['payload']['businessDetail']['businessName'] = ''; //$LEGAL_NAME;
            $data['payload']['businessDetail']['type'] = ''; //$BUSINESS_TYPE;
            // businessIdentification details
            $data['payload']['businessIdentification']['abn'] = ''; //$ABN;
            $data['payload']['businessIdentification']['acn'] = ''; //$ACN;
            $data['payload']['authorisedContactPersonDetail']['title']       =  '';
            $data['payload']['authorisedContactPersonDetail']['firstName']   =  '';
            $data['payload']['authorisedContactPersonDetail']['middleName']  =  '';
            $data['payload']['authorisedContactPersonDetail']['lastName']    =  '';
            $data['payload']['authorisedContactPersonDetail']['dateOfBirth'] =  '';
            $data['payload']['authorisedPersonContact']['emailAddress']      =  '';
            $data['payload']['authorisedPersonContact']['mobilePhone']       =  '';
            $data['payload']['authorisedPersonContact']['homePhone']         =  '';
            $data['payload']['authorisedPersonContact']['workPhone']         =  '';
            // authorisedContactPersonDetail details
            if ($request[0]->property_type == 2) {
                $data['payload']['businessDetail']['name'] = (isset($request[0]->business_legal_name)) ? $request[0]->business_legal_name : '';
                $data['payload']['businessDetail']['businessName'] = (isset($request[0]->business_legal_name)) ? $request[0]->business_legal_name : '';
                $BUSINESS_TYPE = (isset($request[0]->business_company_type)) ? $request[0]->business_company_type : '';
                $ABN_ACN = (isset($exports['visitor_business_detail']['business_abn'])) ? $exports['visitor_business_detail']['business_abn'] : '';
                if ($BUSINESS_TYPE == 'Incorporation') {
                    $BUSINESS_TYPE = 'Other';
                } elseif ($BUSINESS_TYPE == 'Limited Company') {
                    $BUSINESS_TYPE = "Company";
                } elseif ($BUSINESS_TYPE == 'Partnership') {
                    $BUSINESS_TYPE = "Partnership";
                } elseif ($BUSINESS_TYPE == 'Private') {
                    $BUSINESS_TYPE = "Other";
                } elseif ($BUSINESS_TYPE == 'Sole Trader') {
                    $BUSINESS_TYPE = "SoleTrader";
                } elseif ($BUSINESS_TYPE == 'Trust') {
                    $BUSINESS_TYPE = "Other";
                } else {
                    $BUSINESS_TYPE = "Other";
                }
                $data['payload']['businessDetail']['type'] = $BUSINESS_TYPE;
                if (strlen($ABN_ACN) == 9) {
                    $data['payload']['businessIdentification']['acn'] = $ABN_ACN;
                } else {
                    $data['payload']['businessIdentification']['abn'] = $ABN_ACN;
                }
                // authorisedContactPersonDetail details
                $data['payload']['authorisedContactPersonDetail']['title']       = $request[0]->v_title;
                $data['payload']['authorisedContactPersonDetail']['firstName']   = $request[0]->v_first_name;
                $data['payload']['authorisedContactPersonDetail']['middleName']  = isset($request[0]->v_middle_name) ? $request[0]->v_middle_name : "";
                $data['payload']['authorisedContactPersonDetail']['lastName']    =  $request[0]->v_last_name;
                $data['payload']['authorisedContactPersonDetail']['dateOfBirth'] =  Carbon::parse($request[0]->v_dob)->format('Y-m-d');
                $data['payload']['authorisedPersonContact']['emailAddress'] = $request[0]->v_email;
                $data['payload']['authorisedPersonContact']['mobilePhone'] = $request[0]->v_phone;
                $data['payload']['authorisedPersonContact']['homePhone'] = isset($request[0]->v_alternate_phone) ? $request[0]->v_alternate_phone : "";
                $data['payload']['authorisedPersonContact']['workPhone'] = isset($request[0]->v_alternate_phone) ? $request[0]->v_alternate_phone : "";
                $data['payload']['concessionCardDetail']['cardType']     = '';
                $data['payload']['concessionCardDetail']['cardNumber']   = '';
                $data['payload']['concessionCardDetail']['dateOfExpiry'] = '';
            }
            //siteAddress details
            $data['payload']['siteAddress']['buildingName'] = $request[0]->property_name;
            $data['payload']['siteAddress']['floorNumber'] = $request[0]->va_lot_number;
            $data['payload']['siteAddress']['ignoreAddressValidation'] = false;
            if ($request[0]->validate_address == 1) {
                $data['payload']['siteAddress']['ignoreAddressValidation'] = true;
            }
            //true or false
            $data['payload']['siteAddress']['lotNumber'] = $request[0]->va_lot_number;
            $data['payload']['siteAddress']['postcode'] = $request[0]->va_postcode;
            $data['payload']['siteAddress']['postOfficeBoxNumber'] = null;
            $data['payload']['siteAddress']['state'] =  $request[0]->va_state;
            $data['payload']['siteAddress']['streetName'] = $request[0]->va_street_name;
            $data['payload']['siteAddress']['streetNumber'] = $request[0]->va_street_number;
            $data['payload']['siteAddress']['suburb'] = $request[0]->va_suburb;
            $data['payload']['siteAddress']['unitNumber'] = isset($request[0]->va_unit_no) ? $request[0]->va_unit_no : "";
            /* Identification details Start Here */
            $data['payload']['identification']['driversLicense']['licenseNumber'] = '';
            $data['payload']['identification']['medicare']['medicareNumber'] = '';
            $data['payload']['identification']['medicare']['individualReferenceNumber'] = '';
            $data['payload']['identification']['passport']['passportNumber'] = '';
            //authorisedPersonIdentification details
            $data['payload']['authorisedPersonIdentification']['driversLicense']['licenseNumber'] = '';

            if (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Drivers Licence') {
                $data['payload']['identification']['driversLicense']['licenseNumber'] = $request[0]->vi_licence_number;
                $data['payload']['authorisedPersonIdentification']['driversLicense']['licenseNumber'] = $request[0]->vi_licence_number;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Foreign Passport') {
                $data['payload']['identification']['passport']['passportNumber'] = $request[0]->vi_foreign_passport_number;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Passport') {
                $data['payload']['identification']['passport']['passportNumber'] = $request[0]->vi_passport_number;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'medicare card') {
                $data['payload']['identification']['medicare']['medicareNumber'] = $request[0]->vi_medicare_number;
                $data['payload']['identification']['medicare']['individualReferenceNumber'] = $request[0]->reference_number;
            }
            /* Identification details End Here */
            //concessionCard Detail
            $data['payload']['concessionCardDetail']['cardType'] = '';
            $data['payload']['concessionCardDetail']['cardNumber'] = '';
            $data['payload']['concessionCardDetail']['dateOfExpiry'] = '';
            if ($request[0]->property_type == 1) {
                if (isset($request[0]->vcd_concession_type) && !empty($request[0]->vcd_concession_type) && $request[0]->vcd_concession_type != "Not Applicable") {
                    if ($request[0]->vcd_concession_type == 'Commonwealth Senior Health Card') {
                        $CONCESSION_TYPE = 'COM_SENIOR';
                    } elseif ($request[0]->vcd_concession_type == 'Centrelink Healthcare Card') {
                        $CONCESSION_TYPE = 'HEALTHCARE';
                    } elseif ($request[0]->vcd_concession_type == 'Pensioner Concession Card') {
                        $CONCESSION_TYPE = 'PENSIONER';
                    } elseif ($request[0]->vcd_concession_type == 'Queensland Government Seniors Card') {
                        $CONCESSION_TYPE = 'QSC_GOV';
                    } elseif ($request[0]->vcd_concession_type == 'DVA Gold Card(Extreme Disablement Adjustment)') {
                        $CONCESSION_TYPE = 'GOLD_EDA';
                    } elseif ($request[0]->vcd_concession_type == 'DVA Gold Card(TPI)') {
                        $CONCESSION_TYPE = 'GOLD_TPI';
                    } elseif ($request[0]->vcd_concession_type == 'DVA Gold Card(War Widow)') {
                        $CONCESSION_TYPE = 'GOLD_WW';
                    } else {
                        $CONCESSION_TYPE = '';
                    }
                }

                $data['payload']['concessionCardDetail']['cardType'] = $CONCESSION_TYPE;
                $data['payload']['concessionCardDetail']['cardNumber'] = $request[0]->vcd_card_number;
                $data['payload']['concessionCardDetail']['dateOfExpiry'] = '9999-12-31';
            }
            $data['payload']['orderDetail']['gas']['existingBusinessPartnerNumber'] = '';
            $data['payload']['orderDetail']['electricity']['existingBusinessPartnerNumber'] = '';
            $checkEnergyType = '';
            if ($request[0]->sale_product_product_type == 1) {
                $checkEnergyType = ['electricity'];
                $data['payload']['siteMeterDetail']['electricity']['nmi'] = $request[0]->vie_nmi_number;
                $data['payload']['siteMeterDetail']['electricity']['meterNumber'] =
                    isset($request[0]->vie_meter_number_e) ? $request[0]->vie_meter_number_e : "";
                $data['payload']['moveDetail']['moveIn']['electricity']['date'] = '';
                $data['payload']['moveDetail']['moveIn']['electricity']['instructions'] = '';
                if ($request[0]->journey_moving_house == 1) {
                    $data['payload']['moveDetail']['moveIn']['electricity']['instructions'] = $request[0]->l_notes;
                    $mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $request[0]->journey_moving_date);
                    $MOVEIN_DATE_E =     $mydate->format('Y-m-d');
                    $data['payload']['moveDetail']['moveIn']['electricity']['date'] = $MOVEIN_DATE_E;
                } else {
                    $data['payload']['orderDetail']['electricity']['existingBusinessPartnerNumber'] = isset($request[0]->vie_elec_account_number) ? $request[0]->vie_elec_account_number : '';
                }
                $data['payload']['moveDetail']['moveIn']['electricity']['meterHazardInformation'] = $request[0]->vie_meter_hazard;
                $data['payload']['moveDetail']['moveIn']['electricity']['siteAccessInformation'] = $request[0]->vie_site_access_electricity;
                $data['payload']['orderDetail']['electricity']['productCode'] = $request[0]->plan_product_code;
                $data['payload']['orderDetail']['electricity']['campaignCode'] = $request[0]->plan_campaign_code;
                $data['payload']['orderDetail']['electricity']['offerDescription'] = $request[0]->plan_promotion_code;
            } else {
                $checkEnergyType = ['gas'];
                $data['payload']['siteMeterDetail']['gas']['meterNumber'] = isset($request[0]->vie_meter_number_g) ? $request[0]->vie_meter_number_g : "";
                $data['payload']['siteMeterDetail']['gas']['mirn'] = $request[0]->vie_dpi_mirn_number;
                $data['payload']['moveDetail']['moveIn']['gas']['siteAccessInformation'] = isset($request[0]->vie_site_access_gas) ? $request[0]->vie_site_access_gas : '';
                $data['payload']['moveDetail']['moveIn']['gas']['instructions'] = '';
                $data['payload']['moveDetail']['moveIn']['gas']['date'] = '';
                if ($request[0]->journey_moving_house == 1) {
                    $data['payload']['moveDetail']['moveIn']['gas']['instructions'] = $request[0]->l_notes;
                    $mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $request[0]->journey_moving_date);
                    $data['payload']['moveDetail']['moveIn']['gas']['date'] = $mydate->format('Y-m-d');
                } else {
                    $data['payload']['orderDetail']['gas']['existingBusinessPartnerNumber'] =
                        isset($request[0]->vie_gas_account_number) ? $request[0]->vie_gas_account_number : '';;
                }
                $data['payload']['orderDetail']['gas']['productCode'] = $request[0]->plan_product_code;
                $data['payload']['orderDetail']['gas']['campaignCode'] = $request[0]->plan_campaign_code;
                $data['payload']['orderDetail']['gas']['offerDescription'] = $request[0]->plan_promotion_code;
            }
            if ($single_both == "both") {
                $checkEnergyType = ['electricity', 'gas'];
                if ($request[1]->sale_product_product_type == 1) {
                    $data['payload']['siteMeterDetail']['electricity']['nmi'] = $request[1]->vie_nmi_number;
                    $data['payload']['siteMeterDetail']['electricity']['meterNumber'] =
                        isset($request[1]->vie_meter_number_e) ? $request[1]->vie_meter_number_e : "";
                    $data['payload']['moveDetail']['moveIn']['electricity']['date'] = '';
                    $data['payload']['moveDetail']['moveIn']['electricity']['instructions'] = '';
                    if ($request[1]->journey_moving_house == 1) {
                        $data['payload']['moveDetail']['moveIn']['electricity']['instructions'] = $request[1]->l_notes;
                        $mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $request[1]->journey_moving_date);
                        $MOVEIN_DATE_E =     $mydate->format('Y-m-d');
                        $data['payload']['moveDetail']['moveIn']['electricity']['date'] = $MOVEIN_DATE_E;
                    } else {
                        $data['payload']['orderDetail']['electricity']['existingBusinessPartnerNumber'] = isset($request[0]->vie_elec_account_number) ? $request[0]->vie_elec_account_number : '';
                    }

                    $data['payload']['moveDetail']['moveIn']['electricity']['meterHazardInformation'] = $request[1]->vie_meter_hazard;
                    $data['payload']['moveDetail']['moveIn']['electricity']['siteAccessInformation'] = $request[1]->vie_site_access_electricity;
                    $data['payload']['orderDetail']['electricity']['productCode'] = $request[0]->plan_product_code;
                    $data['payload']['orderDetail']['electricity']['campaignCode'] = $request[0]->plan_campaign_code;
                    $data['payload']['orderDetail']['electricity']['offerDescription'] = $request[0]->plan_promotion_code;
                } else {
                    $data['payload']['siteMeterDetail']['gas']['meterNumber'] = isset($request[1]->vie_meter_number_g) ? $request[1]->vie_meter_number_g : "";
                    $data['payload']['siteMeterDetail']['gas']['mirn'] = $request[1]->vie_dpi_mirn_number;
                    $data['payload']['moveDetail']['moveIn']['gas']['siteAccessInformation'] = isset($request[1]->vie_site_access_gas) ? $request[1]->vie_site_access_gas : '';
                    $data['payload']['moveDetail']['moveIn']['gas']['instructions'] = '';
                    $data['payload']['moveDetail']['moveIn']['gas']['date'] = '';
                    if ($request[1]->journey_moving_house == 1) {
                        $data['payload']['moveDetail']['moveIn']['gas']['instructions'] = $request[1]->l_notes;
                        $mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $request[1]->journey_moving_date);
                        $data['payload']['moveDetail']['moveIn']['gas']['date'] = $mydate->format('Y-m-d');
                    } else {
                        $data['payload']['orderDetail']['gas']['existingBusinessPartnerNumber'] =
                            isset($request[0]->vie_gas_account_number) ? $request[0]->vie_gas_account_number : '';;
                    }
                    $data['payload']['orderDetail']['gas']['productCode'] = $request[0]->plan_product_code;
                    $data['payload']['orderDetail']['gas']['campaignCode'] = $request[0]->plan_campaign_code;
                    $data['payload']['orderDetail']['gas']['offerDescription'] = $request[0]->plan_promotion_code;
                }
            }
            $data['payload']['siteAdditionalDetail']['lifeSupportSiteIndicator'] = '';
            $data['payload']['siteAdditionalDetail']['greenSale'] = '';

            $data['payload']['siteAdditionalDetail']['meterType'] = '';
            $data['payload']['siteAdditionalDetail']['serviceOrderRequest'] = '';
            $data['payload']['siteAdditionalDetail']['campaignName'] = 'TBA';
            $data['payload']['siteAdditionalDetail']['contractNumber'] = '';
            $data['payload']['siteAdditionalDetail']['matrixCode'] = '';
            $data['payload']['siteAdditionalDetail']['tariffType'] = $request[0]->vie_tariff_type;
            $data['payload']['siteAdditionalDetail']['isFlexiPrice'] = '';
            $data['payload']['siteAdditionalDetail']['referrerNumber'] = '';
            $data['payload']['siteAdditionalDetail']['promotionCode'] = '';
            $data['payload']['siteAdditionalDetail']['merchanisedRequest'] = '';
            $data['payload']['siteAdditionalDetail']['aarhDonation'] = '';
            $data['payload']['siteAdditionalDetail']['energyPriceFactSheetRequest'] = '';
            $data['payload']['siteAdditionalDetail']['salesAgent'] = 'ONLINE';
            $data['payload']['siteAdditionalDetail']['existingCrnNumber'] = '';

            if (empty($request[0]->vie_qa_notes_created_date)) {

                $date_one = Carbon::parse($request[0]->l_sale_created)->format('d/m/Y');
                $other_sale_date = Carbon::createFromFormat('d/m/Y', $date_one);
            } else {

                $other_sale_date = Carbon::createFromFormat('d/m/Y', $request[0]->vie_qa_notes_created_date);
            }
            if ($request[0]->journey_solar_panel  == 0 && $request[0]->journey_moving_house == 1) {
                $TRANSACTION_TYPE = 'SALE';
                //core sale	
            } elseif (($request[0]->journey_moving_house == 1 &&  Carbon::createFromFormat('d/m/Y', $request[0]->journey_moving_date)->gt($other_sale_date))) {
                $TRANSACTION_TYPE = 'SALE';
            } elseif (($request[0]->journey_moving_house == 1 && Carbon::createFromFormat('d/m/Y', $request[0]->journey_moving_date) == Carbon::parse($other_sale_date))) {
                $TRANSACTION_TYPE = 'SDFI';
            } elseif ($request[0]->journey_moving_house == 0) {
                //solar cor sale

                $TRANSACTION_TYPE = 'SALE';
            }
            /*Change_request and chnage_request_date according to transction type*/
            $CHANGE_REQUEST = '';
            $CHANGE_REQUEST_DATE = '';
            if (isset($TRANSACTION_TYPE) && !empty($TRANSACTION_TYPE)) {

                if ($TRANSACTION_TYPE == "CHANGE") {
                    $CHANGE_REQUEST = "Y";
                } else {
                    $CHANGE_REQUEST = "N";
                }
            }

            if (isset($CHANGE_REQUEST) && !empty($CHANGE_REQUEST)) {

                if ($CHANGE_REQUEST == "Y") {
                    $CHANGE_REQUEST_DATE = Carbon::now()->format('Y-m-d');
                } else {

                    $CHANGE_REQUEST_DATE = "";
                }
            }
            $data['payload']['siteAdditionalDetail']['changeRequest'] = $CHANGE_REQUEST;
            $data['payload']['siteAdditionalDetail']['changeRequestDate'] = $CHANGE_REQUEST_DATE;
            $data['payload']['siteAdditionalDetail']['comments'] = '';
            $data['payload']['siteAdditionalDetail']['merchandisedRequest'] = 'N';
            $data['payload']['siteAdditionalDetail']['addressPropertyUse'] = '';
            $data['header']['dateOfSale'] = $other_sale_date->format('Y-m-d');
            //moveDetail
            //move out 
            $data['payload']['moveDetail']['moveOut']['electricity']['instructions'] = '';
            $data['payload']['moveDetail']['moveOut']['electricity']['date'] = '';
            $data['payload']['moveDetail']['moveOut']['gas']['instructions'] = '';
            $data['payload']['moveDetail']['moveOut']['gas']['date'] = '';
            //billingPreference
            $data['payload']['billingPreference']['isDirectDebitRequested'] = 'N';
            //siteMeterAccess detals
            $data['payload']['siteMeterAccess']['electricity']['hasCustomerGivenRemoteEnergiseConsent'] = 'Y';
            $data['payload']['siteMeterAccess']['electricity']['hasCustomerGivenRemoteDeEnergiseConsent'] = '';
            $data['payload']['siteMeterAccess']['gas']['dogHazardCode'] = $request[0]->vie_dog_code;
            //flybuys data
            $data['payload']['flybuys']['hasCustomerGivenFlybuysLinkConsent'] = 'N';
            $data['payload']['flybuys']['flybuysNumber'] = '';
            $data['payload']['flybuys']['flybuysPointsAllocated'] = '';
            /* Address start here */

            $MAILING_BUILDING_NAME = '';
            $MAILING_FLOOR = '';
            $MAILING_LOT_NUMBER = '';
            $MAILING_UNIT_NUMBER = '';
            $MAILING_STREET_NUMBER = '';
            $MAILING_STREET_NAME = '';
            $MAILING_SUBURB = '';
            $MAILING_STATE = '';
            $MAILING_POSTCODE = '';
            $ECONF_PACK_CONSENT = 'N';
            if ($request[0]->l_is_po_box ==  1 && !empty($request[0]->l_is_po_box)) {
                $MAILING_STREET_NUMBER = (isset($poBoxAddress->address)) ?  $poBoxAddress->address : '';
                $MAILING_STREET_NAME = '';
                $MAILING_SUBURB = (isset($poBoxAddress->suburb)) ? $poBoxAddress->suburb : '';
                $MAILING_STATE = (isset($poBoxAddress->state)) ? $poBoxAddress->state : '';
                $MAILING_POSTCODE = (isset($poBoxAddress->postcode)) ?  $poBoxAddress->postcode : '';
                if ($poBoxAddress->validate_address ==  1) {
                    $validate_address = true;
                } else {
                    $validate_address = false;
                }
            } else if ($request[0]->l_billing_preference == "3") {
                $MAILING_BUILDING_NAME = $billingAddress->property_name;
                $MAILING_FLOOR = $billingAddress->floor_number;
                $MAILING_LOT_NUMBER = $billingAddress->lot_number;
                $MAILING_UNIT_NUMBER = $billingAddress->unit_number;
                $MAILING_STREET_NUMBER = $billingAddress->street_number;
                $MAILING_STREET_NAME = $billingAddress->street_name;
                $MAILING_SUBURB = $billingAddress->suburb;
                $MAILING_STATE = $billingAddress->state;
                $MAILING_POSTCODE = $billingAddress->postcode;
                $street_type_val =  $billingAddress->street_code;
                $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                if ($billingAddress->validate_address ==  1) {
                    $validate_address = true;
                } else {
                    $validate_address = false;
                }
            } elseif ($request[0]->l_billing_preference == "1" && $request[0]->email_welcome_pack == 1) {
                $MAILING_BUILDING_NAME = $billingAddress->property_name;
                $MAILING_FLOOR = $billingAddress->floor_number;
                $MAILING_LOT_NUMBER = $billingAddress->lot_number;
                $MAILING_UNIT_NUMBER = $billingAddress->unit_number;
                $MAILING_STREET_NUMBER = $billingAddress->street_number;
                $MAILING_STREET_NAME = $billingAddress->street_name;
                $MAILING_SUBURB = $billingAddress->suburb;
                $MAILING_STATE = $billingAddress->state;
                $MAILING_POSTCODE = $billingAddress->postcode;
                $street_type_val =  $billingAddress->street_code;
                $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                if ($billingAddress->validate_address ==  1) {
                    $validate_address = true;
                } else {
                    $validate_address = false;
                }
                $ECONF_PACK_CONSENT = 'Y';
            } else {
                $MAILING_BUILDING_NAME =  $request[0]->va_property_name;
                $MAILING_FLOOR = $request[0]->va_floor_no;
                $MAILING_LOT_NUMBER =  $request[0]->va_lot_number;
                $MAILING_UNIT_NUMBER = $request[0]->va_unit_no;
                $MAILING_STREET_NUMBER =  $request[0]->va_street_number;
                $MAILING_STREET_NAME =  $request[0]->va_street_name;
                $MAILING_SUBURB =  $request[0]->va_suburb;
                $MAILING_STATE =  $request[0]->va_state;
                $MAILING_POSTCODE  =  $request[0]->va_postcode;
                $street_type_val = $request[0]->va_street_code;
                $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                if ($request[0]->va_validate_address == 1) {
                    $validate_address = true;
                } else {
                    $validate_address = false;
                }
            }
            $ECOMM_CONSENT = 'N';
            $AEO_REG = 'N';
            if ($request[0]->l_billing_preference == "1") {
                $ECOMM_CONSENT = 'Y';
                $AEO_REG = 'Y';
            }
            $data['payload']['mailingAddress']['streetAddress']['buildingName'] = $MAILING_BUILDING_NAME;
            $data['payload']['mailingAddress']['streetAddress']['floorNumber'] = $MAILING_FLOOR;
            $data['payload']['mailingAddress']['streetAddress']['ignoreAddressValidation'] = $validate_address; //true or false
            $data['payload']['mailingAddress']['streetAddress']['lotNumber'] = $MAILING_LOT_NUMBER;
            $data['payload']['mailingAddress']['streetAddress']['postcode'] = $MAILING_POSTCODE;
            $data['payload']['mailingAddress']['streetAddress']['postOfficeBoxNumber'] = '';
            $data['payload']['mailingAddress']['streetAddress']['state'] = $MAILING_STATE;
            $data['payload']['mailingAddress']['streetAddress']['streetName'] = $MAILING_STREET_NAME;
            $data['payload']['mailingAddress']['streetAddress']['streetNumber'] = $MAILING_STREET_NUMBER;
            $data['payload']['mailingAddress']['streetAddress']['suburb'] = $MAILING_SUBURB;
            $data['payload']['mailingAddress']['streetAddress']['unitNumber'] = $MAILING_UNIT_NUMBER;



            /* Address end here */
            //customerConsent details
            $data['payload']['customerConsent']['hasGivenMarketingCommunicationConsent'] = 'Y';
            $data['payload']['customerConsent']['hasGivenElectronicWelcomePackConsent'] = $ECONF_PACK_CONSENT;
            $data['payload']['customerConsent']['hasGivenEBillingConsent'] = $ECOMM_CONSENT;
            $data['payload']['customerConsent']['hasGivenBillingUpdateViaSmsConsent'] = 'Y';
            $CREDIT_CONSENT = 'N';
            $saleCheckBoxs = DB::table('sale_checkbox_statuses')->select('module_type')->where('sale_id', $sale_id)->whereIn('energy_type', $checkEnergyType)->where('status', 1)->where('module_type', 1)->first();
            if ($saleCheckBoxs) {
                $CREDIT_CONSENT = 'N';
            }
            $data['payload']['customerConsent']['hasGivenCreditCheckConsent'] = $CREDIT_CONSENT;
            $data['payload']['customerConsent']['hasGivenOnlineAccountRegistrationConsent'] = $AEO_REG;
            //cancellationDetail details
            $data['payload']['cancellationDetail']['dateOfCancellation'] = '';
            $data['payload']['cancellationDetail']['type'] = '';
            $data['payload']['cancellationDetail']['reason'] = '';
            $data['payload']['cancellationDetail']['reasonOther'] = '';

            /* Header*/
            $data['header']['transactionType'] = $TRANSACTION_TYPE;
            $data['header']['customerType'] = "RES";
            if ($request[0]->property_type == 2){
                $data['header']['customerType']="BUS";
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
