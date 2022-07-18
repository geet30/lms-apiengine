<?php

namespace App\Traits\Provider\Tango;

use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Provider\Tango\Headings;
use Illuminate\Support\Facades\{Storage};
use App\Models\{Lead, Providers};
use Carbon\Carbon;
trait Schema
{
    function tangoSchema($providerLeads, $data)
    {
  
        try{
            $data['providerName'] = 'TANGO RETAILER';
            $data['mailType'] = 'test';
            $data['referenceNo'] = $refNo = $providerLeads[0]->sale_product_reference_no;
            $data['requestType'] = 'Fulfilment';
          
            $SaleRef = "CIMET" . $providerLeads[0]->sale_product_reference_no;
            $providerData = $processedRefNum = $leadIds = $reference_key_array =  [];
 
            $submitDataInc = $resubmitDataInc = $sendSchema = 0;
            $LeadID =  $Incentive = $DateofSale = $PromoCode = $CurrentElecRetailer =  $CurrentGasRetailer =   $ExistingCustomer =  $CustomerAccountNumber = $CustomerType =  $AccountName = $ABN = $ACN =$BusinessName =  $BusinessType =  $TrusteeName =$TradingName = $Position =$SaleType = $CustomerTitle =  $FirstName = $LastName = $PhoneLandline = $PhoneMobile = $AuthenticationDateOfBirth = $AuthenticationExpiry = $AuthenticationNo = $AuthenticationType =  $Email = $ConcessionerNumber = $ConcessionExpiryDate = $ConcessionFlag = $ConcessionStartDate =  $ConcFirstName =  $ConcLastName = $SecondaryCustomerTitle  = $SecondaryFirstName =$SecondaryLastName =$SecondaryAuthenticationDateOfBirth = $SecondaryEmail =  $SecondaryPhoneHome = $SecondaryPhoneMobile = $SecondaryAuthenticationExpiry = $SecondaryAuthenticationNo =  $SecondaryAuthenticationType = $SiteApartmentNumber =  $SiteApartmentType = $SiteBuildingName =$SiteFloorNumber = $SiteFloorType = $SiteLocationDescription =  $mail_type = $SiteLotNumber = $SiteStreetName = $SiteStreetNumber =  $SiteStreetNumberSuffix = $SiteStreetType =$SiteStreetSuffix =  $SiteSuburb = $SiteState =  $SitePostCode = $GasSiteApartmentNumber =  $GasSiteApartmentType = $GasSiteBuildingName = $GasSiteFloorNumber = $GasSiteFloorType =	 $GasSiteLocationDescription = $GasSiteLotNumber = $GasSiteStreetName =$GasSiteStreetNumber =  $GasSiteStreetNumberSuffix = $GasSiteStreetType = $GasSiteStreetSuffix =$GasSiteSuburb =  $GasSiteState = $GasSitePostCode =  $NMI = $MIRN =  $Fuel = $FeedIn = $AnnualUsage = $GasAnnualUsage =  $ProductCode = $GasProductCode = $OfferDescription =  $GasOfferDescription = $GreenPercent =  $ProposedTransferDate = $GasProposedTransferDate = $BillCycleCode = $GasBillCycleCode = $Averagemonthlyspend = $IsOwner = $BillingEmail = $PostalApartmentNumber = $PostalApartmentType = $PostalFloorNumber = $PostalFloorType =$PostalLotNo =  $PostalBuildingName =  $PostalStreetNumber =  $PostalStreetNumberSuffix =  $PostalStreetName = $PostalStreetType = $PostPropertyName =  $PostalStreetSuffix = $PostalSuburb =  $PostalPostCode =$PostalState = $Comments =$TransferSpecialInstructions = $BenefitEndDate  = $SalesClass =  $bill_group_code =  $GasMeterNumber =  $ConcessionType = '';  
        
            foreach($providerLeads as $providerLead){
                $energy_type = $providerLead->sale_product_product_type;
                array_push($leadIds, $providerLead->l_lead_id);
                if (!in_array($providerLead->spe_sale_status. '_' . $refNo, $processedRefNum)) {

                    if ($providerLead->sale_product_reference_no) {
                        $processedRefNum[] = $providerLead->spe_sale_status . '_' . $refNo;
                        if ($providerLead->spe_sale_status == 4) {
                            $reference_key_array[$refNo] = $submitDataInc;
                            $submitDataInc++;
                        }
                        if ($providerLead->spe_sale_status == 12) {
                            $reference_key_array[$refNo] = $resubmitDataInc;
                            $resubmitDataInc++;
                        }
                    }

                    $DateofSale =$providerLead->vie_qa_notes_created_date ? $providerLead->vie_qa_notes_created_date : '';
                    $multiSite =  $ExistingCustomer = "N";
                    if ($providerLead->vga_id  && $providerLead->journey_is_dual == 1) {
                        $multiSite = "Y";
                    } 
                        

                    if ($providerLead->journey_previous_provider_id == $this->tangoEnergyId) {
                        $ExistingCustomer = "Y";
                        if ($energy_type == 1 && $providerLead->vie_elec_account_number) {
                            $CustomerAccountNumber = $providerLead->vie_elec_account_number;
                        }
                    }else{
                        $CustomerAccountNumber = $providerLead->vie_gas_account_number ? $providerLead->vie_gas_account_number : '';
                        
                    }
                
                    if ($providerLead->journey_property_type == 1) {
                        $CustomerType = 'RESIDENT';
                    } 
                    elseif($providerLead->journey_property_type == 2) {
                        $CustomerType = 'COMPANY';
                        if ($providerLead->vbd_business_legal_name) {

                            $AccountName =$BusinessName = $providerLead->vbd_business_legal_name;
                            if ($providerLead->vbd_business_abn) {
                                if (strlen($providerLead->vbd_business_abn) == 11) 
                                    $ABN = $providerLead->vbd_business_abn;
                                
            
                                if (strlen($providerLead->vbd_business_abn) == 9) 
                                    $ACN = $providerLead->vbd_business_abn;
                                
                            }
                            if ($providerLead->vbd_business_company_type) 
                                $BusinessType = $providerLead->vbd_business_company_type;
                            
                            if ($providerLead->vbd_business_industry_type) 
                                $TradingName = $providerLead->vbd_business_industry_type;
                            
                            if($providerLead->vbd_business_designation)
                                $Position = $providerLead->vbd_business_designation;
                            
                        }
                    }

                    $MovingHouse = ($providerLead->journey_moving_house == 0) ? "N" : "Y";
                    if ($MovingHouse != "N") {
                        $SaleType = "MOVEIN";
                    } else {
                        $SaleType = "TRANSFER";
                    }

                    $CustomerTitle = decryptGdprData($providerLead->vis_title) ?? '';
                    $FirstName = decryptGdprData($providerLead->vis_first_name) ?? '';
                    $LastName = decryptGdprData($providerLead->vis_last_name) ?? '';
                    $PhoneMobile =  decryptGdprData($providerLead->vis_alternate_phone) ?? '';
                    if ($providerLead->vis_dob) {
                        $AuthenticationDateOfBirth = Carbon::parse($providerLead->vis_dob)->format('d/m/Y');
                    }
                        
                    if ($providerLead->vie_passport_card_expiry_date) {
                        $AuthenticationExpiry = Carbon::parse($providerLead->vie_passport_card_expiry_date)->format('d/m/Y');
                        $AuthenticationNo = $providerLead->vi_passport_number;
                        $AuthenticationType = 'Passport';
                    
                    }elseif($providerLead->vi_medicare_card_expiry_date) {
                        $AuthenticationExpiry = Carbon::parse($providerLead->vi_medicare_card_expiry_date)->format('d/m/Y');
                        $AuthenticationNo = $providerLead->vi_medicare_number;
                        $AuthenticationType = 'MedicareCard';
                    } else {
                        $AuthenticationExpiry = Carbon::parse($providerLead->vie_licence_card_expiry_date)->format('d/m/Y');
                        $AuthenticationNo = $providerLead->vie_licence_number;
                        $AuthenticationType = 'DriversLicence';
                    }

                    $Email = decryptGdprData($providerLead->vis_email) ?? '';
                    $LifeSupport = $ConcessionFlag = "N";
                    if ($providerLead->journey_life_support && $providerLead->journey_life_support == 1) {
                        $LifeSupport = "Y";
                    }
                    if ($providerLead->vcd_card_number) {

                        $ConcessionerNumber = $providerLead->vcd_card_number;

                        if ($providerLead->journey_property_type != 2 && $providerLead->vcd_card_expiry_date) {

                            $ConcessionExpiryDate = $providerLead->vcd_card_expiry_date;
                        } 
                        
                        if ($providerLead->journey_property_type != 2 || $providerLead->vcd_concession_type != 'Not Applicable') {

                            $ConcessionFlag = "Y";
                            $ConcFirstName 	=  decryptGdprData($providerLead->vis_first_name);
                            $ConcLastName 	= decryptGdprData($providerLead->vis_last_name);
                        }

                        $ConcessionStartDate = $providerLead->vcd_card_start_date ?? '';
                        $ConcessionType = 'DVAGC';
                        if (in_array($providerLead->vcd_concession_type, $this->hcc)) {
                            $ConcessionType = 'HCC';
                        }else if (in_array($providerLead->vcd_concession_type, $this->pcc)) {
                            $ConcessionType = 'PCC';
                        }else if (in_array($providerLead->vcd_concession_type, $this->DVAGC_TPI)) {
                            $ConcessionType = 'DVAGC';
                        }else if (in_array($providerLead->vcd_concession_type, $this->DVAPCC)) {
                            $ConcessionType = 'DVAPCC';
                        }


                    }
                    $sales = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'provider_id' => 124], ['sale_products_energy.sale_status', 'schema_status']);
                
                    

                    if ($providerLead->journey_is_dual == 0) {
                        if ($energy_type == 1) {
                            foreach ($this->electricityAddressFields as $addressField => $fieldName) {
                                ${$addressField} = $providerLead->{'va_' . $fieldName};
                            }
                        }else{
                            foreach ($this->gasAddressFields as $gasAddressField => $fieldName) {
                                ${$gasAddressField} = $providerLead->{'va_' . $fieldName};
                            }
                        }
                    } else {
                        if (isset($sales[0]) && isset($sales[1]) && $providerLead->vga_is_same_gas_connection == 1) {
                            if ($sales[0]->sale_status == $sales[1]->sale_status) {
                                if ($sales[0]->schema_status == $sales[1]->schema_status) {
                                    foreach ($this->electricityAddressFields as $addressField => $fieldName) {
                                        ${$addressField} = $providerLead->{'va_' . $fieldName};
                                    }
                                    foreach ($this->gasAddressFields as $gasAddressField => $fieldName) {
                                        ${$gasAddressField} = $providerLead->{'va_' . $fieldName};
                                    }
                                } elseif ($sales[0]->schema_status == 1) {
                                    foreach ($this->electricityAddressFields as $addressField => $fieldName) {
                                        ${$addressField} = $providerLead->{'va_' . $fieldName};
                                    }
                                }
                            } elseif ($sales[0]->sale_status != $sales[1]->sale_status && $energy_type == 2) {
                                foreach ($this->gasAddressFields as $gasAddressField => $fieldName) {
                                    ${$gasAddressField} = $providerLead->{'vga_' . $fieldName};
                                }
                            } else {
                                foreach ($this->electricityAddressFields as $addressField => $fieldName) {
                                    ${$addressField} = $providerLead->{'va_' . $fieldName};
                                }
                            }
                        } else {
                            foreach ($this->electricityAddressFields as $addressField => $fieldName) {
                                ${$addressField} = $providerLead->{'va_' . $fieldName};
                            }
                            $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'provider_id' => 124,'lead_journey_data_energy.energy_type'=>2], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            
                            if (!empty($sale_other_record->sale_status)) {
                                if( $sale_other_record->sale_status  == 4 || $sale_other_record->sale_status == 12){
                                    foreach ($this->gasAddressFields as $gasAddressField => $fieldName) {
                                        ${$gasAddressField} = $providerLead->{'vga_' . $fieldName};
                                    }
                                }
                                
                            }
                        }

                    
                    }
                    
                   
                    if ($providerLead->journey_is_dual == 1) {
                    
                        if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                        
                            $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'provider_id' => 124,'lead_journey_data_energy.energy_type'=>2], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            if ($sale_other_record->sale_status == 4 || $sale_other_record->sale_status == 12) {
                                $Fuel = "Dual";
                            } else {
                                $Fuel = "Electricity";
                            }

                            $NMI = $providerLead->vie_nmi_number ?? ''; 
                            $ProductCode = $providerLead->vie_electricity_code ?? '';


                            $OfferDescription = $providerLead->plan_plan_campaign_code ?? '';
                            $BillCycleCode = "MM_MONTHLY";
                            if ($providerLead->journey_moving_house == 0 && $providerLead->journey_previous_provider_id) {
                                $CurrentElecRetailer =  $providerLead->journey_previous_provider_id;
                            }
                            if ($providerLead->journey_moving_date) {
                                $ProposedTransferDate = $providerLead->journey_moving_date;
                            }
                            $Comments = $providerLead->l_note ?? '';
                        }else if($energy_type == 2 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'provider_id' => 124,'lead_journey_data_energy.energy_type'=>1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            if ($sale_other_record->sale_status == 4 || $sale_other_record->sale_status == 12) {
                                $Fuel = "Dual";
                            } else {
                                $Fuel = "Gas";
                            }
                            $MIRN = $providerLead->vie_dpi_mirn_number ?? '';
                            $GasProductCode = $providerLead->vie_gas_code ?? '';
                            $GasOfferDescription = $providerLead->plan_plan_campaign_code ?? '';
                            $GasBillCycleCode = "MM_GAS";
                            $GasMeterNumber =$providerLead->vie_meter_number_g ?? '';
                            if ($providerLead->journey_moving_house == 0 && $providerLead->journey_previous_provider_id) {
                                $CurrentGasRetailer =  $providerLead->journey_previous_provider_id;
                            }
                            if ($providerLead->journey_moving_date) {
                                $GasProposedTransferDate = $providerLead->journey_moving_date;
                            }
                            
                            $Comments = $providerLead->l_note ?? '';
                        }
                    } else {

                        if ($energy_type == 1 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $NMI = $providerLead->vie_nmi_number ?? '';
                            $ProductCode = $providerLead->vie_electricity_code ?? '';

                            $OfferDescription =  $providerLead->plan_plan_campaign_code ?? '';
                            $BillCycleCode = "MM_MONTHLY";
                            if ($providerLead->journey_moving_house == 0 && $providerLead->journey_previous_provider_id) {
                                $CurrentElecRetailer =  $providerLead->journey_previous_provider_id;
                            }
                            if ($providerLead->journey_moving_date) {
                                $ProposedTransferDate = $providerLead->journey_moving_date;
                            }
                            
                            $Comments = $providerLead->l_note ?? '';
                            $Fuel = "Electricity";
                        } 
                        else if ($energy_type == 2 && ($providerLead->spe_sale_status == 4 || $providerLead->spe_sale_status == 12)) {
                            $MIRN =$providerLead->vie_dpi_mirn_number ?? '';
                        
                            $GasProductCode = $providerLead->vie_gas_code ?? '';
                            $GasOfferDescription =  $providerLead->plan_plan_campaign_code ?? '';
                            $GasBillCycleCode = "MM_GAS";
                            $GasMeterNumber =$providerLead->vie_meter_number_g ?? ''; 
                            if ($providerLead->journey_moving_house == 0 && $providerLead->journey_previous_provider_id) {
                                $CurrentGasRetailer =  $providerLead->journey_previous_provider_id;
                            }
                            if ($providerLead->journey_moving_date) {
                                $GasProposedTransferDate = $providerLead->journey_moving_date;
                            }
                            
                            $Comments = $providerLead->l_note ?? '';
                            $Fuel = "Gas";
                        }
                    }
                 
                    if($energy_type == 1 || $providerLead->journey_solar_panel == 1) {
                        if($providerLead->ebd_solar_tariff == "normal") {
                            $FeedIn = "RFIT";
                        }

                        if($providerLead->ebd_solar_tariff == "premium") {
                            $FeedIn = "PFIT";
                        }
                        if($providerLead->journey_bill_available == 0) {
                            $FeedIn = "RFIT";
                        }
                    }
                       

                    $IsOwner = "Owner";
                    if ($providerLead->vga_is_same_gas_connection != 0 && $energy_type  == 2) {
                        if ($providerLead->vga_property_ownership == "Rent") {

                            $IsOwner = "Renter";
                        }
                    }else {
                       
                        if ($providerLead->va_property_ownership == "Rent") {

                            $IsOwner = "Renter";
                        } 
                    }

                    $HasAcceptedMarketing = "Y";

                    $EmailAccountNotice =  $EmailInvoice = "POST";

                    if ($providerLead->l_billing_preference == 1) {
                        $EmailInvoice = "EMAIL";
                        if ($providerLead->l_email_welcome_pack == 0) {
                            $EmailAccountNotice = "EMAIL";
                            $BillingEmail =  decryptGdprData($providerLead->vis_email);
                        }
                    }
                
                    if ($energy_type == 2) {
                        if ($providerLead->is_po_box == 1) {
                            foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'vpa_' . $fieldName};
                            }
                        }
                        else {
                            if ($providerLead->l_billing_preference == 3) {
                                foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                }
                            
                            }
                
                            else if ($providerLead->l_billing_preference == 2) {//2
                                if($providerLead->va_is_same_gas_connection  == 1){
                                    foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                        ${$postalField} = $providerLead->{'vga_' . $fieldName};
                                    }
                                } else {
                                    foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                        ${$postalField} = $providerLead->{'va_' . $fieldName};
                                    }
                                }
                            }
                            else if ($providerLead->l_billing_preference == 1) {
                                if ($providerLead->l_email_welcome_pack == 1) {
                                    foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                        ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                    }
                                } else {
                                    if($providerLead->va_is_same_gas_connection  == 1){
                                        foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                            ${$postalField} = $providerLead->{'vga_' . $fieldName};
                                        }
                                    
                                    } else {
                                        foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                            ${$postalField} = $providerLead->{'va_' . $fieldName};
                                        }
                
                                        
                                    }
                
                                    
                                }
                
                            }
                        }
                    } 
                    else {
                        if ($providerLead->is_po_box == 1) {
                            foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                ${$postalField} = $providerLead->{'vpa_' . $fieldName};
                            }
                        }
                        else {
                
                            if ($providerLead->l_billing_preference ==3) { //3
                                foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                }
                            }
                
                            else if ($providerLead->l_billing_preference == 2) { //2
                                foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                    ${$postalField} = $providerLead->{'va_' . $fieldName};
                                }
                            } 
                            else if ($providerLead->l_billing_preference == 1) {
                                if ($providerLead->l_email_welcome_pack == 1) {
                                    foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                        ${$postalField} = $providerLead->{'vba_' . $fieldName};
                                    }
                                } else {
                                    foreach ($this->tangopostalFields as $postalField => $fieldName) {
                                        ${$postalField} = $providerLead->{'va_' . $fieldName};
                                    }
                                    
                                }
                
                            }
                        }
                        
                    
                        
                    }

                        //check the provider dynamically
                    $current_provider = $providerLead->journey_current_provider_id;
                    $sale_previous_provider = $providerLead->journey_previous_provider_id;

                    if ($MovingHouse == 'N') {
                        if ($providerLead->journey_is_dual == 1) {
                            if ($providerLead->spe_sale_status == 4 && $energy_type== 1) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>2,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1,'sale_products_energy.sale_status',4], ['sale_products_energy.sale_status', 'schema_status'])->first();

                                if (!empty($sale_other_record)) {

                                    if (($sale_other_record->previous_provider == $current_provider) && ($sale_previous_provider == $current_provider)) {
                                        $SalesClass = "RDF";
                                    } else {
                                        $SalesClass = "ADF";
                                        if (($current_provider == $sale_previous_provider) || ($current_provider == $sale_other_record->previous_provider)) {
                                            $SalesClass = "RDF";
                                        }
                                    }
                                } else {
                                    $SalesClass = "AEO";
                                    if ($current_provider ==$sale_previous_provider) {

                                        $SalesClass = "REO";
                                    }
                                }
                            }


                            if ($providerLead->spe_sale_status == 12 && $energy_type == 1) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>2,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();
                                if (!empty($sale_other_record)) {


                                    if (($sale_other_record->previous_provider == $current_provider) && ($sale_previous_provider == $current_provider)) {

                                        $SalesClass = "RDF";
                                    } else {
                                        $SalesClass = "ADF";
                                        if (($current_provider == $sale_previous_provider) || ($current_provider == $sale_other_record->previous_provider)) {

                                            $SalesClass = "RDF";
                                        }
                                    }
                                } else {
                                    $SalesClass = "AEO";
                                    if ($current_provider == $sale_previous_provider) {

                                        $SalesClass = "REO";
                                    }
                                }
                            }

                            if ($providerLead->spe_sale_status == 4 && $energy_type == 2) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>1,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                                if (!empty($sale_other_record)) {

                                    if (($sale_other_record->previous_provider == $current_provider) && ($sale_previous_provider == $current_provider)) {
                                        $SalesClass = "RDF";
                                    } else {
                                        if (($current_provider == $sale_previous_provider) || ($current_provider == $sale_other_record->previous_provider)) {
                                            $SalesClass = "RDF";
                                        } else {
                                            $SalesClass = "ADF";
                                        }
                                    }
                                } else {
                                    if ($current_provider == $sale_previous_provider) {
                                        $SalesClass = "RGO";
                                    } else {
                                        $SalesClass = "AGO";
                                    }
                                }
                            }

                            //resubmitted cases
                            if ($providerLead->spe_sale_status == 12 && $energy_type == 2) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>1,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            

                                if (!empty($sale_other_record)) {

                                    if (($current_provider == $sale_previous_provider) || ($current_provider == $sale_other_record->previous_provider)) {

                                        $SalesClass = "RDF";
                                    } else {
                                        $SalesClass = "ADF";
                                        if (($current_provider == $sale_previous_provider) || ($current_provider == $sale_other_record->previous_provider)) {

                                            $SalesClass = "RDF";
                                        } 
                                    }
                                } else {
                                    $SalesClass = "AGO";
                                    if ($current_provider == $sale_previous_provider) {

                                        $SalesClass = "RGO";
                                    }
                                }
                            }
                        }
                        else {
                            if ($energy_type == 1) {
                                $SalesClass = "AEO";
                                if ($current_provider == $sale_previous_provider) {
                                    $SalesClass = "REO";
                                }
                            } else {
                                $SalesClass = "AGO";
                                if ($current_provider == $sale_previous_provider) {
                                    $SalesClass = "RGO";
                                } 
                            }
                        }
                    } else {
                        //moving house "yes" and sale is dual sale
                        if ($providerLead->journey_is_dual == 1) {
                            //submit cases
                            if ($providerLead->l_status == 4 && $energy_type == 1) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>2,'sale_products_energy.sale_status'=>4,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                        
                                //if gas record found then ADF
                                $SalesClass = "AEO"; 
                                if ($sale_other_record) {
                                    $SalesClass = "ADF";
                                } 
                            }

                            //resubmit cases
                            if ($providerLead->l_status == 12 && $energy_type == 1) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>2,'sale_products_energy.sale_status'=>12,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            
                                //if gas record found
                                if (!empty($sale_other_record)) {
                                    $SalesClass = "ADF";
                                } else {
                                    $SalesClass = "AEO"; //else AEO
                                }
                            }

                            //submit cases
                            if ($providerLead->l_status == 4 && $energy_type == 2) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>1,'sale_products_energy.sale_status'=>4,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                            
                                //if electricity record found
                                $SalesClass = "AGO"; //else AGO
                                if (!empty($sale_other_record)) {
                                    $SalesClass = "ADF";
                                }
                            }
                            //resubmitted cases
                            if ($exports['sale_status'] == 12 && $energy_typ == 2) {
                                $sale_other_record = Lead::getProductData(['leads.lead_id' => $providerLead->l_lead_id, 'lead_journey_data_energy.energy_type'=>1,'sale_products_energy.sale_status'=>12,'lead_journey_data_energy.current_provider_id'=>$current_provider,'schema_status','!=',1], ['sale_products_energy.sale_status', 'schema_status'])->first();

                                
                                //if electricity record found
                                $SalesClass = "AGO";
                                if (!empty($sale_other_record)) {
                                    $SalesClass = "ADF";
                                }
                            }
                        } else {
                            $current_provider = Providers::select("name")->where('id', $current_provider)->first()->name;
                            //electricity
                            if ($energy_type == 1 && $current_provider == "Tango Energy") {
                                $SalesClass = "AEO";
                            }
                            //gas
                            if ($energy_type  == 2 && $current_provider == "Tango Energy") {
                                $SalesClass = "AGO";
                            }
                        }
                    }
                    $TransferSpecialInstructions = $providerLead->vie_qa_notes ?? '';

                    $MedicalCooling = "N";


                    $providerData[$providerLead->spe_sale_status][] = array(
                        'CIMETSALES', //0
                        'CIMET', //1
                        'Online', //2
                        $SaleRef, //3
                        $LeadID,  //4
                        $Incentive, //5
                        $DateofSale, //6
                        '2021SUMSIZ', //7
                        $PromoCode, //8
                        $CurrentElecRetailer, //9
                        $CurrentGasRetailer, //10
                        $multiSite, //11
                        $ExistingCustomer, //12
                        $CustomerAccountNumber, //13
                        $CustomerType, //14
                        $AccountName, //15
                        $ABN, //16
                        $ACN, //17
                        $BusinessName, //18
                        $BusinessType, //19
                        $TrusteeName, //20
                        $TradingName, //21
                        $Position, //22
                        $SaleType, //23
                        $CustomerTitle, // 24
                        $FirstName, //25
                        $LastName, //26
                        $PhoneLandline, //27
                        $PhoneMobile, //28
                        $AuthenticationDateOfBirth, //29
                        $AuthenticationExpiry, //30
                        $AuthenticationNo, //31 
                        $AuthenticationType, //32
                        $Email, //33
                        $LifeSupport, //34
                        $ConcessionerNumber, //35
                        $ConcessionExpiryDate, //36
                        $ConcessionFlag, //37
                        $ConcessionStartDate, //38
                        $ConcessionType, //39
                        $ConcFirstName, //40
                        $ConcLastName, //41
                        $SecondaryCustomerTitle, //42
                        $SecondaryFirstName, //43
                        $SecondaryLastName, //44
                        $SecondaryAuthenticationDateOfBirth, //45
                        $SecondaryEmail, //46
                        $SecondaryPhoneHome, //47
                        $SecondaryPhoneMobile, //48
                        $SecondaryAuthenticationExpiry, //49
                        $SecondaryAuthenticationNo, //50
                        $SecondaryAuthenticationType, //51
                        $SiteApartmentNumber, //52
                        $SiteApartmentType, //53
                        $SiteBuildingName, //54
                        $SiteFloorNumber, //55
                        $SiteFloorType, //56
                        $SiteLocationDescription, //57
                        $SiteLotNumber, //58
                        $SiteStreetName, //59
                        $SiteStreetNumber, //60
                        $SiteStreetNumberSuffix, //61
                        $SiteStreetType, //62
                        $SiteStreetSuffix, //63
                        $SiteSuburb, //64
                        $SiteState, //65
                        $SitePostCode, //66
                        $GasSiteApartmentNumber, //BP 67
                        $GasSiteApartmentType, //BP 68
                        $GasSiteBuildingName, //BQ 69
                        $GasSiteFloorNumber, //BR 	70
                        $GasSiteFloorType, //BS 71		
                        $GasSiteLocationDescription, //BT 72
                        $GasSiteLotNumber, //BU  73
                        $GasSiteStreetName, //BV 74
                        $GasSiteStreetNumber, //BW 75
                        $GasSiteStreetNumberSuffix, //BX 76
                        $GasSiteStreetType, //BY 77
                        $GasSiteStreetSuffix, //BZ 78
                        $GasSiteSuburb, //CA 79
                        $GasSiteState, //CB 80
                        $GasSitePostCode, //CC 81
                        $NMI, //82
                        $MIRN, //83
                        $Fuel, //84
                        $FeedIn, //85
                        $AnnualUsage, //86
                        $GasAnnualUsage, //87
                        $ProductCode, //88
                        $GasProductCode, //89
                        $OfferDescription, //90
                        $GasOfferDescription, //91
                        $GreenPercent, //92
                        $ProposedTransferDate, //93
                        $GasProposedTransferDate, //94
                        $BillCycleCode, //95
                        $GasBillCycleCode, //96
                        $Averagemonthlyspend,
                        $IsOwner, //97
                        $HasAcceptedMarketing, //98
                        $EmailAccountNotice, //99
                        $EmailInvoice, //100
                        $BillingEmail, //101
                        $PostalApartmentNumber, //102
                        $PostalApartmentType, // 103
                        $PostalFloorNumber, //104
                        $PostalFloorType, //105
                        $PostalLotNo, //106
                        $PostalBuildingName, //107
                        $PostalStreetNumber, //108
                        $PostalStreetNumberSuffix, //109
                        $PostalStreetName, //110
                        $PostalStreetType, //111
                        $PostPropertyName, //112
                        $PostalStreetSuffix, //113
                        $PostalSuburb, //114
                        $PostalPostCode, // 115
                        $PostalState, //116
                        $Comments, //117
                        $TransferSpecialInstructions, //118
                        $MedicalCooling, //119					
                        $BenefitEndDate, //120
                        $SalesClass, //121
                        $bill_group_code, //122
                        $GasMeterNumber //123							 
                    );
                }else{
                   
                

                    if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][9]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][9])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][9] = $sale_previous_provider ?? '';
                    } 
                    elseif (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][10])  && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][10])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][10] = $sale_previous_provider ?? '';
                    }
                
                    elseif (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][82]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][82])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][82] = $providerLead->vie_nmi_number ?? ''; 
                    } 
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][83]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][83])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][83] = $providerLead->vie_dpi_mirn_number ?? '';
                    }
                
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][88]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][88])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][88] = $providerLead->vie_electricity_code ?? '';
                    } 
                    elseif (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][89]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][89])){
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][89]=$providerLead->vie_gas_code ?? '';
                    }
                
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][90]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][90])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][90]=$providerLead->plan_plan_campaign_code ?? '';
                    } 
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][91]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][91])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][91]=$providerLead->plan_plan_campaign_code ?? '';
                        
                    }
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][93]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][93])) {
                        if ($providerLead->journey_moving_house == 1) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][93]=$providerLead->journey_moving_date ?? '';
                        }
                    } 
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][94]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][94])) {
                        if ($providerLead->journey_moving_house == 1) {
                            $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][94]=$providerLead->journey_moving_date ?? '';
                        }
                    }
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][95]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][95])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][95] = 'MM_MONTHLY'; //EC
                    } 
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][96]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][96])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][96] = 'MM_GAS'; //EI
                    }
                    else if (isset($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][123]) && empty($providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][123])) {
                        $providerData[$providerLead->spe_sale_status][$reference_key_array[$refNo]][123] = $providerLead->vie_meter_number_g ?? '';
                    }
                
                }
                
                
             
            } //  end foreach
    
            $data['protectedPassword'] = '';
            if ($providerLead->p_protected_sale_submission == 1) {
                $data['protectedPassword'] = $providerLead->p_protected_password;
            }
            
            $data['subject'] = 'TANGO_RETAILER_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
            
            $batchDetails = Providers::where('id', env('tango_energy'))->select('batch_number', 'batch_created_date')->first();
            $batch_number = $batchDetails ? $batchDetails->batch_number : 0;
            $batch_number = $batch_number + 1;
            $provider_update['batch_number'] = $batch_number;
            $provider_update['batch_created_date'] = Carbon::now();

            $data['leadIds'] = $leadIds;
            if (!$data['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                Providers::where('id', env('tango'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'TANGO_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                /* End */
                return $this->finalizeCaf($providerLead, $fileName, $data, new Headings($providerLeadData));
              
            }
            
            if (!$data['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                Providers::where('id', env('tango'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'TANGO_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
                /* End */
                return $this->finalizeCaf($providerLead, $fileName, $data, new Headings($providerLeadData));
              
            }

            if ($data['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $data['requestType'] = 'Testing manually';
                $fileName = 'Sumo_Power_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
            }

            return false;
            /* Start file_name */
            
            
        }
        catch (\Exception $e) {
           print_r($e->getMessage()); print_r($e->getFile());print_r($e->getLine());die('j');
           return response()->json(['success' => true, 'message' => $e->getMessage() . ' in file: ' . $e->getFile() . ' in file: ' . $e->getLine()]);
        }
    }
}
