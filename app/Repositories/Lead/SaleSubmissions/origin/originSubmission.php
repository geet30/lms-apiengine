<?php

namespace App\Repositories\Lead\SaleSubmissions\origin;

use App\models\{
    Sale,
    ApiResponse,
    Lead
};
use Carbon\Carbon;
use repositories\CommonRepository;
use Illuminate\Support\Facades\DB;

class originSubmission
{
    public $request_data;
    public $response_data;

    public function __construct()
    {

        $this->request_data = "";
        $this->response_data = "";
    }

    public static function getProductId($campaign_code, $product_code, $env_type = 'production')
    {
        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $productID = 0;
        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
        );

        $c = "'" . $campaign_code . "'";
        $e = "'" . $product_code . "'";

        $c = str_replace('%20', ' ', $c);
        $e = str_replace('%20', ' ', $e);

        //$url = config('app.origin_dev_url').'sap/opu/odata/sap/PRODUCT_CATALOG/Products/?$filter=%20CampaignID%20eq%20'.$c.'%20and%20ProductCode%20eq%20'.$e.'';

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $url = config('app.origin_production_url') . 'sap/opu/odata/sap/PRODUCT_CATALOG/Products/?$filter=%20CampaignID%20eq%20' . $c . '%20and%20ProductCode%20eq%20' . $e . '';
            } else {
                $url = config('app.origin_dev_url') . 'sap/opu/odata/sap/PRODUCT_CATALOG/Products/?$filter=%20CampaignID%20eq%20' . $c . '%20and%20ProductCode%20eq%20' . $e . '';
            }
        } else {
            $url = config('app.origin_dev_url') . 'sap/opu/odata/sap/PRODUCT_CATALOG/Products/?$filter=%20CampaignID%20eq%20' . $c . '%20and%20ProductCode%20eq%20' . $e . '';
        }

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($cURL);
        $arr = explode("'", $output);
        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        if (isset($arr[1]) && $arr[1] != "" &&  $httpcode != 400) {
            $productID = $arr[1];
            //  self::uploadOnS3($energy_type . ' product-ID', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            // self::saveProductID($energy_type, $reference_no, $productID);
        } else {
            $productID = 0;
            //self::uploadOnS3($energy_type . ' product-ID', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
        }

        if ($campaign_code == "" || $product_code == "") {
            $res_arr = array($productID, str_replace('%20', ' ', $url), $output);
            return $res_arr;
        }

        $res_arr = array();
        $res_arr = array($productID, str_replace('%20', ' ', $url), $output);
        return $res_arr;
    }


    public static function saveProductID($energy_type, $reference_no, $productID)
    {

        $expiry_time = Carbon::now();
        $expiry_time = $expiry_time->toDateTimeString();
        $expiry_time = Carbon::parse($expiry_time)->addHour();

        $is_save = Lead::where('energy_type', strtolower($energy_type))
            ->where('reference_no', $reference_no)
            ->update([

                'plan_product_id'         => $productID,
                'product_id_expiry_time'  => $expiry_time
            ]);

        return $is_save;
    }

    public static function postOriginData($gas_ID, $elec_ID, $sale_id, $energy_type, $env_type)
    {
        $OrderIDgas[0] = "";
        $OrderIDelec[0] = "";
        $origin_id = config('app.origin_id');
        DB::select('set @leadId=' . $sale_id);
        $request = DB::select('call final_sale_detail_energy(@leadId)');
        $is_same = 0;
        if ($energy_type == 'both') {
            $is_same = 1;
            if (isset($request[0]->is_same_gas_connection) && $request[0]->is_same_gas_connection == 0) {

                $OrderIDelec = self::checkNMIAddress($request[0]->sale_product_reference_no, $request[0]->vie_nmi_number, $env_type);

                if (!$OrderIDelec[0]) {

                    $OrderIDelec = self::checkMIRNAddress($request[0]->sale_product_reference_no, $request[0]->vie_dpi_mirn_number, $env_type);
                }

                if (!$OrderIDelec[0]) {

                    $OrderIDelec = self::checkValidateAddress($request[0]->sale_product_reference_no, 'electricity', $request[0], $env_type);
                }

                if (!$OrderIDelec[0]) {

                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $OrderIDelec[1], 'response_data' => $OrderIDelec[2]];
                    $status = 200;
                    return response()->json($response, $status);
                }
            } else {

                $OrderIDelec = self::checkNMIAddress($request[0]->sale_product_reference_no, $request[0]->vie_nmi_number, $env_type);
                if (!$OrderIDelec[0]) {
                    $OrderIDelec = self::checkValidateAddress($request[0]->sale_product_reference_no, 'electricity', $request[0], $env_type);
                }
                if (!$OrderIDelec[0]) {
                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $OrderIDelec[1], 'response_data' => $OrderIDelec[2]];
                    $status = 200;
                    return response()->json($response, $status);
                }
                $OrderIDgas = self::checkMIRNAddress($request[0]->sale_product_reference_no, $request[0]->dpi_mirn_number, $env_type);
                if (!$OrderIDgas[0]) {
                    $visitor_gas_connection = DB::table('visitor_addresses')->where('id', $request[0]->l_gas_address_id)->first();
                    $OrderIDgas = self::checkValidateAddress($request[0]->sale_product_reference_no, 'gas', $visitor_gas_connection, $env_type);
                }
                if (!$OrderIDgas[0]) {
                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $OrderIDgas[1], 'response_data' => $OrderIDgas[2]];
                    $status = 200;
                    return response()->json($response, $status);
                }
            }
        } else {
            if ($request[0]->sale_product_product_type == 1) {
                $OrderIDelec = self::checkNMIAddress($request[0]->sale_product_reference_no, $request[0]->vie_nmi_number, $env_type);
                if (!$OrderIDelec[0]) {
                    $OrderIDelec = self::checkValidateAddress($request[0]->sale_product_reference_no, 'electricity', $request[0], $env_type);
                }
                if (!$OrderIDelec[0]) {
                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $OrderIDelec[1], 'response_data' => $OrderIDelec[2]];
                    $status = 200;
                    return response()->json($response, $status);
                }
            } else {

                $OrderIDgas = self::checkMIRNAddress($request[0]->sale_product_reference_no, $request[0]->vie_dpi_mirn_number, $env_type);

                if (!$OrderIDgas[0]) {

                    if ($request[0]->is_same_gas_connection == 0) {

                        $OrderIDgas = self::checkValidateAddress($request[0]->sale_product_reference_no, 'electricity', $request[0], $env_type);
                    } else {
                        $visitor_gas_connection = DB::table('visitor_addresses')->where('id', $request[0]->l_gas_address_id)->first();
                        $OrderIDgas = self::checkValidateAddress($request[0]->sale_product_reference_no, 'gas', $visitor_gas_connection, $env_type);
                    }
                }

                if (!$OrderIDgas[0]) {

                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $OrderIDgas[1], 'response_data' => $OrderIDgas[2]];
                    $status = 200;
                    return response()->json($response, $status);
                }
            }
        }

        $token = self::getCSRFToken($env_type);

        if ($token != "") {
            $res = self::getOriginResponse($gas_ID, $elec_ID, $is_same, $OrderIDelec[0], $OrderIDgas[0], $token, $request, $env_type);
            return $res;
        }
    }

    public static function checkNMIAddress($reference_no, $nmi_number, $env_type)
    {

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
            'X-CSRF-Token: Fetch'
        );
        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?NMI='" . $nmi_number . "'";
        } else {

            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?NMI='" . $nmi_number . "'";
            } else {
                $url = config('app.origin_dev_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?NMI='" . $nmi_number . "'";
            }
        }

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($cURL);


        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        if (strpos(strip_tags($output), '01fa') !== false) {

            $arr = explode("01fa", strip_tags($output));

            if (isset($arr[0]) && $arr[0] != "" &&  $httpcode != 400) {

                $orderID = $arr[0];

                self::uploadOnS3('check-nmi', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-nmi', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        } else {
            $orderID = 0;
            self::uploadOnS3('check-nmi', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
        }

        $res_arr = array();
        $res_arr = array($orderID, str_replace('%20', ' ', $url), $output);
        return $res_arr;
    }


    public static function uploadOnS3($type, $reference_no, $url, $output, $res, $env_type)
    {
        //Create LOgs and Save in S3 
        $common = new CommonRepository();
        $s3_file_name = '';
        $common->save_log(base_path() . '/storage/logs/origin/' . $type . '/' . date('Y-m-d') . '/' . $type . '.log', ['message' => 'Origin ' . $type . ' logs', 'request' => $url, 'Response' => $output]);

        $local_file_path = realpath(base_path() . '/storage/logs/origin/' . $type . '/' . date('Y-m-d') . '/' . $type . '.log');

        if (file_exists($local_file_path)) {
            $s3_file_name = 'Submission_API/origin/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $reference_no . '/' . $type;
            //move to s3 bucket
            $upload_s3 = \Storage::disk('s3')->put($s3_file_name, file_get_contents($local_file_path), 'private');
        }

        $sale_id = Sale::select('sale_id')->where('reference_no', $reference_no)->first()->sale_id;

        if (config('app.origin_api_log')) {

            if ($env_type != "dev") {
                $apiResponse['visitor_id'] = $sale_id;
                $apiResponse['api_name'] = 'Origin ' . $type;
                $apiResponse['api_reference'] = 'Origin Energy';
                $apiResponse['response_text'] = $res;
                $apiResponse['api_response'] = $output;
                $apiResponse['api_request'] = $url;
                $apiResponse['s3_url'] = $s3_file_name;
                //Save API Response
                //  ApiResponse::Create($apiResponse);
            }
        }
    }

    public static function checkMIRNAddress($reference_no, $mirn_number, $env_type)
    {

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
            'X-CSRF-Token: Fetch'
        );

        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?MIRN='" . $mirn_number . "'";
        } else {

            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?MIRN='" . $mirn_number . "'";
            } else {
                $url = config('app.origin_dev_url') . "sap/opu/odata/SAP/SALES/ValidateSupplyAddressesByExtID?MIRN='" . $mirn_number . "'";
            }
        }

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($cURL);
        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        if (strpos(strip_tags($output), '01fa') !== false) {

            $arr = explode("01fa", strip_tags($output));
            if (isset($arr[0]) && $arr[0] != "" && $httpcode != 400) {
                $orderID = $arr[0];
                self::uploadOnS3('check-mirn', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-mirn', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        } else {

            $orderID = 0;
            self::uploadOnS3('check-mirn', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
        }

        $res_arr = array();
        $res_arr = array($orderID, str_replace('%20', ' ', $url), $output);
        return $res_arr;
    }

    public static function checkValidateAddress($reference_no, $energy_type, $address_arr, $env_type)
    {

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
        );


        //dd($address_arr);

        $house_no = trim($address_arr['street_number'] . $address_arr['street_number_suffix']);
        $street = trim($address_arr['street_name'] . '%20' . $address_arr['street_code'] . '%20' . $address_arr['street_suffix']);
        $city = trim($address_arr['suburb']);
        $post_code   = trim($address_arr['postcode']);
        $state = trim($address_arr['state']);

        $streetType = trim($address_arr['street_code']);
        $RoomNo     = trim($address_arr['unit_no']);
        $RoomType   = trim($address_arr['unit_type_code']);

        $Floor     = trim($address_arr['floor_no']);
        $FloorType   = trim($address_arr['floor_type_code']);

        $LotNo     = trim($address_arr['lot_number']);
        $Building   = trim($address_arr['property_name']);

        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . "sap/opu/odata/sap/SALES/ValidateSupplyAddresses?HouseNo='" . $house_no . "'&Street='" . $street . "'&City='" . $city . "'&PostalCode='" . $post_code . "'&Region='" . $state . "'&CountryID='AU'&StreetType='" . $streetType . "'&RoomNo='" . $RoomNo . "'&RoomType='" . $RoomType . "'&Floor='" . $Floor . "'&FloorType='" . $FloorType . "'&LotNo='" . $LotNo . "'&Building='" . $Building . "'";
        } else {

            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . "sap/opu/odata/sap/SALES/ValidateSupplyAddresses?HouseNo='" . $house_no . "'&Street='" . $street . "'&City='" . $city . "'&PostalCode='" . $post_code . "'&Region='" . $state . "'&CountryID='AU'&StreetType='" . $streetType . "'&RoomNo='" . $RoomNo . "'&RoomType='" . $RoomType . "'&Floor='" . $Floor . "'&FloorType='" . $FloorType . "'&LotNo='" . $LotNo . "'&Building='" . $Building . "'";
            } else {
                $url = config('app.origin_dev_url') . "sap/opu/odata/sap/SALES/ValidateSupplyAddresses?HouseNo='" . $house_no . "'&Street='" . $street . "'&City='" . $city . "'&PostalCode='" . $post_code . "'&Region='" . $state . "'&CountryID='AU'&StreetType='" . $streetType . "'&RoomNo='" . $RoomNo . "'&RoomType='" . $RoomType . "'&Floor='" . $Floor . "'&FloorType='" . $FloorType . "'&LotNo='" . $LotNo . "'&Building='" . $Building . "'";
            }
        }

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, str_replace(' ', '%20', $url));
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($cURL);
        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        if (strpos(strip_tags($output), '01fa') !== false) {
            $arr = explode("01fa", strip_tags($output));
            if (isset($arr[0]) && $arr[0] != "" && $httpcode != 400) {
                $orderID = $arr[0];
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        } else if (strpos(strip_tags($output), '02fa') !== false) {
            $arr = explode("02fa", strip_tags($output));
            if (isset($arr[0]) && $arr[0] != "" && $httpcode != 400) {
                $orderID = $arr[0];
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        } else if (strpos(strip_tags($output), '03fa') !== false) {
            $arr = explode("03fa", strip_tags($output));
            if (isset($arr[0]) && $arr[0] != "" && $httpcode != 400) {
                $orderID = $arr[0];
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        } else {

            $arr = explode("04fa", strip_tags($output));
            if (isset($arr[0]) && $arr[0] != "" && $httpcode != 400) {
                $orderID = $arr[0];
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
            } else {
                $orderID = 0;
                self::uploadOnS3('check-validate-address', $reference_no, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
            }
        }
        $res_arr = array();
        $res_arr = array($orderID, str_replace('%20', ' ', $url), $output);

        return $res_arr;
    }

    public static function getCSRFToken($env_type)
    {

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
            'X-CSRF-Token: Fetch'
        );


        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . "/sap/opu/odata/sap/SALES/FunctionTypes";
        } else {

            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . "/sap/opu/odata/sap/SALES/FunctionTypes";
            } else {
                $url = config('app.origin_dev_url') . "/sap/opu/odata/sap/SALES/FunctionTypes";
            }
        }

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($cURL, CURLOPT_VERBOSE, 1);
        curl_setopt($cURL, CURLOPT_HEADER, 1);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($cURL, CURLINFO_HEADER_OUT, true);


        $output = curl_exec($cURL);
        $header_size = curl_getinfo($cURL, CURLINFO_HEADER_SIZE);
        $headers = substr($output, 0, $header_size);
        $body = substr($output, $header_size);

        //curl_setopt($curlHandle,CURLOPT_COOKIE, $cookieString);

        //echo "<pre>"; print_r($headers);

        $headers = explode("\r\n", $headers); // The seperator used in the Response Header is CRLF (Aka. \r\n) 

        $headers = array_filter($headers);

        //curl_setopt( $curl, CURLOPT_COOKIE, $strCookie );

        //echo "<pre>"; print_r($headers); 

        $csrf_token = substr($headers[10], strpos($headers[10], ":") + 1);

        $csrf_token = $headers[10];

        if (isset($csrf_token) && $csrf_token != "") {
            $csrf_token;
        } else {
            $csrf_token = 0;
        }

        //echo trim($token); exit;


        $x = explode("Set-Cookie: ", $headers[6]);
        $y = explode("set-cookie: ", $headers[7]);
        $z = explode("set-cookie: ", $headers[8]);
        $q = explode("set-cookie: ", $headers[9]);

        $token = [];
        if (isset($x[1])) {
            $token[] = $x[1];
        } else {
            $x = explode("set-cookie: ", $headers[6]);
            $token[] = $x[1];
        }

        if (isset($y[1])) {
            $token[] = $y[1];
        } else {
            $y = explode("Set-Cookie: ", $headers[7]);
            $token[] = $y[1];
        }

        if (isset($z[1])) {
            $token[] = $z[1];
        } else {
            $token[] = $z[0];
        }

        if (isset($q[1])) {
            $token[] = $q[1];
        }

        $token[] = $headers[10];

        return $token;
    }

    public static function getOriginResponse($gas_ID, $elec_ID, $is_same, $OrderIDelec, $OrderIDgas, $token, $leads, $env_type)
    {
        $addressDetails = DB::table('visitor_addresses')->whereIn('id', [$leads[0]->l_billing_address_id, $leads[0]->l_billing_po_box_id, $leads[0]->l_gas_address_id])->get();
        $billingAddress    = null;
        $poBoxAddress      = null;
        $gasAddress        = null;
        if (isset($addressDetails)) {
            foreach ($addressDetails as $addressDetail) {
                if (isset($leads[0]->l_billing_address_id) && $leads[0]->l_billing_address_id == $addressDetail->id) {
                    $billingAddress = $addressDetail;
                }
                if (isset($leads[0]->l_billing_po_box_id) && $leads[0]->l_billing_po_box_id == $addressDetail->id) {
                    $poBoxAddress = $addressDetail;
                }
                if (isset($leads[0]->l_gas_address_id) && $leads[0]->l_gas_address_id == $addressDetail->id) {
                    $gasAddress = $addressDetail;
                }
            }
        }
        if (isset($leads[0]->vie_qa_notes_created_date)) {

            $created_date = explode(" ", $leads[0]->l_sale_created);

            $qa_notes_created_date = str_replace('/', '-', $leads[0]->vie_qa_notes_created_date);

            $qa_notes_created_date = date(DATE_ISO8601, strtotime($qa_notes_created_date . $created_date[1]));

            $qa_notes_created_date = explode("+", $qa_notes_created_date);

            $sale_date_val = $qa_notes_created_date[0];
        } else {

            $AddressStartDate = date(DATE_ISO8601, strtotime($leads[0]->l_sale_created));
            $AddressStartDate = explode("+", $AddressStartDate);
            $sale_date_val = $AddressStartDate[0];
        }

        $moving_house      = $leads[0]['moving_house'];
        $solar_panel       = $leads[0]['solar_panel'];
        $previous_provider = $leads[0]['previous_provider'];
        $current_provider  = $leads[0]['current_provider'];
        $property_type     = $leads[0]['property_type'];

        if ($leads[0]->journey_property_type == 1) {
            $CustomerTypeID = "0001";
        } else {
            $CustomerTypeID = "0002";
        }

        if ($leads[0]->journey_previous_provider_id == $leads[0]->journey_current_provider_id) {
            $IsExistingCustomer = true;
        } else {
            $IsExistingCustomer = false;
        }

        if ($leads[0]->sale_product_product_type == 1) {
            $DivisionID = "01";
        } else {
            $DivisionID = "02";
        }

        if (count($leads) > 1) {
            $ElecDivisionID = "01";
            $GasDivisionID = "02";
        }

        if ($leads[0]->sale_product_is_moving == 1) {

            $ConnectionScenarioID = 'CUST_MOVE';
            $OrderItemType = 'MoveIn';
        } else if ($leads[0]->sale_product_is_moving == 0 && $leads[0]->journey_previous_provider_id != $leads[0]->journey_current_provider_id) {

            $ConnectionScenarioID = 'CUST_SWT';
            $OrderItemType = 'TransferIn';
        } else if ($leads[0]->sale_product_is_moving == 0 && $leads[0]->journey_previous_provider_id == $leads[0]->journey_current_provider_id) {

            $ConnectionScenarioID = 'CUST_PRCH';
            $OrderItemType = 'ProdChange';
        } else if ($leads[0]->journey_previous_provider_id == $leads[0]->journey_current_provider_id) {
            $ConnectionScenarioID = 'CUST_PRCH';
        }
        switch ($leads[0]->v_title) {
            case "Mr":
                $title = "0008";
                break;
            case "Ms":
                $title = "0011";
                break;

            case "MS":
                $title = "0011";
                break;

            case "Miss":
                $title = "0009";
                break;

            case "Sir":
                $title = "0004";
                break;
            case "Dr":
                $title = "0003";
                break;
            case "Mrs":
                $title = "0002";
                break;
            default:
                $title = "0008";
        }

        if ($leads[0]->l_is_po_box) {
            $UseBPCommunicationAddress = true;
        } else {

            if ($leads[0]->l_billing_preference == 2) {
                $UseBPCommunicationAddress = true;
            } else if ($leads[0]->l_billing_preference == 3) {
                $UseBPCommunicationAddress = false;
            } else if ($leads[0]->l_billing_preference == 1) {

                if ($leads[0]->email_welcome_pack == 1) {
                    $UseBPCommunicationAddress = true;
                } else {
                    $UseBPCommunicationAddress = false;
                }
            }
        }

        $data = array();

        $SPAppointmentID = "";
        $ContractAccountNumber = "";

        if ($leads[0]->sale_product_product_type == 1) {
            if ($leads[0]->sale_product_is_moving == 1) {
                if (trim($leads[0]->journey_prefered_move_in_time) == "8am - 1pm") {
                    $SPAppointmentID = "#0800#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "9am - 2pm") {
                    $SPAppointmentID = "#0900#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "10am - 3pm") {
                    $SPAppointmentID = "#1000#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "11am - 4pm") {
                    $SPAppointmentID = "#1100#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "12pm - 5pm") {
                    $SPAppointmentID = "#1200#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "1pm - 6pm") {
                    $SPAppointmentID = "#1300#";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "8am - 11:59am") {
                    $SPAppointmentID = "AM";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "12pm - 6pm") {
                    $SPAppointmentID = "PM";
                } else if (trim($leads[0]->journey_prefered_move_in_time) == "12pm-6pm") {
                    $SPAppointmentID = "PM";
                }
            } else {
                $ContractAccountNumber = $leads[0]->vie_elec_account_number ? $leads[0]->vie_elec_account_number : '';
            }
        } else {
            if ($leads[0]->sale_product_is_moving == 1) {
                $ContractAccountNumber = $leads[0]->vie_gas_account_number ? $leads[0]->vie_gas_account_number : '';
            }
        }

        $data["d"]["OrderType"] = "Contract";
        $data["d"]["ConnectionScenarioID"] = $ConnectionScenarioID;
        $data["d"]["OrderStatus"] = "Submitted";


        $Dateofsale = date(DATE_ISO8601, strtotime($leads[0]->l_sale_created));
        $Dateofsale = explode("+", $Dateofsale);

        $data["d"]["DateOfSale"] = $sale_date_val;

        $data["d"]["CustomerTypeID"] = $CustomerTypeID;
        $data["d"]["IsExistingCustomer"] = $IsExistingCustomer;
        $data["d"]["PartnerReferenceNumber"] = $leads[0]->sale_product_reference_no;
        $data["d"]["OrderItems"]["results"][0]["OrderItemType"] = $OrderItemType;
        if ($leads[0]->sale_product_is_moving == 0)
            $data["d"]["OrderItems"]["results"][0]["ContractAccountNumber"] = $ContractAccountNumber;
        $data["d"]["OrderItems"]["results"][0]["UseBPCommunicationAddress"] = $UseBPCommunicationAddress;
        if ($leads[0]->sale_product_product_type == 1) {
            $data["d"]["OrderItems"]["results"][0]["ProductID"] = $elec_ID;
        } else {
            $data["d"]["OrderItems"]["results"][0]["ProductID"] = $gas_ID;
        }
        if ($leads[0]->sale_product_product_type == 1) {
            $data["d"]["OrderItems"]["results"][0]["OrderAddressID"] = $OrderIDelec;
            $data["d"]["OrderItems"]["results"][0]["SPAppointmentID"] = $SPAppointmentID;
        } else {
            $data["d"]["OrderItems"]["results"][0]["SPAppointmentID"] = "";
            $data["d"]["OrderItems"]["results"][0]["OrderAddressID"] = $OrderIDgas;
            if ($leads[0]['is_same_gas_connection'] == 'no' && count($leads) > 1) {
                $data["d"]["OrderItems"]["results"][0]["OrderAddressID"] = $OrderIDelec;
            }
        }

        $data["d"]["OrderItems"]["results"][0]["DivisionID"] = $DivisionID;

        if (count($leads) > 1) {
            $data["d"]["OrderItems"]["results"][0]["DivisionID"] = $ElecDivisionID;
        }

        if ($leads[0]->l_billing_preference == 1) {
            $IsEmailBilling = true;
        } else {
            $IsEmailBilling = false;
        }
        $data["d"]["OrderItems"]["results"][0]["IsEmailBilling"] = $IsEmailBilling;
        if ($leads[0]->sale_product_product_type == 1) {
            $moving_date = str_replace('/', '-', $leads[0]->journey_moving_date);
            $moving_date = date(DATE_ISO8601, strtotime($moving_date));
            $moving_date = explode("+", $moving_date);
            $data["d"]["OrderItems"]["results"][0]["EffectiveFromDate"] = $moving_date[0];
        }
        if ($leads[0]['energy_type'] == 'electricity') {
            $data["d"]["OrderItems"]["results"][0]["NMI_MIRN"] = $leads[0]->vie_nmi_number;
        } else {
            $data["d"]["OrderItems"]["results"][0]["NMI_MIRN"] = $leads[0]->vie_dpi_mirn_number;
        }

        //Static Content
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["isEasyPay"] = false;
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["Amount"] = "0.000";
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["StartDate"] = null;
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["PaymentCardID"] = "";
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["isDirectDebit"] = false;
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["GranularityID"] = "";
        $data["d"]["OrderItems"]["results"][0]["PaymentPlanInfo"]["BankAccountID"] = "";

        if (count($leads) > 1) {
            //Dual Case

            if ($leads[0]->sale_product_product_type == 1) {

                if ($leads[0]->sale_product_is_moving == 0) {
                    $ContractAccountNumber = $leads[1]->vie_gas_account_number ? $leads[1]->vie_gas_account_number : '';
                }

                $data["d"]["OrderItems"]["results"][1]["SPAppointmentID"] = $SPAppointmentID;
            } else {

                if ($leads[0]->sale_product_is_moving == 0) {
                    $ContractAccountNumber = $leads[1]->vie_gas_account_number ? $leads[1]->vie_gas_account_number : '';
                }

                $data["d"]["OrderItems"]["results"][1]["SPAppointmentID"] = "";
            }

            $data["d"]["OrderItems"]["results"][1]["OrderItemType"] = $OrderItemType;

            if ($leads[0]->sale_product_is_moving == 0)
                $data["d"]["OrderItems"]["results"][1]["ContractAccountNumber"] = $ContractAccountNumber;

            $data["d"]["OrderItems"]["results"][1]["UseBPCommunicationAddress"] = $UseBPCommunicationAddress;
            $data["d"]["OrderItems"]["results"][1]["ProductID"] = $gas_ID;

            $data["d"]["OrderItems"]["results"][1]["OrderAddressID"] = $OrderIDgas;
            if ($leads[0]['is_same_gas_connection'] == 'no') {
                $data["d"]["OrderItems"]["results"][1]["OrderAddressID"] = $OrderIDelec;
            }

            $data["d"]["OrderItems"]["results"][1]["DivisionID"] = $GasDivisionID;
            $data["d"]["OrderItems"]["results"][1]["IsEmailBilling"] = $IsEmailBilling;

            if ($leads[0]->sale_product_is_moving == 1) {

                if ($leads[1]->sale_product_is_moving != '') {
                    $moving_date_gas = str_replace('/', '-', $leads[1]->journey_moving_date);
                    $moving_date_gas = date(DATE_ISO8601, strtotime($moving_date_gas));
                    $moving_date_gas = explode("+", $moving_date_gas);
                    $moving_date_gas_date = $moving_date_gas[0];
                } else {

                    $moving_date_gas = str_replace('/', '-', $leads[0]->journey_moving_date);
                    $moving_date_gas = date(DATE_ISO8601, strtotime($moving_date_gas));
                    $moving_date_gas = explode("+", $moving_date_gas);
                    $moving_date_gas_date = $moving_date_gas[0];
                }

                $data["d"]["OrderItems"]["results"][1]["EffectiveFromDate"] = $moving_date_gas_date;
            }

            if ($leads[1]->sale_product_product_type == 1) {
                $data["d"]["OrderItems"]["results"][1]["NMI_MIRN"] = $leads[0]->vie_nmi_number;
            } else {
                $data["d"]["OrderItems"]["results"][1]["NMI_MIRN"] = $leads[0]->vie_dpi_mirn_number;
            }

            //Static Content
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["isEasyPay"] = false;
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["Amount"] = "0.000";
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["StartDate"] = null;
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["PaymentCardID"] = "";
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["isDirectDebit"] = false;
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["GranularityID"] = "";
            $data["d"]["OrderItems"]["results"][1]["PaymentPlanInfo"]["BankAccountID"] = "";
        }

        if ($leads[0]->va_is_same_gas_connection == 1 && $leads[1]->sale_product_product_type == 2) {
            //Order Address gas_address_id
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StandardFlag"] = false;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["City"] = $gasAddress->suburb;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["District"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["PostalCode"] = $gasAddress->postcode;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBoxPostalCode"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBox"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBoxType"] = "";

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Street"] = $gasAddress->street_name;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StreetType"] = $gasAddress->street_code;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StreetSuffix"] = $gasAddress->street_suffix;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["HouseNo"] = $gasAddress->street_number . $gasAddress->street_number_suffix;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["LotNo"] = $gasAddress->lot_number;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Building"] = $gasAddress->property_name;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Floor"] = $gasAddress->floor_no;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["FloorType"] = $gasAddress->floor_type_code;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["RoomNo"] = $gasAddress->unit_no;

            // if ($leads[0]['visitor_gas_connection']['unit_type_code'] == "") {

            //     $leads[0]['visitor_gas_connection']['unit_type_code'] = "";
            // }
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["RoomType"] = $gasAddress->unit_type_code;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["CountryID"] = "AU";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Region"] = $gasAddress->state;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["TimeZone"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["TaxJurisdictionCode"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["LanguageID"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["ShortForm"] = "";

            $IsQASValid = false;
            $DPID = "";
            if ($gasAddress->is_qas_valid) {
                $IsQASValid = true;
                if ($gasAddress->connection_dpid != "")
                    $DPID = $gasAddress->connection_dpid;
            }

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["IsQASValid"] = $IsQASValid;


            $data["d"]["OrderAddresses"]["results"][0]["Address"]["DPID"] = $DPID;
        } else {

            //Order Address
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StandardFlag"] = false;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["City"] = $leads[0]->va_suburb;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["District"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["PostalCode"] = $leads[0]->va_postcode;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBoxPostalCode"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBox"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["POBoxType"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Street"] = $leads[0]->va_street_name;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StreetType"] = $leads[0]->va_street_code;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["StreetSuffix"] = $leads[0]->va_street_suffix;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["HouseNo"] = $leads[0]->va_street_number . $leads[0]->va_street_number_suffix;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["LotNo"] = $leads[0]->va_lot_number;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Building"] = $leads[0]->va_property_name;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Floor"] = $leads[0]->va_floor_no;


            if ($leads[0]->ua_floor_type_code == "") {

                $leads[0]['visitor_connection_address']['floor_type_code'] = "";
            }

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["FloorType"] = $leads[0]->va_floor_type_code;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["RoomNo"] = $leads[0]->va_unit_no;


            if ($leads[0]['visitor_connection_address']['unit_type_code'] == "") {

                $leads[0]['visitor_connection_address']['unit_type_code'] = "";
            }


            $data["d"]["OrderAddresses"]["results"][0]["Address"]["RoomType"] = $leads[0]->va_unit_type_code;

            $data["d"]["OrderAddresses"]["results"][0]["Address"]["CountryID"] = "AU";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["Region"] = $leads[0]->va_state;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["TimeZone"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["TaxJurisdictionCode"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["LanguageID"] = "";
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["ShortForm"] = "";

            $IsQASValid = false;
            $DPID = "";
            if ($leads[0]->va_is_qas_valid) {
                $IsQASValid = true;
                if ($leads[0]->va_dpid != "")
                    $DPID = $leads[0]->va_dpid;
            }


            $data["d"]["OrderAddresses"]["results"][0]["Address"]["IsQASValid"] = $IsQASValid;
            $data["d"]["OrderAddresses"]["results"][0]["Address"]["DPID"] = $DPID;
        }

        if ($leads[0]->sale_product_product_type == 1) {
            $data["d"]["OrderAddresses"]["results"][0]["OrderAddressID"] = $OrderIDelec;
        } else {

            $data["d"]["OrderAddresses"]["results"][0]["OrderAddressID"] = $OrderIDgas;
            if (isset($leads[0]->va_is_same_gas_connection) && $leads[0]->va_is_same_gas_connection == 1 && count($leads) > 1) {
                $data["d"]["OrderAddresses"]["results"][0]["OrderAddressID"] = $OrderIDelec;
            }
        }

        $data["d"]["OrderAddresses"]["results"][0]["IsPrimaryResidence"] = false;
        if ($leads[0]->vcd_concession_type != "Not Applicable") {
            $data["d"]["OrderAddresses"]["results"][0]["IsPrimaryResidence"] = true;
        }

        if ($leads[0]->vie_is_any_access_issue) {
            $data["d"]["OrderAddresses"]["results"][0]["IsAccessRequirement"] = true;
        } else {
            $data["d"]["OrderAddresses"]["results"][0]["IsAccessRequirement"] = false;
        }

        $data["d"]["OrderAddresses"]["results"][0]["IsUnrestrainedAnimal"] = false;

        $IsLifeSupport = false;
        if ($leads[0]['medical_equipment'] == 'yes') {
            $IsLifeSupport = true;
        }

        $data["d"]["OrderAddresses"]["results"][0]["IsLifeSupport"] = $IsLifeSupport;

        if ($leads[0]->vie_is_elec_work) {
            $data["d"]["OrderAddresses"]["results"][0]["IsElectricalWork"] = true;
        } else {
            $data["d"]["OrderAddresses"]["results"][0]["IsElectricalWork"] = false;
        }

        $data["d"]["OrderAddresses"]["results"][0]["HouseSize"] = 0;

        if (count($leads) > 1) {

            if ($leads[0]['visitor_information']['site_access_electricity'] == "") {
                $leads[0]['visitor_information']['site_access_electricity'] = "";
            }

            $data["d"]["OrderAddresses"]["results"][0]["AdditionalAccessInformation"] = $leads[0]->vie_site_access_electricity;
        } else {
            if ($leads[0]->sale_product_product_type == 1) {

                if ($leads[0]['visitor_information']['site_access_electricity'] == "") {
                    $leads[0]['visitor_information']['site_access_electricity'] = "";
                }

                $data["d"]["OrderAddresses"]["results"][0]["AdditionalAccessInformation"] = $leads[0]->vie_site_access_electricity;
            } else {

                if ($leads[0]['visitor_information']['site_access_gas'] == "") {
                    $leads[0]['visitor_information']['site_access_gas'] = "";
                }

                $data["d"]["OrderAddresses"]["results"][0]["AdditionalAccessInformation"] = $leads[0]->vie_site_access_gas;
            }
        }
        if (count($leads) > 1) {
            //Order with Different Address 
            if ($leads[0]->va_is_same_gas_connection == 1 && isset($gasAddress)) {
                //Order Address
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["StandardFlag"] = false;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["City"] = $gasAddress->suburb;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["District"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["PostalCode"] = $gasAddress->postcode;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["POBoxPostalCode"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["POBox"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["POBoxType"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["Street"] = $gasAddress->street_name;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["StreetType"] = $gasAddress->street_code;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["StreetSuffix"] = $gasAddress->street_suffix;

                $data["d"]["OrderAddresses"]["results"][1]["Address"]["HouseNo"] = $gasAddress->street_number . $gasAddress->street_number_suffix;

                $data["d"]["OrderAddresses"]["results"][1]["Address"]["LotNo"] = $gasAddress->lot_number;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["Building"] = $gasAddress->property_name;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["Floor"] = $gasAddress->floor_no;


                // if ($leads[0]['visitor_gas_connection']['floor_type_code'] == "") {

                //     $leads[0]['visitor_gas_connection']['floor_type_code'] = "";
                // }
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["FloorType"] = $gasAddress->floor_type_code;


                $data["d"]["OrderAddresses"]["results"][1]["Address"]["RoomNo"] = $gasAddress->unit_no;

                // if ($leads[0]['visitor_gas_connection']['unit_type_code'] == "") {

                //     $leads[0]['visitor_gas_connection']['unit_type_code'] = "";
                // }


                $data["d"]["OrderAddresses"]["results"][1]["Address"]["RoomType"] = $gasAddress->unit_type_code;

                $data["d"]["OrderAddresses"]["results"][1]["Address"]["CountryID"] = "AU";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["Region"] = $gasAddress->state;
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["TimeZone"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["TaxJurisdictionCode"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["LanguageID"] = "";
                $data["d"]["OrderAddresses"]["results"][1]["Address"]["ShortForm"] = "";

                $IsQASValid = false;
                $DPID = "";
                if ($gasAddress->is_qas_valid) {
                    $IsQASValid = true;
                    if ($gasAddress->connection_dpid != "")
                        $DPID = $gasAddress->connection_dpid;
                }

                $data["d"]["OrderAddresses"]["results"][1]["Address"]["IsQASValid"] = $IsQASValid;

                $data["d"]["OrderAddresses"]["results"][1]["Address"]["DPID"] = $DPID;


                if ($leads[1]->sale_product_product_type == 1) {
                    $data["d"]["OrderAddresses"]["results"][1]["OrderAddressID"] = $OrderIDelec;
                } else {

                    $data["d"]["OrderAddresses"]["results"][1]["OrderAddressID"] = $OrderIDgas;
                    if ($leads[0]['is_same_gas_connection'] == 'no') {
                        $data["d"]["OrderAddresses"]["results"][1]["OrderAddressID"] = $OrderIDelec;
                    }
                }

                $data["d"]["OrderAddresses"]["results"][1]["IsPrimaryResidence"] = false;
                if ($leads[0]->vcd_concession_type != "Not Applicable") {
                    $data["d"]["OrderAddresses"]["results"][1]["IsPrimaryResidence"] = true;
                }

                if ($leads[0]->vie_is_any_access_issue) {
                    $data["d"]["OrderAddresses"]["results"][1]["IsAccessRequirement"] = true;
                } else {
                    $data["d"]["OrderAddresses"]["results"][1]["IsAccessRequirement"] = false;
                }

                $data["d"]["OrderAddresses"]["results"][1]["IsUnrestrainedAnimal"] = false;

                $IsLifeSupport = false;
                $data["d"]["OrderAddresses"]["results"][1]["IsLifeSupport"] = $IsLifeSupport;
                $data["d"]["OrderAddresses"]["results"][0]["IsLifeSupport"] = $IsLifeSupport;
                if ($leads[0]['medical_equipment'] == 'yes') {
                    $IsLifeSupport = true;
                    if ($leads[0]['medical_equipment_energytype'] == 1 && $leads[1]['medical_equipment_energytype'] == 1) {
                        $IsLifeSupport = true;
                        $data["d"]["OrderAddresses"]["results"][1]["IsLifeSupport"] = $IsLifeSupport;
                        $data["d"]["OrderAddresses"]["results"][0]["IsLifeSupport"] = $IsLifeSupport;
                    } else if ($leads[0]['medical_equipment_energytype'] == 1 && $leads[1]['medical_equipment_energytype'] == 0) {
                        $data["d"]["OrderAddresses"]["results"][0]["IsLifeSupport"] = true;
                        $data["d"]["OrderAddresses"]["results"][1]["IsLifeSupport"] = false;
                    } else {
                        $data["d"]["OrderAddresses"]["results"][0]["IsLifeSupport"] = false;
                        $data["d"]["OrderAddresses"]["results"][1]["IsLifeSupport"] = true;
                    }
                }

                // $data["d"]["OrderAddresses"]["results"][1]["IsLifeSupport"] = $IsLifeSupport;

                if ($leads[0]->vie_is_elec_work) {
                    $data["d"]["OrderAddresses"]["results"][1]["IsElectricalWork"] = true;
                } else {
                    $data["d"]["OrderAddresses"]["results"][1]["IsElectricalWork"] = false;
                }

                $data["d"]["OrderAddresses"]["results"][1]["HouseSize"] = 0;

                // if ($leads[0]['visitor_information']['site_access_gas'] == "") {
                //     $leads[0]['visitor_information']['site_access_gas'] = "";
                // }

                $data["d"]["OrderAddresses"]["results"][1]["AdditionalAccessInformation"] = $leads[0]->vie_site_access_gas;
            }
        }

        $dob = date(DATE_ISO8601, strtotime($leads[0]->v_dob));
        $dob = explode("+", $dob);

        if ($leads[0]->journey_property_type == 1) {
            //Customer Info Data 
            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["Title"] = $title;
            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["FirstName"] = $leads[0]->v_first_name;
            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["LastName"] = $leads[0]->v_last_name;

            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["DateOfBirth"] = $dob[0];

            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["DriversLicence"] = $leads[0]->vi_licence_number;
            $data["d"]["CustomerInfo"]["ResidentialCustomerInfo"]["DriversLicenceRegion"] =  $leads[0]->vi_licence_state_code;
        } else {

            $data["d"]["CustomerInfo"]["BusinessCustomerInfo"]["BusinessName"] = $leads[0]->vbd_business_legal_name;
            $data["d"]["CustomerInfo"]["BusinessCustomerInfo"]["ABN"] = $leads[0]->vbd_business_abn;
            $data["d"]["CustomerInfo"]["BusinessCustomerInfo"]["ACN"] = "";
        }

        $is_CorrespondenceAddress = 1;

        if ($leads[0]->l_billing_preference == 2) {
            $is_CorrespondenceAddress = 2;
        }
        if ($leads[0]->l_billing_preference == 1) {
            if ($leads[0]->email_welcome_pack != 1) {
                $is_CorrespondenceAddress = 2;
            }
        }
        if (isset($leads[0]->l_billing_po_box_id) && !empty($leads[0]->l_billing_po_box_id)) {
            $is_CorrespondenceAddress = 1;
        }

        if ($is_CorrespondenceAddress) {

            if ($is_CorrespondenceAddress == 2) {

                //Order Address
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StandardFlag"] = false;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["City"] = $leads[0]->va_suburb;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["District"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["PostalCode"] = $leads[0]->va_postcode;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxPostalCode"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBox"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxType"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Street"] = $leads[0]->va_street_name;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetType"] = $leads[0]->va_street_code;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetSuffix"] = $leads[0]->va_street_suffix;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["HouseNo"] = $leads[0]->va_street_number . $leads[0]->va_street_number_suffix;

                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LotNo"] = $leads[0]['visitor_connection_address']->va_lot_number;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Building"] = $leads[0]->va_property_name;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Floor"] = $leads[0]->va_floor_no;

                if ($leads[0]['visitor_connection_address']['floor_type_code'] == "") {
                    $leads[0]['visitor_connection_address']['floor_type_code'] = "";
                }

                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["FloorType"] = $leads[0]->va_floor_type_code;


                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomNo"] = $leads[0]->va_unit_no;


                if ($leads[0]['visitor_connection_address']['unit_type_code'] == "") {

                    $leads[0]['visitor_connection_address']['unit_type_code'] = "";
                }


                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomType"] = $leads[0]->va_unit_type_code;

                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["CountryID"] = "AU";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Region"] = $leads[0]->va_state;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TimeZone"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TaxJurisdictionCode"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LanguageID"] = "";
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["ShortForm"] = "";

                $IsQASValid = false;
                $DPID = "";
                if ($leads[0]->va_is_qas_valid) {
                    $IsQASValid = true;
                    if ($leads[0]['visitor_connection_address']['connection_dpid'] != "")
                        $DPID = $leads[0]->va_dpid;
                }


                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["IsQASValid"] = $IsQASValid;
                $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["DPID"] = $DPID;
            } else {

                if ($leads[0]->l_is_po_box ==  1 && !empty($leads[0]->l_is_po_box)) {

                    //Order Address
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StandardFlag"] = false;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["City"] = $poBoxAddress->suburb;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["District"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["PostalCode"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxPostalCode"] = $poBoxAddress->postcode;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBox"] = $poBoxAddress->address;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxType"] = "10";

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Street"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetType"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetSuffix"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["HouseNo"] = "";

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LotNo"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Building"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Floor"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["FloorType"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomNo"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomType"] = "";

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["CountryID"] = "AU";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Region"] = $poBoxAddress->state;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TimeZone"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TaxJurisdictionCode"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LanguageID"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["ShortForm"] = "";

                    $IsQASValid = false;
                    $DPID = "";
                    if ($poBoxAddress->is_qas_valid) {
                        $IsQASValid = true;
                        if ($poBoxAddress->connection_dpid != "")
                            $DPID = $poBoxAddress->connection_dpid;
                    }
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["IsQASValid"] = $IsQASValid;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["DPID"] = $DPID;
                } else if ($leads[0]->l_billing_preference) {
                    if ($leads[0]->email_welcome_pack == 1) {

                        //Order Address
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StandardFlag"] = false;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["City"] = $billingAddress->suburb;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["District"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["PostalCode"] = $billingAddress->postcode;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxPostalCode"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBox"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxType"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Street"] = $billingAddress->street_name;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetType"] =
                            isset($billingAddress->street_code) ? $billingAddress->street_code : "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetSuffix"] = $billingAddress->street_suffix;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["HouseNo"] = $$billingAddress->street_number . $billingAddress->street_number_suffix;

                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LotNo"] = $billingAddress->lot_number;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Building"] = $billingAddress->property_name;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Floor"] = $billingAddress->floor_no;

                        // if ($leads[0]['visitor_email_welcome_address']['floor_type_code'] == "") {
                        //     $leads[0]['visitor_email_welcome_address']['floor_type_code'] = "";
                        // }

                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["FloorType"] = isset($billingAddress->floor_type_code) ? $billingAddress->floor_type_code : '';


                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomNo"] = $billingAddress->unit_no;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomType"] = isset($billingAddress->unit_type_code) ? $billingAddress->unit_type_code : '';

                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["CountryID"] = "AU";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Region"] = $billingAddress->state;
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TimeZone"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TaxJurisdictionCode"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LanguageID"] = "";
                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["ShortForm"] = "";

                        $IsQASValid = false;
                        $DPID = "";
                        if ($billingAddress->is_qas_valid) {
                            $IsQASValid = true;
                            if ($billingAddress->connection_dpid != "")
                                $DPID = $billingAddress->connection_dpid;
                        }


                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["IsQASValid"] = $IsQASValid;

                        $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["DPID"] = $DPID;
                    }
                } else if ($leads[0]['billing_option_selected'] == 'yes') {

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StandardFlag"] = false;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["City"] = $billingAddress->suburb;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["District"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["PostalCode"] = $poBoxAddress->postcode;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxPostalCode"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBox"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["POBoxType"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Street"] = $billingAddress->street_name;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetType"] =
                        isset($billingAddress->street_code) ? $billingAddress->street_code : "";;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["StreetSuffix"] = $billingAddress->street_suffix;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["HouseNo"] = $$billingAddress->street_number . $billingAddress->street_number_suffix;

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LotNo"] = $billingAddress->lot_number;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Building"] = $billingAddress->property_name;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Floor"] = $billingAddress->floor_no;

                    // if ($leads[0]['visitor_billing_address']['floor_type_code'] == "") {

                    //     $leads[0]['visitor_billing_address']['floor_type_code'] = "";
                    // }


                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["FloorType"]
                        = isset($billingAddress->floor_type_code) ? $billingAddress->floor_type_code : '';;


                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomNo"] = $billingAddress->unit_no;


                    if ($leads[0]['visitor_billing_address']['unit_type_code'] == "") {

                        $leads[0]['visitor_billing_address']['unit_type_code'] = "";
                    }

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["RoomType"] = isset($billingAddress->unit_type_code) ? $billingAddress->unit_type_code : '';

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["CountryID"] = "AU";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["Region"] = $billingAddress->state;
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TimeZone"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["TaxJurisdictionCode"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["LanguageID"] = "";
                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["ShortForm"] = "";

                    $IsQASValid = false;
                    $DPID = "";
                    if ($billingAddress->is_qas_valid) {
                        $IsQASValid = true;
                        if ($billingAddress->connection_dpid != "")
                            $DPID = $billingAddress->connection_dpid;
                    }

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["IsQASValid"] = $IsQASValid;

                    $data["d"]["CustomerInfo"]["CorrespondenceAddress"]["DPID"] = $DPID;
                }
            }
        }

        if ($leads[0]->vcd_concession_type != "Not Applicable") {
            //If property Type resident
            if ($leads[0]->journey_property_type == 1) {
                //ConcessionCardInfo
                switch ($leads[0]->vcd_concession_type) {
                    case "Commonwealth Senior Health Card":
                        $concession_type = "HCC";
                        break;
                    case "DVA Gold Card (Extreme Disablement Adjustment)":
                        $concession_type = "DVA";
                        break;
                    case "DVA Gold Card (TPI)":
                        $concession_type = "DVA";
                        break;

                    case "DVA Gold Card (War Widow)":
                        $concession_type = "DVA";
                        break;

                    case "Commonwealth Senior Health Card":
                        $concession_type = "HCC";
                        break;

                    case "DVA Gold Card(War Widow)":
                        $concession_type = "DVA";
                        break;

                    case "DVA Gold Card(TPI)":
                        $concession_type = "DVA";
                        break;

                    case "DVA Gold Card(Extreme Disablement Adjustment)":
                        $concession_type = "DVA";
                        break;

                    case "DVA Gold Card":
                        $concession_type = "DVA";
                        break;

                    case "DVA Pensioner Concession Card":
                        $concession_type = "PCC";
                        break;

                    case "DVA Pension Concession Card":
                        $concession_type = "PCC";
                        break;

                    case "Centrelink Healthcare Card":
                        $concession_type = "HCC";
                        break;

                    case "Pensioner Concession Card":
                        $concession_type = "PCC";
                        break;
                    case "Queensland Government Seniors Card":
                        $concession_type = "QSC";
                        break;

                    default:
                        $concession_type = "Not Applicable";
                }
                $data["d"]["CustomerInfo"]["ConcessionCardInfo"]["CardTypeID"] = $concession_type;
                $data["d"]["CustomerInfo"]["ConcessionCardInfo"]["CardNumber"] = $leads[0]->vcd_card_number;

                $card_start_date = str_replace('/', '-', $leads[0]->vcd_card_start_date);
                $card_expiry_date = str_replace('/', '-', $leads[0]->vcd_card_expiry_date);

                $card_start_date = date(DATE_ISO8601, strtotime($card_start_date));
                $card_expiry_date = date(DATE_ISO8601, strtotime($card_expiry_date));

                $card_start_date = explode("+", $card_start_date);
                $card_expiry_date = explode("+", $card_expiry_date);

                $data["d"]["CustomerInfo"]["ConcessionCardInfo"]["StartDate"] = $card_start_date[0];
                $data["d"]["CustomerInfo"]["ConcessionCardInfo"]["EndDate"] = $card_expiry_date[0];
            }
        }

        $data["d"]["CustomerInfo"]["CustomerIdentifier"] = "";
        $data["d"]["CustomerInfo"]["Type"] = $CustomerTypeID;
        $data["d"]["CustomerInfo"]["AddressStartDate"] = $sale_date_val;
        $IsEmailPrefCorrChannel = false;
        if ($leads[0]->l_billing_preference == 1) {
            $IsEmailPrefCorrChannel = true;
        }

        $data["d"]["CustomerInfo"]["IsEmailPrefCorrChannel"] = $IsEmailPrefCorrChannel;


        $data["d"]["CustomerInfo"]["EnableMarketingOffers"] = true;
        //PhoneNumbers
        $data["d"]["CustomerInfo"]["PhoneNumbers"]["results"][0]["PhoneNumber"] = $leads[0]->v_phone;
        $data["d"]["CustomerInfo"]["PhoneNumbers"]["results"][0]["TypeID"] = "3";
        $data["d"]["CustomerInfo"]["PhoneNumbers"]["results"][0]["IsDefault"] = true;
        $data["d"]["CustomerInfo"]["PhoneNumbers"]["results"][0]["PhoneType"]["TypeID"] = "3";
        $data["d"]["CustomerInfo"]["PhoneNumbers"]["results"][0]["PhoneType"]["Description"] = "Mobile";
        //Email
        $data["d"]["CustomerInfo"]["Emails"]["results"][0]["Email"] = $leads[0]->v_email;
        $data["d"]["CustomerInfo"]["Emails"]["results"][0]["IsDefault"] = true;


        if ($leads[0]->journey_property_type == 1) {

            if ($leads[0]->vie_is_connection_joint_account_holder == 1) {

                switch ($leads[0]->vie_joint_acc_holder_title) {
                    case "Mr":
                        $joint_title = "0008";
                        break;
                    case "Ms":
                        $joint_title = "0011";
                        break;

                    case "MS":
                        $joint_title = "0011";
                        break;

                    case "Miss":
                        $joint_title = "0009";
                        break;

                    case "Sir":
                        $joint_title = "0004";
                        break;
                    case "Dr":
                        $joint_title = "0003";
                        break;
                    case "Mrs":
                        $joint_title = "0002";
                        break;
                    default:
                        $joint_title = "0008";
                }


                $joint_dob = date(DATE_ISO8601, strtotime($leads[0]->vie_joint_acc_holder_dob));
                $joint_dob = explode("+", $joint_dob);


                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Title"] = $joint_title;
                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["FirstName"] = $leads[0]->vie_joint_acc_holder_first_name;
                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["LastName"] = $leads[0]->vie_joint_acc_holder_last_name;
                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["DateOfBirth"] = $joint_dob[0];
                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["FunctionTypeID"] = "1";



                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["ContactIdentifier"] = "";

                $HomePhone = "";
                if ($leads[0]->vie_joint_acc_holder_home_phone_no != "") {
                    $HomePhone = $leads[0]->vie_joint_acc_holder_home_phone_no;
                }

                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["HomePhone"] = $HomePhone;
                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Mobile"] = $HomePhone;

                $alternate_phone = "";
                if (isset($leads[0]->vie_joint_acc_holder_office_phone_no)) {

                    if ($leads[0]->vie_joint_acc_holder_office_phone_no != "") {
                        $alternate_phone = $leads[0]->vie_joint_acc_holder_office_phone_no;
                    }
                }

                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["OfficePhone"] = $alternate_phone;

                $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Email"] = $leads[0]->vie_joint_acc_holder_email;
            }
        } else {


            //ContactPersons
            //$dob = date(DATE_ISO8601, strtotime($leads[0]['dob']));

            //echo "<pre>"; print_r($dob[0]);exit;  
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Title"] = $title;
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["FirstName"] = $leads[0]->v_first_name;
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["LastName"] = $leads[0]->v_last_name;
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["DateOfBirth"] = $dob[0];
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["FunctionTypeID"] = "1";
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["ContactIdentifier"] = "";

            $HomePhone = "";
            if ($leads[0]->v_alternate_phone != "") {
                $HomePhone = $leads[0]->v_alternate_phone;
            }

            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["HomePhone"] = $HomePhone;
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Mobile"] = $leads[0]->v_phone;

            $alternate_phone = "";
            if (isset($leads[0]['visitor_business_detail']['customer_work_contact'])) {

                if ($leads[0]['visitor_business_detail']['customer_work_contact'] != "") {
                    $alternate_phone = $leads[0]['visitor_business_detail']['customer_work_contact'];
                }
            }
            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["OfficePhone"] = $alternate_phone;

            $data["d"]["CustomerInfo"]["ContactPersons"]["results"][0]["Email"] = $leads[0]->v_email;
        }

        $data = str_replace("\u200b", "", json_encode($data));

        //echo $data; exit;

        if (config('app.origin_production')) {

            if ($env_type == 'production') {
                $username = config('app.origin_username');
                $password = config('app.origin_password');
            } else {
                $username = 'CIMT_API_AWS';
                $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
            }
        } else {
            $username = 'CIMT_API_AWS';
            $password = 'CdqwWYmyAmbQX5F4d7SxL7G6ke';
        }

        $token_val = explode(":", $token[4]);
        $token_val = trim($token_val[1]);

        $headers = array(
            'Authorization: Basic ' . base64_encode("$username:$password"),
            'X-CSRF-Token: ' . $token_val,
            'Content-Type: application/json'
        );

        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . "/sap/opu/odata/sap/SALES/OrderHeaders";
        } else {

            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . "/sap/opu/odata/sap/SALES/OrderHeaders";
            } else {
                $url = config('app.origin_dev_url') . "/sap/opu/odata/sap/SALES/OrderHeaders";
            }
        }


        $cookies = array('Set-Cookie' => $token[0]);
        //echo "<pre>"; print_r($headers); exit;
        //echo "<pre>"; print_r($token); exit;

        $cookies_1 = explode(";", $token[0]);
        $cookies_2 = explode(";", $token[1]);
        $cookies_3 = explode(";", $token[2]);
        $cookies_4 = explode(";", $token[3]);

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
        //send json here
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $data);


        curl_setopt($cURL, CURLOPT_COOKIE, $cookies_1[0] . '; ' . $cookies_2[0] . '; ' . $cookies_3[0] . '; ' . $cookies_4[0] . '; ');

        $output = curl_exec($cURL);
        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        curl_close($cURL);

        if ($httpcode != 400)
            self::uploadOnS3('Submit-origin-API', $leads[0]['reference_no'], $data, $output, 'Connected', $env_type);
        else
            self::uploadOnS3('Submit-origin-API', $leads[0]['reference_no'], $data, $output, 'Failure', $env_type);


        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $data, 'response_data' => $output, 'status_code' => $httpcode];

        $status = $httpcode;
        return response()->json($response, $status);
    }


    public static function checkSaleStatus($reference_no, $sale_id, $env_type = 'production')
    {
        $username = config('app.origin_username');
        $password = config('app.origin_password');
        $headers = array('Authorization: Basic ' . base64_encode("$username:$password"),);
        $ref_no = "'" . $reference_no . "'";
        if ($env_type == "dev") {
            $url = config('app.origin_dev_url') . 'sap/opu/odata/sap/SALES/OrderItemStatuses?$filter=ReferenceNumber%20eq%20' . $ref_no . '';
        } else {
            if (config('app.origin_production')) {
                $url = config('app.origin_production_url') . 'sap/opu/odata/sap/SALES/OrderItemStatuses?$filter=ReferenceNumber%20eq%20' . $ref_no . '';
            } else {
                $url = config('app.origin_dev_url') . 'sap/opu/odata/sap/SALES/OrderItemStatuses?$filter=ReferenceNumber%20eq%20' . $ref_no . '';
            }
        }
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($cURL);
        $httpcode = curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        curl_close($cURL);
        if ($httpcode != 400)
            self::uploadOnS3('Check-Sale-Status', $sale_id, str_replace('%20', ' ', $url), $output, 'Connected', $env_type);
        else
            self::uploadOnS3('Check-Sale-Status', $sale_id, str_replace('%20', ' ', $url), $output, 'Failure', $env_type);
        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => str_replace('%20', ' ', $url), 'response_data' => $output, 'status_code' => $httpcode];
        $status = $httpcode;
        return response()->json($response, $status);
    }
}
