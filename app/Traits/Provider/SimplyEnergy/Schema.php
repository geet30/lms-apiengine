<?php

namespace App\Traits\Provider\SimplyEnergy;

use Illuminate\Support\Facades\{DB};
use App\Models\{DistributorPostCode, DmoPrice, Lead, Providers};
use Carbon\Carbon;

trait Schema
{
    function simplyEnergySchema($providerLeads, $data)
    {
        try {
            $data['providerName'] = 'Simply Energy';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
            $refNo = $providerLeads[0]->sale_product_reference_no;
            $refArray = $reference_key_array = $leadIds = [];
            $submit_data_inc = 0;
            $resubmit_data_inc = 0;
            $offer_type_elec = 0;
            $offer_type_gas = 0;
            $CustomerNumber = ''; //AK
            $NameInitialOnRewardCard = '';
            $ls_energy_type_inc = 1; //added

            $SurnameOnRewardCard = '';
            $NameInitialOnRewardCard = '';
            foreach ($providerLeads as $providerLead) {
                $lead_ids[$providerLead->spe_sale_status][] = $providerLead->l_lead_id;
                //get energy type
                $energy_type = $providerLead->sale_product_product_type ?? '';
                array_push($leadIds, $providerLead->l_lead_id);
                //Get bundle-code from plan info.
                $bundleCode = $providerLead->plan_bundle_code ?? '';

                if (empty($bundleCode)) {
                    $plan = DB::table('plans_energy')->select('bundle_code')->where('energy_type', $energy_type)->where('provider_id', $providerLead->sale_product_provider_id)->where('name', $providerLead->plan_name)->first();
                    $bundleCode = $plan ? $plan->bundle_code : $bundleCode;
                }
                $movin_house = $providerLead->journey_moving_house ?? '';


                if (!in_array($providerLead->spe_sale_status . '_' . $refNo, $refArray)) {

                    $refArray[] = $providerLead->spe_sale_status . '_' . $refNo;
                    if ($providerLead->spe_sale_status == '4') {
                        $reference_key_array[$refNo] = $submit_data_inc;
                        $submit_data_inc++;
                    }
                    if ($providerLead->spe_sale_status == '12') {
                        $reference_key_array[$refNo] = $resubmit_data_inc;
                        $resubmit_data_inc++;
                    }



                    //get moving house
                    $movin_house = $providerLead->journey_moving_house ?? '';

                    //Set Sale agent data
                    $SalesAgent = $providerLead->vie_sale_agent ?? '';

                    //Set OfferType //C
                    $OfferType = '';

                    $TrackingNumber = $refNo;

                    $FeedInType = $providerLead->ebd_tariff_type ?? '';  //D
                    $CampaignName = ''; //E
                    $NMI = '';  //W
                    $MIRN = '';  //X
                    $ElectricityProductCode = '';  //G
                    $GasProductCode = '';  //H	
                    $EstimatedAnnualUsage = '';  //AM					
                    $EnergisationDate = '';  //DS
                    $CustomerPreferredDate = '';  //DV
                    $ElectricityAdminFeeWaived = ''; //DX
                    $ElectricityAdminFeeWaiverReason = ''; //DY
                    $ElecSOFeeWaive = ''; //DZ
                    $GasAdminFeeWaived = ''; //ED
                    $GasAdminFeeWaiverReason = ''; //EE
                    $GasSOFeeWaive = ''; //EF
                    $ElectricitySpecialInstructions = ''; //EB
                    $ElectricityAccessDetails = ''; //EC
                    $GasSpecialInstructions = ''; //EH
                    $GasAccessDetails = '';  //EI 


                    $postcode = $providerLead->va_postcode;



                    // get distributor id for energy type electricity 
                    $peak_only_usage = "";
                    if ($energy_type == 1 && $providerLead->journey_property_type == 2) {
                        $distributor_id = $providerLead->journey_distributor_id;

                        //get DMO price and handle 'idontknow' case for distributor id
                        if ($distributor_id != 'idontknow') {
                            $peak_only_usage = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 'business', 'tariff_type' => 'peak_only']);
                            if ($peak_only_usage->count() > 0) {
                                $peak_only_usage = $peak_only_usage->first()->peak_only;
                            }
                        } else {
                            $distributor_id = DistributorPostCode::where('post_code', $postcode)->first()->select('distributor_id');
                            $peak_only_usage = DmoPrice::where(['distributor_id' => $distributor_id, 'property_type' => 'business', 'tariff_type' => 'peak_only']);
                            if ($peak_only_usage->count() > 0) {
                                $peak_only_usage = $peak_only_usage->first()->peak_only;
                            }
                        }
                    }
                    if (!isset($distributor_id)) {
                        $distributor_id = DistributorPostCode::where('post_code', $postcode)->first()->distributor_id;
                    }


                    //Conditons for dual cases fields
                    if ($providerLead->journey_is_dual == 1) {
                        if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $EstimatedAnnualUsage = "";  //AM
                            $offer_type_elec = 1; //echo " 241 
                            $ElectricityProductCode = $providerLead->vie_electricity_code ?? '';
                            if ($providerLead->journey_property_type == 'business') {
                                $EstimatedAnnualUsage = $peak_only_usage ? $peak_only_usage : '';  //AM	

                            }
                            $NMI = $providerLead->vie_nmi_number ?? '';
                            $ElectricityAdminFeeWaived = 'Y'; //DX
                            $ElectricityAdminFeeWaiverReason = 'SALI'; //DY								
                            $ElectricitySpecialInstructions = $providerLead->l_note ?? ''; //EB
                            $ElectricityAccessDetails = $providerLead->vie_site_access_electricity ?? ''; //EC
                            //check moving house
                            if ($movin_house == 1 && $providerLead->journey_moving_date) {
                                $EnergisationDate  = $providerLead->journey_moving_date; //DS
                                $CustomerPreferredDate  = $providerLead->journey_moving_date;  //DV 
                                $ElecSOFeeWaive = 'N'; //DZ
                            }
                        } else if ($energy_type == 'gas' && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $offer_type_gas = 1; //echo " 268 
                            $GasProductCode = $providerLead->vie_gas_code ?? '';  //H					
                            $MIRN = $providerLead->vie_dpi_mirn_number ?? '';
                            $GasAdminFeeWaived = 'Y'; //ED
                            $GasAdminFeeWaiverReason = 'SALI'; //EE
                            $GasSpecialInstructions = $providerLead->l_note ?? ''; //EH
                            $GasAccessDetails = $providerLead->vie_site_access_gas ?? ''; //EI	
                            //check moving house
                            if ($movin_house == 'yes' && $providerLead->journey_moving_date) {
                                $EnergisationDate  = $providerLead->journey_moving_date; //DS
                                $GasSOFeeWaive = 'N'; //EF 
                            }
                        }
                    } else {

                        if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $offer_type_elec = 1;
                            $EstimatedAnnualUsage = "";  //AM
                            $ElectricityProductCode = $providerLead->vie_electricity_code ?? '';     //G	
                            if ($providerLead->journey_property_type == 'business') {
                                $EstimatedAnnualUsage = $peak_only_usage ? $peak_only_usage : '';  //AM	
                            }
                            $NMI = $providerLead->vie_nmi_number ?? '';  //W
                            $ElectricityAdminFeeWaived = 'Y'; //DX
                            $ElectricityAdminFeeWaiverReason = 'SALI'; //DY

                            $ElectricitySpecialInstructions = $providerLead->l_note ?? ''; //EB
                            $ElectricityAccessDetails = $providerLead->vie_site_access_electricity ?? ''; //EC
                            //check moving house
                            if ($movin_house == 'yes' && $providerLead->journey_moving_date) {

                                $EnergisationDate  = $providerLead->journey_moving_date; //DS
                                $CustomerPreferredDate  = $providerLead->journey_moving_date;  //DV  
                                $ElecSOFeeWaive = 'N'; //DZ
                            }
                        } else if ($energy_type == 'gas' && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $offer_type_gas = 1;
                            $GasProductCode = $providerLead->vie_gas_code ?? '';  //H				
                            $MIRN = $providerLead->vie_dpi_mirn_number ?? '';  //X
                            $GasAdminFeeWaived = 'Y'; //ED
                            $GasAdminFeeWaiverReason = 'SALI'; //EE

                            $GasSpecialInstructions = $providerLead->l_note ?? ''; //EH
                            $GasAccessDetails = $providerLead->vie_site_access_gas ?? ''; //EI	
                            //check moving house
                            if ($movin_house == 1 && $providerLead->journey_moving_date) {

                                $EnergisationDate  = $providerLead->journey_moving_date; //DS
                                //$CustomerPreferredDate  = '';  //DV 
                                //$CustomerPreferredDate  = $exports['moving_date'];  //DV 
                                $GasSOFeeWaive = 'N'; //EF 
                            }
                        }
                    }
                    $ls_energy_type = '';

                    //Set the offertype and Campaign name for simply schema
                    $CampaignName = $bundleCode;
                    if ($offer_type_elec == 1 && $offer_type_gas == 1) {
                        $OfferType = 'DF';
                        // $CampaignName = $bundle_code_elec;
                        $offer_type_elec = 0;
                        $offer_type_gas  = 0;
                        $ls_energy_type = 'both';
                    } else if ($offer_type_elec == 1 && $offer_type_gas == 0) {
                        $OfferType = 'E';
                        // $CampaignName = $bundle_code_elec;
                        $offer_type_elec = 0;
                        $ls_energy_type = 'elec';
                    } else if ($offer_type_gas == 1 && $offer_type_elec == 0) {
                        $OfferType = 'G';
                        // $CampaignName = $bundle_code_gas;
                        $offer_type_gas = 0;
                        $ls_energy_type = 'gas';
                    }

                    //ContractSignedDate //F
                    $other_created_date = $providerLead->vie_qa_notes_created_date;
                    $ContractSignedDate = $other_created_date ? $other_created_date : '';

                    // changes in SupplyBuildingPropertyName  23-7-20 harvinder
                    $supplyFields = ['SupplyBuildingPropertyName' => 'property_name'];
                    $SupplyBuildingPropertyName = '';
                    $SupplyBuildingPropertyName =  '';
                    $SupplyLotNumber = '';  //J
                    $SupplyFlatUnitType =  '';  //K
                    $SupplyFlatUnitNumber = '';  //L
                    $SupplyFloorLevelType = '';  //M
                    $SupplyFloorLevelNumber = '';  //N
                    $SupplyHouseNumber = '';  //O
                    $SupplyHouseNumberSuffix = '';  //P
                    $SupplyStreet = '';  //Q
                    $SupplyStreetType =  '';   //R 
                    $SupplyStreetSuffix =  '';   //S
                    $SupplySuburbTown =  '';  //T
                    $SupplyPostcode =  '';   //U
                    $SupplyState = '';  //V  //I

                    $sales = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'provider_id' => 1], ['sale_products_energy.sale_status', 'schema_status']);

                    if ($providerLead->journey_is_dual == 0) {
                        foreach ($this->supplyFields as $supplyField => $fieldName) {
                            ${$supplyField} = $providerLead->{'va_' . $fieldName};
                        }
                    } else {
                        if (isset($sales[0]) && isset($sales[1]) && $providerLead->vga_is_same_gas_connection == 1) {
                            if ($sales[0]->sale_status == $sales[1]->sale_status) {
                                if ($sales[0]->schema_status == $sales[1]->schema_status) {
                                    foreach ($this->supplyFields as $supplyField => $fieldName) {
                                        ${$supplyField} = $providerLead->{'va_' . $fieldName};
                                    }
                                } elseif ($sales[0]->schema_status == 1) {
                                    foreach ($this->supplyFields as $supplyField => $fieldName) {
                                        ${$supplyField} = $providerLead->{'vga_' . $fieldName};
                                    }
                                }
                            } elseif ($sales[0]->sale_status != $sales[1]->sale_status && $providerLead->sale_product_product_type == 2) {
                                foreach ($this->supplyFields as $supplyField => $fieldName) {
                                    ${$supplyField} = $providerLead->{'vga_' . $fieldName};
                                }
                            } else {
                                foreach ($this->supplyFields as $supplyField => $fieldName) {
                                    ${$supplyField} = $providerLead->{'va_' . $fieldName};
                                }
                            }
                        } else {
                            foreach ($this->supplyFields as $supplyField => $fieldName) {
                                ${$supplyField} = $providerLead->{'va_' . $fieldName};
                            }
                        }
                    }

                    $LifeSupport = 'N'; //AA
                    if ($providerLead->journey_life_support == 1 && $providerLead->journey_life_support_energy_type == 1) {
                        if ($providerLead->journey_is_dual == 0) {
                            $LifeSupport = 'E';
                            if ($providerLead->sale_product_product_type == 2) {
                                $LifeSupport = 'G';
                            }
                        } else {
                            if ($ls_energy_type_inc > 1) {
                                if ($ls_energy_type == 'both') {
                                    $LifeSupport = 'DF'; //AA
                                } else if ($ls_energy_type == 'elec') {
                                    $LifeSupport = 'E'; //AA
                                } else if ($ls_energy_type == 'gas') {
                                    $LifeSupport = 'G'; //AA
                                }
                            } else {
                                $LifeSupport = 'E'; //AA
                                if ($providerLead->sale_product_product_type == 2) {
                                    $LifeSupport = 'G'; //AA
                                }
                            }
                            $ls_energy_type_inc++;
                        }
                    }


                    //Customer Basic Information
                    $Title = $Title = strtoupper($providerLead->vis_title);;  //AB
                    if ($providerLead->vis_title && $providerLead->vis_title == 'Miss') {
                        $Title = 'MI';
                    } else if ($providerLead->vis_title == 'Sir') {
                        $Title = 'SR';
                    }

                    $FirstName = decryptGdprData($providerLead->vis_first_name) ?? '';  //AC

                    $LastName = decryptGdprData($providerLead->vis_last_name) ?? ''; //AD

                    $DateofBirth = $providerLead->vis_dob ? Carbon::parse($providerLead->vis_dob)->format('d/m/Y') : '';  //AE

                    $PhoneMobile = decryptGdprData($providerLead->vis_visitor_phone) ?? '';  //AH

                    $EmailAddress = decryptGdprData($providerLead->vis_email) ?? '';  //AI


                    if ($energy_type == 1) {
                        $CustomerNumber = $providerLead->vie_elec_account_number ?? ''; //AK	
                    }
                    if ($energy_type == 2) {
                        $CustomerNumber = $providerLead->vie_gas_account_number ?? ''; //AK	
                    }


                    $PinNumber = $providerLead->vie_pin_number ?? '';  //AL

                    //Business Information
                    $CompanyPositionHeld = '';  //AJ	
                    $CompanyName = '';  //AT
                    $TradingName = '';  //AU
                    $AustralianBusinessNumber = ''; //AV
                    $AustralianCompanyNumber = ''; //AW	
                    $BusinessType = '';

                    $business_company_type = $providerLead->vbd_business_company_type ?? '';

                    $legel_name = $providerLead->vbd_business_legal_name ?? '';
                    if (isset($providerLead->journey_property_type) && $providerLead->journey_property_type == 2) {
                        $CompanyPositionHeld = $providerLead->vbd_business_designation ?? '';
                        $CompanyName = $legel_name;
                        $TradingName = $legel_name;
                        $AustralianBusinessNumber = (strlen($providerLead->vbd_business_abn) > 9) ? $providerLead->vbd_business_abn : '';

                        $AustralianCompanyNumber = (strlen($providerLead->vbd_business_abn) <= 9) ? $providerLead->vbd_business_abn : '';

                        switch ($business_company_type) {
                            case 'Limited Company':
                                $BusinessType = 'C';
                                break;
                            case 'Partnership':
                                $BusinessType = 'P';
                                break;
                            case 'Sole Trader':
                                $BusinessType = 'ST';
                                break;
                            case 'Trust':
                                $BusinessType = 'T';
                                break;
                            default:
                                $BusinessType = 'OT';
                                break;
                        }
                    }

                    //Identity Information
                    $DriversLicense = ''; //AN
                    $Passport = ''; //AO
                    $Medicare = ''; //AP

                    if ($providerLead->vie_identity_type == 'Drivers Licence') {
                        $DriversLicense = $providerLead->vie_licence_number;
                    }
                    if ($providerLead->vie_identity_type == 'Passport' || $providerLead->vie_identity_type == 'Foreign Passport') {
                        $Passport = $providerLead->vie_passport_number;
                    }
                    if ($providerLead->vie_identity_type == 'Medicare Card') {
                        $Medicare  = $providerLead->vie_medicare_reference_number;
                    }

                    $WelcomePackDeliveryMethod = 'POST';  //AZ
                    $AccountMedia = 'P'; //BB
                    $BillMedia = 'P'; //BC
                    $PostalDeliveryType = ''; // CQ
                    $PostalDeliveryNumber = ''; //CR

                    if ($providerLead->l_billing_preference == 1) {
                        $BillMedia = 'EP';
                        $AccountMedia = 'P';
                        if ($providerLead->l_email_welcome_pack != 1) {
                            $AccountMedia = 'EP';
                            $WelcomePackDeliveryMethod = 'EMAIL';  //AZ
                        } else {
                            $WelcomePackDeliveryMethod = 'POST';
                        }
                    }
                    //Concessions details
                    $concession_type = $providerLead->vcd_concession_type ?? '';


                    if ($providerLead->journey_property_type == 2 || $concession_type == "Not Applicable") {
                        $PensionType = ''; //BM
                        $PensionNumber = ''; //BN
                        $PensionStartDate = ''; //BO
                        $PensionCardFirstName = ''; //BP
                        $PensionCardSurname = ''; //BQ
                    } else {
                        switch ($concession_type) {
                            case 'Commonwealth Senior Health Card':
                                $PensionType = 'HEALTHCARE';
                                break;
                            case 'DVA Gold Card(Extreme Disablement Adjustment)':
                                $PensionType = 'DVAGOLD';
                                break;
                            case 'DVA Gold Card(TPI)':
                                $PensionType = 'DVAGOLD';
                                break;
                            case 'DVA Gold Card(War Widow)':
                                $PensionType = 'DVAGOLD';
                                break;
                            case 'DVA Gold Card':
                                $PensionType = 'DVAGOLD';
                                break;
                            case 'DVA Pension Concession Card':
                                $PensionType = 'DVAGOLD';
                                break;
                            case 'Centrelink Healthcare Card':
                                $PensionType = 'HEALTHCARE';
                                break;
                            case 'Pensioner Concession Card':
                                $PensionType = 'PENCONC';
                                break;
                            case 'Queensland Government Seniors Card':
                                $PensionType = 'QLDGOVSENIORS';
                                break;
                            case 'Australian Government ImmiCard (Asylum Seeker)':
                                $PensionType = '';
                                break;
                            default:
                                $PensionType = '';
                                break;
                        }
                        $PensionNumber = $providerLead->vcd_card_number ?? '';
                        $PensionStartDate = $providerLead->vcd_card_start_date ?? '';
                        $PensionCardFirstName = $FirstName;
                        $PensionCardSurname = $LastName;
                    }

                    if ($providerLead->vie_simply_reward_id) {
                        $SurnameOnRewardCard = $FirstName;
                        $NameInitialOnRewardCard = $providerLead->vis_title ?? '';
                        $NameInitialOnRewardCard  = $NameInitialOnRewardCard . " " . $LastName;
                    }
                    $RewardPlanMembershipId = $providerLead->vie_simply_reward_id ?? '';
                    //Joint account details
                    $Customer2Title = ''; //CY
                    $Customer2FirstName = ''; //CZ
                    $Customer2LastName = ''; //DA
                    $Customer2DateOfBirth = ''; //DB
                    $Customer2PhoneMobile = ''; //DE
                    $Customer2EmailAddress = ''; //DF
                    $Customer2Title = strtoupper($providerLead->vie_joint_acc_holder_title);  //CY
                    if ($providerLead->vie_is_connection_joint_account_holder == 1) {

                        if ($providerLead->vie_joint_acc_holder_title == 'Miss') {
                            $Customer2Title = 'MI';
                        } else if ($providerLead->vie_joint_acc_holder_title == 'Sir') {
                            $Customer2Title = 'SR';
                        }

                        $Customer2FirstName = $providerLead->vie_joint_acc_holder_first_name ?? '';  //CZ
                        $Customer2LastName = $providerLead->vie_joint_acc_holder_last_name ?? '';  //DA
                        $Customer2DateOfBirth = $providerLead->vie_joint_acc_holder_dob ? Carbon::parse($providerLead->vie_joint_acc_holder_dob)->format('d/m/Y') : '';  //DB
                        $Customer2PhoneMobile = $providerLead->vie_joint_acc_holder_email ? $providerLead->vie_joint_acc_holder_email : ''; //DE
                        $Customer2EmailAddress = $providerLead->vie_joint_acc_holder_phone_no ?? ''; //DF
                    }

                    //BU to CP postal and Residential address

                    $po_box_address_checked = $providerLead->is_po_box ?? '';
                    foreach ($this->residentialFields as $residentialField => $fieldName) {
                        ${$residentialField} = '';
                    }
                    if (!empty($po_box_address_checked) && $po_box_address_checked == 1) {
                        $needToFill = ['address', 'suburb', 'postcode', 'state'];
                        foreach ($this->postalFields as $postalField => $fieldName) {
                            if (in_array($fieldName, $needToFill)) {
                                ${$postalField} = $providerLead->{'vpa_' . $fieldName};
                            } else {
                                ${$postalField} = '';
                            }
                        }
                    } else {
                        if ($providerLead->l_billing_preference == 1) {
                            foreach ($this->postalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'vba_' . $fieldName};
                            }
                        } else if ($providerLead->l_billing_preference == 2) {
                            foreach ($this->postalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'va_' . $fieldName};
                            }
                        } else {
                            if ($providerLead->l_email_welcome_pack == 1) {
                                foreach ($this->postalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                }
                            } else {
                                foreach ($this->postalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'va_' . $fieldName};
                                }
                            }
                        }
                    }
                    if ($po_box_address_checked == 1) {
                        $PostalHouseNumber = $providerLead->va_address;
                    } else if ($providerLead->l_billing_preference == 1) {
                        $PostalHouseNumber = $providerLead->va_street_number;
                    } else {
                        if ($providerLead->l_billing_preference == 1) {
                            $PostalHouseNumber = $providerLead->vba_street_number;
                        } else {
                            $PostalHouseNumber = $providerLead->va_street_number;
                        }
                    }

                    $ServiceOrderSubType = ''; //DT		
                    $ServiceTime = '';  //DU				
                    $CustomerPreferredTime = ''; //DW	
                    if ($movin_house == 1) {
                        if (!empty($providerLead->sale_product_product_type) && $providerLead->sale_product_product_type == 1) {
                            $CustomerPreferredTime = '10:00';
                            $ServiceTime = 'ANYTIME';  //DU
                            if ($providerLead->va_state == 'VIC') {
                                $ServiceOrderSubType = 'REMOTE';
                            } else {
                                $ServiceOrderSubType = 'NEWRDREQ';
                            }
                        }
                    }
                    //SupplyBuildingPropertyNameGas
                    foreach ($this->supplyFields as $supplyField => $fieldName) {
                        ${$supplyField . 'Gas'} = $providerLead->{'va_' . $fieldName};
                    }

                    //set data for gas supply address  add by harvinder :- 22/98/20
                    if ($providerLead->journey_is_dual != 1 && $providerLead->sale_product_product_type == 2) {
                        foreach ($this->supplyFields as $supplyField => $fieldName) {
                            ${$supplyField . 'Gas'} = $providerLead->{'va_' . $fieldName};
                        }
                    } else {
                        if (isset($sales[0]) && isset($sales[1]) && $providerLead->vga_is_same_gas_connection == 1) {

                            if ($sales[0]->sale_status == $sales[1]->sale_status) {

                                if ($sales[0]->schema_status == $sales[1]->schema_status) {
                                    foreach ($this->supplyFields as $supplyField => $fieldName) {
                                        ${$supplyField . 'Gas'} = $providerLead->{'vga_' . $fieldName};
                                    }
                                } elseif ($sales[0]->schema_status == 1) {
                                    foreach ($this->supplyFields as $supplyField => $fieldName) {
                                        ${$supplyField . 'Gas'} = $providerLead->{'vga_' . $fieldName};
                                    }
                                }
                            } elseif ($sales[0]->sale_status != $sales[1]->sale_status && $providerLead->sale_product_product_type == 2) {
                                foreach ($this->supplyFields as $supplyField => $fieldName) {
                                    ${$supplyField . 'Gas'} = $providerLead->{'vga_' . $fieldName};
                                }
                            }
                        } else {
                            if ($providerLead->sale_product_product_type == 2) {
                                foreach ($this->supplyFields as $supplyField => $fieldName) {
                                    ${$supplyField . 'Gas'} = $providerLead->{'va_' . $fieldName};
                                }
                            }
                        }
                    }
                    // set all selected data to respective column.
                    $providerData[$providerLead->spe_sale_status][] = array(
                        $SalesAgent,  //A
                        $TrackingNumber,  //B
                        $OfferType,  //C
                        $FeedInType,  //D
                        $CampaignName,  //E
                        $ContractSignedDate,  //F
                        $ElectricityProductCode,  //G
                        $GasProductCode,  //H
                        $SupplyBuildingPropertyName, //I 
                        $SupplyLotNumber, //J
                        $SupplyFlatUnitType, //K
                        $SupplyFlatUnitNumber, //L
                        $SupplyFloorLevelType, //M
                        $SupplyFloorLevelNumber, //N
                        $SupplyHouseNumber, //O
                        $SupplyHouseNumberSuffix, //P
                        $SupplyStreet, //Q
                        $SupplyStreetType, //R 
                        $SupplyStreetSuffix, //S
                        $SupplySuburbTown, //T
                        $SupplyPostcode, //U
                        $SupplyState, //V
                        $NMI,  //W							
                        $MIRN,  //X
                        '',  //Y
                        'Y',  //Z
                        $LifeSupport,  //AA 
                        $Title, //AB
                        $FirstName, //AC
                        $LastName,  //AD
                        $DateofBirth, //AE
                        '',  //AF
                        '',  //AG
                        $PhoneMobile, //AH
                        $EmailAddress, //AI
                        $CompanyPositionHeld, //AJ							
                        $CustomerNumber,  //AK
                        $PinNumber,  //AL
                        $EstimatedAnnualUsage,  //AM
                        $DriversLicense, //AN
                        $Passport, //AO
                        $Medicare, //AP
                        'N',  //AQ
                        'N',  //AR
                        'CN',  //AS
                        $CompanyName,  //AT
                        $TradingName,  //AU
                        $AustralianBusinessNumber, //AV
                        $AustralianCompanyNumber,  //AW	
                        $BusinessType,  //AX
                        'N',  //AY
                        $WelcomePackDeliveryMethod, //AZ
                        'DNC',   //BA
                        $AccountMedia, //BB
                        $BillMedia, //BC
                        'MP',  //BD
                        '',  //BE
                        '',  //BF
                        '',  //BG
                        '',  //BH
                        '',  //BI
                        '',  //BJ
                        '',  //BK
                        '',  //BL
                        $PensionType, //BM
                        $PensionNumber, //BN
                        $PensionStartDate, //BO
                        $PensionCardFirstName, //BP
                        '',
                        $PensionCardSurname, //BQ
                        $RewardPlanMembershipId,  //BR
                        $SurnameOnRewardCard,  //BS
                        $NameInitialOnRewardCard,  //BT
                        $ResidentialBuildingPropertyName, //BU 
                        $ResidentialLotNumber, //BV
                        $ResidentialFlatUnitType, //BW
                        $ResidentialFlatUnitNumber, //BX
                        $ResidentialFloorLevelType, //BY
                        $ResidentialFloorLevelNumber, //BZ
                        $ResidentialHouseNumber, //CA
                        $ResidentialHouseNumberSuffix, //CB
                        $ResidentialStreet, //CC
                        $ResidentialStreetType, //CD
                        $ResidentialStreetSuffix, //CE
                        $ResidentialSuburbTown, //CF
                        $ResidentialPostcode, //CG
                        $ResidentialState, //CH
                        $PostalBuildingPropertyName, //CI
                        $PostalLotNumber, //CJ
                        $PostalFlatUnitType, //CK
                        $PostalFlatUnitNumber, //CL
                        $PostalFloorLevelType, //CM
                        $PostalFloorLevelNumber, //CN
                        $PostalHouseNumber, //CO
                        $PostalHouseNumberSuffix, //CP
                        $PostalDeliveryType, //CQ
                        $PostalDeliveryNumber, //CR	
                        $PostalStreet, //CS
                        $PostalStreetType, //CT
                        $PostalStreetSuffix, //CU
                        $PostalSuburbTown, //CV
                        $PostalPostcode, //CW
                        $PostalState, //CX
                        $Customer2Title, //CY
                        $Customer2FirstName, //CZ
                        $Customer2LastName, //DA
                        $Customer2DateOfBirth, //DB
                        '',  //DC
                        '',  //DD
                        $Customer2PhoneMobile, //DE
                        $Customer2EmailAddress, //DF
                        '',  //DG
                        '',  //DH
                        '',  //DI
                        '',  //DJ
                        '',  //DK
                        '',  //DDL
                        '',  //DM
                        '',  //DN
                        '',  //DO
                        '',  //DP
                        '',  //DQ
                        '',  //DR
                        $EnergisationDate,  //DS
                        $ServiceOrderSubType, //DT							
                        $ServiceTime,  //DU
                        $CustomerPreferredDate,  //DV
                        $CustomerPreferredTime, //DW
                        $ElectricityAdminFeeWaived, //DX
                        $ElectricityAdminFeeWaiverReason, //DY
                        $ElecSOFeeWaive, //DZ
                        '',  //EA
                        $ElectricitySpecialInstructions,  //EB
                        $ElectricityAccessDetails,  //EC
                        $GasAdminFeeWaived, //ED
                        $GasAdminFeeWaiverReason, //EE
                        $GasSOFeeWaive, //EF
                        '',  //EG							
                        $GasSpecialInstructions, //EH
                        $GasAccessDetails, //EI
                        '',  //EJ
                        '',  //EK
                        'Y',   //EL
                        $SupplyBuildingPropertyNameGas,  //I
                        $SupplyLotNumberGas,
                        $SupplyFlatUnitTypeGas,
                        $SupplyFlatUnitNumberGas,
                        $SupplyFloorLevelTypeGas,
                        $SupplyFloorLevelNumberGas,
                        $SupplyHouseNumberGas,
                        $SupplyHouseNumberSuffixGas,
                        $SupplyStreetGas,
                        $SupplyStreetTypeGas,
                        $SupplyStreetSuffixGas,
                        $SupplySuburbTownGas,
                        $SupplyPostcodeGas,
                        $SupplyStateGas,
                        'TELSL'
                    );
                } else {
                    // for Electricity Move in sale only : added by Maninderjeet Singh
                    if ($movin_house == 1) {
                        if (!empty($providerLead->sale_product_product_type) && $providerLead->sale_product_product_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][126] = $providerLead->journey_moving_date; //dw
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][127] = '10:00'; //dx 		
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][125] = 'ANYTIME';  //DV
                            if ($providerLead->va_state == ' VIC') {
                                $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][124] = 'REMOTE'; //DU
                            } else {
                                $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][124] = 'NEWRDREQ'; //DU
                            }
                        }
                    }


                    //Offer Type 	
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][2]) && !empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][2])) {
                        //for electricity case				
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][2] = 'DF';  //G								
                    } else {
                        //for gas case	
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][2] = '';
                    }
                    //added //amandeep17june2020
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][26]) && !empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][26])) {
                        //for electricity case	//added //amandeep17june2020
                        if ($providerLead->journey_life_support == 1 && $providerLead->journey_life_support_energy_type == 1) {
                            if ($ls_energy_type_inc > 1) {
                                $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][26] = 'DF'; //AA									
                            } else {
                                $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][26] = 'E'; //AA
                                if ($providerLead->sale_product_product_type == 'gas') {
                                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][26] = 'G'; //AA
                                }
                            }
                        }
                    }

                    //Campaign name
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][4] = $bundleCode;

                    //Electricity Product and Gas Product code
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][6]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][6])) {
                        //electricity 
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][6] = $providerLead->vie_electricity_code ?? '';  //G
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][7])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][7] = $providerLead->vie_gas_code ?? '';  //H
                        }
                    }

                    //nmi and nirm
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][22]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][22])) {
                        //electricity
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][22] = $providerLead->vie_nmi_number;
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][23])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][23] = $providerLead->vie_dpi_mirn_number;
                        }
                    }

                    //AdminFeeWaived
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][128]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][128])) {
                        //electricity
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][128] = 'Y'; //DX
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][134])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][134] = 'Y'; //ED
                        }
                    }

                    //AdminFeeWaiverReason
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][129]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][129])) {
                        //electricity
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][129] = 'SALI'; //DY
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][135])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][135] = 'SALI'; //EE
                        }
                    }

                    // FeeWaive

                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][130]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][130])) {
                        //electricity
                        if ($movin_house == 1) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][130] = 'N'; //DZ
                        }
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][136])) {
                            if ($movin_house == 1) {
                                $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][136] = 'N'; //EF
                            }
                        }
                    }

                    //SpecialInstructions
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][132]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][132])) {
                        //electricity
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][132] = $providerLead->l_note ?? ''; //EC
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][138])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][138] = $providerLead->l_note ?? ''; //EI
                        }
                    }
                    //Site access details
                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][133]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][133])) {
                        //electricity
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][133] = $providerLead->vie_site_access_electricity ?? ''; //EC
                    } else {
                        //gas
                        if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][139])) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][139] = $providerLead->vie_site_access_gas ?? ''; //EI
                        }
                    }
                }


                if (isset($providerData[$providerLead->spe_sale_status]) && isset($reference_key_array[$refNo])) {
                    /** CAF changes added on 30 sept 2021 **/
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][158] = 'PROS';
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][159] = 'E';
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][160] = '';
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][161] = '';
                    /** End **/

                    /** CAF changes added on 30 march 2022 **/
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][162] = '';
                    $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][163] = '';
                    /** End **/
                }
            }


            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }

            $data['subject'] = 'Simply_Energy_' . Carbon::now()->format('m-d-Y') . '_' . Carbon::now()->format('H:m');

            $batchDetails = Providers::where('id', env('simply_energy'))->select('batch_number', 'batch_created_date')->first();
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
                $fileName = 'Simply_Energy_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                Providers::where('id', env('simply_energy'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'Simply_Energy_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'Simply_Energy_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
