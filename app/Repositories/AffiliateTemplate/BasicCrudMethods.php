<?php

namespace App\Repositories\AffiliateTemplate;

use App\Models\{Affiliate, AffiliateThirdPartyApi, AffiliateTemplate};
use App\Repositories\SparkPost\SparkPost;
use App\Repositories\Sms\Sms;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait BasicCrudMethods
{
    /**
     *save or update affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function  saveUpdateEmailTemplate($request)
    {
        try {
            $url = $request->user_id;
            $request->merge([
                'user_id' => decryptGdprData($request->user_id),
                'content' => $request->contents,
                'immediate_sms' => AffiliateTemplate::ONE,
            ]);
            if ($request->has('interval') && $request->interval != "") {
                if ($request->interval == AffiliateTemplate::ZERO) {
                    $request->merge([
                        'remarketing_time' => "",
                        'remarketing_duplicate_check' => AffiliateTemplate::ZERO,
                        'immediate_sms' => AffiliateTemplate::ZERO,
                        'delay_time' => (isset($request->delay_time) != '') ? self::get_minutes($request->delay_time) : null
                    ]);
                    if ($request->has('instant') && $request->instant == AffiliateTemplate::ONE) {
                        $request->merge([
                            'immediate_sms' => AffiliateTemplate::ONE,
                            'delay_time' => AffiliateTemplate::DEFAULT_TIME

                        ]);
                    }
                    //Check duplicat check allow or not
                    if ($request->has('dupli_enable') && $request->dupli_enable == AffiliateTemplate::ONE) {
                        $request->merge([
                            'remarketing_duplicate_check' => AffiliateTemplate::ONE
                        ]);
                    }
                } else {
                    $request->merge([
                        'remarketing_time' => date('H:i:s', strtotime($request->remarketing_time)),
                        'remarketing_duplicate_check' => AffiliateTemplate::ZERO,
                        'immediate_sms' => AffiliateTemplate::ZERO,
                        'delay_time' => ""

                    ]);
                }
            }

            if ($request->has('sender_id_method')) {
                $sender_id_method = $request->sender_id_method;
                switch ($sender_id_method) {
                    case AffiliateTemplate::ONE:
                        $affiliate_sender_id = DB::table('affiliates')->where('user_id', $request->user_id)->value('sender_id');
                        $sender_id = $affiliate_sender_id;
                        break;
                    case AffiliateTemplate::TWO:
                        $sender_id = $request->sender_id;
                        break;
                    case AffiliateTemplate::THREE:
                        $sender_id = $request->plivo_number;
                        break;
                    default:
                        $affiliate_sender_id = DB::table('affiliates')->where('user_id', $request->user_id)->value('sender_id');
                        $sender_id = $affiliate_sender_id;
                        break;
                }
                $request->merge([
                    'sender_id' => $sender_id
                ]);
            }

            $sparkPost = [];
            $sparkPost['open_tracking']  = true;
            $sparkPost['click_tracking'] = true;
            $sparkPost['transactional']  = true;
            $continue = 0;
            if ($request->type == AffiliateTemplate::TYPE_EMAIL) {
                if (!$request->has('opens_tracking')) {
                    $request->merge([
                        'opens_tracking' => AffiliateTemplate::ZERO
                    ]);
                    $sparkPost['open_tracking'] = true;
                }
                if (!$request->has('click_tracking')) {
                    $request->merge([
                        'click_tracking' => AffiliateTemplate::ZERO
                    ]);
                    $sparkPost['click_tracking'] = true;
                }
                if (!$request->has('transactional')) {
                    $request->merge([
                        'transactional' => AffiliateTemplate::ZERO
                    ]);
                    $sparkPost['transactional'] = true;
                }

                $spark = new SparkPost();
                $data['service_id'] = $request->service_id;
                $getToken = $spark->getToken($data);
                $sparkPost['template_name']   = $request->template_name;
                $sparkPost['description']     = $request->description;
                $sparkPost['from_email']      = $request->from_email;
                $sparkPost['from_name']       = $request->from_name;
                $sparkPost['subject']         = $request->subject;
                $sparkPost['html']            = $request->contents;
                $sparkPost['text']            = '';
                $sparkPost['reply_to']        = $request->reply_to;
                $api_key = DB::table('users')->select('affiliate_keys.api_key')->join('affiliate_keys', 'affiliate_keys.user_id', 'users.id')
                    ->where('users.id', $request->user_id)->first();
                $api = decryptGdprData($api_key->api_key);
                if (!isset($request->id) && $request->id == '') {
                    $response =  $spark->createUpdateTemplate($sparkPost, $getToken['data']->token, $api, 'create');
                    if ($response['status'] == 200) {
                        $request->merge([
                            'template_id' => $response['data']
                        ]);
                        $continue = 1;
                    }
                } else {
                    $id = AffiliateTemplate::where('id', decryptGdprData($request->id))->first()->template_id;
                    $sparkPost['template_id']  = $id;
                    $response =  $spark->createUpdateTemplate($sparkPost, $getToken['data']->token, $api, 'update');
                    if ($response['status'] == 200) {
                        $continue = 1;
                    }
                }
            } else {
                $continue = 1;
            }
            if ($continue == 1) {
                $response = AffiliateTemplate::updateOrCreate(['id' => decryptGdprData($request->id)], $request->all());
                if ($response) {
                    return response()->json(['status' => 200, 'message' => trans('affiliates.success'), 'url' => url("/affiliates/templates/" . $url)]);
                }
            }
            return response()->json(['status' => 400, 'message' => 'Something Went wrong']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * convert time in minutes
     * @param string $time_string
     * @return int
     */
    public static function get_minutes($time_string)
    {
        $parts = explode(":", $time_string);
        $hours = intval($parts[0]);
        $minutes = 00;
        if (isset($parts[1])) {
            $minutes = intval($parts[1]);
        }
        return $hours * AffiliateTemplate::MINUTES + $minutes;
    }
    /**
     * get filter affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function getDataEmailSmsTemplate($request)
    {
        try {
            $data["user_id"] = decryptGdprData($request->users_id);
            $data["type"] = $request->select_source;
            $data["email_type"] = $request->select_email_type;
            $data["service_id"] = $request->service_email_sms_type;
            if ($request->has('template_type')) {
                $data['template_type'] = $request->template_type;
            }
            $data = AffiliateTemplate::where($data)->get()->makeHidden(['user_id', 'content'])->toArray();
            return response()->json(['status' => 200, 'message' => 'Success', 'data' => $data]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * get html parameter   
     * @param  int $source, $types, $email_type
     * @return $data
     */
    public static function getHtmlParameter($source, $types, $email_type, $template_type)
    {
        try {
            $request = [];
            $request['source_type'] = $source;
            $request['service_id'] = $email_type;
            $request['email_type'] = $types;
            $request['template_type'] = $template_type;
            $remarketing = false;
            
            $data =  DB::table('affiliate_template_attribute')->select('attribute')->where(['service_id' =>  AffiliateTemplate::ZERO, 'source_type' =>  AffiliateTemplate::ZERO, 'template_type' =>  AffiliateTemplate::ZERO, 'email_type' => AffiliateTemplate::ZERO]);
            if (($source == 1 && $email_type == 1) && (($types == 1 || $types == 4))) {
                $data = $data->orWhere(function ($query) {
                    $query->where(['service_id' => 0, 'source_type' => 3, 'template_type' => 0, 'email_type' => 0]);
                })->when($template_type == 3, function ($query) {
                    $query->orWhere(function ($query) {
                        $query->where(['service_id' => 1, 'source_type' =>  1, 'template_type' =>  3, 'email_type' => 0]);
                    });
                })->when($template_type == 3 || $template_type == 4, function ($query) {
                    $query->orWhere(function ($query) {
                        $query->where(['service_id' => 1, 'source_type' =>  1, 'template_type' =>  4, 'email_type' => 0]);
                    });
                })->when($types == 4, function ($query) {
                    $query->orWhere(function ($query) {
                        $query->where(['service_id' => 1, 'source_type' =>  1, 'template_type' =>  0, 'email_type' => 4]);
                    });
                })->get();
            } else if ($source == 1 && $types == 2 && $email_type == 1) {
                $data = $data->orWhere(function ($query) {
                    $query->where(['service_id' => 1, 'source_type' => 1, 'template_type' => 0, 'email_type' => 2]);
                })->get();
            } else if (($source == 1 && $email_type == 3) && ($types == 1 || $types == 4)) {
                $data = $data->orWhere(function ($query) {
                    $query->where(['service_id' => 3, 'source_type' => 1, 'template_type' => 0, 'email_type' => 0]);
                })->get();
            } elseif ($source == 1 && $email_type == 3 && $types == 2) {
                $data = $data->orWhere(function ($query) {
                    $query->where(['service_id' => 3, 'source_type' => 1, 'template_type' => 0, 'email_type' => 2]);
                })->get();
            } else if (($source == 1 && $email_type == 2) && ($types == 1 || $types == 2 || $types == 4)) {
                $data = $data->orWhere(function ($query) {
                    $query->where(['service_id' => 2, 'source_type' => 1, 'template_type' => 0, 'email_type' => 0]);
                })->get();
            } else if (($source == 2)) {
                $data = $data->when($types == 2, function ($query) {
                    $query->orWhere(function ($query) {
                        $query->where(['service_id' => 0, 'source_type' => 2, 'template_type' =>  0, 'email_type' => 2]);
                    });
                })->get();
            }
            return $data;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * get particular data
     * @param  int $id
     * @return object
     */
    public static function getParticulardataSmsEmail($id)
    {
        try {
            return AffiliateTemplate::find($id);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * get response bounce and ip pool data
     * @param  string $userId, $serviceId
     * @return $data
     */
    public static function getBounceOrPool($userId, $serviceId)
    {
        try {
            $key = AffiliateThirdPartyApi::select('api_key')->where('user_id', decryptGdprData($userId))->where('status', 1)->first();
            if (!isset($key->api_key) || $key->api_key == null || $key->api_key == '') {
                $affiliate_key = config('env.SPARKPOST_AFFILIATE_KEY');
            } else {
                $affiliate_key = $key->api_key;
            }

            $spark = new SparkPost();
            $data['service_id'] = $serviceId;
            $getToken = $spark->getToken($data);
            $sendData = [
                "sparkpost_keys" => $affiliate_key
            ];
            $response = $spark->getDomainOrPool($sendData, $getToken['data']->token);
            return isset($response['data']->data) ? $response['data']->data : null;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function getPlivoNumbers($userId, $serviceId)
    {
        try {
            $sms = new Sms();
            $data['service_id'] = $serviceId;
            // $api_key = DB::table('affiliate_keys')->where('user_id', decryptGdprData($userId))->first()->api_key; 
            $response = $sms->getToken($data, env('AFFILIATE_API_KEY'));
            return $response;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * delete affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function deleteTemplate($request)
    {
        try {
            $checkStatus = AffiliateTemplate::select('status', 'type', 'email_type')->where('id', $request->id)->first();
            $response = null;
            $message = "You can not delete this template because affiliate status is enable";
            if (($checkStatus->status != AffiliateTemplate::ZERO) && ($checkStatus->type != AffiliateTemplate::ONE) && ($checkStatus->email_type != AffiliateTemplate::WELCOME || $checkStatus->email_type != AffiliateTemplate::SEND_PLAN)) {
                $response =  AffiliateTemplate::where('id', $request->id)->delete();
                $message = trans('affiliates.template_delete');
                if (!$response) {
                    $message = trans('affiliates.aff_error');
                }
            }

            if (!$response) {
                return response()->json(['status' => 200, 'message' => $message]);
            }
            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /**
     * change status of  affiliate template
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function emailTemplateStatus($request)
    {
        try {
            if ($request->type == AffiliateTemplate::TYPE_EMAIL && $request->status == AffiliateTemplate::ONE && ($request->email_type == AffiliateTemplate::WELCOME || $request->email_type == AffiliateTemplate::SEND_PLAN)) {
                AffiliateTemplate::where([
                    'type'           =>  AffiliateTemplate::TYPE_EMAIL,
                    'email_type'     =>  $request->email_type,
                    'user_id'        =>  decryptGdprData($request->user_id),
                    'service_id'     =>  $request->service_id,
                    'template_type'  =>  $request->template_type,
                ])->update(['status' => AffiliateTemplate::ZERO]);
            }
            if ($request->status == AffiliateTemplate::ONE && $request->email_type == AffiliateTemplate::REMARKETING) {
                AffiliateTemplate::where([
                    'type' => $request->type,
                    'email_type'     =>  $request->email_type,
                    'user_id'        =>  decryptGdprData($request->user_id),
                    'service_id'     => $request->service_id,
                    'interval'       => $request->interval
                ])->update(['status' => AffiliateTemplate::ZERO]);
            }
            $response = AffiliateTemplate::where('id', $request->id)->update(['status' => $request->status]);
            if (!$response) {
                return response()->json(['status' => 400, 'message' => "oops, Something went wrong"]);
            }
            return response()->json(['status' => 200, 'message' => "Status has been changed"]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function affiliateData($id)
    {
        try {
            return Affiliate::where('user_id', $id)->first()->company_name;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}
