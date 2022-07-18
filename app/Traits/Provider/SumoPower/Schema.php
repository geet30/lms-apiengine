<?php

namespace App\Traits\Provider\SumoPower;

use App\Traits\Provider\SumoPower\Headings;
use Carbon\Carbon;

trait Schema
{
    function sumoPowerSchema($providerLeads, $data)
    {
        try {
            $data['providerName'] = 'Sumo Power';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
            $providerData = $processedRefNum = $lead_ids = $leadIds = [];
            $referenceNo = $providerLeads[0]->sale_product_reference_no;
            $submit_data_inc = $resubmit_data_inc = $send_schema = 0;
            foreach ($providerLeads as $providerLead) {
                $NMI = $ElecProductOffer = $ElecPromoCode = $MIRN = $GasProductOffer = $GasPromoCode = '';
                array_push($leadIds, $providerLead->l_lead_id);
                if (!in_array($providerLead->spe_sale_status . '_' . $referenceNo, $processedRefNum)) {
                    $processedRefNum[] = $providerLead->spe_sale_status . '_' . $referenceNo;
                    if ($providerLead->spe_sale_status == 4) {
                        $reference_key_array[$referenceNo] = $submit_data_inc;
                        $submit_data_inc++;
                    }
                    if ($providerLead->spe_sale_status == 12) {
                        $reference_key_array[$referenceNo] = $resubmit_data_inc;
                        $resubmit_data_inc++;
                    }
                    if ($data['mailType'] == "test") {
                        $reference_key_array[$referenceNo] = $send_schema;
                        $send_schema++;
                    }
    
                    $lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id;
    
                    if ($providerLead->sale_product_product_type == 1) {
                        $CommodityType = 'E';
                        $NMI = $providerLead->vie_nmi_number ?? ''; //excel column Y
                        $ElecProductOffer = $providerLead->plan_product_code ?? ''; //excel column AA
                        $ElecPromoCode = $providerLead->plan_promotion_code ?? ''; //excel column BZ
    
                    } else {
                        $CommodityType = 'G';
                        $MIRN = $providerLead->vie_dpi_mirn_number ?? ''; //excel column Z
                        $GasProductOffer = $providerLead->plan_product_code ?? ''; //excel column AB
                        $GasPromoCode = $providerLead->plan_promotion_code ?? ''; //excel column CA
                    }
    
                    //customer title - excel Column : B
                    $CustomerTitle =  decryptGdprData($providerLead->vis_title) ? str_replace('.', ' ', decryptGdprData($providerLead->vis_title)) : "";
    
                    //FirstName - excel column - C
                    $FirstName = decryptGdprData($providerLead->vis_first_name) ?? "";
    
                    //FirstName - excel column - D
                    $LastName = decryptGdprData($providerLead->vis_last_name) ?? "";
    
                    //SecondaryCustomerTitle - excel column - E (always to be blank)
                    $SecondaryCustomerTitle = "";
                    //SecondaryFirstName - excel column - F (always to be blank)
                    $SecondaryFirstName = "";
                    //SecondaryLastName - excel column - G (always to be blank) 
                    $SecondaryLastName = "";
                    //AuthenticationType - excel column - H
                    $AuthenticationType = "";
                    //AuthenticationNo - excel cloumn - I
                    $AuthenticationNo = '';
                    if ($providerLead->vie_identity_type) {
                        $AuthenticationType = $providerLead->vie_identity_type;
                        //foreign passport
                        if ($providerLead->vie_identity_type == 'Passport' || $providerLead->vie_identity_type == 'Foreign Passport') {
                            $AuthenticationNo = $providerLead->vie_passport_number;
                        }
                        //Driving Licence
                        if ($providerLead->vie_identity_type == 'Drivers Licence') {
                            $AuthenticationNo = $providerLead->vie_licence_number;
                        }
                        //Medicare Card
                        if ($providerLead->vie_identity_type == 'Medicare Card') {
                            $AuthenticationNo = $providerLead->vie_medicare_number;
                        }
                    }
                    //AuthenticationName - excel column J
                    $AuthenticationName = str_replace('.', ' ', $CustomerTitle) . " " . $FirstName . " " . $LastName;
                    //AuthenticationDateOfBirth - excel column K
                    $AuthenticationDateOfBirth = "";
                    if ($providerLead->vis_dob) {
                        $AuthenticationDateOfBirth = Carbon::parse($providerLead->vis_dob)->format('d/m/Y');
                    }
                    //SecondaryAuthenticationType - excel column L (always to be blank)
                    $SecondaryAuthenticationType = "";
                    //SecondaryAuthenticationNo - excel column M  (always to be blank)
                    $SecondaryAuthenticationNo = "";
                    //SecondaryAuthenticationName - excel column N  (always to be blank)
                    $SecondaryAuthenticationName = "";
                    //SecondaryAuthenticationDateOfBirth - excel column O  (always to be blank)
                    $SecondaryAuthenticationDateOfBirth = "";
                    //PhoneHome - excel column P  (always to be blank)
                    $PhoneHome = "";
                    //PhoneMobile - excel column Q
                    $PhoneMobile = decryptGdprData($providerLead->vis_visitor_phone) ?? "";
                    //Email - excel column R
                    $Email = decryptGdprData($providerLead->vis_email) ?? "";
                    //SecondaryPhoneHome - excel column S  (always to be blank)
                    $SecondaryPhoneHome = "";
                    //SecondaryPhoneMobile - excel column T  (always to be blank)
                    $SecondaryPhoneMobile = "";
                    //SecondaryEmail - excel column U  (always to be blank)
                    $SecondaryEmail = "";
                    //CustomerType - excel column V
                    $CustomerType = "";
                    if ($providerLead->journey_property_type == 1) {
                        $CustomerType = 'Residential';
                    } elseif ($providerLead->journey_property_type == 2) {
                        $CustomerType = 'Business';
                    }
                    //InvoiceDisplayName - excel column W (always to be blank)
                    $InvoiceDisplayName = "";
                    //CustomerReference - excel column X
                    $CustomerReference = $referenceNo ?? '';
    
                    //ProposedTransferDate - excel column AC
                    $ProposedTransferDate = "";
                    if ($providerLead->journey_moving_house == 1 && $providerLead->journey_moving_date) {
                        //check last business day
                        $ProposedTransferDate = $this->getLastBusinessDay($providerLead->va_state, $providerLead->journey_moving_date);
                    }
    
                    //EmailInvoice - excel column AD
                    $EmailInvoice = "N"; //if selected eBill then Y otherwise N
                    if ($providerLead->l_billing_preference == 1) {
                        $EmailInvoice = "Y";
                    }
                    //CommunicationMethod - excel column AE (Always Mobile)
                    $CommunicationMethod = "Mobile";
                    //ConcessionType - excel column AF
                    $ConcessionType = "";
                    //ConcessionerNumber - excel column AG
                    $ConcessionerNumber = "";
                    //ConcessionerElectricityRebate - excel Column AH
                    $ConcessionerElectricityRebate = "N";
                    if ($providerLead->vcd_concession_type != "" && $providerLead->journey_property_type != 2 && $providerLead->vcd_concession_type != "Not Applicable") {
                        $ConcessionType = $providerLead->vcd_concession_type;
                        $ConcessionerNumber = $providerLead->vcd_card_number ?? '';
                        $ConcessionerElectricityRebate = "Y";
                    }
                    //ConcessionerDeclarationProvided - excel column  AI
                    $ConcessionerDeclarationProvided = "N"; //always set to N
                    //OccupancyType - excel column AJ
                    $OccupancyType = "";
                    if ($providerLead->journey_property_type == 1) {
                        $OccupancyType = 'Residential';
                    } elseif ($providerLead->journey_property_type == 2) {
                        $OccupancyType = 'Commercial';
                    }
                    //IsOwner - excel column AK
                    $IsOwner = "Y"; // please leave blank (as per answer given by Raj sir over basecamp)
                    //LifeSupport - excel column AL
                    $LifeSupport = "N";
                    /** Life support fuel **/
                    $lifeSupportFuel = '';
                    $isLifeSupport = ($providerLead->journey_life_support == 1);
                    if ($isLifeSupport) {
                        $LifeSupport = "Y";
                        if ($providerLead->journey_is_dual == 1) {
                            $lifeSupportFuel = 'B';
                        } else {
                            $lifeSupportFuel = ($providerLead->sale_product_product_type == 1) ? 'E' : 'G';
                        }
                    }
                    //SiteBuildingName - excel column AM
                    $SiteBuildingName = $providerLead->journey_property_type ?? '';
    
                    //SiteLocationDescriptor - excel column AN
                    $SiteLocationDescriptor = $providerLead->va_site_descriptor ?? '';
    
                    //SiteLotNumber - excel column AO
                    $SiteLotNumber = $providerLead->va_lot_number ?? '';
                    //SiteFloorType - excel column AP
                    $SiteFloorType = $providerLead->va_floor_level_type ?? '';
    
                    //SiteFloorNumber - excel column AQ
                    $SiteFloorNumber = $providerLead->va_floor_no ?? '';
                    //SiteApartmentType - excel column AR
                    $SiteApartmentType = $providerLead->va_unit_type ?? '';
                    //SiteApartmentNumber - excel column AS
                    $SiteApartmentNumber = $providerLead->va_unit_number ?? '';
                    //SiteStreetNumber - excel column AT
                    $SiteStreetNumber = $providerLead->va_street_number ?? '';
                    //SiteStreetNumberSuffix - excel column AU
                    $SiteStreetNumberSuffix = ""; //leave blank as per gurjinder sir
    
                    //SiteStreetName - excel column AV
                    $SiteStreetName = $providerLead->va_street_name ?? '';
                    //SiteStreetType - excel column AW
                    $SiteStreetType = $providerLead->va_street_code ?? '';
                    //SiteStreetSuffix - excel column AX
                    $SiteStreetSuffix = $providerLead->va_street_suffix ?? '';
                    //SiteSuburb - excel column AY
                    $SiteSuburb = $providerLead->va_suburb ?? '';
                    //SiteState - excel column AZ
                    $SiteState = $providerLead->va_state ?? '';
                    //SitePostCode - excel column BA
                    $SitePostCode = $providerLead->va_postcode ?? '';
                    //SiteAddressIsPostalAddress - excel column BB
                    $SiteAddressIsPostalAddress = "N";
                    if ($providerLead->l_billing_preference == 2) {
                        $SiteAddressIsPostalAddress = "Y";
                    }
    
                    //UseStructuredPostalAddress - excel column BC
                    $UseStructuredPostalAddress = "Y";
                    //PostalUnstructuredAddress1 - excel column BD
                    $PostalUnstructuredAddress1 = "";
                    //PostalUnstructuredAddress2 - excel column BE
                    $PostalUnstructuredAddress2 = "";
                    //PostalUnstructuredAddress3 - excel column BF
                    $PostalUnstructuredAddress3 = "";
                    if ($providerLead->is_po_box == 1) {
                        $UseStructuredPostalAddress = "N";
                        $PostalUnstructuredAddress1 = str_replace(',', ' ', $providerLead->vpa_address);
                        $PostalUnstructuredAddress2 = $providerLead->vpa_suburb;
                        $PostalUnstructuredAddress3 = $providerLead->vpa_state;
                        $PostalUnstructuredAddress3 .= " " . $providerLead->vpa_postcode;
                    }
    
    
                    /*
                         If we have po box then this field will blank otherwise fill this option from billing address.
    
                        In case user select Email or connection address in billing preferrences then we will fill this field from connection address
                         * */
                    foreach ($this->sumoAddressFields as $field => $fieldValue) {
                        ${$field} = '';
                    }

                    if ($providerLead->is_po_box == 0) { //po box is disabled
                        if ($providerLead->l_billing_preference == 1 || $providerLead->l_billing_preference == 2) {
                            foreach ($this->sumoAddressFields as $field => $fieldValue) {
                                ${$field} = $providerLead->{'va_' . $fieldValue};
                            }
                        } else {
                            foreach ($this->sumoAddressFields as $field => $fieldValue) {
                                ${$field} = $providerLead->{'vba_' . $fieldValue};
                            }
                        }
                    }
    
    
                    //PostalCountry - excel column BS
                    $PostalCountry = "AUS";
    
                    //SalesRepresentative - excel column BT
                    $SalesRepresentative = "CIMET"; //Always CIMET
                    //HasAcceptedMarketing - excel column BU
                    $HasAcceptedMarketing = "N"; //Always N
                    //HasAcceptedConditions - excel column BV
                    $HasAcceptedConditions = "Y"; //Always Y
                    //MiddleName - excel column BW
                    $MiddleName = ""; //Always blank
                    //SecondaryContactMiddleName - excel column BX
                    $SecondaryContactMiddleName = ""; //Always blank
                    //DateofSale - excel column BY
                    $DateofSale = "";
                    if ($providerLead->vie_qa_notes_created_date) {
                        try {
                            $DateofSale = Carbon::createFromFormat('d/m/Y', $providerLead->vie_qa_notes_created_date)->format('d/m/Y');
                        } catch (\Exception $e) {
                            $DateofSale = $providerLead->vie_qa_notes_created_date;
                        }
                    }
                    //Solar - excel column CB
                    $Solar = "Y";
                    if ($providerLead->journey_solar_panel == 0) {
                        $Solar = 'N';
                    }
                    //ABN - excel column CC
                    $ABN = "";
                    //ACN - excel column CD
                    $ACN = "";
                    if ($providerLead->vbd_business_abn) {
                        if (strlen($providerLead->vbd_business_abn) == 11) {
                            $ABN = $providerLead->vbd_business_abn;
                        }
    
                        if (strlen($providerLead->vbd_business_abn) == 9) {
                            $ACN = $providerLead->vbd_business_abn;
                        }
                    }
                    //ExistingSumoPowerCustomer - excel column CE
                    $ExistingSumoPowerCustomer = "N"; //Always N
                    //CustomerAccountNumber - excel column CF
                    $CustomerAccountNumber = "";
                    //CompanyBillingContact - excel column CG
                    $CompanyBillingContact = str_replace('.', ' ', $CustomerTitle) . " " . $FirstName . " " . $LastName;
                    //MovingHouse - excel column CH
                    $MovingHouse = ($providerLead->journey_moving_house == 0) ? "N" : "Y";
    
                    //HouseholdSize - excel column CI
                    $HouseholdSize = "";
                    //ElecAverageDailyUsage - excel column CJ
                    $ElecAverageDailyUsage = ""; //always blank
                    //GasAverageDailyUsage  - excel column CK
                    $GasAverageDailyUsage = "";
                    //ElecEstimatedBillAmount  - excel column CL
                    $ElecEstimatedBillAmount = "";
                    //GasEstimatedBillAmount  - excel column CM
                    $GasEstimatedBillAmount = "";
    
                    $providerData[$providerLead->spe_sale_status][] = [$CommodityType, $CustomerTitle, $FirstName, $LastName, $SecondaryCustomerTitle, $SecondaryFirstName, $SecondaryLastName, $AuthenticationType, $AuthenticationNo, $AuthenticationName, $AuthenticationDateOfBirth, $SecondaryAuthenticationType, $SecondaryAuthenticationNo, $SecondaryAuthenticationName, $SecondaryAuthenticationDateOfBirth, $PhoneHome, $PhoneMobile, $Email, $SecondaryPhoneHome, $SecondaryPhoneMobile, $SecondaryEmail, $CustomerType, $InvoiceDisplayName, $CustomerReference, $NMI, $MIRN, $ElecProductOffer, $GasProductOffer, $ProposedTransferDate, $EmailInvoice, $CommunicationMethod, $ConcessionType, $ConcessionerNumber, $ConcessionerElectricityRebate, $ConcessionerDeclarationProvided, $OccupancyType, $IsOwner, $LifeSupport, $lifeSupportFuel, $SiteBuildingName, $SiteLocationDescriptor, $SiteLotNumber, $SiteFloorType, $SiteFloorNumber, $SiteApartmentType, $SiteApartmentNumber, $SiteStreetNumber, $SiteStreetNumberSuffix, $SiteStreetName, $SiteStreetType, $SiteStreetSuffix, $SiteSuburb, $SiteState, $SitePostCode, $SiteAddressIsPostalAddress, $UseStructuredPostalAddress, $PostalUnstructuredAddress1, $PostalUnstructuredAddress2, $PostalUnstructuredAddress3, $PostalFloorType, $PostalFloorNo, $PostalApartmentType, $PostalApartmentNumber, $PostalStreetNumber, $Postal_Street_Number_Suffix, $PostalStreetName, $PostalStreetType, $PostalStreetSuffix, $PostalSuburb, $PostalState, $PostalPostCode, $PostalCountry, $SalesRepresentative, $HasAcceptedMarketing, $HasAcceptedConditions, $MiddleName, $SecondaryContactMiddleName, $DateofSale, $ElecPromoCode, $GasPromoCode, $Solar, $ABN, $ACN, $ExistingSumoPowerCustomer, $CustomerAccountNumber, $CompanyBillingContact, $MovingHouse, $HouseholdSize, $ElecAverageDailyUsage, $GasAverageDailyUsage, $ElecEstimatedBillAmount, $GasEstimatedBillAmount];
                } else {
                    $lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id;
                    //add values that are not same in both case
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][0] = 'D'; // excel column 0 i.e sale is dual for same provider.
    
    
    
                    if ($providerLead->sale_product_product_type == 1) {
                        //nmi number
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][24] = $providerLead->vie_nmi_number ?? ''; //excel column Y
    
                        //Product code E
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][26] = $providerLead->plan_product_code ?? ''; //excel column AA
    
                        //promotion code for elec
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][77] = $providerLead->plan_promotion_code ?? ''; //excel column BZ
    
                    } else {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][25] = $providerLead->vie_dpi_mirn_number ?? ''; //excel column Z
    
                        //product code g
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][27] = $providerLead->plan_product_code ?? ''; //excel column AB
    
                        //promotion code for gas
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$referenceNo]][78] = $providerLead->plan_promotion_code ?? ''; //excel column CA
                    }
                }
            }

            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'Sumo_Power_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'Sumo_Power_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'Sumo_Power_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'Sumo_Power_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
            
        } catch (\Exception $e) {
            dd($e->getMessage() . '  file: ' . $e->getFile() . '  line: ' . $e->getLine());
        }
    }
}
