<?php 
use Illuminate\Support\Facades\DB;
use App\Models\{Provider,ProviderList,SaleBusinessDetail,SaleEmploymentDetail,Variant,Sale,Affiliate,SaleAddress,AffiliateProvider,BroadbandPlanAddon,BroadbandAdditionalAddons,Services,PhoneHomeLineConnection,BroadbandModem,SaleCommonData,VisitorDebitInfo,Otp,VisitorSession,SaleIdentification,AffiliateKey,ApiResponse,SubStatus,SubStatusonnectionType,ConnectionType,State,Settings,Contract,EmailTemplate};

use Carbon\Carbon; 
use App\Repositories\{
    SparkPostRepository,
    CommonRepositary,
    SaleStatusREpository
}; 



  function filterSaleData($request,$Sale)
  {
        $affiliateId =  $request->affiliateId;
        $providerId =  get_encrypt_data($request->providerName);
        $connectionTypeId =  $request->ConnectionType;
        $technologyType = $request->technologyType;
        $movinType = $request->movinType;
        $filter_movin_start_date =  $request->movinstartDate;
        $filter_movin_end_date =  $request->movinendDate;
        $planTypeId =  $request->PlanType;
        $userName = set_gdpr_encrypt_data(strtolower($request->searchUserName));
        $searchSaleId = $request->searchSaleId;
        $searchEmail = set_gdpr_encrypt_data(strtolower($request->searchEmail));
        $searchPhone = set_gdpr_encrypt_data($request->searchPhone);
        $salesorting = $request->salesorting;
        $bought_through = $request->boughtThrough;
        $filter_start_date =  $request->startDate;
        $filter_end_date =  $request->endDate;
        $filter_type =  $request->type;
        $subAffiliateId =  $request->subAffiliateId;
        $service_type_id =  3;  
        $broadbandConnectionType = [];
         
        $availableConn =  ConnectionType::where('is_deleted','0')->where('status','1')->whereNull('connection_type_id')->select('id','connection_name')->get();
        foreach($availableConn as $connType){
            $broadbandConnectionType[$connType->id] = $connType->connection_name;
        } 
        $service = Services::select('service_title','id')->get();

        $affiliate = Affiliate::where('parent_id','=',0)->get(['id','user_id','legal_name']);
        $subAffiliate = new Affiliate();

        if($request->ServiceType){
            $service_type_id = $request->ServiceType;
        }

        $Sale = $Sale->where('service_id',$service_type_id);

        if (!empty($planTypeId)) {
            if($service_type_id != 3){
                $plan_type = (int)$planTypeId;
                $Sale = $Sale->where('plan_type', $plan_type);
            }
        } 
        if(!empty($affiliateId) && empty($subAffiliateId))
        {
            $common = new CommonRepositary;

            $affiliateIds = $common->getSubaffiliateId($affiliateId);
            array_push($affiliateIds, $affiliateId);
            $Sale = $Sale->whereIn('affiliate_id',$affiliateIds);

        }
        if(!empty($subAffiliateId) && empty($affiliateId))
        {
            $Sale = $Sale->where('affiliate_id',$subAffiliateId);
        }
        if(!empty($subAffiliateId) && !empty($affiliateId))
        {
            $common = new CommonRepositary;
            $affiliate_ids = $common->getAffilateIdWithSubaffiliateId($affiliateId,$subAffiliateId);
            $Sale = $Sale->whereIn('affiliate_id',$affiliate_ids);
        }


        if (!empty($connectionTypeId)) {
            $Sale = $Sale->where('connection_type', $connectionTypeId);
        }
        if(isset($technologyType) && !empty($technologyType))
        {
            $Sale = $Sale->Where('technology', 'like', '%' . $technologyType . '%');
        }

        if(isset($movinType) && !empty($movinType))
        {
            $Sale = $Sale->where('movin_type',$movinType);
        }

        if(isset($request->saleStatus) && !empty($request->saleStatus))
        {
            $Sale = $Sale->WhereIn('sale_status', $request->saleStatus);
        }

        if(isset($request->saleSubStatus) && !empty($request->saleSubStatus))
        {
            $Sale = $Sale->whereIn('sale_sub_status',$request->saleSubStatus);
        }

        if (!empty($providerId)) {
            $Sale = $Sale->where('provider_id', $providerId);
        }
        if (!empty($userName)) {  
            $Sale = $Sale->where('user_name', $userName);
        }
        if (!empty($searchSaleId)) {
            $Sale = $Sale->where('reference_number', 'like', "%" . $searchSaleId . "%");
        }
        if (!empty($searchEmail)) {
            $Sale = $Sale->where('email', 'like', "%" . $searchEmail . "%");
        }
        if (!empty($searchPhone)) {
            $Sale = $Sale->where('phone', 'like', "%" . $searchPhone . "%");
        }
        if (!empty($salesorting)) {
            $Sale = $Sale->orderBy('id', $salesorting);
        }
        if (!empty($bought_through)) {
            if($service_type_id !=3){
             $Sale = $Sale->where('bought_through', $bought_through);
            }
        }
        if((isset($filter_start_date) && $filter_start_date != 'undefined')  && (isset($filter_end_date) && $filter_end_date != 'undefined'))
        {
            $startDate = Carbon::createFromFormat('d/m/Y', $filter_start_date);
            $selected_start_date = Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = Carbon::createFromFormat('d/m/Y', $filter_end_date);
            $selected_end_date = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
            $Sale = $Sale->whereBetween(DB::raw("date(sale_created_at)"), [$selected_start_date, $selected_end_date])->whereStatus(1);
        }

        if((isset($filter_movin_start_date) && $filter_movin_start_date != 'undefined')  && (isset($filter_movin_end_date) && $filter_movin_end_date != 'undefined'))
        {
            $movinstartDate = Carbon::createFromFormat('d/m/Y', $filter_movin_start_date);
            $movin_selected_start_date = Carbon::parse($movinstartDate)->format('Y-m-d');
            $movinendDate = Carbon::createFromFormat('d/m/Y', $filter_movin_end_date);
            $movin_selected_end_date = Carbon::parse($movinendDate)->format('Y-m-d');
            $Sale = $Sale->whereBetween(DB::raw('STR_TO_DATE(movin_date, "%d/%m/%Y")'), [$movin_selected_start_date, $movin_selected_end_date]);
        }

        $sales =  $Sale->whereStatus(1)
        ->with('affiliateName')->with('connection_name')->with(array('service'=>function($query){
            $query->select('id','service_title');
        }))->with(array('providers'=>function($query){
            $query->select('provider_unique_id','id','business_name');
        }));
         
        $provider = Provider::whereStatus(1)->get(['id','business_name','legal_name']);

        if(Auth::user()->getRoleNames()->first() != 'admin'){
            if(auth()->user()->role_name == 'affiliate'){

              $common = new CommonRepositary;
              $affiliateId = $common->getSubaffiliateId();
              $sales = $sales->whereIn('affiliate_id',$affiliateId);
              $provider = AffiliateProvider::whereIn('affiliate_id',$affiliateId)->with('providers:provider_unique_id,id,business_name')->get();
              $to_remove = array(Auth::user()->id);
              $affiliateId = array_diff($affiliateId, $to_remove);
              $subAffiliate = $subAffiliate->whereIn('user_id',$affiliateId);
            }else if(auth()->user()->role_name == 'sub-affiliate'){
             $sales = $sales->where('affiliate_id',Auth::user()->id);
             $provider = AffiliateProvider::where('affiliate_id',Auth::user()->id)->with('providers:provider_unique_id,id,business_name')->get();
             $assigned_provider_id = array_column($provider->toArray(),'provider_id');
             $sales = $sales->whereIn('provider_id',$assigned_provider_id);
            }

        }else{
            $subAffiliate = $subAffiliate->where('parent_id','!=',0);
        }

        if(auth()->user()->hasAnyRole(['accountant','qa','bdm','admin']))
        {
            //get assigned affiliates
           $linked_affiliates = DB::table('assign_users')->where('source_user_id', Auth::user()->id)->where( 'relation_type',2)->pluck('relational_user_id')->toArray(); 

            $linked_subaffiliates = DB::table('assign_users')->where('source_user_id', Auth::user()->id)->where( 'relation_type',3)->pluck('relational_user_id')->toArray(); 

            $sales = $sales->whereIn('affiliate_id', array_merge($linked_affiliates,$linked_subaffiliates));
        }

        if(auth()->user()->hasAnyRole(['bdm']))
        {
            //get sales under bdm date range
            $bdm_user = UserSetting::where('user_id', \Auth::user()->id)->first();
            $column = 'created_at';
            if ($bdm_user) {
              if ($bdm_user->date_range_checkbox != 1) {
                  $endDate = str_replace('/', '-', $bdm_user->date_range_to);
                  $selected_end_date = date('d-m-Y', strtotime($endDate));
                  $filter_select_end_date = date('Y-m-d', strtotime($endDate));
              } else {
                  $selected_end_date = date('d-m-Y');
                  $filter_select_end_date = date('Y-m-d');
              }

              if ($bdm_user->date_range_from != '') {
                  $startDate = str_replace('/', '-', $bdm_user->date_range_from);
                  $filter_select_date = date('Y-m-d', strtotime($startDate));
                  $sales = $sales->whereBetween(DB::raw('date(' . $column . ')'), [$filter_select_date, $filter_select_end_date]);
              } else {
                  $sales = $sales->where(DB::raw('date(' . $column . ')'), '<=', $filter_select_end_date);
              }
            }
        }
    return ['sales' => $sales, 'service_type_id' => $service_type_id ,'service' => $service, 'provider' => $provider];
  }
  /*
  * setPasswordForCsv => set password to lead/sale csv file 
  * 
  */
  function setPasswordForCsv($sale_password,$filename,$s3bukcetpath)
  {
      try
      {
        $returnStatus = false;
        $fileLink =[];  
        if($sale_password) {
            $hash = base64_decode($sale_password); 
            $real_path = realpath(base_path() . "/../");

            //make a password encrypted zip file
            $zip_path = str_replace('csv', 'zip', $filename);
            exec('zip -P ' . $hash . '  -j ' . $zip_path . ' ' . $filename);
            
            //upload csv file to s3
            $upload_S3 = \Storage::disk("s3")->put(str_replace('.csv', '.zip', $s3bukcetpath), file_get_contents($zip_path), 'public');
            
            if ($upload_S3) {
              $returnStatus = true;

              //get path of s3 file
              $fileLink = csv_document_link(str_replace('.csv', '.zip', $s3bukcetpath), 's3');
            }

            //delete zip file from server
            unlink($zip_path);
        } 
        else 
        {
          //upload file to s3
           $upload_S3 = \Storage::disk("s3")->put($s3bukcetpath, file_get_contents($filename), 'public');
            if ($upload_S3) {
              $returnStatus = true;

              // get path of uploaded csv file
              $fileLink = csv_document_link($s3bukcetpath, 's3');
            }
        }
        return $fileLink;
      }
      catch (Exception $err){
        throw new Exception($err->getMessage(),0,$err);
      }
  }
  
  /*
  * generateSaleInfoCsvFile => generate sale information lead/sale csv file 
  * 
  */
  function generateSaleInfoCsvFile($sales,$filename,$service,$provider,$order,$csv_select,$request,$saleType)
  {  
      try
      {
        $handle = fopen($filename, 'w+');
        //start csv file
        fputcsv($handle, $order); 
        $i=1;
        $serviceCode =array_column($service->toArray(),'service_title','id');   
        $providerIdName =array_column($provider->toArray(),'business_name','id');
        $connectionNameMapping = [
          '1'=>'Personal',
          '2'=>'Business',
          '3'=>'Enterprise',
        ]; 
        $contractNames = Contract::select('id','validity')->pluck('validity','id'); 
        $subStatusTitle = SubStatus::pluck('title','id')->toArray(); 
        //$affiliateApiKey = AffiliateKey::select('api_key','unique_code','name')->get()->toArray();
        // $apiKeyName = array_column($affiliateApiKey, 'name','api_key');
        // $uniqueCodeName = array_column($affiliateApiKey, 'name','unique_code');
        // $uniqueOrApiKey = array_column($affiliateApiKey, 'unique_code','api_key');
        $table = [];
        $sales->select('id','rc','cui','utm_source','utm_medium','utm_campaign','utm_term','utm_content','gclid','fbclid','sale_created_at','movin_date','plan_name','service_id','connection_type','plan_cost','title','first_name','last_name','email','phone','dob','alternate_phone','connection_delivery_date','plan_internet_speed','contract_id','total_data_allowance','download_speed','upload_speed','plan_special_offer_price','plan_special_offer','plan_nbn_key_url','critical_info_url','monthly_cost','setup_fee','delivery_fee','payment_processing_fees','termination_fee','other_fee_and_charges','minimum_total_cost','is_provider_account','connection_account_no','is_phone_number','home_number','provider_account','browser','platform','user_agent','device','ip_address','created_at','latitude','longitude','affiliate_id','provider_id','connection_type','delivery_preferences','billing_preferences','api_key','rc_status','reference_number','unique_id','current_account','transfer_service','middle_name','utm_rm','utm_rm_source','utm_rm_date','sale_status','sale_sub_status','duplicate_status')
          ->orderBy('id','DESC')
          ->with([
            'affiliateName' => function ($query) {
                $query->select('id','user_id','legal_name','email','phone','referral_code_title','parent_id','company_name');
            }, 
            'affiliateName.getParentAffiliate'  => function ($query) {
                $query->select('id','user_id','legal_name','email','phone','referral_code_title','parent_id','company_name');
            },
            'saleCompleteAddress' => function ($query) {
                $query->select('sale_id','full_address','living_year','living_month','residential_status');
            },
            'saleIdentification',
            'saleIdentification.State',
            'employmentDetails', 
            'getSaleCommonData'  => function ($query) {
                $query->select('sale_id','eic_checkbox_content','eic_content');
            },
            'SaleHomeConnection' => function ($query) {
                $query->select('sale_id','phone_home_connection_id','phone_home_connection_price','is_mandatory');
            },
            'SaleHomeConnection.BroadbandPhoneHomeConnection' => function ($query) {
                $query->select('id','call_plan_name');
            },
            'SaleModem' => function ($query) {
                $query->select('sale_id','broadband_modem_id','broadband_modem_price','is_mandatory');
            },
            'SaleModem.BroadbandModemConnection' => function ($query) {
                $query->select('id','modem_modal_name');
            },
            'SaleAddons' => function ($query) {
                $query->select('sale_id','broadband_other_addon_id','broadband_other_addon_price','is_mandatory');
            },
            'SaleAddons.BroadbandAddonConnection' => function ($query) {
                $query->select('id','addon_name');
            },
            'getReferralByApiKey' => function ($query) {
                $query->select('id','api_key','unique_code','name');
            },
            'getReferralByUniqueCode' => function ($query) {
                $query->select('id','api_key','unique_code','name');
            },
            'service' => function ($query) {
                $query->select('id','service_title');
            },
            'connection_name' => function ($query) {
                $query->select('id','connection_name');
            },
            'getSatelliteQuestions',
            'getSatelliteQuestions.parent_question',
            'getSatelliteQuestions.options',
          ])
          ->chunk(500, function ($sales) use($table,$serviceCode,$providerIdName,$connectionNameMapping,$contractNames,$i,$csv_select,$request,$saleType,$order,$handle,$subStatusTitle)
          {

            foreach ($sales as $lead) 
            {     
                if (isset($csv_select['sale_status'])) {
                  $table[$i]['sale_status'] = isset($lead->sale_status) ? SaleStatusREpository::status($lead->sale_status) : '--';
                }   

                if (isset($csv_select['sale_sub_status'])) {
                  $table[$i]['sale_sub_status'] = isset($lead->sale_sub_status) ? $subStatusTitle[$lead->sale_sub_status] : '--';
                }
                if (isset($csv_select['source'])) {
                  $table[$i]['source'] = 'API'; 
                } 
                if (isset($csv_select['rc'])) {
                  $table[$i]['rc'] = isset($lead->rc) ? $lead->rc : '--';
                }
                if (isset($csv_select['cui'])) {
                  $table[$i]['cui'] = isset($lead->cui) ? $lead->cui : '--';
                }
                if (isset($csv_select['utm_source'])) {
                  $table[$i]['utm_source'] = isset($lead->utm_source) ? $lead->utm_source : '--';
                }
                if (isset($csv_select['utm_medium'])) {
                  $table[$i]['utm_medium'] = isset($lead->utm_medium) ? $lead->utm_medium : '--';
                }
                if (isset($csv_select['utm_campaign'])) {
                  $table[$i]['utm_campaign'] = isset($lead->utm_campaign) ? $lead->utm_campaign : '--';
                }
                if (isset($csv_select['utm_term'])) {
                  $table[$i]['utm_term'] = isset($lead->utm_term) ? $lead->utm_term : '--';
                }
                if (isset($csv_select['utm_content'])) {
                  $table[$i]['utm_content'] = isset($lead->utm_content) ? $lead->utm_content : '--';
                }
                if (isset($csv_select['gclid'])) {
                  $table[$i]['gclid'] = isset($lead->gclid) ? $lead->gclid : '--';
                }
                if (isset($csv_select['fbclid'])) {
                  $table[$i]['fbclid'] = isset($lead->fbclid) ? $lead->fbclid : '--';
                }
 
                if (isset($csv_select['sale_id'])) {
                  $table[$i]['sale_id'] = isset($lead->unique_id) ? $lead->unique_id : '--'; 
                }

                if($saleType == 'sale')
                {
                    if (isset($csv_select['reference_number'])) {
                      $table[$i]['reference_number'] = isset($lead->reference_number) ? $lead->reference_number : '--';
                    }
                } 

                if (isset($csv_select['sale_create_date'])) {
                  $table[$i]['sale_create_date'] = isset($lead->sale_created_at) ? $lead->sale_created_at : '--';
                }  
                if (isset($csv_select['utm_rm'])) {
                  $table[$i]['utm_rm'] = isset($lead->utm_rm) ? $lead->utm_rm : '--';
                }
                if (isset($csv_select['utm_rm_source'])) {
                  $table[$i]['utm_rm_source'] = isset($lead->utm_rm_source) ? $lead->utm_rm_source : '--';
                }
                if (isset($csv_select['utm_rm_date'])) {
                  $table[$i]['utm_rm_date'] = isset($lead->utm_rm_date) ? $lead->utm_rm_date : '--';
                }
                if (isset($csv_select['duplicate_status'])) {
                  $table[$i]['duplicate_status'] = $lead->duplicate_status? 'Yes': 'No';
                }

                $referral_code_url_title ='--';
                if($lead->rc_status == 0)
                {   
                    $referral_code_url_title = isset($lead->getReferralByApiKey[0])?$lead->getReferralByApiKey[0]->name:'--';
                    if (isset($csv_select['rc'])) {
                      $table[$i]['rc'] = (isset($lead->getReferralByApiKey[0]) && $lead->getReferralByApiKey[0]->unique_code != 0 )?$lead->getReferralByApiKey[0]->unique_code:'--';
                    }
                }
                else if($lead->rc_status == 1)
                {
                    $referral_code_url_title = isset($lead->getReferralByUniqueCode[0])?$lead->getReferralByUniqueCode[0]->name:'--';
                }

                if(isset($lead->affiliateName->parent_id) && $lead->affiliateName->parent_id != 0)
                {
                    if (isset($csv_select['affiliate_information'])) {
                      $table[$i]['affiliate_information'] = isset($lead->affiliateName->getParentAffiliate)?('Name: '.$lead->affiliateName->getParentAffiliate->company_name.' , Email: '.get_gdpr_encrypt_data($lead->affiliateName->getParentAffiliate->email).' , Phone: '.get_gdpr_encrypt_data($lead->affiliateName->getParentAffiliate->phone).' , Referral Code Title: '.$referral_code_url_title):'--';
                    } 
                    if (isset($csv_select['affiliate_name'])) {
                      $table[$i]['affiliate_name'] = isset($lead->affiliateName->getParentAffiliate->company_name) ? $lead->affiliateName->getParentAffiliate->company_name : '--';
                    }
                    if (isset($csv_select['affiliate_email'])) {
                      $table[$i]['affiliate_email'] = isset($lead->affiliateName->getParentAffiliate->email) ? get_gdpr_encrypt_data($lead->affiliateName->getParentAffiliate->email) : '--';
                    }
                    if (isset($csv_select['affiliate_phone'])) {
                      $table[$i]['affiliate_phone'] = isset($lead->affiliateName->getParentAffiliate->phone) ? get_gdpr_encrypt_data($lead->affiliateName->getParentAffiliate->phone) : '--';
                    }
                    if (isset($csv_select['sub_affiliate_name'])) {
                      $table[$i]['sub_affiliate_name'] = isset($lead->affiliateName->company_name) ? $lead->affiliateName->company_name : '--';
                    }
                    if (isset($csv_select['referral_code_url_title'])) { 
                      $table[$i]['referral_code_url_title'] = $referral_code_url_title;
                    }
                }
                else
                {
                  if (isset($csv_select['affiliate_information'])) {
                    $table[$i]['affiliate_information'] = isset($lead->affiliateName)?($lead->affiliateName->company_name.' , '.get_gdpr_encrypt_data($lead->affiliateName->email).' , '.get_gdpr_encrypt_data($lead->affiliateName->phone)):'--';
                  } 
                  if (isset($csv_select['affiliate_name'])) {
                    $table[$i]['affiliate_name'] = isset($lead->affiliateName->company_name) ? $lead->affiliateName->company_name : '--';
                  }
                  if (isset($csv_select['affiliate_email'])) {
                    $table[$i]['affiliate_email'] = isset($lead->affiliateName->email) ? get_gdpr_encrypt_data($lead->affiliateName->email) : '--';
                  }
                  if (isset($csv_select['affiliate_phone'])) {
                    $table[$i]['affiliate_phone'] = isset($lead->affiliateName->phone) ? get_gdpr_encrypt_data($lead->affiliateName->phone) : '--';
                  }
                  if (isset($csv_select['sub_affiliate_name'])) {
                    $table[$i]['sub_affiliate_name'] ='--';
                  }
                  if (isset($csv_select['referral_code_url_title'])) {
                    $table[$i]['referral_code_url_title'] = '--';
                  }
                }  

                if (isset($csv_select['complete_address'])) {
                  $table[$i]['complete_address'] = isset($lead->saleCompleteAddress->full_address) ? $lead->saleCompleteAddress->full_address : '--';
                }
                if (isset($csv_select['movin_date'])) {
                  $table[$i]['movin_date'] = isset($lead->movin_date) ? $lead->movin_date : '--';
                }
                if (isset($csv_select['plan_name'])) {
                  $table[$i]['plan_name'] = isset($lead->plan_name) ? $lead->plan_name : '--';
                }
                if (isset($csv_select['service_type'])) {
                   $table[$i]['service_type'] = isset($serviceCode[$lead->service_id])?$serviceCode[$lead->service_id]:'Others';
                }
                if (isset($csv_select['connection_type'])) { 
                    if(isset($lead->service->service_title))
                    {
                        if($lead->service->service_title == 'mobile')
                        {
                            $table[$i]['connection_type'] = isset($connectionNameMapping[$lead->connection_type]) ? $connectionNameMapping[$lead->connection_type] : '--';
                        }
                        else
                        {
                            $table[$i]['connection_type'] = isset($lead->connection_name->connection_name)?$lead->connection_name->connection_name:'--';
                        }
                    }
                    else
                    {
                        $table[$i]['connection_type'] = isset($connectionNameMapping[$lead->connection_type]) ? $connectionNameMapping[$lead->connection_type] : '--';
                    }
                }   
                if (isset($csv_select['total_plan_cost'])) {
                  $table[$i]['total_plan_cost'] = isset($lead->plan_cost) ? '$'.$lead->plan_cost : '--';
                }
                // if (isset($csv_select['provider'])) {
                //   $table[$i]['provider'] = isset($lead->provider_id) ? isset($providerIdName[$lead->provider_id])?$providerIdName[$lead->provider_id]:'--' : '--';
                // }
                if (isset($csv_select['customer_title'])) {
                  $table[$i]['customer_title'] = isset($lead->title) ? $lead->title : '--';
                }
                if (isset($csv_select['customer_first_name'])) {
                  $table[$i]['customer_first_name'] = isset($lead->first_name) ? get_gdpr_encrypt_data($lead->first_name) : '--';
                }
                if (isset($csv_select['customer_middle_name'])) {
                  $table[$i]['customer_middle_name'] = isset($lead->middle_name) ? get_gdpr_encrypt_data($lead->middle_name) : '--';
                }
                if (isset($csv_select['customer_last_name'])) {
                  $table[$i]['customer_last_name'] = isset($lead->last_name) ? get_gdpr_encrypt_data($lead->last_name) : '--';
                }
                if (isset($csv_select['customer_email'])) {
                  $table[$i]['customer_email'] = isset($lead->email) ? get_gdpr_encrypt_data($lead->email) : '--';
                }
                if (isset($csv_select['customer_phone'])) {
                  $table[$i]['customer_phone'] = isset($lead->phone) ? get_gdpr_encrypt_data($lead->phone) : '--';
                }
                if (isset($csv_select['customer_dob'])) {
                  $table[$i]['customer_dob'] = isset($lead->dob) ? get_gdpr_encrypt_data($lead->dob) : '--';
                }
                if (isset($csv_select['customer_alternate_phone'])) {
                  $table[$i]['customer_alternate_phone'] = isset($lead->alternate_phone) ? get_gdpr_encrypt_data($lead->alternate_phone) : '--';
                }


                $identificationType = '--';
                $identificationNumber ='--';
                $identificationExpiry = '--';  
                $identificationMiddleName = '--';
                $identificationPassportCountry = '--';
                $identificationLicenceState = '--';
                $cardColor = '--';
                
                $secondaryidentificationType = '--';
                $secondaryidentificationNumber ='--';
                $secondaryidentificationExpiry = '--';  
                $secondaryidentificationMiddleName = '--';
                $secondaryidentificationPassportCountry = '--';
                $secondaryidentificationLicenceState = '--';
                $secondarycardColor = '--';


                foreach($lead->saleIdentification as $identification)
                { 
                    if(isset($identification->identification_option) && $identification->identification_option == 1){
                        $identificationType = isset($identification->identification_type) ? $identification->identification_type : '--';

                        if($identification->identification_type == 'Drivers Licence'){
                            $identificationNumber = isset($identification->licence_number) ? get_gdpr_encrypt_data($identification->licence_number) : '--';
                            $identificationExpiry = isset($identification->licence_expiry_date) ? get_gdpr_encrypt_data($identification->licence_expiry_date) : '--';
                            $identificationLicenceState = isset($identification->licence_state_code) ? get_gdpr_encrypt_data($identification->licence_state_code) : '--';
                        }
                        else if($identification->identification_type == 'Medicare Card'){
                            $identificationNumber = isset($identification->medicare_number) ? get_gdpr_encrypt_data($identification->medicare_number) : '--';
                            $identificationExpiry = isset($identification->medicare_card_expiry_date) ? get_gdpr_encrypt_data($identification->medicare_card_expiry_date) : '--';
                            $identificationMiddleName = isset($identification->card_middle_name) ? $identification->card_middle_name : '--';
                        }
                        else if($identification->identification_type == 'Passport'){
                            $identificationNumber = isset($identification->passport_number) ? get_gdpr_encrypt_data($identification->passport_number) : '--';
                            $identificationExpiry = isset($identification->passport_expiry_date) ? get_gdpr_encrypt_data($identification->passport_expiry_date) : '--';
                        }
                        else if($identification->identification_type == 'Foreign Passport'){
                            $identificationNumber = isset($identification->foreign_passport_number) ? get_gdpr_encrypt_data($identification->foreign_passport_number) : '--';
                            $identificationExpiry = isset($identification->foreign_passport_expiry_date) ? get_gdpr_encrypt_data($identification->foreign_passport_expiry_date) : '--';
                            $identificationPassportCountry = isset($identification->foreign_country_name) ? get_gdpr_encrypt_data($identification->foreign_country_name) : '--';
                        }

                        $cardColor = isset($identification->card_color) ? $identification->card_color : '--';
                    }

                    if(isset($identification->identification_option) && $identification->identification_option == 2){
                        $secondaryidentificationType = isset($identification->identification_type) ? $identification->identification_type : '--';

                        if($identification->identification_type == 'Drivers Licence'){
                            $secondaryidentificationNumber = isset($identification->licence_number) ? get_gdpr_encrypt_data($identification->licence_number) : '--';
                            $secondaryidentificationExpiry = isset($identification->licence_expiry_date) ? get_gdpr_encrypt_data($identification->licence_expiry_date) : '--';
                            $secondaryidentificationLicenceState = isset($identification->licence_state_code) ? get_gdpr_encrypt_data($identification->licence_state_code) : '--';
                        }
                        else if($identification->identification_type == 'Medicare Card'){
                            $secondaryidentificationNumber = isset($identification->medicare_number) ? get_gdpr_encrypt_data($identification->medicare_number) : '--';
                            $secondaryidentificationExpiry = isset($identification->medicare_card_expiry_date) ? get_gdpr_encrypt_data($identification->medicare_card_expiry_date) : '--';
                            $secondaryidentificationMiddleName = isset($identification->card_middle_name) ? $identification->card_middle_name : '--';
                        }
                        else if($identification->identification_type == 'Passport'){
                            $secondaryidentificationNumber = isset($identification->passport_number) ? get_gdpr_encrypt_data($identification->passport_number) : '--';
                            $secondaryidentificationExpiry = isset($identification->passport_expiry_date) ? get_gdpr_encrypt_data($identification->passport_expiry_date) : '--';
                        }
                        else if($identification->identification_type == 'Foreign Passport'){
                            $secondaryidentificationNumber = isset($identification->foreign_passport_number) ? get_gdpr_encrypt_data($identification->foreign_passport_number) : '--';
                            $secondaryidentificationExpiry = isset($identification->foreign_passport_expiry_date) ? get_gdpr_encrypt_data($identification->foreign_passport_expiry_date) : '--';
                            $secondaryidentificationPassportCountry = isset($identification->foreign_country_name) ? get_gdpr_encrypt_data($identification->foreign_country_name) : '--';
                        }

                        $secondarycardColor = isset($identification->card_color) ? $identification->card_color : '--';
                    }
                }


                if (isset($csv_select['identification_type'])) {
                    $table[$i]['identification_type'] = $identificationType!=''?$identificationType:'--';  
                }

                if (isset($csv_select['identification_number'])) {
                  $table[$i]['identification_number'] = $identificationNumber!=''?$identificationNumber:'--';  
                }

                if (isset($csv_select['identification_expiry'])) {
                  $table[$i]['identification_expiry'] = $identificationExpiry!=''?$identificationExpiry:'--'; 
                }

                if (isset($csv_select['licence_state_code'])) {
                  $table[$i]['licence_state_code'] = $identificationLicenceState!=''?$identificationLicenceState:'--'; 
                }

                if (isset($csv_select['middle_name_on_card'])) {
                  $table[$i]['middle_name_on_card'] = $identificationMiddleName!=''?$identificationMiddleName:'--'; 
                }

                if (isset($csv_select['passport_country'])) {
                  $table[$i]['passport_country'] = $identificationPassportCountry!=''?$identificationPassportCountry:'--'; 
                }

                if (isset($csv_select['card_color'])) {
                    if($cardColor == 1)
                    {
                        $cardColor = 'G';
                    }
                    elseif($cardColor == 2)
                    {
                        $cardColor = 'B';
                    }
                    elseif($cardColor == 3)
                    {
                        $cardColor = 'Y';
                    }
                    else
                    {
                        $cardColor = '--';
                    }
                    $table[$i]['card_color'] = '--';
                }

                    
                if (isset($csv_select['identification_type_secondary'])) {
                    $table[$i]['identification_type_secondary'] = $secondaryidentificationType!=''?$secondaryidentificationType:'--';
                }

                if (isset($csv_select['identification_number_secondary'])) {
                    $table[$i]['identification_number_secondary'] = $secondaryidentificationNumber!=''?$secondaryidentificationNumber:'--'; 
                }

                if (isset($csv_select['identification_expiry_secondary'])) {
                  $table[$i]['identification_expiry_secondary'] = $secondaryidentificationExpiry!=''?$secondaryidentificationExpiry:'--'; 
                }

                if (isset($csv_select['licence_state_code_secondary'])) {
                  $table[$i]['licence_state_code_secondary'] = $secondaryidentificationLicenceState!=''?$secondaryidentificationLicenceState:'--'; 
                }

                if (isset($csv_select['middle_name_on_card_secondary'])) {
                  $table[$i]['middle_name_on_card_secondary'] = $secondaryidentificationMiddleName!=''?$secondaryidentificationMiddleName:'--'; 
                }

                if (isset($csv_select['passport_country_secondary'])) {
                  $table[$i]['passport_country_secondary'] = $secondaryidentificationPassportCountry!=''?$secondaryidentificationPassportCountry:'--'; 
                }

                if (isset($csv_select['card_color_secondary'])) {
                    if($secondarycardColor == 1)
                    {
                        $secondarycardColor = 'G';
                    }
                    elseif($secondarycardColor == 2)
                    {
                        $secondarycardColor = 'B';
                    }
                    elseif($secondarycardColor == 3)
                    {
                        $secondarycardColor = 'Y';
                    }
                    else
                    {
                        $secondarycardColor = '--';
                    }
                    $table[$i]['card_color_secondary'] = '--';
                }


                if (isset($csv_select['employer_name'])) {
                  $table[$i]['employer_name'] = isset($lead->employmentDetails->occupation_employer_name) ? $lead->employmentDetails->occupation_employer_name : '--';
                }
                if (isset($csv_select['occupation'])) {
                  $table[$i]['occupation'] = isset($lead->employmentDetails->occupation) ? $lead->employmentDetails->occupation : '--';
                }
                if (isset($csv_select['employement_duration'])) {

                  $employementDuration = '--';
                  if(isset($lead->employmentDetails->occupation_started_yr) && $lead->employmentDetails->occupation_started_yr != '')
                  {
                      $employementDuration = (isset($lead->employmentDetails->occupation_started_yr)?$lead->employmentDetails->occupation_started_yr:'0').' Yr(s) '.(isset($lead->employmentDetails->occupation_started_month)?$lead->employmentDetails->occupation_started_month:'0'). ' Month(s)';
                  }
                  $table[$i]['employement_duration'] =  $employementDuration;
                }   
                if (isset($csv_select['have_credit_card'])) {
                  $table[$i]['have_credit_card'] = isset($lead->employmentDetails->user_have_cc) ? ($lead->employmentDetails->user_have_cc==1?'Yes':'No') : '--';
                } 
                if (isset($csv_select['occupation_type'])) {
                  $table[$i]['occupation_type'] = isset($lead->employmentDetails->occupation_type) ? $lead->employmentDetails->occupation_type : '--';
                } 
                if (isset($csv_select['industry'])) {
                  $table[$i]['industry'] = isset($lead->employmentDetails->occupation_industry) ? $lead->employmentDetails->occupation_industry : '--';
                }
                if (isset($csv_select['employement_status'])) {
                  $table[$i]['employement_status'] = isset($lead->employmentDetails->occupation_status) ? $lead->employmentDetails->occupation_status : '--';
                }
                if (isset($csv_select['time_at_current_address'])) {
                   
                  $timeAtCurrentAddress = '--';
                  if(isset($lead->saleCompleteAddress->living_year) && $lead->saleCompleteAddress->living_year != '')
                  {
                      $timeAtCurrentAddress = (isset($lead->saleCompleteAddress->living_year)?$lead->saleCompleteAddress->living_year:'0').' Yr(s) '.(isset($lead->saleCompleteAddress->living_month)?$lead->saleCompleteAddress->living_month:'0'). ' Month(s)';
                  }
                  $table[$i]['time_at_current_address'] = $timeAtCurrentAddress;              
                }
                if (isset($csv_select['previous_address'])) {
                  $table[$i]['previous_address'] = isset($lead->salePreviousAddress->full_address) ? $lead->salePreviousAddress->full_address : '--';
                } 
                if (isset($csv_select['delivery_address'])) {
                    if($lead->delivery_preferences =='address')
                    {
                          $table[$i]['delivery_address'] =  isset($lead->saleCompleteAddress->full_address) ? $lead->saleCompleteAddress->full_address : '--';
                    }
                    elseif ($lead->delivery_preferences =='other') {
                          $table[$i]['delivery_address'] =  isset($lead->saleDeliveryAddress->full_address) ? $lead->saleDeliveryAddress->full_address : '--';
                    } 
                    else
                    {
                         $table[$i]['delivery_address'] =  '--';
                    }
                }
                if (isset($csv_select['billing_address'])) {
                    if($lead->billing_preferences =='address')
                    {
                          $table[$i]['billing_address'] =  isset($lead->saleCompleteAddress->full_address) ? $lead->saleCompleteAddress->full_address : '--';
                    }
                    elseif ($lead->billing_preferences =='email') {
                          $table[$i]['billing_address'] =  isset($lead->email) ? get_gdpr_encrypt_data($lead->email) : '--';
                    }
                    elseif ($lead->billing_preferences =='other') 
                    {
                          $table[$i]['billing_address'] =  isset($lead->saleBillingAddress->full_address) ? $lead->saleBillingAddress->full_address : '--';
                    }
                    else
                    {
                         $table[$i]['billing_address'] =  '--';
                    }
                }   
                if (isset($csv_select['resident_status'])) {
                  $table[$i]['resident_status'] = isset($lead->saleCompleteAddress->residential_status) ? $lead->saleCompleteAddress->residential_status : '--';
                }
                if (isset($csv_select['connection_delivery_date'])) {
                  $table[$i]['connection_delivery_date'] = isset($lead->connection_delivery_date) ? $lead->connection_delivery_date : '--';
                }

                if (isset($csv_select['provider'])) {
                  $table[$i]['provider'] = isset($lead->providers->business_name) ? $lead->providers->business_name : '--';
                }
                  
                if (isset($csv_select['internet_speed'])) {
                  $table[$i]['internet_speed'] = isset($lead->plan_internet_speed) ? $lead->plan_internet_speed : '--';
                }
                if (isset($csv_select['contract_length'])) {
                  $contractLength = $contractNames->get($lead->contract_id);
                  $table[$i]['contract_length'] = isset($contractLength) ? $contractNames->get($lead->contract_id).'Month(s)' : '--';
                }

                if (isset($csv_select['total_data_allowance'])) {
                  $table[$i]['total_data_allowance'] = isset($lead->total_data_allowance) ? $lead->total_data_allowance : '--';
                }
                if (isset($csv_select['download_speed'])) {
                  $table[$i]['download_speed'] = isset($lead->download_speed) ? $lead->download_speed : '--';
                } 
                if (isset($csv_select['upload_speed'])) {
                  $table[$i]['upload_speed'] = isset($lead->upload_speed) ? $lead->upload_speed : '--';
                }
                if (isset($csv_select['special_offer_price'])) {
                  $table[$i]['special_offer_price'] = isset($lead->plan_special_offer_price) ? $lead->plan_special_offer_price: '--';
                }
                if (isset($csv_select['special_offer_description'])) {
                  $table[$i]['special_offer_description'] = isset($lead->plan_special_offer) ? $lead->plan_special_offer: '--';
                } 
                if (isset($csv_select['nbm_key_fact'])) {
                  $table[$i]['nbm_key_fact'] = isset($lead->plan_nbn_key_url) ? $lead->plan_nbn_key_url: '--';
                }
                if (isset($csv_select['critical_information'])) {
                  $table[$i]['critical_information'] = isset($lead->critical_info_url) ? $lead->critical_info_url: '--';
                } 
                if (isset($csv_select['plan_acknowledgment_consent'])) {
                  $table[$i]['plan_acknowledgment_consent'] = isset($lead->getSaleCommonData)?'Plan Ack Checkbox Content : '.$lead->getSaleCommonData->eic_checkbox_content.' , Plan Ack Content : '.$lead->getSaleCommonData->eic_content: '--';
                }  
                // if (isset($csv_select['phone_home_line_connection'])) {
                //   $table[$i]['phone_home_line_connection'] = '--';
                // } 
                if (isset($csv_select['monthly_cost'])) {
                  $table[$i]['monthly_cost'] =  isset($lead->monthly_cost) ? $lead->monthly_cost: '--';
                }
                if (isset($csv_select['setup_fee'])) {
                  $table[$i]['setup_fee'] =  isset($lead->setup_fee) ? $lead->setup_fee: '--';
                }
                if (isset($csv_select['delivery_fee'])) {
                  $table[$i]['delivery_fee'] = isset($lead->delivery_fee) ? $lead->delivery_fee: '--';
                }
                if (isset($csv_select['payment_processing_fee'])) {
                  $table[$i]['payment_processing_fee'] =   isset($lead->payment_processing_fees) ? $lead->payment_processing_fees: '--';
                }
                if (isset($csv_select['termination_fee'])) {
                  $table[$i]['termination_fee'] =  isset($lead->termination_fee) ? $lead->termination_fee: '--';
                } 
                if (isset($csv_select['other_fee_and_charge'])) {
                  $table[$i]['other_fee_and_charge'] =  isset($lead->other_fee_and_charges) ? $lead->other_fee_and_charges: '--';
                }
                if (isset($csv_select['minimum_total_cost'])) {
                  $table[$i]['minimum_total_cost'] = isset($lead->minimum_total_cost) ? $lead->minimum_total_cost: '--';
                }
                if (isset($csv_select['questions'])) {
                  $questions= '';
                  $que =1;
                  foreach ($lead->getSatelliteQuestions as $satellite) {
                      if($que!=1)
                      {
                        $questions .= ' , ';  
                      }
                      $questions .= $que.'. ';
                      foreach($satellite->parent_question as $parentData)
                      {
                        $questions .= $parentData->question.' : ';
                      }
                      
                      foreach($satellite->options as $optionData)
                      {
                        $questions .= $optionData->question.' '; 
                      }
                      $que++; 
                  }
                  $table[$i]['questions'] = $questions==''?'--':$questions;
                }   
                if (isset($csv_select['included_home_line_connection'])) {
                  $phomeHomeLineConnection = '--';
                  if(isset($lead->SaleHomeConnection))
                  {
                      $phomeHomeLineConnection = '';
                      foreach($lead->SaleHomeConnection as $connection)
                      {
                          if($connection->is_mandatory == 1)
                            $phomeHomeLineConnection .= 'Name: '.(isset($connection->BroadbandPhoneHomeConnection->call_plan_name)?$connection->BroadbandPhoneHomeConnection->call_plan_name:'').' - Price: '.$connection->phone_home_connection_price.' , ';
                      }
                  }
                  $table[$i]['included_home_line_connection'] = $phomeHomeLineConnection != ''?$phomeHomeLineConnection:'--';
                } 
                if (isset($csv_select['included_modem'])) {
                  $modemConnection = '--';
                  if(isset($lead->SaleModem))
                  {
                      $modemConnection = '';
                      foreach($lead->SaleModem as $connection)
                      { 
                          if($connection->is_mandatory == 1)
                            $modemConnection .= 'Name: '.(isset($connection->BroadbandModemConnection->modem_modal_name)?$connection->BroadbandModemConnection->modem_modal_name:'').' - Price: '.$connection->broadband_modem_price.' , ';
                      }
                  }
                  $table[$i]['included_modem'] = $modemConnection!=''?$modemConnection:'--';
                }
                if (isset($csv_select['included_other_addons'])) {
                  $addonConnection = '--';
                  if(isset($lead->SaleAddons))
                  {
                      $addonConnection = '';
                      foreach($lead->SaleAddons as $connection)
                      { 
                          if($connection->is_mandatory == 1)
                            $addonConnection .= 'Name: '.(isset($connection->BroadbandAddonConnection->addon_name)?$connection->BroadbandAddonConnection->addon_name:'').' - Price: '.$connection->broadband_other_addon_price.' , ';
                      }
                  } 
                  $table[$i]['included_other_addons'] = $addonConnection!=''?$addonConnection:'--';
                }
                if (isset($csv_select['home_line_connection'])) {
                  $phomeHomeLineConnection = '--';
                  if(isset($lead->SaleHomeConnection))
                  {
                      $phomeHomeLineConnection = '';
                      foreach($lead->SaleHomeConnection as $connection)
                      {
                          if($connection->is_mandatory == 0)
                            $phomeHomeLineConnection .= 'Name: '.(isset($connection->BroadbandPhoneHomeConnection->call_plan_name)?$connection->BroadbandPhoneHomeConnection->call_plan_name:'').' - Price: '.$connection->phone_home_connection_price.' , ';
                      }
                  }
                  
                  $table[$i]['home_line_connection'] = $phomeHomeLineConnection!=''?$phomeHomeLineConnection:'--';
                } 
                if (isset($csv_select['modem'])) {
                  $modemConnection = '--';
                  if(isset($lead->SaleModem))
                  {
                      $modemConnection = '';
                      foreach($lead->SaleModem as $connection)
                      { 
                          if($connection->is_mandatory == 0)
                            $modemConnection .= 'Name: '.(isset($connection->BroadbandModemConnection->modem_modal_name)?$connection->BroadbandModemConnection->modem_modal_name:'').' - Price: '.$connection->broadband_modem_price.' , ';
                      }
                  } 
                  $table[$i]['modem'] = $modemConnection!=''?$modemConnection:'--';
                }
                if (isset($csv_select['other_addons'])) {
                  $addonConnection = '--';
                  if(isset($lead->SaleAddons))
                  {
                      $addonConnection = '';
                      foreach($lead->SaleAddons as $connection)
                      { 
                          if($connection->is_mandatory == 0)
                            $addonConnection .= 'Name: '.(isset($connection->BroadbandAddonConnection->addon_name)?$connection->BroadbandAddonConnection->addon_name:'').' - Price: '.$connection->broadband_other_addon_price.' , ';
                      }
                  }
                  $table[$i]['other_addons'] = $addonConnection!=''?$addonConnection:'--';
                }    
      
                if (isset($csv_select['having_account_with_current_provider'])) {
                  $isProviderAccount = 'No';
                  if(isset($lead->is_provider_account) && $lead->is_provider_account == 1)
                  {
                    $isProviderAccount = 'Yes';
                  }
                  $table[$i]['having_account_with_current_provider'] = $isProviderAccount;
                }
                if (isset($csv_select['account_number'])) {
                  $table[$i]['account_number'] = isset($lead->current_account) ? $lead->current_account : '--';
                }  
                if (isset($csv_select['keep_existing_phone_number'])) {
                  $isPhoneNumber = 'No';
                  if(isset($lead->is_phone_number) && $lead->is_phone_number == 1)
                  {
                    $isPhoneNumber = 'Yes';
                  }
                  $table[$i]['keep_existing_phone_number'] = $isPhoneNumber;
                }
                if (isset($csv_select['home_number'])) {
                  $table[$i]['home_number'] = isset($lead->home_number) ? get_gdpr_encrypt_data($lead->home_number) : '--';
                }
                if (isset($csv_select['private_account_number'])) {
                  $table[$i]['private_account_number'] = isset($lead->provider_account) ? $lead->provider_account : '--';
                }
                if (isset($csv_select['transfer_service'])) {
                  $transferService = 'No';
                  if(isset($lead->transfer_service) && $lead->transfer_service == 1)
                  {
                    $transferService = 'Yes';
                  }
                  $table[$i]['transfer_service'] = $transferService;
                }
                if (isset($csv_select['browser'])) {
                  $table[$i]['browser'] = isset($lead->browser) ? $lead->browser : '--'; 
                }
                if (isset($csv_select['platform'])) {
                  $table[$i]['platform'] = isset($lead->platform) ? $lead->platform : '--';
                }
                if (isset($csv_select['device_type'])) {
                  $table[$i]['device_type'] = isset($lead->device) ? $lead->device : '--';
                }
                if (isset($csv_select['user_agent'])) {
                  $table[$i]['user_agent'] = isset($lead->user_agent) ? $lead->user_agent : '--';
                }
                if (isset($csv_select['lead_ip'])) {
                  $table[$i]['lead_ip'] = isset($lead->ip_address) ? get_gdpr_encrypt_data($lead->ip_address) : '--';
                }
                if (isset($csv_select['lead_date'])) {
                  $table[$i]['lead_date'] = isset($lead->created_at) ? $lead->created_at : '--';
                }
                if (isset($csv_select['latitude'])) {
                  $table[$i]['latitude'] = isset($lead->latitude) ? $lead->latitude : '--';
                }
                if (isset($csv_select['longitude'])) {
                  $table[$i]['longitude'] = isset($lead->longitude) ? $lead->longitude : '--';
                }   
                $csv_row_data = salesCsvRowData($table[$i], $request->selected_data,$saleType);  
                fputcsv($handle, $csv_row_data);

                $i++;
            }   

          });
        fclose($handle); 
        //close csv file
      }
      catch (Exception $err){
        throw new Exception($err->getMessage(),0,$err);
      }
  }

  /*
  * csv_document_link => get  lead/sale csv file path from s3 bucket
  * 
  */
  function csv_document_link($s3bukcetpath, $s3_bucket = 's3')
  {
    try
    {
        $document_token = $s3bukcetpath;
        if (!empty($document_token)) {
          $disk = \Storage::disk($s3_bucket);
          $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.' . $s3_bucket . '.bucket'),
            'Key' => $s3bukcetpath,
            'ResponseContentDisposition' => 'attachment;'
          ]);
          $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+' . env('s3_TIMEOUT', 15) . ' minutes');
          return ['success' => true, 'file_url' => (string) $request->getUri()];
        } 
        else {
          return ['success' => true, 'message' => 'no-data'];
        }
    }
    catch (Exception $err){
      throw new Exception($err->getMessage(),0,$err);
    }
  }
 
  /*
   * DESC: to return sale csv header row on behalf of selected fields
   * */
  function csv_header_data($csv_select,$saleType)
  {
    try
    {
      $order = [];
      if($saleType == 'sale')
      {
          if (isset($csv_select['sale_status'])) {
            $order[] = 'Sale Status';
          }
          if (isset($csv_select['sale_sub_status'])) {
            $order[] = 'Sale Sub Status';
          }
      }
      if (isset($csv_select['source'])) {
        $order[] = 'Source';
      }
      if (isset($csv_select['rc'])) {
        $order[] = 'RC';
      }
      if (isset($csv_select['cui'])) {
        $order[] = 'CUI';
      }
      if (isset($csv_select['utm_source'])) {
        $order[] = 'UTM Source';
      }
      if (isset($csv_select['utm_medium'])) {
        $order[] = 'UTM Medium';
      }
      if (isset($csv_select['utm_campaign'])) {
        $order[] = 'UTM Campaign';
      }
      if (isset($csv_select['utm_term'])) {
        $order[] = 'UTM Term';
      }  
      if (isset($csv_select['utm_content'])) {
        $order[] = 'UTM Content';
      }
      if (isset($csv_select['gclid'])) {
        $order[] = 'GCLID';
      }
      if (isset($csv_select['fbclid'])) {
        $order[] = 'FBCLID';
      }
      if($saleType == 'lead')
      {
          if (isset($csv_select['sale_id'])) {
            $order[] = 'Lead ID';
          }
      }
      else if($saleType == 'sale')
      {
        if (isset($csv_select['sale_id'])) {
            $order[] = 'Sale ID';
        }
        if (isset($csv_select['reference_number'])) {
          $order[] = 'Reference Number';
        }
        if (isset($csv_select['sale_create_date'])) {
          $order[] = 'Sale Create Date';
        }
      }
      if (isset($csv_select['utm_rm'])) {
        $order[] = 'UTM RM';
      }
      if (isset($csv_select['utm_rm_source'])) {
        $order[] = 'UTM RM Source';
      }
      if (isset($csv_select['utm_rm_date'])) {
        $order[] = 'UTM RM Date';
      }
      if (isset($csv_select['duplicate_status'])) {
        $order[] = 'Duplicate';
      }
      if (isset($csv_select['affiliate_information'])) {
        $order[] = 'Affiliate Information';
      }
      if (isset($csv_select['affiliate_name'])) {
        $order[] = 'Affiliate Name';
      }
      if (isset($csv_select['affiliate_email'])) {
        $order[] = 'Affiliate Email';
      }
      if (isset($csv_select['affiliate_phone'])) {
        $order[] = 'Affiliate Phone';
      }
      if (isset($csv_select['sub_affiliate_name'])) {
        $order[] = 'Sub Affiliate Name';
      }
      if (isset($csv_select['referral_code_url_title'])) {
        $order[] = 'Referral Code Url Title';
      }  
      if (isset($csv_select['complete_address'])) {
        $order[] = 'Complete Address';
      }
      if (isset($csv_select['movin_date'])) {
        $order[] = 'Move In Date';
      }
      if (isset($csv_select['plan_name'])) {
        $order[] = 'Plan Name';
      }
      if (isset($csv_select['service_type'])) {
        $order[] = 'Service Type';
      }
      if (isset($csv_select['connection_type'])) {
        $order[] = 'Connection Type';
      }
      if (isset($csv_select['total_plan_cost'])) {
        $order[] = 'Total Plan Cost';
      }
      if (isset($csv_select['provider'])) {
        $order[] = 'Provider';
      }
      if (isset($csv_select['customer_title'])) {
        $order[] = 'Title';
      }
      if (isset($csv_select['customer_first_name'])) {
        $order[] = 'First Name';
      }
      if (isset($csv_select['customer_middle_name'])) {
        $order[] = 'Middle Name';
      }
      if (isset($csv_select['customer_last_name'])) {
        $order[] = 'Last Name';
      }
      if (isset($csv_select['customer_email'])) {
        $order[] = 'Email';
      }
      if (isset($csv_select['customer_phone'])) {
        $order[] = 'Phone';
      }
      if (isset($csv_select['customer_alternate_phone'])) {
        $order[] = 'Alternate Phone';
      }
      if (isset($csv_select['customer_dob'])) {
        $order[] = 'DOB';
      }
      if (isset($csv_select['identification_type'])) {
        $order[] = 'Primary Identification Type';
      }
      if (isset($csv_select['identification_number'])) {
        $order[] = 'Primary Identification Number';
      }
      if (isset($csv_select['identification_expiry'])) {
        $order[] = 'Primary Identification Expiry Date';
      }
      if (isset($csv_select['licence_state_code'])) {
        $order[] = 'Primary Licence State Code';
      } 
      if (isset($csv_select['passport_country'])) {
        $order[] = 'Primary Passport Country';
      }
      if (isset($csv_select['middle_name_on_card'])) {
        $order[] = 'Primary Middle Name On Card';
      }
      if (isset($csv_select['card_color'])) {
        $order[] = 'Primary Card Color';
      }
      if (isset($csv_select['identification_type_secondary'])) {
        $order[] = 'Secondary Identification Type';
      }
      if (isset($csv_select['identification_number_secondary'])) {
        $order[] = 'Secondary Identification Number';
      }
      if (isset($csv_select['identification_expiry_secondary'])) {
        $order[] = 'Secondary Identification Expiry Date';
      }
      if (isset($csv_select['licence_state_code_secondary'])) {
        $order[] = 'Secondary Licence State Code';
      } 
      if (isset($csv_select['passport_country_secondary'])) {
        $order[] = 'Secondary Passport Country';
      }
      if (isset($csv_select['middle_name_on_card_secondary'])) {
        $order[] = 'Secondary Middle Name On Card';
      }
      if (isset($csv_select['card_color_secondary'])) {
        $order[] = 'Secondary Card Color';
      }
      if (isset($csv_select['employer_name'])) {
        $order[] = 'Employer Name';
      }
      if (isset($csv_select['occupation'])) {
        $order[] = 'Occupation';
      } 
      if (isset($csv_select['employement_duration'])) {
        $order[] = 'Employement Duration';
      }
      if (isset($csv_select['have_credit_card'])) {
        $order[] = 'Have Credit Card';
      }
      if (isset($csv_select['occupation_type'])) {
        $order[] = 'Occupation Type';
      }
      if (isset($csv_select['industry'])) {
        $order[] = 'Industry';
      }
      if (isset($csv_select['employement_status'])) {
        $order[] = 'Employement Status';
      }

      if (isset($csv_select['time_at_current_address'])) {
        $order[] = 'Time At Current Address';
      }
      if (isset($csv_select['previous_address'])) {
        $order[] = 'Previous Address';
      } 
      if (isset($csv_select['delivery_address'])) {
        $order[] = 'Delivery Address';
      }
      if (isset($csv_select['billing_address'])) {
        $order[] = 'Billing Address';
      }
       
      if (isset($csv_select['resident_status'])) {
        $order[] = 'Resident Status';
      }
      if (isset($csv_select['connection_delivery_date'])) {
        $order[] = 'Connection Delivery Date';
      }
      if (isset($csv_select['internet_speed'])) {
        $order[] = 'Internet Speed';
      }
      if (isset($csv_select['contract_length'])) {
        $order[] = 'Contract Length';
      }
      if (isset($csv_select['total_data_allowance'])) {
        $order[] = 'Total Data Allowance';
      }
      if (isset($csv_select['download_speed'])) {
        $order[] = 'Download Speed';
      }
      if (isset($csv_select['upload_speed'])) {
        $order[] = 'Upload Speed';
      }
      if (isset($csv_select['special_offer_price'])) {
        $order[] = 'Special Offer Price';
      }
      if (isset($csv_select['special_offer_description'])) {
        $order[] = 'Special Offer Description';
      }
      if (isset($csv_select['nbm_key_fact'])) {
        $order[] = 'NBM Key Fact';
      }
      if (isset($csv_select['critical_information'])) {
        $order[] = 'Critical Information';
      }
      if (isset($csv_select['plan_acknowledgment_consent'])) {
        $order[] = 'Plan Acknowledgment Consent ';
      }
      // if (isset($csv_select['phone_home_line_connection'])) {
      //   $order[] = 'Phone Home Line Connection ';
      // }
      if (isset($csv_select['monthly_cost'])) {
        $order[] = 'Monthly Cost';
      }
      if (isset($csv_select['setup_fee'])) {
        $order[] = 'Setup Fee';
      }
      if (isset($csv_select['delivery_fee'])) {
        $order[] = 'Delivery Fee';
      }
      if (isset($csv_select['payment_processing_fee'])) {
        $order[] = 'Payment Processing Fee';
      }
      if (isset($csv_select['termination_fee'])) {
        $order[] = 'Termination Fee';
      }
      if (isset($csv_select['other_fee_and_charge'])) {
        $order[] = 'Other Fee And Charge';
      }
      if (isset($csv_select['minimum_total_cost'])) {
        $order[] = 'Minimum Total Cost';
      }
      if (isset($csv_select['questions'])) {
        $order[] = 'Satellite Installation';
      }
      if (isset($csv_select['included_home_line_connection'])) {
        $order[] = 'Included Home Line Connection';
      }
      if (isset($csv_select['included_modem'])) {
        $order[] = 'Included Modem';
      }
      if (isset($csv_select['included_other_addons'])) {
        $order[] = 'Included Other Addons ';
      }
      if (isset($csv_select['home_line_connection'])) {
        $order[] = 'Home Line Connection';
      }
      if (isset($csv_select['modem'])) {
        $order[] = 'Modem';
      }
      if (isset($csv_select['other_addons'])) {
        $order[] = 'Other Addons ';
      }
      if (isset($csv_select['having_account_with_current_provider'])) {
        $order[] = 'Account With Current Provider';
      }
      if (isset($csv_select['account_number'])) {
        $order[] = 'Account Number';
      }
      if (isset($csv_select['keep_existing_phone_number'])) {
        $order[] = 'Existing Phone Number';
      }
      if (isset($csv_select['home_number'])) {
        $order[] = 'Home Number';
      }
      if (isset($csv_select['private_account_number'])) {
        $order[] = 'Provider Account Number';
      }
      if (isset($csv_select['transfer_service'])) {
        $order[] = 'Transfer Service';
      }
      if (isset($csv_select['browser'])) {
        $order[] = 'Browser';
      }
      if (isset($csv_select['platform'])) {
        $order[] = 'Platform';
      }
      if (isset($csv_select['device_type'])) {
        $order[] = 'Device Type';
      }
      if (isset($csv_select['user_agent'])) {
        $order[] = 'User Agent';
      }
      if (isset($csv_select['lead_ip'])) {
        $order[] = 'lead IP';
      }
      if (isset($csv_select['lead_date'])) {
        $order[] = 'Lead Date';
      }
      if (isset($csv_select['latitude'])) {
        $order[] = 'Latitude';
      }
      if (isset($csv_select['longitude'])) {
        $order[] = 'Longitude';
      } 
      return $order;
    }
    catch (Exception $err){
      throw new Exception($err->getMessage(),0,$err);
    }
  } 
 
  /*
   * DESC: to return sale info csv  row on behalf of selected fields
   * */
  function salesCsvRowData($row, $csv_select,$saleType)
  {
    try
    {
      $csv_row = [];
      if($saleType == 'sale')
      {
          if (isset($csv_select['sale_status'])) {
            $csv_row[] = $row['sale_status'];
          }
          if (isset($csv_select['sale_sub_status'])) {
            $csv_row[] = $row['sale_sub_status'];
          }
      }
      if (isset($csv_select['source'])) {
        $csv_row[] = $row['source'];
      }
      if (isset($csv_select['rc'])) {
        $csv_row[] = $row['rc'];
      }
      
      if (isset($csv_select['cui'])) {
        $csv_row[] = $row['cui'];
      }
      if (isset($csv_select['utm_source'])) {
        $csv_row[] = $row['utm_source'];
      }
      if (isset($csv_select['utm_medium'])) {
        $csv_row[] = $row['utm_medium'];
      }
      if (isset($csv_select['utm_campaign'])) {
        $csv_row[] = $row['utm_campaign'];
      }
      if (isset($csv_select['utm_term'])) {
        $csv_row[] = $row['utm_term'];
      }
      if (isset($csv_select['utm_content'])) {
        $csv_row[] = $row['utm_content'];
      }
      if (isset($csv_select['gclid'])) {
        $csv_row[] = $row['gclid'];
      }
      if (isset($csv_select['fbclid'])) {
        $csv_row[] = $row['fbclid'];
      }
      if($saleType == 'lead')
      {
          if (isset($csv_select['sale_id'])) {
            $csv_row[] = $row['sale_id'];
          }
      }
      else if($saleType == 'sale')
      {
        if (isset($csv_select['sale_id'])) {
          $csv_row[] = $row['sale_id'];
        }
        if (isset($csv_select['reference_number'])) {
          $csv_row[] = $row['reference_number'];
        }
        if (isset($csv_select['sale_create_date'])) {
          $csv_row[] = $row['sale_create_date'];
        }
      }
      if (isset($csv_select['utm_rm'])) {
        $csv_row[] = $row['utm_rm'];
      }
      if (isset($csv_select['utm_rm_source'])) {
        $csv_row[] = $row['utm_rm_source'];
      }
      if (isset($csv_select['utm_rm_date'])) {
        $csv_row[] = $row['utm_rm_date'];
      }
      if (isset($csv_select['duplicate_status'])) {
        $csv_row[] = $row['duplicate_status'];
      }
      if (isset($csv_select['affiliate_information'])) {
        $csv_row[] = $row['affiliate_information'];
      }
      if (isset($csv_select['affiliate_name'])) {
        $csv_row[] = $row['affiliate_name'];
      }
      if (isset($csv_select['affiliate_email'])) {
        $csv_row[] = $row['affiliate_email'];
      }
      if (isset($csv_select['affiliate_phone'])) {
        $csv_row[] = $row['affiliate_phone'];
      }
      if (isset($csv_select['sub_affiliate_name'])) {
        $csv_row[] = $row['sub_affiliate_name'];
      }
      if (isset($csv_select['referral_code_url_title'])) {
        $csv_row[] = $row['referral_code_url_title'];
      }
      
      if (isset($csv_select['complete_address'])) {
        $csv_row[] = $row['complete_address'];
      }
      if (isset($csv_select['movin_date'])) {
        $csv_row[] = $row['movin_date'];
      }
      if (isset($csv_select['plan_name'])) {
        $csv_row[] = $row['plan_name'];
      }
      if (isset($csv_select['service_type'])) {
        $csv_row[] = $row['service_type'];
      }
      if (isset($csv_select['connection_type'])) {
        $csv_row[] = $row['connection_type'];
      }
      if (isset($csv_select['total_plan_cost'])) {
        $csv_row[] = $row['total_plan_cost'];
      }
      if (isset($csv_select['provider'])) {
        $csv_row[] = $row['provider'];
      }
      if (isset($csv_select['customer_title'])) {
        $csv_row[] = $row['customer_title'];
      }
      if (isset($csv_select['customer_first_name'])) {
        $csv_row[] = $row['customer_first_name'];
      }
      if (isset($csv_select['customer_middle_name'])) {
        $csv_row[] = $row['customer_middle_name'];
      }
      if (isset($csv_select['customer_last_name'])) {
        $csv_row[] = $row['customer_last_name'];
      }
       
      if (isset($csv_select['customer_email'])) {
        $csv_row[] = $row['customer_email'];
      }
      if (isset($csv_select['customer_phone'])) {
        $csv_row[] = $row['customer_phone'];
      }
      if (isset($csv_select['customer_alternate_phone'])) {
        $csv_row[] = $row['customer_alternate_phone'];
      }
      if (isset($csv_select['customer_dob'])) {
        $csv_row[] = $row['customer_dob'];
      }
      if (isset($csv_select['identification_type'])) {
        $csv_row[] = $row['identification_type'];
      }
      if (isset($csv_select['identification_number'])) {
        $csv_row[] = $row['identification_number'];
      }
      if (isset($csv_select['identification_expiry'])) {
        $csv_row[] = $row['identification_expiry'];
      }
      if (isset($csv_select['licence_state_code'])) {
        $csv_row[] = $row['licence_state_code'];
      } 
      if (isset($csv_select['passport_country'])) {
        $csv_row[] = $row['passport_country'];
      }
      if (isset($csv_select['middle_name_on_card'])) {
        $csv_row[] = $row['middle_name_on_card'];
      } 
      if (isset($csv_select['card_color'])) {
        $csv_row[] = $row['card_color'];
      }
      if (isset($csv_select['identification_type_secondary'])) {
        $csv_row[] = $row['identification_type_secondary'];
      }
      if (isset($csv_select['identification_number_secondary'])) {
        $csv_row[] = $row['identification_number_secondary'];
      }
      if (isset($csv_select['identification_expiry_secondary'])) {
        $csv_row[] = $row['identification_expiry_secondary'];
      }
      if (isset($csv_select['licence_state_code_secondary'])) {
        $csv_row[] = $row['licence_state_code_secondary'];
      } 
      if (isset($csv_select['passport_country_secondary'])) {
        $csv_row[] = $row['passport_country_secondary'];
      }
      if (isset($csv_select['middle_name_on_card_secondary'])) {
        $csv_row[] = $row['middle_name_on_card_secondary'];
      } 
      if (isset($csv_select['card_color_secondary'])) {
        $csv_row[] = $row['card_color_secondary'];
      }
      if (isset($csv_select['employer_name'])) {
        $csv_row[] = $row['employer_name'];
      }
      if (isset($csv_select['occupation'])) {
        $csv_row[] = $row['occupation'];
      } 
      if (isset($csv_select['employement_duration'])) {
        $csv_row[] = $row['employement_duration'];
      }
      if (isset($csv_select['have_credit_card'])) {
        $csv_row[] = $row['have_credit_card'];
      }
      if (isset($csv_select['occupation_type'])) {
        $csv_row[] = $row['occupation_type'];
      }
      if (isset($csv_select['industry'])) {
        $csv_row[] = $row['industry'];
      }
      if (isset($csv_select['employement_status'])) {
        $csv_row[] = $row['employement_status'];
      }
      if (isset($csv_select['time_at_current_address'])) {
        $csv_row[] = $row['time_at_current_address'];
      }
      if (isset($csv_select['previous_address'])) {
        $csv_row[] = $row['previous_address'];
      } 
      if (isset($csv_select['delivery_address'])) {
        $csv_row[] = $row['delivery_address'];
      }
      if (isset($csv_select['billing_address'])) {
        $csv_row[] = $row['billing_address'];
      }
       
      if (isset($csv_select['resident_status'])) {
        $csv_row[] = $row['resident_status'];
      }
      if (isset($csv_select['connection_delivery_date'])) {
        $csv_row[] = $row['connection_delivery_date'];
      }
      if (isset($csv_select['internet_speed'])) {
        $csv_row[] = $row['internet_speed'];
      }
      if (isset($csv_select['contract_length'])) {
        $csv_row[] = $row['contract_length'];
      }
      if (isset($csv_select['total_data_allowance'])) {
        $csv_row[] = $row['total_data_allowance'];
      }
      if (isset($csv_select['download_speed'])) {
        $csv_row[] = $row['download_speed'];
      }
      if (isset($csv_select['upload_speed'])) {
        $csv_row[] = $row['upload_speed'];
      }
      if (isset($csv_select['special_offer_price'])) {
        $csv_row[] = $row['special_offer_price'];
      }
      if (isset($csv_select['special_offer_description'])) {
        $csv_row[] = $row['special_offer_description'];
      }
      if (isset($csv_select['nbm_key_fact'])) {
        $csv_row[] = $row['nbm_key_fact'];
      }
      if (isset($csv_select['critical_information'])) {
        $csv_row[] = $row['critical_information'];
      }
      if (isset($csv_select['plan_acknowledgment_consent'])) {
        $csv_row[] = $row['plan_acknowledgment_consent'];
      }
      // if (isset($csv_select['phone_home_line_connection'])) {
      //   $csv_row[] = $row['phone_home_line_connection'];
      // }
      if (isset($csv_select['monthly_cost'])) {
        $csv_row[] = $row['monthly_cost'];
      }
      if (isset($csv_select['setup_fee'])) {
        $csv_row[] = $row['setup_fee'];
      }
      if (isset($csv_select['delivery_fee'])) {
        $csv_row[] = $row['delivery_fee'];
      }
      if (isset($csv_select['payment_processing_fee'])) {
        $csv_row[] = $row['payment_processing_fee'];
      }
      if (isset($csv_select['termination_fee'])) {
        $csv_row[] = $row['termination_fee'];
      }
      if (isset($csv_select['other_fee_and_charge'])) {
        $csv_row[] = $row['other_fee_and_charge'];
      }  
      if (isset($csv_select['minimum_total_cost'])) {
        $csv_row[] = $row['minimum_total_cost'];
      }
      if (isset($csv_select['questions'])) {
        $csv_row[] = $row['questions'];
      }
      if (isset($csv_select['included_home_line_connection'])) {
        $csv_row[] = $row['included_home_line_connection'];
      }
      if (isset($csv_select['included_modem'])) {
        $csv_row[] = $row['included_modem'];
      }
      if (isset($csv_select['included_other_addons'])) {
        $csv_row[] = $row['included_other_addons'];
      }
      if (isset($csv_select['home_line_connection'])) {
        $csv_row[] = $row['home_line_connection'];
      }
      if (isset($csv_select['modem'])) {
        $csv_row[] = $row['modem'];
      }
      if (isset($csv_select['other_addons'])) {
        $csv_row[] = $row['other_addons'];
      }
      if (isset($csv_select['having_account_with_current_provider'])) {
        $csv_row[] = $row['having_account_with_current_provider'];
      }
      if (isset($csv_select['account_number'])) {
        $csv_row[] = $row['account_number'];
      }
      if (isset($csv_select['keep_existing_phone_number'])) {
        $csv_row[] = $row['keep_existing_phone_number'];
      }
      if (isset($csv_select['home_number'])) {
        $csv_row[] = $row['home_number'];
      }
      if (isset($csv_select['private_account_number'])) {
        $csv_row[] = $row['private_account_number'];
      }
      if (isset($csv_select['transfer_service'])) {
        $csv_row[] = $row['transfer_service'];
      }
      if (isset($csv_select['browser'])) {
        $csv_row[] = $row['browser'];
      }
      if (isset($csv_select['platform'])) {
        $csv_row[] = $row['platform'];
      }
      if (isset($csv_select['device_type'])) {
        $csv_row[] = $row['device_type'];
      }
      if (isset($csv_select['user_agent'])) {
        $csv_row[] = $row['user_agent'];
      }
      if (isset($csv_select['lead_ip'])) {
        $csv_row[] = $row['lead_ip'];
      }
      if (isset($csv_select['lead_date'])) {
        $csv_row[] = $row['lead_date'];
      }
      if (isset($csv_select['latitude'])) {
        $csv_row[] = $row['latitude'];
      }
      if (isset($csv_select['longitude'])) {
        $csv_row[] = $row['longitude'];
      }
      return $csv_row;
    }
    catch (Exception $err){
      throw new Exception($err->getMessage(),0,$err);
    }
  }

  /*
    * generateCreditInfoCsvFile => generate credit info sale information
    * 
  */
  function generateCreditInfoCsvFile($sales,$creditFilename,$order,$credit_csv_select,$request,$saleType)
  { 
      try
      {
        $handle = fopen($creditFilename, 'w+');
        fputcsv($handle, $order); 
        $i=1; 
        $table =[];   
        $sales->select('id','reference_number','unique_id','is_debit_card_or_bank_info')->with(['visitorDebitInfo','visitorbankInfo'])->orderBy('id','DESC')
        ->chunk(500, function ($sales) use($table,$i,$credit_csv_select,$request,$order,$handle,$saleType) 
        {
              foreach ($sales as $lead) 
              {       
                      if (isset($credit_csv_select['credit_sale_id'])) {
                        $table[$i]['credit_sale_id'] = isset($lead->unique_id) ? $lead->unique_id : '--';
                      }
                      
                      $table[$i]['payment_type'] = '--';
                      
                      $table[$i]['name_on_card'] = $table[$i]['first_six'] = $table[$i]['last_four'] = $table[$i]['exp_month'] = $table[$i]['exp_year'] = $table[$i]['card_type'] = '--';

                      $table[$i]['bank_name'] = $table[$i]['name_on_account'] = $table[$i]['bsb_number'] = $table[$i]['branch_name'] = $table[$i]['account_number'] = '--';

                      if($lead->is_debit_card_or_bank_info == 1)
                      {
                          if (isset($credit_csv_select['payment_type'])) {
                            $table[$i]['payment_type'] = 'Debit Info';
                          } 
                          if (isset($credit_csv_select['name_on_card'])) {
                            $table[$i]['name_on_card'] = isset($lead->visitorDebitInfo->name_on_card) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->name_on_card) : '--';
                          } 
                          if (isset($credit_csv_select['first_six_digit'])) {
                            $table[$i]['first_six'] = isset($lead->visitorDebitInfo->first_six) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->first_six) : '--';
                          }
                          if (isset($credit_csv_select['last_four_digit'])) {
                            $table[$i]['last_four'] = isset($lead->visitorDebitInfo->last_four) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->last_four) : '--';
                          }
                          if (isset($credit_csv_select['expiry_month'])) {
                            $table[$i]['exp_month'] = isset($lead->visitorDebitInfo->exp_month) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->exp_month) : '--';
                          }
                          if (isset($credit_csv_select['expiry_year'])) {
                            $table[$i]['exp_year'] = isset($lead->visitorDebitInfo->exp_year) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->exp_year) : '--';
                          }
                          if (isset($credit_csv_select['card_type'])) {
                            $table[$i]['card_type'] = isset($lead->visitorDebitInfo->card_type) ? get_tokenex_encrypt_data($lead->visitorDebitInfo->card_type) : '--';
                          }  
                      }
                      else if($lead->is_debit_card_or_bank_info == 2)
                      { 
                          if (isset($credit_csv_select['payment_type'])) {
                            $table[$i]['payment_type'] = 'Bank Info';
                          }
                          if (isset($credit_csv_select['bank_name'])) {
                            $table[$i]['bank_name'] = isset($lead->visitorbankInfo->bank_name) ? decrypt_bank_data($lead->visitorbankInfo->bank_name) : '--';
                          } 
                          if (isset($credit_csv_select['name_on_account'])) {
                            $table[$i]['name_on_account'] = isset($lead->visitorbankInfo->name_on_account) ? decrypt_bank_data($lead->visitorbankInfo->name_on_account) : '--';
                          }
                          if (isset($credit_csv_select['bsb_number'])) {
                            $table[$i]['bsb_number'] = isset($lead->visitorbankInfo->bsb) ? decrypt_bank_data($lead->visitorbankInfo->bsb) : '--';
                          }
                          if (isset($credit_csv_select['branch_name'])) {
                            $table[$i]['branch_name'] = isset($lead->visitorbankInfo->branch_name) ? decrypt_bank_data($lead->visitorbankInfo->branch_name) : '--';
                          }
                          if (isset($credit_csv_select['account_number'])) {
                            $table[$i]['account_number'] = isset($lead->visitorbankInfo->account_number) ? decrypt_bank_data($lead->visitorbankInfo->account_number) : '--';
                          }
                      }
                  $csv_row_data = creditSalesCsvRowData($table[$i], $request->credit_selected_data); 
                  fputcsv($handle, $csv_row_data);
                  $i++;
              } 
        });
        fclose($handle);  
    }
    catch (Exception $err){
      throw new Exception($err->getMessage(),0,$err);
    }
  }

  /*
   * DESC: to return sale csv header row on behalf of selected fields
   * */
    function credit_csv_header_data($csv_select)
    {
      try
      {
        $order = [];
        if (isset($csv_select['credit_sale_id'])) {
          $order[] = 'Sale Id';
        }
        if (isset($csv_select['payment_type'])) {
          $order[] = 'Payment Type';
        }
        if (isset($csv_select['name_on_card'])) {
          $order[] = 'Name On Card';
        }
        if (isset($csv_select['first_six_digit'])) {
          $order[] = 'First Six digits';
        }
        if (isset($csv_select['last_four_digit'])) {
          $order[] = 'Last Four Digits';
        }
        if (isset($csv_select['expiry_month'])) {
          $order[] = 'Expiry Month';
        }
        if (isset($csv_select['expiry_year'])) {
          $order[] = 'Expiry Year';
        }
        if (isset($csv_select['card_type'])) {
          $order[] = 'Card Type';
        } 

        if (isset($csv_select['bank_name'])) {
          $order[] = 'Bank Name';
        }
        if (isset($csv_select['name_on_account'])) {
          $order[] = 'Name On Account';
        }
        if (isset($csv_select['bsb_number'])) {
          $order[] = 'BSB Number';
        }
        if (isset($csv_select['branch_name'])) {
          $order[] = 'Branch Name';
        }
        if (isset($csv_select['account_number'])) {
          $order[] = 'Account Number';
        }
        return $order;
      }
      catch (Exception $err){
        throw new Exception($err->getMessage(),0,$err);
      }
    }

  /*
   * DESC: to return sale credit info csv row on behalf of selected fields
   * */
  function creditSalesCsvRowData($row, $csv_select){
    
    try
    {
      $csv_row = [];
      if (isset($csv_select['credit_sale_id'])) {
        $csv_row[] = $row['credit_sale_id'];
      }
      if (isset($csv_select['payment_type'])) {
        $csv_row[] = $row['payment_type'];
      }
      if (isset($csv_select['name_on_card'])) {
        $csv_row[] = $row['name_on_card'];
      }
      if (isset($csv_select['first_six_digit'])) {
        $csv_row[] = $row['first_six'];
      } 
      if (isset($csv_select['last_four_digit'])) {
        $csv_row[] = $row['last_four'];
      }
      if (isset($csv_select['expiry_month'])) {
        $csv_row[] = $row['exp_month'];
      }
      if (isset($csv_select['expiry_year'])) {
        $csv_row[] = $row['exp_year'];
      }
      if (isset($csv_select['card_type'])) {
        $csv_row[] = $row['card_type'];
      }

      if (isset($csv_select['bank_name'])) {
        $csv_row[] = $row['bank_name'];
      } 
      if (isset($csv_select['name_on_account'])) {
        $csv_row[] = $row['name_on_account'];
      } 
      if (isset($csv_select['bsb_number'])) {
        $csv_row[] = $row['bsb_number'];
      }
      if (isset($csv_select['branch_name'])) {
        $csv_row[] = $row['branch_name'];
      }
      if (isset($csv_select['account_number'])) {
        $csv_row[] = $row['account_number'];
      }
      return $csv_row;
    }
    catch (Exception $err){
      throw new Exception($err->getMessage(),0,$err);
    }
  }
