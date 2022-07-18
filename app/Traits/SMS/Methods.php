<?php

namespace App\Traits\Sms;

use Illuminate\Support\Facades\{DB, Crypt};
use App\Models\{SmsLog};
use App\Repositories\SparkPost\NodeMailer;

/**
 * SMS methods model.
 * Author: Sandeep Bangarh
 */

trait Methods
{
    // public static function createSms($senderId, $destination, $message, $smsType, $leadId)
    public static function createSms($request)
    {
        $request = request();
        try {
            if($request->method_content != null){
                $request->senderId = $request->method_content;
            }
            if($request->plivo_number != null){
                $request->senderId = $request->plivo_number;
            }
            // if request number exists in temp array then return true.
            // if (in_array($request->sms_to, config('numbers.temporary_mobile_numbers'))) {
            //     return ['status' => true, 'response' => 'number in saved in preserved list.'];
            // }
            $destination = $request->sms_to;
            $envoirnment = env('ENVIRONMENT', 'production');
            // if (!$request->has('otp_type')) {
            //     $destination = decryptGdprData($destination);
            // }
            $num = $destination;
            
            if ($envoirnment == 'production') {
                if (substr($destination, 0, 1) == 0) {
                    $num = '61' . substr($destination, 1);
                } elseif (substr($destination, 0, 2) == 61) {
                    $num = $destination;
                } else {
                    $num = '61' . $destination;
                }
            }
            $pivilioResponse = loginTokenx($request, $request->senderId, $num, $request->message, $request->smsType);
            $errorCodeArray = [400, 401, 404, 405, 500];

            //when there is an error sending sms using plivo, then send message using twilio
            if (isset($pivilioResponse['status']) && in_array($pivilioResponse['status'], $errorCodeArray)) {
                $reason = 'There is an Exception.';
                if (isset($pivilioResponse['response']['error'])) {
                    $reason = $pivilioResponse['response']['error'];
                }
            }
            $sendSms = [];
            $sendSms['affiliate_id']   = $request->userId;
            $sendSms['service_id']   = $request->leadId;
            $sendSms['api_name']   = "plivo";
            $sendSms['api_status'] = '';
            $sendSms['api_response'] = $pivilioResponse['status'];
            $sendSms['api_request'] = json_encode($pivilioResponse);
            $sendSms['phone'] = '';
            // SmsLog::create($sendSms);
            if (isset($reason)) {
                return ['status' => false, 'response' => $reason];
            }
            return ['status' => true, 'response' => $pivilioResponse];
        } catch (\Exception $err) {
            throw new \Exception($err->getMessage(), 0, $err);
        }
    }
}
