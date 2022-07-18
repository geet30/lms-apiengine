<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('loginTokenx')) {

    function loginTokenx($request, $senderId, $num, $message, $smsType)
    {
        $response = [];
        try {
            $url = config('url.sms_login');

            $header = [
                'Content-Type'     => 'application/json',
                'API-KEY'      => config('env.AFFILIATE_API_KEY')
            ];

            $bodyData = [
                'service_id' => $request->serviceId
            ];

            $client = new \GuzzleHttp\Client();
            $responses = $client->request('POST', $url, [
                'headers' => $header,
                'body' => json_encode($bodyData),
                'http_errors' => false
            ]);

            if ($responses->getStatusCode() == 200) {
                $data =  json_decode($responses->getBody());
                if ($smsType == 'plivo')
                    $smsApiUrl = config('url.plivo_api_url');
                if ($smsType == 'twillio')
                    $smsApiUrl = config('url.twilio_api_url');
                return sendSmsLambda($request, $senderId, $data->token, $smsApiUrl, $num, $message);
            } else {
                $http_status = 400;
                $response['message'] = "Token not found.";
                $response['status'] = $http_status;
            }
            return $response;
        } catch (\Exception $err) {
            $response['message'] = $err->getMessage();
            $response['status'] = 400;
            return $response;
        }
    }
}
if (!function_exists('sendSmsLambda')) {

    function sendSmsLambda($request, $senderId, $auth_token, $apiUrl, $contactNo, $message)
    {
        $bodyData = [
            'phonenumber' => $contactNo,
            'content' => $message,
            'senderid' => $senderId,
            'service_id' => $request->serviceId,
            'lead_id' => encryptGdprData($request->leadId)
        ];
        $header = [
            'authorization' => 'Bearer ' . $auth_token,
            'API-KEY' => config('env.AFFILIATE_API_KEY'),
            'Content-Type' => 'application/json'
        ];
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $apiUrl, [
            'headers' => $header,
            'body' => json_encode($bodyData),
            'http_errors' => false
        ]);
        if ($response->getStatusCode() == 200) {
            $data =  json_decode($response->getBody());
            $result = array('status' => 200, 'response' => $data);
        } else {
            $result['message'] = "Token not found.";
            $result['status'] = 400;
        }
        return $result;
    }
}
if (!function_exists('actionSalesQaLogs')) {
    function actionSalesQaLogs($data)
    {
        switch ($data) {
            case "1":
                return "Assigned QA";
                break;
            case "2":
                return "Assigned Collaborators";
                break;
            case "3":
                return "Un-assigned QA";
                break;
            case "4":
                return "Un-assigned Collaborators";
                break;
            case "5":
                return "Start QA";
                break;
            case "6":
                return "End QA";
                break;
            case "7":
                return "Pause/Hold QA";
                break;
            default:
            return "N/A";
        }
    }
}
