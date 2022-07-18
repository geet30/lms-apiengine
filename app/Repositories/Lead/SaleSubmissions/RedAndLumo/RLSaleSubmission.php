<?php

namespace App\Repositories\Lead\SaleSubmissions\RedAndLumo;

use App\Models\{Providers};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\SaleSubmission\CommonGuzzelTrait;
use GuzzleHttp\Client;
class RLSaleSubmission
{
    use CommonGuzzelTrait;
    function submitData($sale_id, $single_both,$request)
    {
         
            $data = array(
                'serviceRequestId' => "",
                'applicationId' => "",
                'serviceType' => "",
                'serviceBrand' => "",
                'serviceSubType' => "",
                'serviceStartDate' => "",
                'serviceSaleDate' => "",
                'serviceAppointmentWindow' => "",
                'requiresLifeSupport' => "",
                'visualInspectionRequired' => "",
                'sameDayServiceRequired' => "",
                'appointmentRequired' => "",
                'specialInstructions' => "",
                'applicants' =>
                array(
                    0 =>
                    array(
                        'isPrimary' => "",
                        'title' => "",
                        'firstName' => "",
                        'lastName' => "",
                        'middleName' => "",
                        'dob' => "",
                        'contactDetails' =>
                        array(
                            'email' => "",
                            'mobilePhoneNumber' => "",
                            'homePhoneNumber' => "",
                            'workPhoneNumber' => "",
                        ),
                        'addresses' =>
                        array(
                            0 =>
                            array(
                                'addressType' => "",
                                'postalDeliveryPrefix' => "",
                                'postalDeliveryNumber' => "",
                                'unitNumber' => "",
                                'streetNumber' => "",
                                'streetName' => "",
                                'streetType' => "",
                                'suburb' => "",
                                'state' => "",
                                'postCode' => "",
                                'dpid' => "",
                            ),

                        ),
                        'identification' =>
                        array(
                            'idType' => "",
                            'idNumber' => "",
                            'idExpiryDate' => "",
                        ),
                        'concession' =>
                        array(
                            'concessionType' => "",
                            'concessionNumber' => "",
                            'concessionExpiryDate' => "",
                        ),
                        'familyViolenceProtectionDetails' =>
                        array(
                            'isAffectedByFamilyViolence' => false,
                            'password'  => "",
                            'passwordHintQuestion' => "",
                            'passwordHintAnswer' => "",
                        ),
                    ),

                ),
                'accountDetails' =>
                array(
                    'agreedToMarketing' => "",
                    'agreedToWelcomePack' => "",
                    'agreedToEBill' => "",
                    'agreedToReceiveSMS' => "",
                    'billingDetails' =>
                    array(
                        'billingCycle' => "",
                    ),
                ),
                'propertyDetails' =>
                array(
                    'occupancyType' => "",
                    'isVacant' => "",
                    'isDogOnPremises' => "",
                    'addresses' =>
                    array(
                        'addressType' => "",
                        'postalDeliveryPrefix' => "",
                        'postalDeliveryNumber' => "",
                        'unitNumber' => "",
                        'streetNumber' => "",
                        'streetName' => "",
                        'streetType' => "",
                        'suburb' => "",
                        'state' => "",
                        'postCode' => "",
                        'dpid' => "",
                    ),
                ),
                'serviceMeters' =>
                array(
                    0 =>
                    array(
                        'meterType'  => "",
                        'meterIdentifier'  => "",
                        'meterNumber' => "",
                        'meterStatus' => "",
                        'meterInstructions' => "",
                        'meterAddress' =>
                        array(
                            'hazardDescription' => "",
                            'locationDescription' => "",
                        ),
                    ),

                ),
                'productDetails' =>
                array(
                    0 =>
                    array(
                        'productFuel' => "",
                        'productCode' => "",
                        'productOptions' =>
                        array(
                            'productAdditional' => "",
                        ),
                    )
                ),
            );
 
            $addressDetails = DB::table('visitor_addresses')->whereIn('id', [$request[0]->l_billing_address_id, $request[0]->l_billing_po_box_id])->get();
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
            $provider_data = Providers::where('user_id',$request[0]->sale_product_provider_id)->first();
            $batch_number = $provider_data->batch_number;
            $data['serviceRequestId'] = $batch_number;
            $data['applicationId'] = $batch_number;

            $error = [];
            /*Validations Start here */

            if ((!isset($request[0]->vie_qa_notes_created_date))) {
                $error['sale_created'] = "Sale created is Mandatory";
            }

            $title = array("mr", "mrs", "ms", "miss", "dr", "rabbi", "rev", "sr", "prof", "mx");
            if (!isset($request[0]->v_title) && !in_array($request[0]->v_title, $title)) {
                $error['title'] = "Title must be in ['mr','mrs','ms','miss','dr','rabbi','rev','sr','prof','mx']";
            }
            unset($title);

            if (!isset($request[0]->v_first_name)) {
                $error["first_name"] = "First name is Mandatory";
            }

            if (!isset($request[0]->v_last_name)) {
                $error["last_name"] = "Last name is Mandatory";
            }

            if (!isset($request[0]->v_dob)) {
                $error["dob"] = "Date of birth is Mandatory";
            }

            if (!isset($request[0]->va_street_name)) {
                $error["street_name"] = "Street Name is Mandatory";
            }

            if (!isset($request[0]->va_street_code) || empty($request[0]->va_street_code)) {
                $error["street_code"] = "Street Code is Mandatory";
            }

            if (!isset($request[0]->va_suburb)) {
                $error["suburb"] = "suburb is Mandatory";
            }

            if (!isset($request[0]->va_state)) {
                $error["state"] = "State is Mandatory";
            }


            /*product details start here */
            $data['productDetails'][0]['productFuel'] = $request[0]->sale_product_product_type;
            if ($request[0]->sale_product_product_type == "2") {
                if (!isset($request[0]->plan_product_code)) {
                    $error["plan_code_g"] = "Gas plan code is required";
                }
                $data['productDetails'][0]['productCode'] = $request[0]->plan_product_code;
            } else {
                if (!isset($request[0]->plan_product_code)) {
                    $error["plan_code_e"] = "Electricity plan code is required";
                }
                $data['productDetails'][0]['productCode'] = $request[0]->plan_product_code;
            }

            if ($single_both == "3") {
                $data['productDetails'][1]['productFuel'] = $request[1]->sale_product_product_type;
                if ($request[1]->sale_product_product_type == 2) {
                    if (!isset($request[1]->plan_product_code)) {
                        $error["plan_code_g"] = "Gas plan code is required";
                    }
                    $data['productDetails'][1]['productCode'] = $request[1]->plan_product_code;
                } else {
                    if (!isset($request[1]->plan_product_code)) {
                        $error["plan_code_e"] = "Electricity plan code is required";
                    }
                    $data['productDetails'][1]['productCode'] = $request[1]->plan_product_code;
                }
            }
            // if ($error) {
            //     return ['code' => 400, 'header' => 'Errors', 'output' => json_encode($error), 'data' => "Validations error"];
            // }
            /*product details end here */

            /*Validations End here */

            if ($single_both == "3") {
                $data['serviceType'] = "dual";
            } else {
                if ($request[0]->sale_product_product_type == 1) {
                    $data['serviceType'] = "electricity";
                } else {
                    $data['serviceType'] = "gas";
                }
            }

            if (config("app.redLumo.red_energy") == $request[0]->sale_product_provider_id) {
                $data["serviceBrand"] = "REDE";
            } else if (config("app.redLumo.lumo_energy") == $request[0]->sale_product_provider_id) {
                $data["serviceBrand"] = "LUMOE";
            }


            if ($request[0]->journey_moving_house == 1) {
                $data['serviceSubType'] = "connection";
                $data['serviceStartDate'] = date('Y-m-d', strtotime(str_replace('/', '-', $request[0]->journey_moving_date)));
            } else {
                $data['serviceSubType'] = "transfer";
            }


            $data['serviceSaleDate'] = date('Y-m-d', strtotime(str_replace('/', '-', $request[0]->vie_qa_notes_created_date)));
            $data["requiresLifeSupport"] = true;
            if ($request[0]->journey_life_support == "0" || !isset($request[0]->journey_life_support)) {
                $data["requiresLifeSupport"] = false;
            }
            $data["visualInspectionRequired"] = false;
            if ($request[0]->va_state == 'QLD' || $request[0]->va_state == 'NSW') {
                $data["visualInspectionRequired"] = true;
            }

            $data['sameDayServiceRequired'] = false;
            $data['appointmentRequired'] = false;


            $data["applicants"][0]["isPrimary"] = true;
            $data["applicants"][0]["title"] = $request[0]->v_title;
            $data["applicants"][0]["firstName"] = decryptGdprData($request[0]->v_first_name);
            $data["applicants"][0]["lastName"] = decryptGdprData($request[0]->v_last_name);
            $data["applicants"][0]["middleName"] = isset($request[0]->v_middle_name) ? decryptGdprData($request[0]->v_middle_name) : "";
            $data["applicants"][0]["dob"] = Carbon::parse(decryptGdprData($request[0]->v_dob))->format('Y-m-d');
            $data["applicants"][0]["contactDetails"]['email'] = decryptGdprData($request[0]->v_email);
            $data["applicants"][0]["contactDetails"]['mobilePhoneNumber'] =  decryptGdprData($request[0]->v_phone);
            $data["applicants"][0]["contactDetails"]['homePhoneNumber'] =  isset($request[0]->v_alternate_phone) ? decryptGdprData($request[0]->v_alternate_phone) : "";
            $data["applicants"][0]["contactDetails"]['workPhoneNumber'] =  isset($request[0]->v_alternate_phone) ? decryptGdprData($request[0]->v_alternate_phone) : "";


            /* Applicant Address Start Here */
            if ($request[0]->l_save_po_box ==  1 && !empty($request[0]->l_save_po_box)) {

                $data["applicants"][0]["addresses"][0]["addressType"] = 'postal';
                $data["applicants"][0]["addresses"][0]["postalDeliveryPrefix"] = "PO BOX";
                $data["applicants"][0]["addresses"][0]["postalDeliveryNumber"] = "PO BOX " . $poBoxAddress->address;
                $data["applicants"][0]["addresses"][0]["unitNumber"] = "";
                $data["applicants"][0]["addresses"][0]["streetNumber"] = "";
                $data["applicants"][0]["addresses"][0]["streetName"] = "";
                $data["applicants"][0]["addresses"][0]["streetType"] = "";
                $data["applicants"][0]["addresses"][0]["suburb"] = $poBoxAddress->suburb;
                $data["applicants"][0]["addresses"][0]["state"] = $poBoxAddress->state;
                $data["applicants"][0]["addresses"][0]["postCode"] = $poBoxAddress->postcode;
                $data["applicants"][0]["addresses"][0]["dpid"] = $poBoxAddress->dpi;
            } elseif ($request[0]->l_billing_preference == "3") {

                $data["applicants"][0]["addresses"][0]["addressType"] = 'postal';
                $data["applicants"][0]["addresses"][0]["postalDeliveryPrefix"] = "";
                $data["applicants"][0]["addresses"][0]["postalDeliveryNumber"] = "";
                $data["applicants"][0]["addresses"][0]["unitNumber"] = isset($billingAddress->unit_no) ? $billingAddress->unit_no : "";
                $data["applicants"][0]["addresses"][0]["streetNumber"] = $billingAddress->street_number;
                $data["applicants"][0]["addresses"][0]["streetName"] = $billingAddress->street_name;
                $data["applicants"][0]["addresses"][0]["streetType"] = isset($billingAddress->street_code) ? $billingAddress->street_code : "";
                $data["applicants"][0]["addresses"][0]["suburb"] = $billingAddress->suburb;
                $data["applicants"][0]["addresses"][0]["state"] = $billingAddress->state;
                $data["applicants"][0]["addresses"][0]["postCode"] = $billingAddress->postcode;
                $data["applicants"][0]["addresses"][0]["dpid"] = isset($billingAddress->billing_dpid) ? $billingAddress->billing_dpid : "";
            } elseif ($request[0]->l_billing_preference == "1" && $request[0]->l_email_welcome_pack == 1) {
                $data["applicants"][0]["addresses"][0]["addressType"] = 'postal';
                $data["applicants"][0]["addresses"][0]["postalDeliveryPrefix"] = "";
                $data["applicants"][0]["addresses"][0]["postalDeliveryNumber"] = "";
                $data["applicants"][0]["addresses"][0]["unitNumber"] = isset($billingAddress->unit_number) ? $billingAddress->unit_number : "";
                $data["applicants"][0]["addresses"][0]["streetNumber"] = $billingAddress->street_number;
                $data["applicants"][0]["addresses"][0]["streetName"] = $billingAddress->street_name;
                $data["applicants"][0]["addresses"][0]["streetType"] =
                    isset($billingAddress->street_code) ? $billingAddress->street_code : "";
                $data["applicants"][0]["addresses"][0]["suburb"] =  $billingAddress->suburb;
                $data["applicants"][0]["addresses"][0]["state"] = $billingAddress->state;
                $data["applicants"][0]["addresses"][0]["postCode"] =  $billingAddress->postcode;
                $data["applicants"][0]["addresses"][0]["dpid"] = isset($billingAddress->billing_dpid) ? $billingAddress->billing_dpid : "";
            } else {

                $data["applicants"][0]["addresses"][0]["addressType"] = 'previous';
                $data["applicants"][0]["addresses"][0]["postalDeliveryPrefix"] = "";
                $data["applicants"][0]["addresses"][0]["postalDeliveryNumber"] = "";
                $data["applicants"][0]["addresses"][0]["unitNumber"] = isset($request[0]->va_unit_no) ? $request[0]->va_unit_no : "";
                $data["applicants"][0]["addresses"][0]["streetNumber"] = $request[0]->va_street_number;
                $data["applicants"][0]["addresses"][0]["streetName"] = $request[0]->va_street_name;
                $data["applicants"][0]["addresses"][0]["streetType"] = isset($request[0]->va_street_code) ? $request[0]->va_street_code : "";
                $data["applicants"][0]["addresses"][0]["suburb"] = $request[0]->va_suburb;
                $data["applicants"][0]["addresses"][0]["state"] = $request[0]->va_state;
                $data["applicants"][0]["addresses"][0]["postCode"] = $request[0]->va_postcode;
                $data["applicants"][0]["addresses"][0]["dpid"] = isset($request[0]->va_dpid) ? $request[0]->va_dpid : "";
            }

            /* Applicant Address End Here */

            /* Identification details Start Here */

            if (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Drivers Licence') {

                $data["applicants"][0]["identification"]['idType'] = 'drivers licence';

                $data["applicants"][0]["identification"]['idNumber'] = $request[0]->vi_licence_number;

                $data["applicants"][0]["identification"]['idExpiryDate'] = $request[0]->vi_licence_expiry_date;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Foreign Passport') {

                $data["applicants"][0]["identification"]['idType'] = "Passport";

                $data["applicants"][0]["identification"]['idNumber'] = $request[0]->vi_foreign_passport_number;

                $data["applicants"][0]["identification"]['idExpiryDate'] = $request[0]->vi_foreign_passport_expiry_date;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'Passport') {

                $data["applicants"][0]["identification"]['idType'] = "Passport";

                $data["applicants"][0]["identification"]['idNumber'] = $request[0]->vi_passport_number;

                $data["applicants"][0]["identification"]['idExpiryDate'] = $request[0]->vi_passport_expiry_date;
            } elseif (isset($request[0]->vi_identification_type) && $request[0]->vi_identification_type == 'medicare card') {

                $data["applicants"][0]["identification"]['idType'] = "MEDICARE";

                $data["applicants"][0]["identification"]['idNumber'] = $request[0]->vi_medicare_number;

                $data["applicants"][0]["identification"]['idExpiryDate'] = $request[0]->vi_medicare_card_expiry_date;
            }

            /* Identification details End Here */

            /*  Concession Details Start Here */ 

            if (isset($request[0]->vcd_concession_type) && !empty($request[0]->vcd_concession_type) && $request[0]->vcd_concession_type != "Not Applicable") {
                $check = false;
                if ($request[0]->vcd_concession_type == 'Centrelink Healthcare Card') {
                    $check = true;
                    $data['applicants'][0]['concession']['concessionType'] = 'hcc';
                } elseif ($request[0]->vcd_concession_type == 'Pensioner Concession Card') {
                    $check = true;
                    $data['applicants'][0]['concession']['concessionType'] = 'pcc';
                } elseif ($request[0]->vcd_concession_type == 'DVA Pension Concession Card') {
                    $check = true;
                    $data['applicants'][0]['concession']['concessionType'] = 'dva';
                } elseif ($request[0]->vcd_concession_type == 'DVA Gold Card') {
                    $check = true;
                    $data['applicants'][0]['concession']['concessionType'] = 'dvag';
                }

                if ($check) {
                    $data['applicants'][0]['concession']['concessionNumber'] = isset($request[0]->vcd_card_number) ? $request[0]->vcd_card_number : "";

                    $data['applicants'][0]['concession']['concessionExpiryDate'] = isset($request[0]->vcd_card_expiry_date) ? date('Y-m-d', strtotime(str_replace('/', '-', $request[0]->vcd_card_expiry_date))) : "";
                }
            }

            /*  Concession Details End Here */



            /* AccountDetails start Here */

            $data['accountDetails']['agreedToMarketing'] = false;
            $data['accountDetails']['agreedToWelcomePack'] = true;
            if ($request[0]->l_save_po_box !=  1 && $request[0]->l_billing_preference == 2 && $request[0]->l_email_welcome_pack != 1) {
                $data['accountDetails']['agreedToEBill'] = true;
            } else {
                $data['accountDetails']['agreedToEBill'] = false;
            }

            $data['accountDetails']['agreedToReceiveSMS'] = true;
            $data['accountDetails']['billingDetails']['billingCycle'] = "monthly";

            /* AccountDetails end Here */

            // Property Details 

            if (isset($request[0]->va_property_ownership) && $request[0]->va_property_ownership == "Own") {

                $data['propertyDetails']['occupancyType'] = "Owner";
            } elseif (isset($request[0]->va_property_ownership) && $request[0]->va_property_ownership == "Rent") {

                $data['propertyDetails']['occupancyType'] = "Renter";
            } else {

                $data['propertyDetails']['occupancyType'] =  "unknown";
            }

            $data['propertyDetails']['isVacant'] = "";
            if (isset($request[0]->vie_dog_code)) {
                $data['propertyDetails']['isDogOnPremises'] = true;
            } else {
                $data['propertyDetails']['isDogOnPremises'] = false;
            }

            /* Property Details address start here */

            $data['propertyDetails']['addresses']['addressType'] = "service";
            $data['propertyDetails']['addresses']['unitNumber'] = isset($request[0]->va_unit_no) ? $request[0]->va_unit_no : "";
            $data['propertyDetails']['addresses']['streetNumber'] = $request[0]->va_street_number;
            $data['propertyDetails']['addresses']['streetName'] = $request[0]->va_street_name;
            $data['propertyDetails']['addresses']['streetType'] = isset($request[0]->va_street_code) ? $request[0]->va_street_code : "";
            $data['propertyDetails']['addresses']['suburb'] = $request[0]->va_suburb;
            $data['propertyDetails']['addresses']['state'] = $request[0]->va_state;
            $data['propertyDetails']['addresses']['postCode'] = $request[0]->va_postcode;
            $data['propertyDetails']['addresses']['dpid'] = isset($request[0]->va_dpid) ? $request[0]->va_dpid : "";

            /* Property Details address end here */

            /* Service Meter Details start here */


            $data['serviceMeters'][0]['meterStatus'] = "";


            $data['serviceMeters'][0]['meterAddress']['hazardDescription'] = isset($request[0]->vie_meter_hazard) ? $request[0]->vie_meter_hazard : "";
            $data['serviceMeters'][0]['meterAddress']['locationDescription'] = isset($request[0]->va_site_descriptor) ? $request[0]->va_site_descriptor : "";

            if ($request[0]->sale_product_product_type == 1) {
                $data['serviceMeters'][0]['meterType'] = 'electricity';
                $data['serviceMeters'][0]['meterNumber'] = isset($request[0]->vie_meter_number_e) ? $request[0]->vie_meter_number_e : "";

                if ($request[0]->vie_nmi_skip == "0") {
                    $data['serviceMeters'][0]['meterIdentifier'] = $request[0]->vie_nmi_number;
                }

                $data['serviceMeters'][0]['meterInstructions'] = isset($request[0]->vie_site_access_electricity) ? $request[0]->vie_site_access_electricity : "";
            } else {
                $data['serviceMeters'][0]['meterType'] = 'gas';
                $data['serviceMeters'][0]['meterNumber'] = isset($request[0]->vie_meter_number_g) ? $request[0]->vie_meter_number_g : "";

                if ($request[0]->vie_mirn_skip == "0") {
                    $data['serviceMeters'][0]['meterIdentifier'] = $request[0]->vie_dpi_mirn_number;
                }

                $data['serviceMeters'][0]['meterInstructions'] = isset($request[0]->vie_site_access_gas) ? $request[0]->vie_site_access_gas : "";
            }



            if ($single_both == "3") {
                if ($request[1]->sale_product_product_type == 1) {
                    $data['serviceMeters'][1]['meterType'] = "electricity";
                } else {
                    $data['serviceMeters'][1]['meterType'] = "gas";
                }
                $data['serviceMeters'][1]['meterStatus'] = "";


                $data['serviceMeters'][1]['meterAddress']['hazardDescription'] = isset($request[1]->vie_meter_hazard) ? $request[1]->vie_meter_hazard : "";

                $data['serviceMeters'][1]['meterAddress']['locationDescription'] = isset($request[1]->va_site_descriptor) ? $request[1]->va_site_descriptor : "";

                if ($request[1]->sale_product_product_type == 1) {
                    $data['serviceMeters'][1]['meterNumber'] = isset($request[1]->vie_meter_number_e) ? $request[1]->vie_meter_number_e : "";

                    if ($request[1]->vie_nmi_skip == "0") {
                        $data['serviceMeters'][1]['meterIdentifier'] = $request[1]->vie_nmi_number;
                    }

                    $data['serviceMeters'][1]['meterInstructions'] = isset($request[1]->vie_site_access_electricity) ? $request[1]->vie_site_access_electricity : "";
                } else {
                    $data['serviceMeters'][1]['meterNumber'] = isset($request[1]->vie_meter_number_e) ? $request[1]->vie_meter_number_e : "";

                    if ($request[1]->vie_mirn_skip == "0") {
                        $data['serviceMeters'][1]['meterIdentifier'] = $request[1]->vie_dpi_mirn_number;
                    }
                    $data['serviceMeters'][1]['meterInstructions'] = isset($request[0]->vie_site_access_gas) ? $request[0]->vie_site_access_gas : "";
                }
            } 

            /* Service Meter Details end here */
            $req = $request;
            $data = json_encode($data);

            $headers = [
                'Accept'     => 'application/json',
                'Content-Type' =>  'application/json',
                'Authorization' => config('env.redLumo.redlumo_auth')
            ];
            $url = config('app.red_lumo_api_url');
            $client = new Client(); 
            $res =  $client->request(
                'POST',
                $url,
                [
                'headers' => [
                    'Accept'     => 'application/json',
                    'Content-Type' =>  'application/json',
                    'Authorization' => config('app.red_lumo_api_token')
                ],
                'force_ip_resolve' => 'v4',
                'body' => $data,
                'http_errors' => false

                ]
            ); 
            $response = json_decode($res->getBody(), true);  
            if(isset($response['success']) && $response['success'] == false)
			{
				return $response = ['message' => "Something went wrong.", 'output' => json_encode($response),'data' => $data, 'header' => "Red & Lumo Submission", 'code' => 400];
			} ;

            $apirequest = [];
            $apirequest['lead_id'] = $request[0]->l_lead_id;
            $apirequest['api_request'] = $data;
            $apirequest['api_name'] = "Red&Lumo_sale_submission";
            $apirequest['api_response'] = json_encode($response);
            $apirequest['header_data'] = "API";
            $apirequest['api_reference'] = $batch_number;
            $apirequest['status_code'] = $res->getStatusCode();
            DB::connection('sale_logs')->table('sale_submission_api_responses')->insert($apirequest);
            if ($res->getStatusCode() == 202) {
                $apirequest['status_code'] = 200;
                $provider_data->batch_number = $batch_number + 1;
                $provider_data->save();
            }
            return ['code' => $apirequest['status_code'], 'header' => 'R&L Sale Submission API', 'output' => json_encode($response), 'data' => $data];
         
    }
}
