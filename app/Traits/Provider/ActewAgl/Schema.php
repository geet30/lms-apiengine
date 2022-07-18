<?php

namespace App\Traits\Provider\ActewAgl;

use Carbon\Carbon;

trait Schema
{
    function actewAglSchema($providerLeads, $data)
    {
        $data['providerName'] = 'ActewAGL';
        $data['mailType'] = 'test';
        $data['referenceNo'] = $providerLeads[0]->sale_product_reference_no;
        $leadIds = $providerData = [];
        foreach ($providerLeads as $providerLead) {
            if (!$providerLead->spe_sale_status) continue;
            $elec_gas_nmi_mirn = $providerLead->dpi_mirn_number ?? ''; // column C
            if ($providerLead->sale_product_product_type == 1 && $providerLead->vie_nmi_number) {
                $elec_gas_nmi_mirn = $providerLead->vie_nmi_number;
            }
            array_push($leadIds, $providerLead->l_lead_id);
            $company_trading_name = '';
            $abn_number = '';
            $business_email = '';
            $business_phone_no = '';
            if ($providerLead->journey_property_type == 2) {
                $company_trading_name = $providerLead->vbd_business_legal_name ?? '';
                $abn_number = $providerLead->vbd_business_abn;
                $business_email = $providerLead->vis_email;
                $business_phone_no = $providerLead->vis_visitor_phone;
            }

            $identity_type = '';
            $identity_num = '';
            $identity_state = '';
            if ($providerLead->vie_identity_type == 'Drivers Licence') {
                $identity_num = $providerLead->vie_licence_number;
                $identity_type = 'DL';
                $identity_state = $providerLead->vie_licence_state_code ?? '';
            }

            $concession_group = '';
            $concession_card_holder = '';
            $concession_card_number = '';
            $card_start_date = '';
            $card_expiry_date = '';
            $concession_consent = '';
            // 
            if ($providerLead->vcd_concession_type && $providerLead->vcd_concession_type != 'Not Applicable') {
                $concession_card_holder = $providerLead->vcd_card_number ? '1' : '';
                // concession card number
                $concession_card_number = $providerLead->vcd_card_number ?? '';
                $card_start_date = $providerLead->vcd_card_start_date ?? '';
                $card_expiry_date = $providerLead->vcd_card_expiry_date ?? '';
                $concession_consent = 'Y';


                //  concession group
                if (in_array($providerLead->vcd_concession_type, $this->aglHcc)) {
                    $concession_group = 'HCC';
                } else if (in_array($providerLead->vcd_concession_type, $this->cc)) {
                    $concession_group = 'C';
                } else if (in_array($providerLead->vcd_concession_type, $this->qld)) {
                    $concession_group = 'QLD';
                } else if (in_array($providerLead->vcd_concession_type, $this->dva)) {
                    $concession_group = 'DVA';
                } else {
                    $concession_group = '';
                }
            }

            $moving_house = ($providerLead->journey_moving_house == 1) ? 'N' : 'Y';
            $moving_date = ($providerLead->journey_moving_house == 1) ? $providerLead->journey_moving_date : '';


            $billing_preference = ''; //BE
            foreach ($this->aglAddressFields as $requestField) {
                ${'connection_' . $requestField} = $providerLead->{'va_' . $requestField};
            }
            if ($providerLead->sale_product_product_type == 2 && $providerLead->journey_is_dual == 1 && $providerLead->vga_is_same_gas_connection) {
                foreach ($this->aglAddressFields as $aglAddressField => $requestField) {
                    ${'connection_' . $aglAddressField} = $providerLead->{'vga_' . $requestField};
                }
            }

            $po_box = ''; //BN
            $po_suburb = ''; //BO
            $po_state = ''; //BP
            $po_postcode = ''; //BQ

            //  billing address
            $billingArrayFields = ['billing_property_name', 'billing_floor_no', 'billing_floor_type_code', 'billing_unit_type_code', 'billing_unit_number', 'billing_street_number', 'billing_street_name', 'billing_street_code'];
            $billing_property_name = ''; //BF
            $billing_floor_no = ''; //BG
            $billing_floor_type_code = ''; //BH
            $billing_unit_type_code = ''; //BI
            $billing_unit_number = ''; //BJ
            $billing_street_number = ''; //BK
            $billing_street_name = ''; //BL
            $billing_street_type = ''; //BM

            if ($providerLead->is_po_box == 1) {
                $billing_preference = 'N';
                $po_box = $providerLead->vpa_address ? str_replace(',', '', $providerLead->vba_address) : '';
                $po_suburb = $providerLead->vpa_suburb ?? '';
                $po_state = $providerLead->vpa_state ?? '';
                $po_postcode = $providerLead->vpa_postcode ?? '';
            }

            if ($providerLead->l_billing_preference == 1) {
                foreach ($billingArrayFields as $billingArrayField) {
                    $field = str_replace('billing_', 'vba_', $billingArrayField);
                    if (isset($providerLead->{$field})) {
                        ${$billingArrayField} = $providerLead->{$field};
                    }
                }
                $po_suburb = $providerLead->vba_suburb ?? '';
                $po_state = $providerLead->vba_state ?? '';
                $po_postcode = $providerLead->vba_postcode ?? '';
            }


            // if billing preference is connection address means select no.
            if ($providerLead->l_billing_preference == 2) {
                $billing_preference = 'Y';
            } else if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack == 1) {
                $billing_preference = 'N';
            } else if ($providerLead->l_billing_preference == 1 && $providerLead->l_email_welcome_pack == 0) {
                $billing_preference = 'Y';
            } else if ($providerLead->l_billing_preference == 1) {
                $billing_preference = 'N';
            }

            $bundle = $providerLead->plan_product_code ?? '';

            if ($providerLead->journey_is_dual == 1) {
                $bundle = $providerLead->plan_bundle_code ?? $bundle;
            }
            $lifeSupportFuel = '';
            if ($providerLead->journey_life_support == 1) {
                $lifeSupportFuel = ($providerLead->sale_product_product_type == 1) ? 'E' : 'G';
                if ($providerLead->journey_is_dual == 1) {
                    $lifeSupportFuel = 'B';
                }
            }
            $providerData[$providerLead->spe_sale_status][] = [
                $providerLead->sale_product_reference_no, // A
                ($providerLead->sale_product_product_type == 1) ? 'E' : 'G', //B
                $elec_gas_nmi_mirn, //C
                '', //D account number
                '', //E existing account number
                '', //F account manager
                ($providerLead->journey_property_type == 1) ? 'R' : 'B', //G property type
                $company_trading_name, //H
                $abn_number, //I
                $company_trading_name, //J
                $business_email, //K
                $business_phone_no, //L
                '', //M customer id
                str_replace('.', '', $providerLead->vis_title), //N
                decryptGdprData($providerLead->vis_first_name), //O
                decryptGdprData($providerLead->vis_last_name) ?? '', //P
                Carbon::parse($providerLead->vis_dob)->format('d/m/Y'), //Q
                decryptGdprData($providerLead->vis_email), //R
                '', //S private phone number
                decryptGdprData($providerLead->vis_visitor_phone) ?? '', //T
                decryptGdprData($providerLead->vis_alternate_phone) ?? '', //U
                'E', //V
                $identity_type, //W
                $identity_num, //X
                $identity_state, //Y
                '', //Z
                '', //AA
                '', //AB
                '', //AC
                '', //AD
                '', //AE
                '', //EF
                '', //EG
                '', //EH
                '', //EI
                '', //AJ
                '', //AK
                $concession_group, //AL
                $concession_card_holder, //AM
                $concession_card_number, //AN
                '', //AO
                $card_start_date, //AP
                $card_expiry_date, //AQ
                $concession_consent, //AR
                ($providerLead->journey_life_support == 1) ? 'Y' : 'N', //AS
                $lifeSupportFuel,
                $connection_property_name, //AT
                $connection_floor_no, //AU
                $connection_floor_type_code, //AV
                $connection_unit_type, //AW
                $connection_unit_number, //AX
                $connection_street_number, //AY
                $connection_street_name, //AZ
                $connection_street_code, //BA
                $connection_suburb, //BB
                $connection_state, //BC
                $connection_postcode, //BD
                $billing_preference, //BE
                $billing_property_name, //BF
                $billing_floor_no, //BG
                $billing_floor_type_code, //BH
                $billing_unit_type_code, //BI
                $billing_unit_number, //BJ
                $billing_street_number, //BK
                $billing_street_name, //BL
                $billing_street_type, //BM
                $po_box, //BN
                $po_suburb, //BO
                $po_state, //BP
                $po_postcode, //BQ
                '', //BR
                '', //BS
                '', //BT
                $moving_house, //BU
                $moving_date, //BV
                'O', //BW
                '', //BX
                '', //BY
                'CIMET', //BZ
                $providerLead->vie_qa_notes_created_date ?? '', //CA 
                $bundle, //CB
                '', //CC
                '', //CD
                '', //CE
                '', //CF
                '', //CG
                '', //CH
                '', //CI
                '', //CJ
                '', //CK
                '', //CL
                '', //CM
                '', //CN
                '' //CP
            ];
        }

        $data['protectedPassword'] = '';
        if ($providerLead->p_protected_sale_submission == 1) {
            $data['protectedPassword'] = $providerLead->p_protected_password;
        }

        $data['subject'] = 'ActewAGL_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . Carbon::now()->format('H:m');
        $data['leadIds'] = $leadIds;
        if (!$data['isTest'] && array_key_exists('4', $providerData)) {
            $providerLeadData = $providerData['4'];
            $data['requestType'] = 'Fulfilment';
            $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
            $fileName = 'ActewAGL_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
            return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
        }

        if (!$data['isTest'] && array_key_exists('12', $providerData)) {
            $providerLeadData = $providerData['12'];
            $data['requestType'] = 'Resubmission';
            $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
            $fileName = 'ActewAGL_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset) . '.xlsx';
            return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
        }

        if ($data['isTest']) {
            $first_key = key($providerData);
            $providerLeadData = $providerData[$first_key];
            $data['requestType'] = 'Testing manually';
            $fileName = 'ActewAGL_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
            return $this->finalizeCaf($providerLeads[0], $fileName, $data, new Headings($providerLeadData));
        }
        return false;
    }
}
