<?php

namespace App\Repositories\AffiliateTemplate;

use App\Models\{Lead, AffiliateTemplate,Visitor};
use App\Repositories\SparkPost\SparkPost;
use App\Repositories\SparkPost\NodeMailer;
use App\Repositories\Sms\Sms;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\{Storage, DB, Auth};
trait SendWelcomeEmail
{
    static public function sendEmailAndSms($service_id,$products, $visitor, $referenceNos)
	{

		$user = User::find($visitor->affiliate_id);
 
		$firstRow = $products->first();
		$service = Lead::getService($service_id);
     
		$tempObj = null;
		$emailTemplatesColumns = ['id', 'template_id', 'type', 'email_type', 'target_type', 'immediate_sms','subject', 'from_name', 'from_email', 'email_cc', 'email_bcc', 'sending_domain', 'ip_pool','content','source_type','sender_id_method','sender_id','template_name'];
       
		if ($service_id == 1) {
          
			$elecData = $products->where('product_type', 1)->first();
			$gasData = $products->where('product_type', 2)->first();
			$elecProvider = $elecData ? $elecData['provider_id'] : '';
			$gasProvider = $gasData ? $gasData['provider_id'] : '';
         
		
			if ($elecData && $gasData) {
				if ($elecProvider == $gasProvider) {
					/** if both plan applied but providers are different **/
					$tempObj = static::getData(['email_type' => 1, 'template_type' => 4, 'user_id' => $user->id, 'status' => 1,'service_id' => 1], $emailTemplatesColumns);
				} elseif ($elecProvider != $gasProvider) {
					/** if both plan applied and providers are same **/
					$tempObj = static::getData(['email_type' => 1, 'template_type' => 3, 'user_id' => $user->id, 'status' => 1,'service_id' => 1], $emailTemplatesColumns);
				}
			} elseif ($elecData && !$gasData) {
               
				/** if only electricity plan is applied **/
				$tempObj = static::getData(['email_type'  => 1, 'template_type' => 1, 'user_id' => $user->id, 'status' => 1,'service_id' => 1], $emailTemplatesColumns);
                // echo "<pre>";print_r($tempObj);die;
			} elseif (!$elecData && $gasData) {
				/** if only gas plan is applied **/
				$tempObj = static::getData(['email_type'  => 1, 'template_type' => 2, 'user_id' => $user->id, 'status' => 1,'service_id' => 1], $emailTemplatesColumns);
			}
           
		}
      
		if ($service_id != 1) {
			$templateType =  0;
			if ($firstRow['product_type'] == 1) {
				$templateType =  5;
			}

			if ($firstRow['product_type'] == 2) {
				$templateType =  6;
			}
			
			$tempObj = static::getData(['email_type' => 1, 'user_id' => $user->id, 'status' => 1,'service_id' => $service_id, 'template_type' => $templateType], $emailTemplatesColumns);
		}

		$affiliate = $attributes = null;
       
		if ($tempObj && !$tempObj->isEmpty()) {
           
			$firstTempObj = $tempObj->where('type', 1)->first();
			if ($firstTempObj) {
				$templateId = $firstTempObj->template_id;
			}
			$affiliate = $user->getAffiliate(['abn', 'parent_id', 'legal_name', 'support_phone_number', 'youtube_url', 'twitter_url', 'facebook_url', 'linkedin_url', 'google_url', 'subaccount_id', 'page_url', 'address', 'dedicated_page','rc_code','referal_code'], true, true, true, true);
           
			$attributes = DB::table('affiliate_template_attribute')->where('service_id', $service_id)->get();
           
       
            $SendWelcomeMail = static::SendWelcomeMail($service_id,$user, $products, $visitor, $affiliate, $attributes, $firstTempObj, $referenceNos);
         
			

		}
		
		return $tempObj;
	}

	static function getData($conditions, $columns = '*')
	{
		return DB::table('affiliate_templates')->select($columns)->where($conditions)->get();
	}
    static public function sendWelcomeMail($service_id,$user, $productData, $visitor,  $affiliate,$attributes, $emailData = null, $refNo = null)
    {
       
        if (empty($emailData)) return false;
        $service = Lead::getService($service_id);

    
        $visitor = Visitor::removeGDPR($visitor);
    

        if ($service_id != 1) {
            return self::mobileMail($service_id,$user, $productData, $visitor,  $attributes, $affiliate, $emailData , $refNo);
        }

        return self::energyMail($user, $productData, $visitor,  $service, $attributes, $affiliate, $emailData, $refNo);
    }
    static public function mobileMail($service_id,$user, $productData, $visitor, $attributes, $affiliate, $emailData, $refNo)
    {
     
      
        $productData = $productData->first();
        try {
            $nextParameter = [];
            $html = $dedicated_page = '';
            if (!empty($emailData)) {
                $html = $emailData->content;
            }
        
            if(!empty($attributes)){
                $attributes = $attributes->pluck('attribute')->toArray();
            }
            if ($service_id == 3) {
                $refNo = isset($refNo[$service_id]) ? $refNo[$service_id] : '';
                if ($affiliate) {
                    $dedicated_page = $affiliate->dedicated_page . '/terms-conditions/?provider=' . encryptGdprData($productData['provider_id']);
                }

                $nextParameter = [
                    $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name,
                    $productData['provider']['legal_name'],
                    $productData['plan_broadband']['name'],
                    'test test test test Critical-Information-Summary',
                    $dedicated_page,
                    $productData['plan_broadband']['nbn_key_url'],
                    $refNo,
                    $visitor->address,
                ];
            }
           
            $nextParameter = $correctParameters = [];
            // echo "<pre>";print_r($affiliate);die;
            if ($service_id == 2) {
               
                $refNo = isset($refNo[$service_id]) ? $refNo[$service_id] : '';
                $nextParameter['handset_name'] = '';
                 
                $nextParameter['plan_name'] = isset($productData['plan_mobile']['name']) ? $productData['plan_mobile']['name']:'';
              
                $nextParameter['reference_number'] = $refNo;
                $nextParameter['variant_name'] = '';
                $nextParameter['RAM'] = '';
                $nextParameter['internal_storage'] = '';
                $nextParameter['color'] = '';
                // $nextParameter['SignUp_Plan_Detail_Link'] = self::generatePlanDetailLink($user,$service_id,$affiliate,$productData);
               
                $nextParameter['customer_name'] = $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name;
                $nextParameter['provider_name'] = $productData['provider']['legal_name'];
                $nextParameter['connection_type'] = '';
                $nextParameter['connection_number'] = '';
                $nextParameter['provider_terms_condition'] = '';
                $nextParameter['Critical_Information_Summary'] = '';
                $nextParameter['affiliate_name'] = decryptGdprData($affiliate->legal_name);
                $nextParameter['affiliate_address'] = $affiliate->address;
                $nextParameter['twitter'] = '';
                $nextParameter['facebook'] = '';
                if ($productData['product_type'] == 2) {
                    $nextParameter['handset_name'] = $productData['handset']['name'];
                    $nextParameter['variant_name'] = $productData['variant']['variant_name'];
                    $nextParameter['RAM'] = $productData['variant']['capacity']['capacity_name'];
                    $nextParameter['internal_storage'] = $productData['variant']['internal']['storage_name'];
                    $nextParameter['color'] = $productData['variant']['color']['title'];
                    $nextParameter['contract_term'] = $productData['contract']['contract_name'];
                }
            }
     
            $nextKeys = array_keys($nextParameter);
            foreach ($attributes as $attribute) {
                foreach ($nextKeys as $nextKey) {
                    if (str_contains($attribute, $nextKey)) {
                        $correctParameters[$nextKey] = $nextParameter[$nextKey];
                    }
                }
            }
        
           
          
            $html = str_replace($attributes, $correctParameters, $html);
       
            $mailData = [];
            $mailData['text'] = '';
            $mailData['from_email'] = $emailData->from_email ?? 'support@cimet.com.au';
            $mailData['from_name'] = $emailData->from_name ?? 'CIMET Support Team';
            $mailData['service_id'] = 1;
            $mailData['subject'] = str_replace('_', ' ', $emailData->subject);
            $mailData['cc_mail'] = [];
            $mailData['bcc_mail'] = [];
            $mailData['html']  = $html;
            $mailData['lead_id'] = encryptGdprData($productData['lead_id']);
            $mailData['user_email'] = strtolower($visitor->email) ?? '';
            $nodeMailer = new NodeMailer();
            $senderId = $emailData->sender_id;
            // Sender ID for plivo functionality
            // if ($emailData->sender_id_method == 'default') {
            //     $senderId = $affiliate->sender_id;
            //     config(['plivo.source-number' => $affiliate->sender_id]);
            // }
            // $smsType = 'plivo';

            $mailObj = $nodeMailer->sendMail($mailData);
            self::addLogs($mailObj, $productData,$service_id);
            // $this->createSms($senderId, $visitor->phone, $html, $smsType, $productData['lead_id']);
            return $mailObj;
        } catch (\Exception $e) {
            $msg = $e->getMessage() . '  Line no:' . $e->getLine() . '  File:' . $e->getFile();
            self::addLogs(['message' => $msg], $productData,$service_id);
            return false;
        }
    }
    public static function addLogs($mailObj, $productData,$service_id)
    {
        $apiRefNo = '';
        $message = 'Something went wrong with welcome email';
       
        if (is_object($mailObj)) {
            $apiRefNo = $mailObj->data->results->id;
            $message = 'Welcome email sent successfully';
            $mailObj = json_encode($mailObj);
        }
        
        if (is_array($mailObj)) {
            $mailObj = json_encode($mailObj);
        }

        $data = [];
        $data['lead_id'] = isset($productData['lead_id']) ? $productData['lead_id'] : null;
        $data['sale_product_id'] = isset($productData['product_id']) ? $productData['product_id'] : null;
        $data['service_id'] = $service_id;
        $data['api_name'] = 'Welcome email';
        $data['api_reference'] = $apiRefNo;
        $data['response_text'] = $mailObj;
        $data['api_response'] = $mailObj;
        $data['message'] = $message;

        return DB::table('api_responses')->insert($data);
    }
    static public function energyMail($user, $productData, $visitor,  $service, $attributes, $affiliate, $emailData = null, $refNo)
    {
      
        $sparkPostArray = [];
        $sparkPostArray["base_url"] = url();
        $sparkPostArray['affiliate_name'] = decryptGdprData($affiliate->legal_name);
        $sparkPostArray['affiliate_logo'] = url('/uploads/profile_images/' . $user->photo);
        $sparkPostArray['affiliate_contact_us'] = decryptGdprData($affiliate->support_phone_number);
        $sparkPostArray['affiliate_address'] = $affiliate->address;
        $sparkPostArray['youtube'] = $affiliate->youtube_url;
        $sparkPostArray['twitter'] = $affiliate->twitter_url;
        $sparkPostArray['facebook'] = $affiliate->facebook_url;
        $sparkPostArray['linkedin'] = $affiliate->linkedin_url;
        $sparkPostArray['google_plus'] = $affiliate->google_url;
        $full_name = $visitor->first_name . ' ' . $visitor->last_name;

        $elecData = $productData->where('product_type', 1)->first();
        $gasData = $productData->where('product_type', 2)->first();
        if (!empty($visitor->middle_name)) {
            $full_name = $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name;
        }

        $html = '';
        if (!empty($emailData)) {
            $html = $emailData->content;
        }

        $sparkPostArray['customer_name'] = $full_name;

        $sparkPostArray['customer_email'] = $visitor->email;
        $sparkPostArray['suburb_address'] = $visitor->address;
        $sparkPostArray['customer_property_address'] = $visitor->address;
        $sparkPostArray['customer_billing_address'] = 'N/A';

        if ($visitor->billing_address_id) {
            $billingDetails = DB::table('visitor_addresses')->select('address')->where('id', $visitor->billing_address_id)->first();
            if ($billingDetails) {
                $sparkPostArray['customer_billing_address'] = $billingDetails->address;
            }
        }

        $elec_provider_id = 0;
        $gas_provider_id = 0;
        $elec_ref = '';
        $gas_ref = '';
        $welcomeEmailSubject = "";;
      
        if ($emailData && $emailData->subject)
            $welcomeEmailSubject = $emailData->subject;

        $phone = null;
      
        if ($elecData) {
            $providerUserData = DB::table('users')->select('phone')->find($elecData['provider_id']);
            $phone = $providerUserData ? decryptGdprData($providerUserData->phone) : '';
            $elec_provider_id = $elecData['provider_id'];
            $provider_name = $elecData['provider']['legal_name'];

            if (isset($elecData['reference_no']) && !empty($elecData['reference_no'])) {
                $elec_ref = $elecData['reference_no'];
                $welcomeEmailSubject = $welcomeEmailSubject . ' -  Reference Number:' . $elec_ref;
            }

            $elecData['plan_document'] = isset($elecData['plan_energy']) ? $elecData['plan_energy']['plan_document'] : '#';

            $sparkPostArray['electricity_provider_phone_number'] = $phone;
            $sparkPostArray['electricity_reference_number'] = $elec_ref;
            $sparkPostArray['electricity_plan_name'] = isset($elecData['plan_energy']) ? $elecData['plan_energy']['name'] : '';

            // Price Fact Sheet Function In Welcome Mail
            $sparkPostArray['electricity_plan_detail_link'] = 'Available On Request';
            if (isset($elecData['plan_energy']) && $elecData['plan_energy']['show_price_fact'] == 'yes') {
                $path = 'Providers_Plans' . '/' . str_replace(' ', '_', $provider_name) . '/' . str_replace(' ', '_', $elecData['plan_energy']['name']) . '/' . $elecData['plan_energy']['plan_document'];
                $disk = Storage::disk('s3_plan');

                $url = $disk->getAdapter()->getClient()->getObjectUrl(config('filesystems.disks.s3_plan.bucket'), $path);

                $sparkPostArray['electricity_plan_detail_link'] = '<a href=' . $url . '>Plan Details</a>';
            }
            $sparkPostArray['electricity_provider_name'] = $provider_name;

            $provider_name = preg_replace("/\s+/", "", trim($provider_name));
            $parameter = str_replace(" ", "", $provider_name);
            $sparkPostArray['electricity_provider_term_conditions'] = $affiliate->page_url . '/provider-term-conditions/?provider=' . $parameter;
        }

        if ($gasData) {
            if ($elecData && $gasData && $elecData['provider_id'] == $gasData['provider_id'] && $phone) {
                $sparkPostArray['gas_provider_phone_number'] = $phone;
            } else {
                $providerUserData = DB::table('users')->select('phone')->find($elecData['provider_id']);
                $phone = $providerUserData ? decryptGdprData($providerUserData->phone) : '';
                $sparkPostArray['gas_provider_phone_number'] = $phone;
            }
            $gasData['plan_document'] = $gasData['plan_energy']['plan_document'] ?? '#';
            $gas_provider_id = $gasData['provider_id'];
            $provider_name = $elecData['provider']['legal_name'];
            $plan_name = $gasData['plan_energy']['name'];
            if (isset($gasData['reference_no']) && !empty($gasData['reference_no'])) {
                $welcomeEmailSubject = $welcomeEmailSubject . ' -  Reference Number:' . $gas_ref;
                $gas_ref = $gasData['reference_no'];
            } else {
                $welcomeEmailSubject = $welcomeEmailSubject . ' -  Reference Number:' . $gas_ref;
                $gas_ref = $elecData['reference_no'];
            }
            $sparkPostArray['gas_reference_number'] = $gas_ref;
            $sparkPostArray['gas_plan_name'] = $plan_name;
            $sparkPostArray['gas_plan_detail_link'] = 'Available On Request';
            if ($gasData['plan_energy']['show_price_fact'] == 'yes') {
                // $path = 'Providers_Plans' . '/' . str_replace(' ', '_', $provider_name) . '/' . str_replace(' ', '_', $plan_name) . '/' . $plan['gas']->plan_document;
                $disk = \Storage::disk('s3_plan');

                $url = $disk->getAdapter()->getClient()->getObjectUrl(config('filesystems.disks.s3_plan.bucket'), $path);

                $sparkPostArray['gas_plan_detail_link'] = '<a href=' . $url . '>Plan Details</a>';
            }

            $sparkPostArray['gas_provider_name'] = $provider_name;

            $provider_name = preg_replace("/\s+/", "", trim($provider_name));
            $parameter = str_replace(" ", "", $provider_name);
            $sparkPostArray['gas_provider_term_conditions'] = $affiliate->page_url . '/provider-term-conditions/?provider=' . $parameter;
        }

        if ((!empty($elec_provider_id) && !empty($gas_provider_id)) && ($elec_provider_id == $gas_provider_id)) {
            $welcomeEmailSubject = $welcomeEmailSubject . ' - Electricity & Gas Confirmation - Reference Number:' . $gas_ref;
        }
        if ((!empty($elec_provider_id) && !empty($gas_provider_id)) && ($elec_provider_id != $gas_provider_id)) {
            $welcomeEmailSubject = $welcomeEmailSubject . ' - Electricity & Gas Confirmation - Electricity Reference Number:' . $elec_ref . ' - Gas Reference Number:' . $gas_ref;
        }
        $subAccountData = DB::table('affiliate_third_party_apis')->select('subaccount_id')->where('user_id', $user->id)->first();

        $mailData = [];
        $mailData['template_id'] = $emailData->template_id ?? $emailData->template_id;
        $mailData['subaccount_id'] = $subAccountData ? $subAccountData->subaccount_id : '';
        $mailData['from_email'] = $emailData->from_email ?? 'support@cimet.com.au';
        $mailData['user_email'] = $emailData->from_email ?? 'support@cimet.com.au';
        $mailData['from_name'] = $emailData->from_name ?? 'CIMET Support Team';
        $mailData['service_id'] = 1;
        $mailData['subject'] =str_replace('_', ' ', $emailData->subject) ?? '';
        $mailData['cc_mailID'] = [];
        $mailData['bcc_mailID'] = [];
        $mailData['attachments'] = [];
        $mailData['mail_data'] = $sparkPostArray;
        $firstRow = $productData->first();
        $mailData['lead_id'] = encryptGdprData($firstRow['lead_id']);
        $mailData['receiver_email'] = strtolower($visitor->email) ?? '';
        $nodeMailer = new NodeMailer();
        $mailObj = $nodeMailer->sendMailWithTemplate($mailData);
        return  self::addLogs($mailObj, $productData,1);
    }
 

}