<?php

namespace App\Repositories\Lead\Listing;

use Carbon\Carbon;
use App\Models\{Providers, Affiliate, Lead, ConnectionType, AffiliateKeys,AssignedUsers, Capacity, Color, User, SaleProductsEnergy, Visitor, EnergyBillDetail, Distributor, VisitorAddress, VisitorInformationEnergy, Status, VisitorConcessionDetail, SaleQaSectionBroadband, SaleQaSectionEnergy, SaleQaSectionMobile, VisitorIdentification, SaleProductEnergyOtherInfo, States, VisitorDocument,SaleAssignedEnergyQa,SaleAssignedBroadbandQa,SaleAssignedMobileQa,SaleStatusHistoryBroadband,SaleStatusHistoryEnergy,SaleStatusHistoryMobile,SaleProductsMobile,SaleProductsBroadband,StatusHierarchy,Contract,CostType, Handset, InternalStorage, LeadJourneyDataEnergy, LeadJourneyDataMobile, MasterTariffCode,ProviderLogo, Variant,UserService,Services, VisitorBankInfo, visitorDebitInfo,SaleProductMobileConnectionDetail};
use Carbon\CarbonPeriod;
use CreateLeadJourneyDataBroadband;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToArray;

trait Basic
{
    public static function getListing($request)
    {
        $userPermissions = getUserPermissions();
        $appPermissions = getAppPermissions();
        $saleType = explode('.', \Request::route()->getName())[0];
        $userPermissions = getUserPermissions();
        $appPermissions = getAppPermissions();
        $permissionList = [
                            'visits' => 'show_visits',
                            'leads' => 'show_leads',
                            'sales' => 'show_sales'
                            ];
        $checkPermissions = isset($permissionList[$saleType])? $permissionList[$saleType]:'';

        $user = auth()->user();
        $userRole = $user->role ?? '';
        $type = ['visits' => 0, 'leads' => 1, 'sales' => 2];
        $info = $user->info;
        $statuses = Status::pluck('title', 'id')->toArray();
        if ($request->method() == 'POST')
        {
            $data = Lead::getFilteredListing($request, $type, $info, $statuses,$user,$userRole);
            $data['userPermissions'] = $userPermissions;
            $data['appPermissions'] = $appPermissions;
            return response()->json($data, 200);
        }

        if(!checkPermission($checkPermissions,$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        }
        $status = isset($type[$saleType]) ? $type[$saleType] : '0';

        $userServices=UserService::where(['user_id'=>$user->id,'status' =>1])->with('serviceName')->get();

        $serviceId = isset($userServices[0]['service_id']) ? $userServices[0]['service_id'] : 0;
        $affiliates = $subAffiliates = [];

        $allAffiliates = AssignedUsers::where('source_user_id', $user->id)->where('relation_type',2)->pluck('relational_user_id')->toArray();
        if(!in_array($userRole,[2,3,8,9]))
        {
            $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })->whereIn('user_id',$allAffiliates)->select('id', 'user_id', 'company_name')->where('parent_id', 0)->get();
        }
        else
        {
            $affiliateId = Affiliate::where('user_id', $user->id)->select('id')->value('id');
            $subAffiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })->where('parent_id', $affiliateId)->select('id', 'user_id', 'company_name')->get();
        }

        $providers = Providers::whereHas('getProviderServices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->select('id', 'name', 'user_id')->get();

        $states = DB::table('states')->select('state_id', 'state_code')->get()->toArray();

        $connectionTypes = ConnectionType::select('id', 'name', 'service_id', 'local_id', 'connection_type_id')->where('is_deleted', '0')->where('status', '1')->get();
        $queryString = 'where l.status = ' . $status;
        if(in_array($userRole,[2]))
        {
            $queryString .= ' and a.user_id = ' . $user->id;
        }
        else if($userRole == 8)
        {
            $assignBdmUsers = AssignedUsers::where('relational_user_id',$user->id)->pluck('source_user_id')->ToArray();
            $queryString .= ' and a.user_id in (' .implode(',',$assignBdmUsers).')';
        }
        else if(in_array($userRole,[3]))
        {
            $queryString .= ' and sa.user_id = ' . $user->id;
        }
        else if($userRole == 9)
        {
            $assignBdmUsers = AssignedUsers::where('relational_user_id',$user->id)->pluck('source_user_id')->ToArray();
            $queryString .= ' and sa.user_id in (' .implode(',',$assignBdmUsers).')';
        }
        else{
          $allAffiliatesString = implode(',',$allAffiliates);
          if(empty($allAffiliates))
          {
            $allAffiliatesString='0';
          }
          $queryString .= ' and a.user_id in (' .$allAffiliatesString.')';
        }

        $page = 0;
        $queryString2 = '';

        if($user->role == 4 && $saleType == 'sales'){
          $queryString2 = " where user_ext.user_id = '".$user->id."'";
        }
        $leads = self::callProcedure($type[$saleType], $serviceId, $queryString, $page,$queryString2);

        $collabrator = array_column($leads,'LeadId');
        $collabrator = SaleAssignedMobileQa::select('lead_id','id','user_id')->whereIn('lead_id',$collabrator)->where('type',2)->get();
        $collabratorLeads = $collabrator->groupBy('lead_id')->toArray();
        $collabratorName = array_column($collabrator->toArray(),'user_id');
        $collabratorName = User::select('id','first_name','last_name')->whereIn('id',$collabratorName)->get()->groupBY('id')->toArray();

        $qaList = User::where('role',4)->select('id','first_name','last_name')->get();
        $leads = collect($leads)->groupBy('LeadId');

        return view('pages.leads.list', compact('info', 'userServices', 'saleType', 'leads', 'affiliates', 'subAffiliates', 'providers', 'serviceId', 'states', 'connectionTypes', 'statuses','userRole','user','collabratorLeads','collabratorName','qaList','userPermissions','appPermissions'));
    }

    public static function getFilteredListing($request,$type,$info,$statuses,$user,$userRole)
    {
        $page = 0;
        if (isset($request->page)) {
            $page = $request->page - 1;
         }
        $queryString = 'where ';
        $queryString2 = '';
        $filterData = self::filter($request);
        $filterAssigned = 0;

        if (isset($type[$request->saleType]))
        {
          $queryString .= 'l.status = '.$type[$request->saleType];
        }
        if(in_array($userRole,[2,8]))
        {
            $queryString .= ' and l.affiliate_id = ' . $user->id;
        }
        else if(in_array($userRole,[3,9]))
        {
            $queryString .= ' and l.sub_affiliate_id = ' . $user->id;
        }
        if (isset($filterData['providerId']))
        {
          if($filterAssigned == 0)
          $queryString .= ' and ';
          $queryString .= ' sp.provider_id = '.$filterData['providerId'];
        }
        if (isset($filterData['referenceNo']))
        {
          $queryString .= ' and sp.reference_no = '.$filterData['referenceNo'];
        }
        if (isset($filterData['moveIn']))
        {
          $queryString .= ' and sp.is_moving = '.$filterData['moveIn'];
        }
        if (isset($filterData['moveInDate']))
        {
          $queryString .= ' and sp.moving_at between '.$filterData['fromMovinDate'].' and '.$filterData['toMovinDate'];
        }
        if ($type[$request->saleType] == 1  && isset($filterData['fromCreatedAt']) && isset($filterData['toCreatedAt']))
        {
          $queryString .= ' and sp.created_at between '.$filterData['fromCreatedAt'].' and '.$filterData['toCreatedAt'];
        }
        if ($type[$request->saleType] == 2  && isset($filterData['fromCreatedAt']) && isset($filterData['toCreatedAt']))
        {
          $queryString .= ' and sp.sale_created_at between '.$filterData['fromCreatedAt'].' and '.$filterData['toCreatedAt'];
        }
        if ($type[$request->saleType] == 0  && isset($filterData['fromCreatedAt']) && isset($filterData['toCreatedAt']))
        {
            $queryString .= ' and l.created_at between '.$filterData['fromCreatedAt'].' and '.$filterData['toCreatedAt'];
        }
        if (isset($filterData['leadId']))
        {
          $queryString .= ' and l.lead_id = '.$filterData['leadId'];
        }
        if (isset($filterData['affiliateId']))
        {
          $queryString .= ' and a.user_id = '.$filterData['affiliateId'];
        }
        if (isset($filterData['subAffiliateId']))
        {
          $queryString .= ' and sa.user_id = '.$filterData['subAffiliateId'];
        }
        if (isset($filterData['first_name']))
        {
          $queryString .= " and v.first_name = '".encryptGdprData($filterData['first_name'])."'";
        }
        if (isset($filterData['last_name']))
        {
          $queryString .= " and v.last_name = '".encryptGdprData($filterData['last_name'])."'";
        }
        if (isset($filterData['email']))
        {
          $queryString .= " and v.email = '".encryptGdprData($filterData['email'])."'";
        }
        if (isset($filterData['phone']))
        {
          $queryString .= " and v.phone = '".encryptGdprData($filterData['phone'])."'";
        }
        if (isset($filterData['postcode']) && $filterData['verticalId'] == 1)
        {
          $queryString .= " and va.postcode = '".$filterData['postcode']."'";
        }
        if (isset($filterData['suburb']) && $filterData['verticalId'] == 1)
        {
          $queryString .= " and va.suburb = '".$filterData['suburb']."'";
        }
        if (isset($filterData['state']) && $filterData['verticalId'] == 1)
        {
          $queryString .= " and va.state = '".$filterData['state']."'";
        }
        if (isset($filterData['propertyType']) && $filterData['verticalId'] == 1)
        {
          $queryString .= " and ljd.property_type = '".$filterData['propertyType']."'";
        }
        if (isset($filterData['productType']) && $filterData['verticalId'] == 1)
        {
          $queryString .= " and ljd.energy_type = '".$filterData['productType']."'";
        }

        if (isset($filterData['connectionType']) && in_array($filterData['verticalId'],[2,3]))
        {
          $queryString .= " and ljd.connection_type = '".$filterData['connectionType']."'";
        }
        if (isset($filterData['planType']) && $filterData['verticalId'] == 2)
        {
          $queryString .= " and ljd.plan_type = '".$filterData['planType']."'";
        }

        $queryString2 = '';
        $filter = true;
        if (isset($filterData['assigned_qa']))
        {
          $queryString2 = " where user_ext.user_id = '".$filterData['assigned_qa']."'";
          $filter = false;
        }
        $allAffiliates = AssignedUsers::where('source_user_id', $user->id)->where('relation_type',2)->pluck('relational_user_id')->toArray();
        if(in_array($userRole,[1,4,5,6]))
        {
          $allAffiliatesString = implode(',',$allAffiliates);
          if(empty($allAffiliates))
          {
            $allAffiliatesString='0';
          }
          $queryString .= ' and a.user_id in (' .$allAffiliatesString.')';
        }

        if($user->role == 4 && $request->saleType == 'sales'){
          if($filter)
          {
            $queryString2 .= ' where ';
          }
          else
          {
            $queryString2 .= ' and ';
          }
          $queryString2 .= " user_ext.user_id = '".$user->id."'";
        }
        $leads = self::callProcedure($type[$request->saleType],$filterData['verticalId'],$queryString,$page,$queryString2);
        $collabrator = array_column($leads,'LeadId');
        $collabrator = SaleAssignedMobileQa::select('lead_id','id','user_id')->whereIn('lead_id',$collabrator)->where('type',2)->get();
        $collabratorLeads = $collabrator->groupBy('lead_id')->toArray();
        $collabratorName = array_column($collabrator->toArray(),'user_id');
        $collabratorName = User::select('id','first_name','last_name')->whereIn('id',$collabratorName)->get()->groupBY('id')->toArray();

        $leads = array_map(function ($lead) use ($statuses,$type,$request,$collabratorLeads,$collabratorName)
        {
            $lead->CollabratorName = '';
            $lead->AffiliateLegalName = ucwords($lead->AffiliateLegalName);
            if(isset($lead->VisitorFirstName))
                $lead->VisitorFirstName = decryptGdprData($lead->VisitorFirstName);
            if(isset($lead->LeadId))
                $lead->LeadDataId = encryptGdprData($lead->LeadId);
            if(isset($lead->AssignedUserName))
                $lead->AssignedUserName = decryptGdprData($lead->AssignedUserName);
            if(isset($lead->LeadCreatedDate))
                $lead->LeadCreatedDate = dateTimeFormat($lead->LeadCreatedDate);
            if(isset($lead->SalesCreatedDate))
                $lead->SalesCreatedDate = dateTimeFormat($lead->SalesCreatedDate);
            if(isset($lead->MovingDate))
                $lead->MovingDate = dateTimeFormat($lead->MovingDate);
            if ($type[$request->saleType] !=0 && isset($statuses[$lead->SaleStatus]) && $statuses[$lead->SaleStatus] )
                $lead->SaleStatus = $statuses[$lead->SaleStatus];
            if(isset($collabratorLeads[$lead->LeadId]))
            {
                $i=1;
                foreach(array_column($collabratorLeads[$lead->LeadId],'user_id') as $val)
                {
                    if($i != 1)
                    {
                      $lead->CollabratorName .= ', ';
                    }
                  $lead->CollabratorName .= decryptGdprData($collabratorName[$val][0]['first_name']);
                  $i++;
                }
            }

            return $lead;
        }, $leads);

        $leads = collect($leads)->groupBy('LeadId')->toArray();
        return ['leads' => array_values($leads),'serviceId' => $filterData['verticalId']];
    }

       //Get export filter data
    public static function getExportFilterListing($request)
    {
        $type = ['visits' => 0, 'leads' => 1, 'sales' => 2];
        $info = auth()->user()->info;

        $page = 1;
            $queryString = 'where 1=1';

            $filterData = self::filter($request);
            $filterAssigned = 0;
            $leads = self::callProcedure(1,$filterData['verticalId'],$queryString,$page,'');
            $leads = array_map(function ($lead) {

                $lead->AffiliateLegalName = ucwords($lead->AffiliateLegalName);
                if(isset($lead->VisitorFirstName))
                    $lead->VisitorFirstName = decryptGdprData($lead->VisitorFirstName);
                if(isset($lead->ProiderName))
                    $lead->ProiderName = decryptGdprData($lead->ProiderName);
                if(isset($lead->AssignedUserName))
                    $lead->AssignedUserName = decryptGdprData($lead->AssignedUserName);
                return $lead;
            }, $leads);

            $leads = collect($leads)->groupBy('LeadId')->toArray();
            return ['leads' => array_values($leads),'serviceId' => $filterData['verticalId']];
    }

    public static function csv_header_data($csv_select,$saleType)
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
    public static function salesCsvRowData($row, $csv_select,$saleType)
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
  * generateSaleInfoCsvFile => generate sale information lead/sale csv file
  *
  */
  public static function generateSaleInfoCsvFile($sales,$filename,$service,$provider,$order,$csv_select,$request,$saleType)
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

      //function for get sales or lead data
      public static function filterdata($request, $type)
      {
          $oldRecords = 0;
          $leads = '';
          $affiliate = '';  //default affliate value
          $subaffiliates = ''; //default subaffiliates value

          $inputs = $request->all();
          $leads = Lead::where('status',1);
          $return['leads'] = $leads;
          $return['vertical'] = $inputs['vertical'];
          return $return;
      }

    //Lead detail
    public static function getLeadDetail($verticalId, $leadId,$saleType,$userPermissions,$appPermissions)
    {

        $leads = DB::select('set @leadId=' . decryptGdprData($leadId));
        $saleDetail =  $secondSaleDetail =  $checkboxStatuses =  $identificationDetails =   $addressDetails =  $connectionAddress =  $billingAddress =  $deliveryAddress = $poBoxAddress =  $gasConnectionAddress =  $gasSaleProduct =  $gasStatuses =  $statuses =  $saleProduct =  $gasSaleDetail = $unsubscribesData = $masterTariffs = $saleQaSectionData = $saleOtherInfo = $productId = $productType = $contractData =  $subAffiliate = $employmentDetails = $currentProvider = $affiliateLogo = $affiliateData = $manualConnectionAddress = $connectionTypeName =  $apiResponses = $visitorDocuments = $deliveryAddressId = $costType = null;
        $saleSubmissionResponse = $connectionDetails = [];
        $handsetData = [];
        switch ($verticalId) {
            case '1':
                $saleDetails = DB::select('call final_sale_detail_energy(@leadId)');
                if(empty($saleDetails))
                {
                    Session::flash('error', trans('sale_detail.invalid_sale'));
                    return redirect('/sales/list');
                }
                $groupDetails = collect($saleDetails)->groupBy('sale_product_product_type');

                if (isset($groupDetails[1][0])) {
                    $productId = isset($groupDetails[1][0]->sale_product_id) ? $groupDetails[1][0]->sale_product_id : null;
                    $productType = isset($groupDetails[1][0]->sale_product_product_type) ? $groupDetails[1][0]->sale_product_product_type : null;

                    $saleProduct = SaleProductsEnergy::saleEnergyProduct($productId, $productType);
                    $statuses = SaleStatusHistoryEnergy::getStatusHistory($productId);
                }
                if (isset($groupDetails[2][0])) {
                    $gasProductId = isset($groupDetails[2][0]->sale_product_id) ? $groupDetails[2][0]->sale_product_id : null;
                    $gasProductType = isset($groupDetails[2][0]->sale_product_product_type) ? $groupDetails[2][0]->sale_product_product_type : null;

                    $gasSaleProduct = SaleProductsEnergy::saleEnergyProduct($gasProductId, $gasProductType);
                    $gasStatuses = SaleStatusHistoryEnergy::getStatusHistory($gasProductId);
                }
                $saleDetail = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
                $gasSaleDetail = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null;
                if (count($saleDetails) == 1 && $saleDetails[0]->sale_product_product_type == 2) {
                    $saleDetail = isset($saleDetails[0]) ? $saleDetails[0] : null;
                    $gasSaleDetail = null;
                    $productId = $gasProductId;
                }
                else if($saleType == 'visits')
                {
                    $saleDetail = isset($saleDetails[0]) ? $saleDetails[0] : null;
                    $gasSaleDetail = null;
                    $productId = 0;
                }

                if(isset($saleDetail->journey_property_type)){
                  $masterTariffs = MasterTariffCode::where('property_type', $saleDetail->journey_property_type)->where('status', 1)->where('distributor_id', $saleDetail->journey_distributor_id)->pluck('tariff_code', 'id');
                }
                if(isset($saleDetail->l_lead_id)){
                  $saleQaSectionData = SaleQaSectionEnergy::saleQaSection($saleDetail->l_lead_id);
                }
                $saleSubmissionResponse = DB::connection('sale_logs')->table('sale_submission_api_responses')->where('lead_id',$saleDetail->l_lead_id)->orderBy('id','desc')->get();

                // 29-06-2022
                $userID = \Auth::user()->id;
                $salesQaData = SaleAssignedEnergyQa::where(['lead_id' => $saleDetail->l_lead_id,'user_id' => $userID,'type' => '1'])->get('is_locked')->first();
                // 29-06-2022

                break;
            case '2':
                $saleDetails = DB::select('call final_sale_detail_mobile(@leadId)');
                if(empty($saleDetails))
                {
                    Session::flash('error', trans('sale_detail.invalid_sale'));
                    return redirect('/sales/list');
                }
                $saleDetail = isset($saleDetails[0]) ? $saleDetails[0] : null;
                $productId = isset($saleDetails[0]->sale_product_id) ? $saleDetails[0]->sale_product_id : null;
                $saleProduct = SaleProductsMobile::saleProduct($productId);
                $statuses = SaleStatusHistoryMobile::getStatusHistory($productId);
                $saleQaSectionData = SaleQaSectionMobile::saleQaSection($saleDetail->l_lead_id);
                $deliveryAddressId = $saleDetail->l_delivery_address_id;
                if(isset($saleDetail->plan_contract_id)){
                $contractData = DB::table('contract')->where('id',$saleDetail->plan_contract_id)->select('validity')->first();
                }
                if(isset($saleDetail->journey_plan_type) && $saleDetail->journey_plan_type == 2){
                    if(isset($saleDetail->hsv_handset_id)){
                        $handsetName = Handset::where('id',$saleDetail->hsv_handset_id)->select('name')->first();
                        $handsetData['name'] = $handsetName->name;
                    }
                    if(isset($saleDetail->hsv_id)){
                        $variantName = Variant::where('id',$saleDetail->hsv_id)->select('variant_name','color_id')->first();
                        $handsetData['variant_name'] = $variantName->variant_name;
                        $handsetColor = Color::where('id',$variantName->color_id)->select('title','hexacode')->first();
                        $handsetData['color'] = $handsetColor->title;
                        $handsetData['hexacode'] = $handsetColor->hexacode;
                    }
                    if(isset($saleDetail->hsv_capacity_id)){
                        $capicityName = Capacity::where('id',$saleDetail->hsv_capacity_id)->select('value','unit')->first();
                        $handsetData['capacity'] = $capicityName->value;
                        $handsetData['capacity_unit'] = $capicityName->unit;
                    }
                     if(isset($saleDetail->hsv_internal_stroage_id)){
                        $internalStorageName = InternalStorage::where('id',$saleDetail->hsv_internal_stroage_id)->select('value','unit')->first();
                        $handsetData['internal_storage'] = $internalStorageName->value;
                        $handsetData['internal_storage_unit'] = $internalStorageName->value;
                    }
                }

                // 29-06-2022
                $userID = \Auth::user()->id;
                $salesQaData = SaleAssignedMobileQa::where(['lead_id' => $saleDetail->l_lead_id,'user_id' => $userID,'type' => '1'])->get('is_locked')->first();
                // 29-06-2022

                break;
            case '3':
                $saleDetails = DB::select('call sales_details_Broadband(@leadId)');
                if(empty($saleDetails))
                {
                    Session::flash('error', trans('sale_detail.invalid_sale'));
                    return redirect('/sales/list');
                }
                $saleDetail = isset($saleDetails[0]) ? $saleDetails[0] : null;
                $productId = isset($saleDetails[0]->sale_product_id) ? $saleDetails[0]->sale_product_id : null;
                $saleProduct = SaleProductsBroadband::saleProduct($productId);
                $statuses = SaleStatusHistoryBroadband::getStatusHistory($productId);
                $saleQaSectionData = SaleQaSectionBroadband::saleQaSection($saleDetail->l_lead_id);
                 // 29-06-2022
                 $userID = \Auth::user()->id;
                 $salesQaData = where(['lead_id' => $saleDetail->l_lead_id,'user_id' => $userID,'type' => '1'])->get('is_locked')->first();
                 dd($salesQaData);
                 // 29-06-2022
                break;
            default:
                Session::flash('error', trans('sale_detail.invalid_service'));
                return redirect('/sales/list');
                break;
        }
        $identificationDetails['primary_data']=[];
        $identificationDetails['secondary_data']=[];
        if(!empty($saleDetail->l_lead_id)){
            $identificationDetails['primary_data']=DB::table('visitor_identifications')->where(['lead_id' =>$saleDetail->l_lead_id,'identification_option'=>1])->first();
        }
        if(!empty($saleDetail->l_lead_id)){
            $identificationDetails['secondary_data']=DB::table('visitor_identifications')->where(['lead_id' =>$saleDetail->l_lead_id,'identification_option'=>2])->first();
        }
        if(isset($saleDetail->l_lead_id)){
            $employmentDetails = DB::table('visitor_employment_details')->where(['lead_id' =>$saleDetail->l_lead_id])->get();
        }
        if (isset($saleDetail->l_connection_address_id) || isset($saleDetail->l_billing_address_id) || isset($saleDetail->l_billing_po_box_id) || $deliveryAddressId) {
            $addressDetails = DB::table('visitor_addresses')->whereIn('id', [$saleDetail->l_connection_address_id, $saleDetail->l_billing_address_id, $saleDetail->l_billing_po_box_id,$deliveryAddressId])->get();
        }
        if (isset($addressDetails)) {
            foreach ($addressDetails as $addressDetail) {
                if (isset($saleDetail->l_connection_address_id) && $saleDetail->l_connection_address_id == $addressDetail->id) {
                    $connectionAddress = $addressDetail;
                }
                if (isset($saleDetail->l_billing_address_id) && $saleDetail->l_billing_address_id == $addressDetail->id) {
                    $billingAddress = $addressDetail;
                }
                if (isset($deliveryAddressId) && $deliveryAddressId == $addressDetail->id) {
                    $deliveryAddress = $addressDetail;
                }
                if (isset($saleDetail->l_billing_po_box_id) && $saleDetail->l_billing_po_box_id == $addressDetail->id) {
                    $poBoxAddress = $addressDetail;
                }
            }
        }
        if($verticalId == 1 && isset($saleDetail->lead_id)){
            $unsubscribesData = DB::table('unsubscribes')->where('lead_id',$saleDetail->l_lead_id)->first();
        }
        if(isset($saleDetail->l_sub_affiliate_id)){
            $subAffiliate = Affiliate::where('user_id',$saleDetail->l_sub_affiliate_id)->select('company_name')->first();
        }
        if(isset($saleDetail->l_affiliate_id)){
            $affiliateData = User::where('id',$saleDetail->l_affiliate_id)->select('email','phone')->first();
        }
        if($verticalId == 2){
            $currentProvider = LeadJourneyDataMobile::join('connection_types','lead_journey_data_mobile.current_provider','=','connection_types.id')->where(['lead_journey_data_mobile.lead_id'=>$saleDetail->l_lead_id,'connection_types.service_id'=>2,'connection_types.connection_type_id'=>3])->select('connection_types.name')->first();
            $saleDupicate = SaleProductsMobile::where('lead_id',$saleDetail->l_lead_id)->select('is_duplicate')->first();
            $saleDetail->sale_product_is_duplicate = isset($saleDupicate) ? $saleProduct->is_duplicate:0;
            $connectionDetails = SaleProductMobileConnectionDetail::where(['mobile_connection_id'=>$saleDetail->sale_product_id])->first();
            if(isset($connectionDetails) && $connectionDetails->connection_request_type == 2){
                $currentConnectionProvider = ConnectionType::where('id',$connectionDetails->current_provider)->select('name')->first();
               $connectionDetails->current_provider = isset($currentConnectionProvider) ? $currentConnectionProvider->name:null;
            }
        }
        if($verticalId == 1){
            $currentProvider = LeadJourneyDataEnergy::join('connection_types','lead_journey_data_energy.current_provider_id','=','connection_types.id')->where(['lead_journey_data_energy.lead_id'=>$saleDetail->l_lead_id,'connection_types.service_id'=>1,'connection_types.connection_type_id'=>3])->select('connection_types.name')->first();
        }
        if($verticalId == 3){
            $currentProvider = DB::table('lead_journey_data_broadband')->join('connection_types','lead_journey_data_broadband.current_provider','=','connection_types.id')->where(['lead_journey_data_broadband.lead_id'=>$saleDetail->l_lead_id,'connection_types.service_id'=>3,'connection_types.connection_type_id'=>3])->select('connection_types.name')->first();
        }
        if(isset($saleDetail->a_user_id)){
        $affiliateLogo = Affiliate::where(['user_id'=>$saleDetail->a_user_id])->select('user_id','logo')->first();
        }
        $masterEmploymentDetails = Lead::getMasterEmploymentDetails();
        if(isset($saleDetail->l_visitor_id)){
            $gasConnectionAddress = Lead::getGasConnectionAddress($saleDetail->l_visitor_id);
            $manualConnectionAddress = Lead::getManualConnectionAddress($saleDetail->l_visitor_id);
        }
        $checkboxStatuses = Lead::getcheckboxStatus($productId);
        $apiResponses = Lead::getApiResponses($saleDetail->l_lead_id);
        $distributors = Lead::getDistributors($verticalId);
        $providers = Lead::getProviders($verticalId);
        $states = Lead::getStates();
        $customerTitles = config('sale_detail.titles');
        $unitTypeCodes = config('sale_detail.unit_type_code');
        $floorTypeCodes = config('sale_detail.floor_type_code');
        $streetTypeCodes = Lead::getStreetTypeCodes();
        $unitTypes = Lead::getUnitTypes();
        $lifeSupportEquipments = Lead::getlifeSupportEquipments($verticalId);
        $visitorDocuments = Lead::getVisitorDocument($saleDetail->l_lead_id);
        $concessionTypes=ConnectionType::select('local_id','name')->where(['service_id'=>1,'connection_type_id'=>1])->get()->toArray();
        $allStates=States::select('state','state_code')->get();
        $identificationTypes=config('sale_detail.identifications_type');
        $countriesData=json_decode(file_get_contents(storage_path('countries.json')),true);
        $cardColors=config('sale_detail.card_colors');
        $referenceNumbers=config('sale_detail.reference_numbers');
        $qaSaleCompletedBy = config('sale_detail.qa_sale_completed_by');
        $saleAgentTypes = config('sale_detail.sale_agent');
        $saleOtherInfo = SaleProductEnergyOtherInfo::getOtherInfo($saleDetail->l_lead_id);
        $userPermissions =getUserPermissions();
        $appPermissions =getAppPermissions();
        $visitorBankInfo = VisitorBankInfo::where('lead_id',$saleDetail->l_lead_id)->first();
        $visitorDebitInfo = visitorDebitInfo::where('lead_id',$saleDetail->l_lead_id)->first();
        $tokenExLogs = DB::connection('sale_logs')->table('tokenEx_logs')->where('lead_id',$saleDetail->l_lead_id)->orderBy('id','desc')->get();
        if(isset($saleDetail->plan_cost_type_id)){
        $costType = DB::table('cost_types')->where('id',$saleDetail->plan_cost_type_id)->first();
        }
        $smsLogs = DB::connection('sale_logs')->table('sms_logs')->where('lead_id',$saleDetail->l_lead_id)->orderBy('id','desc')->get();
        $sendEmailLogs = DB::connection('sale_logs')->table('sendemail_logs')->where('lead_id',$saleDetail->l_lead_id)->orderBy('id','desc')->get();
        return view('pages.leads.detail', compact('statuses', 'saleProduct', 'verticalId', 'saleDetail', 'identificationDetails', 'checkboxStatuses', 'connectionAddress', 'billingAddress', 'poBoxAddress', 'apiResponses', 'gasStatuses', 'gasSaleProduct', 'gasSaleDetail', 'saleType','concessionTypes','customerTitles','distributors','providers','masterTariffs','unsubscribesData','states','qaSaleCompletedBy','saleQaSectionData','allStates','identificationTypes','countriesData','cardColors','referenceNumbers','saleSubmissionResponse','saleAgentTypes','saleOtherInfo','userPermissions','appPermissions','gasConnectionAddress','visitorDocuments','unitTypes','unitTypeCodes','floorTypeCodes','streetTypeCodes','lifeSupportEquipments','contractData','subAffiliate','employmentDetails','currentProvider','masterEmploymentDetails','affiliateLogo','affiliateData','manualConnectionAddress','deliveryAddress','handsetData','tokenExLogs','smsLogs','sendEmailLogs','visitorBankInfo','costType','visitorDebitInfo','salesQaData','leadId','connectionDetails'));
    }

    public static function filter($request)
    {
        $filterData = $request->all();
        if (isset($filterData['date'])) {
            $date = explode(" - ", $filterData['date']);
            $filterData['fromCreatedAt'] = "'$date[0]'";
            $filterData['toCreatedAt'] = "'$date[1]'";
        }
        if($filterData['saleType'] == 'visit')
        {
          $filterData['verticalId'] == 0;
        }
        else if($filterData['saleType'] == 'leads')
        {
          $filterData['verticalId'] == 1;
        }
        else {
          $filterData['verticalId'] == 2;
        }
        if(isset($filterData['moveInDate']))
        {
            $date = explode(" - ",$filterData['moveInDate']);
            $filterData['fromMovinDate'] = "'$date[0]'";
            $filterData['toMovinDate'] = "'$date[1]'";
        }
        return $filterData;
    }

    public static function callProcedure($status, $serviceId, $queryString, $page,$queryString2)
    {
        DB::select('set @where_clause="' . $queryString . '"');
        DB::select('set @where_clause2="' . $queryString2 . '"');
        DB::select('set @SL=' . ($page * 30));
        DB::select('set @NOR=30');
        $leads = [];
        if ($status == 0) {
            $leads = DB::select('call sales_visitor_listing(@where_clause  , @SL, @NOR)');
        } else if ($serviceId == 1) {
            $leads = DB::select('call final_sales_listing_energy(@where_clause , @SL, @NOR)');
        } else if ($serviceId == 2) {
            $leads = DB::select('call final_sales_listing_mobile(@where_clause ,@where_clause2, @SL, @NOR)');
        } else if ($serviceId == 3) {
            $leads = DB::select('call sales_listing_broadband(@where_clause , @SL, @NOR)');
        }
        return $leads;
    }

    public static function getAffiliateByService($request)
    {
        $serviceId = $request->serviceId;
        $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->where('parent_id', 0)->select('id', 'user_id', 'company_name')->get()->toArray();

        $providers = Providers::whereHas('getProviderServices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->select('id', 'name', 'user_id')->get()->toArray();

        $providers = array_map(function ($provider) {

            $provider['name'] = $provider['name'];
            return $provider;
        }, $providers);
        return ['affiliates' => $affiliates, 'providers' => $providers];
    }
    public static function getDistributors($serviceId)
    {
        $distributors = Distributor::where('service_id', $serviceId)->select('id', 'name', 'energy_type')->get()->toArray();
        return $distributors;
    }
    public static function getProviders($serviceId)
    {
        $providers = Providers::where('service_id', $serviceId)->select('id', 'name','legal_name','user_id')->get()->toArray();

        return $providers;
    }
    public static function getStates()
    {
        return DB::table('states')->select('state_id', 'state_code')->get()->toArray();
    }

    public static function getMasterEmploymentDetails()
    {
        return DB::table('master_employment_details')->select('id', 'name','type')->get();
    }

    public static function getStreetTypeCodes()
    {
        return DB::table('master_street_codes')->select('id', 'value')->get()->toArray();
    }

    public static function getUnitTypes()
    {
        return DB::table('master_employment_details')->where('type',6)->select('id', 'name')->get()->toArray();
    }
    public static function getlifeSupportEquipments($verticalId)
    {
        return DB::table('life_support_equipments')->where('energy_type', 3)->select('title')->get()->toArray();
    }

    public static function getGasConnectionAddress($visitorId)
    {
        return VisitorAddress::whereNotNull('is_same_gas_connection')->where('visitor_id', $visitorId)->get()->first();
    }
    public static function getManualConnectionAddress($visitorId)
    {
        return VisitorAddress::whereNotNull('manual_connection_details')->where('visitor_id', $visitorId)->get()->first();
    }
    public static function getVisitorDocument($leadId)
    {
        return VisitorDocument::where('lead_id', $leadId)->get()->first();
    }

    public static function getcheckboxStatus($productId)
    {
        return DB::table('sale_checkbox_statuses')->where('sale_id', $productId)->get();
    }

    public static function getApiResponses($leadId)
    {
        return DB::table('sale_products_mobile_dialer')->where('lead_id', $leadId)->orderBY('id','desc')->get();
    }
    public static function getSubAffiliateList($request)
    {
        $allAffiliates = AssignedUsers::where('source_user_id', auth()->user()->id)->where('relation_type',3)->pluck('relational_user_id')->toArray();
        $affiliateId = $request->affiliateId;
        $serviceId = $request->serviceId;
        $affiliateId = Affiliate::where('user_id', $affiliateId)->select('id')->value('id');
        $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->where('parent_id', $affiliateId)->whereIn('user_id',$allAffiliates)->select('id', 'user_id', 'company_name')->get()->toArray();
        return ['affiliates' => $affiliates];
    }

    public static function changeAffiliate($request)
    {
        $id = $request->lead_id;
        $data = [];
        $affiliate_id = $request['affiliate_id'];
        if ($request->type == 'sub-affiliate') {
            $data['sub_affiliate_id'] = $affiliate_id;
        } else {
            $affiliate_key_id = AffiliateKeys::where('user_id', $affiliate_id)->where('status', 1)->orderBy('id', 'asc')->pluck('id')->first();
            if (empty($affiliate_key_id)) {
                $response = ['message' => 'Please enable atleast one affiliate key.', 'status' => 422];
                return $response;
            }
            $data['api_key_id'] = $affiliate_key_id;
            $data['affiliate_id'] = $affiliate_id;
            $data['sub_affiliate_id'] = null;
        }
        $data['is_duplicate'] = 0;

        $isDuplicate = self::checkDuplicateLead($request->phone, $request->email, $id, $affiliate_id, $request->verticalId);
        if ($isDuplicate) {
            $data['is_duplicate'] = 1;
        }
        $result = Lead::where('lead_id', $id)->update($data);
        if ($result) {
            $affiliateData = User::select('id', 'first_name', 'last_name', 'email', 'phone')->where('id', $affiliate_id)->get()->toArray();
            $affiliateData = array_map(function ($data) {
                $data['email'] = decryptGdprData($data['email']);
                $data['phone'] = decryptGdprData($data['phone']);
                return $data;
            }, $affiliateData);
            $msg = 'Affliate updated Successfully.';
            if ($request->type == 'sub-affiliate') {
                $msg = 'Sub-Affliate updated Successfully.';
            }
            $response = ['message' => $msg, 'affiliateData' => $affiliateData, 'status' => 200];
            return   $response;
        }
        $response = ['message' => 'Affiliate not updated', 'status' => 400];
        return $response;
    }

    static function checkDuplicateLead($phone, $email, $visitor, $affiliateId, $service)
    {
        $tableName = 'sale_products_energy';
        if ($service == 2) {
            $tableName = 'sale_products_mobile';
        } else if ($service == 3) {
            $tableName = 'sale_products_broadband';
        }
        $checkVisitor = DB::table('leads')
            ->join('visitors', 'leads.visitor_id', '=', 'visitors.id')
            ->leftjoin($tableName, 'leads.lead_id', '=', $tableName . '.lead_id')
            ->where(function ($check) use ($email, $phone) {
                $check->where('email', encryptGdprData($email))
                    ->orWhere('phone', encryptGdprData($phone));
            })
            ->where($tableName . '.id', '!=', null)
            ->where('leads.lead_id', '!=', $visitor);

        if ($affiliateId) {
            $checkVisitor->where('leads.affiliate_id', $affiliateId);
        }
        return $checkVisitor->exists();
    }

    public static function updateStage($request)
    {
        try {
            $user = auth()->user();
            $current_date_time = Carbon::now()->toDateTimeString();
            $gasUpdatedData = $elecUpdatedData = $broadbandUpdatedData = $mobileUpdatedData = $saleUpdatedData = null;
            $emailSubscription = $request->email_subscription_checkbox;
            $smsSubscription = $request->sms_subscription_checkbox;
            $unsubscribeData = DB::table('unsubscribes')->where('lead_id', $request->leadId)->get()->first();
            if ($request->verticalId == 1) {
                $saleProduct = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->select('id', 'sale_completed_by')->get()->first();
                $elecSaleDuplicate = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 1)->select('is_duplicate')->get()->first();
                $gasSaleDuplicate = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 2)->select('is_duplicate')->get()->first();
            } elseif ($request->verticalId == 2) {
                $saleProduct = DB::table('sale_products_mobile')->where('lead_id', $request->leadId)->select('id', 'sale_completed_by', 'is_duplicate')->get()->first();
            } else {
                $saleProduct = DB::table('sale_products_broadband')->where('lead_id', $request->leadId)->select('id', 'sale_completed_by', 'is_duplicate')->get()->first();
            }
            $leadData = DB::table('leads')->where('lead_id', $request->leadId)->select('visitor_source')->get()->first();
            if ($unsubscribeData == null && $request->verticalId == 1) {
                DB::table('unsubscribes')->insert(['email_unsubscribe' => $emailSubscription, 'sms_unsubscribe' => $smsSubscription, 'sale_product_id' => $saleProduct->id, 'lead_id' => $request->leadId]);
            }
            $logData = [
                'lead_id' => $request->leadId,
                'email_unsubscribe' => isset($unsubscribeData->email_unsubscribe) ? $unsubscribeData->email_unsubscribe : null,
                'sms_unsubscribe' => isset($unsubscribeData->sms_unsubscribe) ? $unsubscribeData->sms_unsubscribe : null,
                'sale_completed_by' => isset($saleProduct) ? $saleProduct->sale_completed_by:null,
                'stage_source' => $leadData->visitor_source,
                'electricity_duplicate' => isset($elecSaleDuplicate) ? $elecSaleDuplicate->is_duplicate : null,
                'gas_duplicate' => isset($gasSaleDuplicate) ? $gasSaleDuplicate->is_duplicate : null,
                'sale_duplicate' => isset($gasSaleDuplicate) ? $gasSaleDuplicate->is_duplicate : null,
                'changed_by' => $user->id,
                'created_at' => $current_date_time,
            ];
            if ($request->verticalId == 1) {
                if ($request->has('electricityProductType')) {
                    $elecProductType = $request->electricityProductType;
                    DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', $elecProductType)->update(['is_duplicate' => $request->electricity_sale_duplicate_checkbox]);
                    $elecUpdatedData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 1)->select('is_duplicate')->get()->first();
                }
                if ($request->has('gasProductType')) {
                    $gasProductType = $request->gasProductType;
                    DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', $gasProductType)->update(['is_duplicate' => $request->gas_sale_duplicate_checkbox]);
                    $gasUpdatedData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 2)->select('is_duplicate')->get()->first();
                }
            } elseif ($request->verticalId == 2) {
                DB::table('sale_products_mobile')->where('lead_id', $request->leadId)->update(['is_duplicate' => $request->sale_duplicate_checkbox,'sale_completed_by'=>$request->sale_completed_by]);
                $mobileUpdatedData = DB::table('sale_products_mobile')->where('lead_id', $request->leadId)->select('is_duplicate','sale_completed_by')->get()->first();
            } else {
                DB::table('sale_products_broadband')->where('lead_id', $request->leadId)->update(['is_duplicate' => $request->sale_duplicate_checkbox,'sale_completed_by'=>$request->sale_completed_by]);
                $broadbandUpdatedData = DB::table('sale_products_broadband')->where('lead_id', $request->leadId)->select('is_duplicate','sale_completed_by')->get()->first();
            }
            $result = DB::connection('sale_logs')->table('stage_logs')->insert($logData);
            $leadUpdateData = DB::table('leads')->where('lead_id', $request->leadId)->update(['visitor_source' => $request->sale_source]);
            if($request->verticalId == 1){
            $unsubscribeUpdate = DB::table('unsubscribes')->where('lead_id', $request->leadId)->update(['email_unsubscribe' => $emailSubscription, 'sms_unsubscribe' => $smsSubscription]);
            $saleUpdateData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->update(['sale_completed_by' => $request->sale_completed_by]);
            $saleUpdatedData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->select('sale_completed_by')->get()->first();
             }
            $leadUpdatedData = DB::table('leads')->where('lead_id', $request->leadId)->select('visitor_source')->get()->first();
            $unsubscribeUpdatedData = DB::table('unsubscribes')->where('lead_id', $request->leadId)->select('email_unsubscribe', 'sms_unsubscribe')->get()->first();
            return response()->json(['status' => true, 'message' => 'Stage data updated successfully', 'elecUpdatedData' => $elecUpdatedData, 'gasUpdatedData' => $gasUpdatedData, 'saleUpdatedData' => $saleUpdatedData, 'leadUpdatedData' => $leadUpdatedData, 'unsubscribeUpdatedData' => $unsubscribeUpdatedData,'mobileUpdatedData'=>$mobileUpdatedData,'broadbandUpdatedData'=>$broadbandUpdatedData,'saleType'=>$request->saleType], 200);
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }
    public static function updateJourney($request)
    {
        try {
            if ($request->verticalId == 1) {
                $elecSaleUpdatedData = null;
                $gasSaleUpdatedData = null;
                $elecProvider = null;
                $gasProvider = null;
                $gasDistributor = null;
                $elecDistributor = null;
                $current_date_time = Carbon::now()->toDateTimeString();
                $user = auth()->user();
                $journeyData = DB::table('lead_journey_data_energy')->where('lead_id', $request->leadId)->get()->first();
                $controlLoad = DB::table('energy_bill_details')->where('lead_id', $request->leadId)->get()->first();
                $elecSaleData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 1)->get()->first();
                $gasSaleData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 2)->get()->first();
                $visitorData = DB::table('visitor_informations_energy')->where('visitor_id', $request->visitorId)->get()->first();
                if ($controlLoad == null) {
                    DB::table('energy_bill_details')->insert(['credit_score' => $request->credit_score, 'control_load_one_off_peak' => $request->control_load_one_off_peak, 'control_load_two_off_peak' => $request->control_load_two_off_peak, 'control_load_one_shoulder' => $request->control_load_one_shoulder, 'control_load_two_shoulder' => $request->control_load_two_shoulder, 'lead_id' => $request->leadId]);
                }
                if ($visitorData == null) {
                    DB::table('visitor_informations_energy')->insert([
                        'is_elec_work' => $request->has('is_elec_work') ? 1 : 0,
                        'is_any_access_issue' => $request->has('is_any_access_issue') ? 1 : 0, 'visitor_id' => $request->visitorId
                    ]);
                }
                $logData = [
                    'lead_id' => $request->leadId,
                    'comments' => $request->comment,
                    'solar_panel' => $journeyData->solar_panel,
                    'solar_options' => $journeyData->solar_options,
                    'is_dual' => $journeyData->is_dual,
                    'moving_house' => $journeyData->moving_house,
                    'life_support' => $journeyData->life_support,
                    'life_support_energy_type' => $journeyData->life_support_energy_type,
                    'life_support_value' => $journeyData->life_support_value,
                    'prefered_move_in_time' => $journeyData->prefered_move_in_time,
                    'electricity_distributor_id' => isset($elecSaleData->distributor_id) ? $elecSaleData->distributor_id : null,
                    'gas_distributor_id' => isset($gasSaleData->distributor_id) ? $gasSaleData->distributor_id : null,
                    'control_load_one_off_peak' => isset($controlLoad) ? $controlLoad->control_load_one_off_peak : null,
                    'control_load_two_off_peak' => isset($controlLoad) ? $controlLoad->control_load_two_off_peak : null,
                    'control_load_one_shoulder' => isset($controlLoad) ? $controlLoad->control_load_one_shoulder : null,
                    'control_load_two_shoulder' => isset($controlLoad) ?  $controlLoad->control_load_two_shoulder : null,
                    'electricity_meter_type_code' => isset($elecSaleData->meter_type_code) ? $elecSaleData->meter_type_code : null,
                    'gas_meter_type_code' => isset($gasSaleData->meter_type_code) ? $gasSaleData->meter_type_code : null,
                    'credit_score' => isset($controlLoad) ? $controlLoad->credit_score : null,
                    'is_elec_work' => isset($visitorData) ? $visitorData->is_elec_work : null,
                    'is_any_access_issue' => isset($visitorData) ? $visitorData->is_any_access_issue : null,
                    'electricity_provider_id' => isset($elecSaleData) ? $elecSaleData->provider_id : null,
                    'electricity_moving_date' => isset($elecSaleData) ? $elecSaleData->moving_at : null,
                    'gas_moving_date' => isset($gasSaleData) ? $gasSaleData->moving_at : null,
                    'gas_provider_id' => isset($gasSaleData) ? $gasSaleData->provider_id : null,
                    'changed_by' => $user->id,
                    'created_at' => $current_date_time,
                ];
                $result = DB::connection('sale_logs')->table('journey_logs')->insert($logData);
                $journeyUpdateData = [
                    'life_support' => $request->life_support,
                    'life_support_energy_type' => $request->medical_equipment_energytype,
                    'life_support_value' => $request->medical_equipment_value,
                    'moving_house' => $request->move_in,
                    'solar_panel' => $request->solar,
                    'solar_options' => $request->solar_tariff_type,
                    'prefered_move_in_time' => $request->prefered_move_in_time,
                    'is_dual' => 0,
                ];
                $energyUpdateData = [
                    'credit_score' => $request->credit_score,
                ];
                $visitorInfoUpdateData = [
                    'is_elec_work' => $request->has('is_elec_work') ? 1 : 0,
                    'is_any_access_issue' => $request->has('is_any_access_issue') ? 1 : 0,
                ];
                $elecUpdateData = [
                    'is_moving' => 0,
                    'moving_at' => $request->elec_movin_date,
                ];
                $gasUpdateData = [
                    'is_moving' => 0,
                    'moving_at' => $request->gas_movin_date,
                ];
                if ($request->life_support == 1) {
                    $journeyUpdateData['life_support_energy_type'] = $request->medical_equipment_energytype;
                    $journeyUpdateData['life_support_value'] = $request->medical_equipment_value;
                }
                if ($request->move_in == 1) {
                    $elecUpdateData['is_moving'] = $gasUpdateData['is_moving'] = 1;
                    $elecUpdateData['moving_at'] = $request->elec_movin_date;
                    $gasUpdateData['moving_at'] = $request->gas_movin_date;
                    $journeyUpdateData['prefered_move_in_time'] = $request->prefered_move_in_time;
                }
                if ($request->solar == 1) {
                    $journeyUpdateData['solar_options'] = $request->solar_tarriff_type;
                }
                if ($request->has('electricityProductType')) {
                    $elecProductType = $request->electricityProductType;
                    $journeyUpdateData['energy_type'] = 1;
                    $energyUpdateData['control_load_one_off_peak'] = $request->control_load_one_off_peak;
                    $energyUpdateData['control_load_two_off_peak'] = $request->control_load_two_off_peak;
                    $energyUpdateData['control_load_one_shoulder'] = $request->control_load_one_shoulder;
                    $energyUpdateData['control_load_two_shoulder'] = $request->control_load_two_shoulder;
                    $elecUpdateData['provider_id'] = $request->elec_provider;
                    $elecUpdateData['distributor_id'] = $request->elec_distributor;
                    $elecUpdateData['meter_type_code'] = $request->elec_meter_type_code;
                    $result =  DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', $elecProductType)->update($elecUpdateData);
                    $elecSaleUpdatedData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 1)->get()->first();
                    $elecDistributor = Distributor::where('id', $elecSaleUpdatedData->distributor_id)->select('name')->first();
                    if ($elecSaleUpdatedData->moving_at == 0) {
                        $elecProvider = Providers::where('id', $elecSaleUpdatedData->provider_id)->select('legal_name')->first();
                        $elecProvider = $elecProvider->legal_name;
                    }
                }
                if ($request->has('gasProductType')) {
                    $gasProductType = $request->gasProductType;
                    $journeyUpdateData['energy_type'] = 2;
                    $gasUpdateData['provider_id'] = $request->gas_provider;
                    $gasUpdateData['distributor_id'] = $request->gas_distributor;
                    $gasUpdateData['meter_type_code'] = $request->gas_meter_type_code;
                    $result =  DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', $gasProductType)->update($gasUpdateData);
                    $gasSaleUpdatedData = DB::table('sale_products_energy')->where('lead_id', $request->leadId)->where('product_type', 2)->get()->first();
                    $gasDistributor = Distributor::where('id', $gasSaleUpdatedData->distributor_id)->select('name')->first();

                    if ($gasSaleUpdatedData->moving_at == 0) {
                        $gasProvider = Providers::where('id', $gasSaleUpdatedData->provider_id)->select('legal_name')->first();
                        $gasProvider = $gasProvider->legal_name;
                    }
                }
                if ($request->has('gasProductType') && $request->has('electricityProductType')) {
                    $journeyUpdateData['is_dual'] = 1;
                    $journeyUpdateData['energy_type'] = 3;
                }
                $result =  DB::table('lead_journey_data_energy')->where('lead_id', $request->leadId)->update($journeyUpdateData);
                $result =  DB::table('energy_bill_details')->where('lead_id', $request->leadId)->update($energyUpdateData);
                $result =  DB::table('visitor_informations_energy')->where('visitor_id', $request->visitorId)->update($visitorInfoUpdateData);
                $journeyUpdatedData = DB::table('lead_journey_data_energy')->where('lead_id', $request->leadId)->get()->first();
                $controlUpdatedLoad = DB::table('energy_bill_details')->where('lead_id', $request->leadId)->get()->first();
                $visitorUpdatedData = DB::table('visitor_informations_energy')->where('visitor_id', $request->visitorId)->get()->first();

                return response()->json(['status' => true, 'message' => 'Journey Data Updated Successfully', 'journeyUpdatedData' => $journeyUpdatedData, 'controlUpdatedLoad' => $controlUpdatedLoad, 'elecSaleUpdatedData' => $elecSaleUpdatedData, 'elecDistributor' => $elecDistributor, 'gasSaleUpdatedData' => $gasSaleUpdatedData, 'gasDistributor' => $gasDistributor, 'elecProvider' => $elecProvider, 'gasProvider' => $gasProvider, 'visitorUpdatedData' => $visitorUpdatedData], 200);
            }
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function updateAddress($request)
    {
        try {
            $user = auth()->user();
            $current_date_time = Carbon::now()->toDateTimeString();
            $isQasvalid = 0;
            $validate_address = 0;
            $email_welcome_pack = 0;
            if ($request->form_name == 'connectioninfo_form') {
                $connectionAddressData = VisitorAddress::where('id', $request->connectionAddressId)->select('id', 'visitor_id', 'address', 'address_type', 'lot_number', 'unit_number', 'unit_type', 'unit_type_code', 'floor_number', 'floor_level_type', 'floor_type_code', 'street_name', 'street_number', 'street_suffix', 'street_number_suffix', 'dpid', 'house_number', 'house_number_suffix', 'suburb', 'state', 'property_name', 'postcode', 'street_code', 'site_descriptor', 'property_ownership', 'is_qas_valid', 'validate_address')->get()->toArray();
                if ($request->has('is_qas_valid')) {
                    $isQasvalid = 1;
                }
                if ($request->has('validate_address')) {
                    $validate_address = 1;
                }
                $state = States::where('state_id',$request->state)->first();
                $street_code = DB::table('master_street_codes')->where('id',$request->street_code)->first();
                $street_code = isset($street_code) ? $street_code->value : '';
                $state_code = isset($state) ? $state->state_code : '';
                $updatedAddressData = [
                    'visitor_id' => $request->visitorId,
                    'address' =>'Unit '.$request->unit_no.' '.$request->street_number.' '.$request->street_name.' '.$street_code.', '.$request->suburb.' '.$state_code.' '.$request->postcode,
                    'address_type' => $request->addressType,
                    'lot_number' => $request->lot_number,
                    'unit_number' => $request->unit_no,
                    'unit_type' => $request->unit_type,
                    'unit_type_code' => $request->unit_type_code,
                    'floor_number' => $request->floor_no,
                    'floor_level_type' => $request->floor_level_type,
                    'floor_type_code' => $request->floor_type_code,
                    'street_name' => $request->street_name,
                    'street_number' => $request->street_number,
                    'street_suffix' => $request->street_suffix,
                    'street_number_suffix' => $request->street_number_suffix,
                    'dpid' => $request->connection_dpid,
                    'house_number' => $request->house_num,
                    'house_number_suffix' => $request->house_number_suffix,
                    'suburb' => $request->suburb,
                    'state' => $request->state,
                    'property_name' => $request->property_name,
                    'postcode' => $request->postcode,
                    'street_code' => $request->street_code,
                    'site_descriptor' => $request->site_descriptor,
                    'property_ownership' => $request->property_ownership,
                    'is_qas_valid' => $isQasvalid,
                    'validate_address' => $validate_address
                ];
                if (count($connectionAddressData) > 0) {
                    $connectionAddressData[0]['visitor_address_id'] = $connectionAddressData[0]['id'];
                    unset($connectionAddressData[0]['id']);
                    $connectionAddressData[0]['comments'] = $request->comment;
                    $connectionAddressData[0]['changed_by'] = $user->id;
                    $connectionAddressData[0]['created_at'] = $current_date_time;
                    DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($connectionAddressData);
                    VisitorAddress::where('id', $request->connectionAddressId)->update($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $request->connectionAddressId)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    return response()->json(['status' => true, 'message' => 'Connection address updated successfully', 'data' => $updatedData, 'addressId' => 'connectioninfo_form'], 200);
                } else {
                    $result = VisitorAddress::create($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $result->id)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    $result = Lead::where('lead_id', $request->leadId)->update(['connection_address_id' => $result->id]);
                    return response()->json(['status' => true, 'message' => 'Connection address updated successfully', 'data' => $updatedData, 'addressId' => 'connectioninfo_form'], 200);
                }
            } else if ($request->form_name == 'gas_connection_form') {
                $gasConnectionAddressData = VisitorAddress::where('id', $request->gasConnectionAddressId)->select('id', 'visitor_id', 'address', 'address_type', 'lot_number', 'unit_number', 'unit_type', 'unit_type_code', 'floor_number', 'floor_level_type', 'floor_type_code', 'street_name', 'street_number', 'street_suffix', 'street_number_suffix', 'dpid', 'house_number', 'house_number_suffix', 'suburb', 'state', 'property_name', 'postcode', 'street_code', 'site_descriptor', 'property_ownership', 'is_qas_valid', 'validate_address', 'is_same_gas_connection')->get()->toArray();
                if ($request->has('is_qas_valid')) {
                    $isQasvalid = 1;
                }
                if ($request->has('validate_address')) {
                    $validate_address = 1;
                }
                $state = States::where('state_id',$request->state)->first();
                $street_code = DB::table('master_street_codes')->where('id',$request->street_code)->first();
                $street_code = isset($street_code) ? $street_code->value : '';
                $state_code = isset($state) ? $state->state_code : '';
                $updatedAddressData = [
                    'visitor_id' => $request->visitorId,
                    'address' =>'Unit '.$request->unit_no.' '.$request->street_number.' '.$request->street_name.' '.$street_code.', '.$request->suburb.' '.$state_code.' '.$request->postcode,
                    'address_type' => $request->addressType,
                    'lot_number' => $request->lot_number,
                    'unit_number' => $request->unit_no,
                    'unit_type' => $request->unit_type,
                    'unit_type_code' => $request->unit_type_code,
                    'floor_number' => $request->floor_no,
                    'floor_level_type' => $request->floor_level_type,
                    'floor_type_code' => $request->floor_type_code,
                    'street_name' => $request->street_name,
                    'street_number' => $request->street_number,
                    'street_suffix' => $request->street_suffix,
                    'street_number_suffix' => $request->street_number_suffix,
                    'dpid' => $request->dpid,
                    'house_number' => $request->house_num,
                    'house_number_suffix' => $request->house_number_suffix,
                    'suburb' => $request->suburb,
                    'state' => $request->state,
                    'property_name' => $request->property_name,
                    'postcode' => $request->postcode,
                    'street_code' => $request->street_code,
                    'site_descriptor' => $request->site_descriptor,
                    'property_ownership' => $request->property_ownership,
                    'is_same_gas_connection' => $request->gas_connection,
                    'is_qas_valid' => $isQasvalid,
                    'validate_address' => $validate_address
                ];
                if (count($gasConnectionAddressData) > 0) {
                    $gasConnectionAddressData[0]['visitor_address_id'] = $gasConnectionAddressData[0]['id'];
                    unset($gasConnectionAddressData[0]['id']);
                    $gasConnectionAddressData[0]['comments'] = $request->comment;
                    $gasConnectionAddressData[0]['changed_by'] = $user->id;
                    $gasConnectionAddressData[0]['created_at'] = $current_date_time;
                    DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($gasConnectionAddressData);
                    VisitorAddress::where('id', $request->gasConnectionAddressId)->update($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $request->gasConnectionAddressId)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    return response()->json(['status' => true, 'message' => 'Gas Connection address updated successfully', 'data' => $updatedData, 'addressId' => 'gas_connection_form'], 200);
                } else {
                    $result = VisitorAddress::create($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $result->id)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    return response()->json(['status' => true, 'message' => 'Gas Connection address updated successfully', 'data' => $updatedData, 'addressId' => 'gas_connection_form'], 200);
                }
            } else if ($request->form_name == 'billinginfo_form') {
                $billingAddressData = VisitorAddress::where('id', $request->billingAddressId)->select('id', 'visitor_id', 'address', 'address_type', 'lot_number', 'unit_number', 'unit_type', 'unit_type_code', 'floor_number', 'floor_level_type', 'floor_type_code', 'street_name', 'street_number', 'street_suffix', 'street_number_suffix', 'dpid', 'house_number', 'house_number_suffix', 'suburb', 'state', 'property_name', 'postcode', 'street_code', 'site_descriptor', 'property_ownership', 'is_qas_valid', 'validate_address')->get()->toArray();
                $leadData = Lead::where('lead_id', $request->leadId)->select(['billing_preference', 'email_welcome_pack'])->get()->first();
                if ($request->billing_is_qas_valid) {
                    $isQasvalid = 1;
                }
                if ($request->billing_validate_address) {
                    $validate_address = 1;
                }
                if ($request->email_welcome_pack) {
                    $email_welcome_pack = 1;
                }
                $state = States::where('state_id',$request->billing_state)->first();
                $street_code = DB::table('master_street_codes')->where('id',$request->billing_street_code)->first();
                $street_code = isset($street_code) ? $street_code->value : '';
                $state_code = isset($state) ? $state->state_code : '';
                $updatedAddressData = [
                    'visitor_id' => $request->visitorId,
                    'address' => 'Unit '.$request->billing_unit_no.' '.$request->billing_street_number.' '.$request->billing_street_name.' '.$street_code.', '.$request->billing_suburb.' '.$state_code.' '.$request->billing_postcode,
                    'address_type' => 3,
                    'lot_number' => $request->billing_lot_number,
                    'unit_number' => $request->billing_unit_no,
                    'unit_type' => $request->billing_unit_type,
                    'unit_type_code' => $request->billing_unit_type_code,
                    'floor_number' => $request->billing_floor_no,
                    'floor_level_type' => $request->billing_floor_level_type,
                    'floor_type_code' => $request->billing_floor_type_code,
                    'street_name' => $request->billing_street_name,
                    'street_number' => $request->billing_street_number,
                    'street_suffix' => $request->billing_street_suffix,
                    'street_number_suffix' => $request->billing_street_number_suffix,
                    'dpid' => $request->billing_dpid,
                    'house_number' => $request->billing_house_num,
                    'house_number_suffix' => $request->billing_house_number_suffix,
                    'suburb' => $request->billing_suburb,
                    'state' => $request->billing_state,
                    'property_name' => $request->billing_property_name,
                    'postcode' => $request->billing_postcode,
                    'street_code' => $request->billing_street_code,
                    'site_descriptor' => $request->billing_site_descriptor,
                    'property_ownership' => $request->billing_property_ownership,
                    'is_qas_valid' => $isQasvalid,
                    'validate_address' => $validate_address
                ];
                if (count($billingAddressData) > 0) {
                    $billingAddressData[0]['visitor_address_id'] = $billingAddressData[0]['id'];
                    unset($billingAddressData[0]['id']);
                    $billingAddressData[0]['comments'] = $request->comment;
                    $billingAddressData[0]['changed_by'] = $user->id;
                    $billingAddressData[0]['created_at'] = $current_date_time;
                    $billingAddressData[0]['email_welcome_pack'] = $leadData->email_welcome_pack;
                    $billingAddressData[0]['billing_preference'] = $leadData->billing_preference;
                    DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($billingAddressData);
                    $result =  VisitorAddress::where('id', $request->billingAddressId)->update($updatedAddressData);
                    $result = Lead::where('lead_id', $request->leadId)->update(['billing_preference' => $request->billing_address_option, 'email_welcome_pack' => $email_welcome_pack]);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $request->billingAddressId)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    $leadUpdatedData = Lead::where('lead_id', $request->leadId)->select('billing_preference', 'email_welcome_pack')->get()->first();
                    $updatedData[0]['email_welcome_pack'] = $leadUpdatedData->email_welcome_pack;
                    $updatedData[0]['billing_preference'] = $leadUpdatedData->billing_preference;
                    return response()->json(['status' => true, 'message' => 'Billing Address Updated Successfully', 'data' => $updatedData, 'addressId' => 'billinginfo_form'], 200);
                } else {
                    $result = VisitorAddress::create($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $result->id)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    $result = Lead::where('lead_id', $request->leadId)->update(['billing_address_id' => $result->id, 'billing_preference' => $request->billing_address_option, 'email_welcome_pack' => $email_welcome_pack]);
                    $leadUpdatedData = Lead::where('lead_id', $request->leadId)->select('billing_preference', 'email_welcome_pack')->get()->first();
                    $updatedData[0]['email_welcome_pack'] = $leadUpdatedData->email_welcome_pack;
                    $updatedData[0]['billing_preference'] = $leadUpdatedData->billing_preference;
                    return response()->json(['status' => true, 'message' => 'Billing Address Updated Successfully', 'data' => $updatedData, 'addressId' => 'billinginfo_form'], 200);
                }
            }
            else if ($request->form_name == 'deliveryinfo_form') {
                $deliveryAddressData = VisitorAddress::where('id', $request->deliveryAddressId)->select('id', 'visitor_id', 'address', 'address_type', 'lot_number', 'unit_number', 'unit_type', 'unit_type_code', 'floor_number', 'floor_level_type', 'floor_type_code', 'street_name', 'street_number', 'street_suffix', 'street_number_suffix', 'dpid', 'house_number', 'house_number_suffix', 'suburb', 'state', 'property_name', 'postcode', 'street_code', 'site_descriptor', 'property_ownership', 'is_qas_valid', 'validate_address')->get()->toArray();
                $leadData = Lead::where('lead_id', $request->leadId)->select(['delivery_preference'])->get()->first();
                if ($request->delivery_is_qas_valid) {
                    $isQasvalid = 1;
                }
                if ($request->delivery_validate_address) {
                    $validate_address = 1;
                }
                $state = States::where('state_id',$request->delivery_state)->first();
                $street_code = DB::table('master_street_codes')->where('id',$request->delivery_street_code)->first();
                $street_code = isset($street_code) ? $street_code->value : '';
                $state_code = isset($state) ? $state->state_code : '';
                $updatedAddressData = [
                    'visitor_id' => $request->visitorId,
                    'address' => 'Unit '.$request->delivery_unit_no.' '.$request->delivery_street_number.' '.$request->delivery_street_name.' '.$street_code.', '.$request->delivery_suburb.' '.$state_code.' '.$request->delivery_postcode,
                    'address_type' => 4,
                    'lot_number' => $request->delivery_lot_number,
                    'unit_number' => $request->delivery_unit_no,
                    'unit_type' => $request->delivery_unit_type,
                    'unit_type_code' => $request->delivery_unit_type_code,
                    'floor_number' => $request->delivery_floor_no,
                    'floor_level_type' => $request->delivery_floor_level_type,
                    'floor_type_code' => $request->delivery_floor_type_code,
                    'street_name' => $request->delivery_street_name,
                    'street_number' => $request->delivery_street_number,
                    'street_suffix' => $request->delivery_street_suffix,
                    'street_number_suffix' => $request->delivery_street_number_suffix,
                    'dpid' => $request->delivery_dpid,
                    'house_number' => $request->delivery_house_num,
                    'house_number_suffix' => $request->delivery_house_number_suffix,
                    'suburb' => $request->delivery_suburb,
                    'state' => $request->delivery_state,
                    'property_name' => $request->delivery_property_name,
                    'postcode' => $request->delivery_postcode,
                    'street_code' => $request->delivery_street_code,
                    'site_descriptor' => $request->delivery_site_descriptor,
                    'property_ownership' => $request->delivery_property_ownership,
                    'is_qas_valid' => $isQasvalid,
                    'validate_address' => $validate_address
                ];
                if (count($deliveryAddressData) > 0) {
                    $deliveryAddressData[0]['visitor_address_id'] = $deliveryAddressData[0]['id'];
                    unset($deliveryAddressData[0]['id']);
                    $deliveryAddressData[0]['comments'] = $request->comment;
                    $deliveryAddressData[0]['changed_by'] = $user->id;
                    $deliveryAddressData[0]['created_at'] = $current_date_time;
                    $deliveryAddressData[0]['billing_preference'] = $leadData->delivery_preference;
                    DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($deliveryAddressData);
                    $result =  VisitorAddress::where('id', $request->deliveryAddressId)->update($updatedAddressData);
                    $result = Lead::where('lead_id', $request->leadId)->update(['delivery_preference' => $request->delivery_address_option]);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $request->deliveryAddressId)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    $leadUpdatedData = Lead::where('lead_id', $request->leadId)->select('delivery_preference')->get()->first();
                    $updatedData[0]['delivery_preference'] = $leadUpdatedData->delivery_preference;
                    return response()->json(['status' => true, 'message' => 'Delivery Address Updated Successfully', 'data' => $updatedData, 'addressId' => 'deliveryinfo_form'], 200);
                } else {
                    $result = VisitorAddress::create($updatedAddressData);
                    $updatedData  = VisitorAddress::where('visitor_addresses.id', $result->id)->get()->toArray();
                    $state = States::where('state_id',$updatedData[0]['state'])->first();
                    $updatedData[0]['state'] = isset($state) ? $state->state_code : null;
                    $unit_type = DB::table('master_employment_details')->where('id',$updatedData[0]['unit_type'])->first();
                    $updatedData[0]['unit_type'] = isset($unit_type) ? $unit_type->name : null;
                    $street_code = DB::table('master_street_codes')->where('id',$updatedData[0]['street_code'])->first();
                    $updatedData[0]['street_code'] = isset($street_code) ? $street_code->value : null;
                    $result = Lead::where('lead_id', $request->leadId)->update(['delivery_address_id' => $result->id, 'delivery_preference' => $request->delivery_address_option]);
                    $leadUpdatedData = Lead::where('lead_id', $request->leadId)->select('delivery_preference')->get()->first();
                    $updatedData[0]['delivery_preference'] = $leadUpdatedData->delivery_preference;
                    return response()->json(['status' => true, 'message' => 'Delivery Address Updated Successfully', 'data' => $updatedData, 'addressId' => 'deliveryinfo_form'], 200);
                }
            }
            else if ($request->form_name == 'pobox_form') {
                $poBoxAddressData = VisitorAddress::where('id', $request->poBoxAddressId)->select('id', 'address_type', 'suburb', 'postcode', 'state', 'dpid', 'po_box', 'is_qas_valid', 'validate_address', 'visitor_id')->get()->toArray();
                if ($request->has('enable_pobox')) {
                    if ($request->has('is_qas_valid')) {
                        $isQasvalid = 1;
                    }
                    if ($request->has('validate_address')) {
                        $validate_address = 1;
                    }

                    $updatedAddressData = [
                        'visitor_id' => $request->visitorId,
                        'address' => $request->address,
                        'po_box' => $request->address,
                        'address_type' => $request->addressType,
                        'dpid' => $request->po_box_dpid,
                        'suburb' => $request->suburb,
                        'state' => $request->state,
                        'postcode' => $request->postcode,
                        'is_qas_valid' => $isQasvalid,
                        'validate_address' => $validate_address,
                    ];
                    if (count($poBoxAddressData) > 0) {
                        $poBoxAddressData[0]['visitor_address_id'] = $poBoxAddressData[0]['id'];
                        unset($poBoxAddressData[0]['id']);
                        $poBoxAddressData[0]['comments'] = $request->comment;
                        $poBoxAddressData[0]['changed_by'] = $user->id;
                        $poBoxAddressData[0]['created_at'] = $current_date_time;
                        DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($poBoxAddressData);
                        VisitorAddress::where('id', $request->poBoxAddressId)->update($updatedAddressData);
                        $updatedData  = VisitorAddress::join('states', 'visitor_addresses.state', '=', 'states.state_id')->select('visitor_addresses.*','states.state_code')->where('id', $request->poBoxAddressId)->get()->toArray();
                        return response()->json(['status' => true, 'message' => 'PO Box address updated successfully', 'data' => $updatedData, 'addressId' => 'pobox_form'], 200);
                    } else {
                        $result = VisitorAddress::create($updatedAddressData);
                        $updatedData  = VisitorAddress::join('states', 'visitor_addresses.state', '=', 'states.state_id')->select('visitor_addresses.*','states.state_code')->where('id', $result->id)->get()->toArray();
                        $result = Lead::where('lead_id', $request->leadId)->update(['billing_po_box_id' => $updatedData[0]['id']]);
                        return response()->json(['status' => true, 'message' => 'PO Box address updated successfully', 'data' => $updatedData, 'addressId' => 'pobox_form'], 200);
                    }
                } else {
                    $updatedAddressData = [
                        'visitor_id' => $request->visitorId,
                        'address' => 'PO Box Address',
                        'po_box' => null,
                        'address_type' => $request->addressType,
                        'dpid' => null,
                        'suburb' => null,
                        'state' => null,
                        'postcode' => null,
                        'is_qas_valid' => null,
                        'validate_address' => null,
                    ];
                    if (count($poBoxAddressData) > 0) {
                        $poBoxAddressData[0]['visitor_address_id'] = $poBoxAddressData[0]['id'];
                        unset($poBoxAddressData[0]['id']);
                        $poBoxAddressData[0]['comments'] = $request->comment;
                        $poBoxAddressData[0]['changed_by'] = $user->id;
                        $poBoxAddressData[0]['created_at'] = $current_date_time;
                        DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($poBoxAddressData);
                        VisitorAddress::where('id', $request->poBoxAddressId)->update($updatedAddressData);
                        $updatedData  = VisitorAddress::where('id', $request->poBoxAddressId)->get()->toArray();
                        return response()->json(['status' => true, 'message' => 'PO Box address updated successfully', 'data' => $updatedData, 'addressId' => 'pobox_form'], 200);
                    }
                    else{
                        $result = VisitorAddress::create($updatedAddressData);
                        $updatedData  = VisitorAddress::where('id', $result->id)->get()->toArray();
                        $result = Lead::where('lead_id', $request->leadId)->update(['billing_po_box_id' => $updatedData[0]['id']]);
                        return response()->json(['status' => true, 'message' => 'PO Box address updated successfully', 'data' => $updatedData, 'addressId' => 'pobox_form'], 200);
                    }
                }
            } else if ($request->form_name == 'manual_connection_form') {
                $manualAddressData = VisitorAddress::where('id', $request->manualAddressId)->select('id', 'address_type', 'visitor_id', 'manual_connection_details')->get()->toArray();
                if (count($manualAddressData) > 0) {
                    $manualAddressData[0]['visitor_address_id'] = $manualAddressData[0]['id'];
                    unset($manualAddressData[0]['id']);
                    $manualAddressData[0]['comments'] = $request->comment;
                    $manualAddressData[0]['changed_by'] = $user->id;
                    DB::connection('sale_logs')->table('visitor_addresses_logs')->insert($manualAddressData);
                    VisitorAddress::where('id', $request->manualAddressId)->update(['manual_connection_details' => $request->manual_connection_address]);
                    $updatedData  = VisitorAddress::where('id', $request->manualAddressId)->get()->toArray();
                    return response()->json(['status' => true, 'message' => 'Manual connection address updated successfully', 'data' => $updatedData, 'addressId' => 'manual_connection_form'], 200);
                } else {
                    $result = VisitorAddress::create(['visitor_id'=>$request->visitorId,'address_type'=>$request->addressType,'address'=>$request->manual_connection_address,'manual_connection_details'=>$request->manual_connection_address]);
                    $updatedData  = VisitorAddress::where('id', $result->id)->get()->toArray();
                    return response()->json(['status' => true, 'message' => 'Manual connection address updated successfully', 'data' => $updatedData, 'addressId' => 'manual_connection_form'], 200);
                }
            }
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function updateCustomerData($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['form', 'comment']);
            $data['first_name'] = encryptGdprData($request->first_name);
            $data['middle_name'] = encryptGdprData($request->middle_name);
            $data['last_name'] = encryptGdprData($request->last_name);
            $data['email'] = encryptGdprData($request->email);
            $phoneCode = substr($request->phone, 0, 2);
            if($phoneCode == '02' || $phoneCode == '03'){
                $data['alternate_phone'] = encryptGdprData($request->phone);
                unset($data['phone']);
            }
            else{
                $data['phone'] = encryptGdprData($request->phone);
                $data['alternate_phone'] = encryptGdprData($request->alternate_phone);
            }
            $visitor_id = $request->visitor_id;
            $existingCustInfo = Visitor::where('id', $visitor_id)->first();
            if ($existingCustInfo) {
                $logsData = [
                    'visitor_id' => $request->visitor_id,
                    'title' => $existingCustInfo->title,
                    'first_name' => $existingCustInfo->first_name,
                    'middle_name' => $existingCustInfo->middle_name,
                    'last_name' => $existingCustInfo->last_name,
                    'email' => $existingCustInfo->email,
                    'dob' => $existingCustInfo->dob,
                    'phone' => $existingCustInfo->phone,
                    'alternate_phone' => $existingCustInfo->alternate_phone,
                    'comment' => $request->comment,
                    'changed_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => now(),

                ];
                $customerInfoLogs = DB::connection('sale_logs')->table('customer_info_logs')->insert($logsData);
            }
            $plan = Visitor::updateOrCreate(['id' => $visitor_id], $data);
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($plan) {
                DB::commit();
                $customerInfoData = Visitor::where('id', $plan->id)->first();
                $customerInfoData['first_name'] = decryptGdprData($customerInfoData->first_name);
                $customerInfoData['middle_name'] = decryptGdprData($customerInfoData->middle_name);
                $customerInfoData['last_name'] = decryptGdprData($customerInfoData->last_name);
                $customerInfoData['email'] = decryptGdprData($customerInfoData->email);
                $customerInfoData['phone'] = decryptGdprData($customerInfoData->phone);
                $customerInfoData['alternate_phone'] = decryptGdprData($customerInfoData->alternate_phone);
                $response['customerInfoData'] = $customerInfoData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }

    public static function updateCustomerNote($request)
    {
        $user = auth()->user();
        $leadId = $request->lead_id;
        $values = [];
        $flag = 0;
        $current_date_time = Carbon::now()->toDateTimeString();
        $query = SaleProductsEnergy::where(['lead_id' => $leadId]);
        if($request->vertical_id == 1){
        if (count($request->product_id) >= 2) {
            $elecDetails = SaleProductsEnergy::where(['lead_id' => $leadId,'product_type'=>$request->product_id[0]])->select('lead_id', 'service_id','note')->get()->toArray();
            $gasDetails = SaleProductsEnergy::where(['lead_id' => $leadId,'product_type'=>$request->product_id[1]])->select('lead_id', 'service_id','note')->get()->toArray();

            SaleProductsEnergy::where(['lead_id' => $leadId, 'product_type' => $request->product_id[0]])->update(['note' => $request->elec_note]);
            SaleProductsEnergy::where(['lead_id' => $leadId, 'product_type' => $request->product_id[1]])->update(['note' => $request->gas_note]);

            $elecDetails[0]['comment'] = $request->comment;
            $elecDetails[0]['changed_by'] = $user->id;
            $elecDetails[0]['created_at'] = $current_date_time;
            $elecDetails[0]['updated_at'] = $current_date_time;
            $elecDetails[0]['electricity_note'] = $elecDetails ? $elecDetails[0]['note'] : null;
            $elecDetails[0]['gas_note'] = $gasDetails ? $gasDetails[0]['note'] : null;
            unset($elecDetails[0]['note']);

            $response = DB::connection('sale_logs')->table('customer_note_logs')->insert($elecDetails);
            $latestProductDetails = $query->whereIn('product_type', [$request->product_id[0], $request->product_id[1]])->get();
            $flag = 1;
        } else {
            if (!empty($request->elec_note)) {
                $note = $request->elec_note;
            } else {
                $note = $request->gas_note;
            }
            // $note=$elec_note ? $elec_note : $gas_note;

            $productDetails = $query->select('lead_id', 'service_id','note')->where('product_type', $request->product_id)->get()->toArray();
            $productDetails[0]['comment'] = $request->comment;
            $productDetails[0]['changed_by'] =  $user->id;
            $productDetails[0]['created_at'] = $current_date_time;
            $productDetails[0]['updated_at'] = $current_date_time;
            if($request->product_id[0] == 1){
            $productDetails[0]['electricity_note'] = $productDetails[0]['note'];
        }
        else{
            $productDetails[0]['gas_note'] = $productDetails[0]['note'];
        }
        unset($productDetails[0]['note']);

            DB::connection('sale_logs')->table('customer_note_logs')->insert($productDetails);
            DB::table('sale_products_energy')->where(['lead_id' => $leadId, 'product_type' => $request->product_id[0]])->update(['note' => $note]);
            $latestProductDetails = $query->where(['product_type' => $request->product_id[0]])->get();
            $flag = 1;
        }
        if ($flag == 1) {
            return response()->json(['status' => 200, 'data' => $latestProductDetails,'verticalId'=>$request->vertical_id, 'message' => "Comment added successfully"]);
        }

    }
    else{
        $note = Lead::where('lead_id',$leadId)->select('note')->get()->toArray();
        if($note[0]['note']){
        $note[0]['comment'] = $request->comment;
        $note[0]['lead_id'] = $leadId;
        $note[0]['service_id'] = $request->vertical_id;
        $note[0]['changed_by'] = $user->id;
        $note[0]['created_at'] = $current_date_time;
        $note[0]['updated_at'] = $current_date_time;
        DB::connection('sale_logs')->table('customer_note_logs')->insert($note);
        }
        $update = Lead::where('lead_id',$leadId)->update(['note'=>$request->customer_note]);
        if($update){
            $latestProductDetails = Lead::where(['lead_id' => $leadId])->get();
            return response()->json(['status' => 200, 'data' => $latestProductDetails,'verticalId'=>$request->vertical_id, 'message' => "Comment added successfully"]);
        }
    }
        return response()->json(['status' => 400, 'message' => "Something went wrong"]);
    }

    public static function updateDemandDetailInfo($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['form', 'energy_bill_details_id', 'comment']);
            $lead_id = $request->lead_id;
            $existingEnergyBillDetail = EnergyBillDetail::where('id', $request->energy_bill_details_id)->first();
            if ($existingEnergyBillDetail) {
            $logsData = [
                'lead_id' => $lead_id,
                'demand_tariff' => $existingEnergyBillDetail->demand_tariff,
                'demand_usage_type' => $existingEnergyBillDetail->demand_usage_type,
                'demand_meter_type' => $existingEnergyBillDetail->demand_meter_type,
                'demand_tariff_code' => $existingEnergyBillDetail->demand_tariff_code,
                'demand_rate1_peak_usage' => $existingEnergyBillDetail->demand_rate1_peak_usage,
                'demand_rate1_off_peak_usage' => $existingEnergyBillDetail->demand_rate1_off_peak_usage,
                'demand_rate1_shoulder_usage' => $existingEnergyBillDetail->demand_rate1_shoulder_usage,
                'demand_rate1_days' => $existingEnergyBillDetail->demand_rate1_days,
                'demand_rate2_peak_usage' => $existingEnergyBillDetail->demand_rate2_peak_usage,
                'demand_rate2_off_peak_usage' => $existingEnergyBillDetail->demand_rate2_off_peak_usage,
                'demand_rate2_shoulder_usage' => $existingEnergyBillDetail->demand_rate2_shoulder_usage,
                'demand_rate2_days' => $existingEnergyBillDetail->demand_rate2_days,
                'demand_rate3_peak_usage' => $existingEnergyBillDetail->demand_rate3_peak_usage,
                'demand_rate3_off_peak_usage' => $existingEnergyBillDetail->demand_rate3_off_peak_usage,
                'demand_rate3_shoulder_usage' => $existingEnergyBillDetail->demand_rate3_shoulder_usage,
                'demand_rate3_days' => $existingEnergyBillDetail->demand_rate3_days,
                'demand_rate4_peak_usage' => $existingEnergyBillDetail->demand_rate4_peak_usage,
                'demand_rate4_off_peak_usage' => $existingEnergyBillDetail->demand_rate4_off_peak_usage,
                'demand_rate4_shoulder_usage' => $existingEnergyBillDetail->demand_rate4_shoulder_usage,
                'demand_rate4_days' => $existingEnergyBillDetail->demand_rate4_days,
                'comment' => $request->comment,
                'changed_by' => auth()->user()->id,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => now(),
            ];
            $demandDetailLogs = DB::connection('sale_logs')->table('energy_bill_details_logs')->insert($logsData);
        }
            $energyBill = EnergyBillDetail::updateOrCreate(['id' => $request->energy_bill_details_id],$data);
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($energyBill) {
                DB::commit();
                $demandDetailsData = EnergyBillDetail::where('lead_id', $lead_id)->first();
                $tariffCode = MasterTariffCode::where('id',$demandDetailsData->demand_tariff_code)->select('tariff_code')->first();
                $demandDetailsData->demand_tariff_code = $tariffCode->tariff_code;
                $response['demandDetailsData'] = $demandDetailsData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }

    public static function updateNmiNumberInfo($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['form', 'comment', 'lead_id']);
            $visitor_info_energy_id = $request->visitor_info_energy_id;
            $existingNmiNumberDetail = VisitorInformationEnergy::where('id', $visitor_info_energy_id)->first();
            if ($existingNmiNumberDetail) {
                $logsData = [
                    'visitor_info_energy_id' => $visitor_info_energy_id,
                    'nmi_number' => $existingNmiNumberDetail->nmi_number,
                    'dpi_mirn_number' => $existingNmiNumberDetail->dpi_mirn_number,
                    'nmi_skip' => $existingNmiNumberDetail->nmi_skip,
                    'mirn_skip' => $existingNmiNumberDetail->mirn_skip,
                    'meter_number_e' => $existingNmiNumberDetail->meter_number_e,
                    'meter_number_g' => $existingNmiNumberDetail->meter_number_g,
                    'electricity_network_code' => $existingNmiNumberDetail->electricity_network_code,
                    'gas_network_code' => $existingNmiNumberDetail->gas_network_code,
                    'tariff_list' => $existingNmiNumberDetail->tariff_list,
                    'tariff_type' => $existingNmiNumberDetail->tariff_type,
                    'electricity_code' => $existingNmiNumberDetail->electricity_code,
                    'gas_code' => $existingNmiNumberDetail->gas_code,
                    'comment' => $request->comment,
                    'changed_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => now(),
                ];
                $nmiNumberLogs = DB::connection('sale_logs')->table('visitor_informations_energy_logs')->insert($logsData);
            }
            $nmiNumber = VisitorInformationEnergy::updateOrCreate(['id' => $visitor_info_energy_id], $data);
            if (!$existingNmiNumberDetail) {
                Lead::where('lead_id', $request->lead_id)->update([
                    'visitor_info_energy_id' => $nmiNumber->id,
                ]);
            }
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($nmiNumber) {
                DB::commit();
                $nmiNumberData = VisitorInformationEnergy::where('id', $nmiNumber->id)->first();
                $response['nmiNumberData'] = $nmiNumberData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }
    public static function updateConcessionDetails($request)
    {
        $user = auth()->user();
        $current_date_time = Carbon::now()->toDateTimeString();
        if (isset($request->vcd_id)) {
            $concessionData = VisitorConcessionDetail::select('visitor_id', 'energy_concession', 'concession_type', 'concession_code', 'card_start_date', 'card_expiry_date', 'card_number')->where(['id' => $request->vcd_id])->first()->toArray();
            $concessionData['created_at'] = $current_date_time;
            $concessionData['updated_at'] = $current_date_time;
            $concessionData['changed_by'] = $user->id;
            $concessionData['comment'] = $request->concession_details_comment ? $request->concession_details_comment : '';
            if (isset($concessionData)) {
                DB::connection('sale_logs')->table('visitor_concession_details_logs')->insert($concessionData);
            }
            $updateData = [
                'concession_type' => $request['concession_type'],
                'concession_code' => $request['concession_code'],
                'card_number' => $request['card_number'],
                'card_start_date' => $request['card_issue_date'],
                'card_expiry_date' => $request['card_expiry_date']
            ];
            $res = VisitorConcessionDetail::where(['id' => $request->vcd_id])->update($updateData);
            $updatedData = VisitorConcessionDetail::where(['id' => $request->vcd_id])->first();
            $connectionTypeName = ConnectionType::select('name')->where(['service_id'=>'1','local_id' => $updatedData->concession_type])->get()->toArray();
            $updatedData->concession_type_name = $connectionTypeName[0]['name'];
            if (isset($res)) {
                return response()->json(['status' => 200, 'data' => $updatedData, 'message' => "Concession details added successfully"]);
            } else {
                return response()->json(['status' => 400, 'message' => "Something went wrong"]);
            }
        } else {
            $requestData[] = [
                'visitor_id' => $request->new_visitor_id,
                'concession_type' => $request['concession_type'],
                'concession_code' => $request['concession_code'],
                'card_number' => $request['card_number'],
                'card_start_date' => $request['card_issue_date'],
                'card_expiry_date' => $request['card_expiry_date']
            ];
            $res = VisitorConcessionDetail::insert($requestData);
            if ($res) {
                $getVisitor = VisitorConcessionDetail::where('visitor_id', $request->new_visitor_id)->first();
                $connectionTypeName = ConnectionType::select('name')->where(['service_id'=>'1','local_id' => $getVisitor->concession_type])->get()->toArray();
                $getVisitor['concession_type_name'] = $connectionTypeName[0]['name'];
                if (isset($getVisitor)) {
                    $updated = Lead::where('lead_id', $request->new_lead)->update(['visitor_concession_details_id' => $getVisitor['id']]);
                    if ($updated) {
                        return response()->json(['status' => 200, 'data' => $getVisitor, 'message' => "Concession details added successfully"]);
                    } else {
                        return response()->json(['status' => 400, 'message' => "Something went wrong"]);
                    }
                }
            }
        }
    }

    public static function updateSiteAccessInfo($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['form', 'comment', 'lead_id']);
            $visitor_info_energy_id = $request->visitor_info_energy_id;
            $existingSiteAccessDetail = VisitorInformationEnergy::where('id', $visitor_info_energy_id)->first();
            if ($existingSiteAccessDetail) {
                $logsData = [
                    'visitor_info_energy_id' => $visitor_info_energy_id,
                    'meter_hazard' => $existingSiteAccessDetail->meter_hazard,
                    'dog_code' => $existingSiteAccessDetail->dog_code,
                    'site_access_electricity' => $existingSiteAccessDetail->site_access_electricity,
                    'site_access_gas' => $existingSiteAccessDetail->site_access_gas,
                    'comment' => $request->comment,
                    'changed_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => now(),
                ];
                $siteAccessLogs = DB::connection('sale_logs')->table('site_access_info_logs')->insert($logsData);
            }
            $siteAccessInfo = VisitorInformationEnergy::updateOrCreate(['id' => $visitor_info_energy_id], $data);
            if (!$existingSiteAccessDetail) {
                Lead::where('lead_id', $request->lead_id)->update([
                    'visitor_info_energy_id' => $siteAccessInfo->id,
                ]);
            }
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($siteAccessInfo) {
                DB::commit();
                $siteAccessData = VisitorInformationEnergy::where('id', $siteAccessInfo->id)->first();
                $response['siteAccessData'] = $siteAccessData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }

    public static function updateQaSectionInfo($request)
    {
        try {
            DB::beginTransaction();
            $query = '';
            $logsTable = '';
            $data = $request->except(['form', 'comment', 'vertical_id']);
            $lead_id = $request->lead_id;
            $vertical_id = $request->vertical_id;
            if ($vertical_id == 1) {
                $query = new SaleQaSectionEnergy();
                $logsTable = 'sale_qa_section_energy_logs';
            } elseif ($vertical_id == 2) {
                $query = new SaleQaSectionMobile();
                $logsTable = 'sale_qa_section_mobile_logs';
            } elseif ($vertical_id == 3) {
                $query = new SaleQaSectionBroadband();
                $logsTable = 'sale_qa_section_broadband_logs';
            }
            $existingQaSectionDetail = $query::where('lead_id', $lead_id)->first();
            if ($existingQaSectionDetail) {
                $logsData = [
                    'lead_id' => $lead_id,
                    'qa_comment' => $existingQaSectionDetail->qa_comment,
                    'sale_comment' => $existingQaSectionDetail->sale_comment,
                    'rework_comment' => $existingQaSectionDetail->rework_comment,
                    'assigned_agent' => $existingQaSectionDetail->assigned_agent,
                    'sale_completed_by' => $existingQaSectionDetail->sale_completed_by,
                    'comment' => $request->comment,
                    'changed_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => now(),
                ];
                $qaSectionLogs = DB::connection('sale_logs')->table($logsTable)->insert($logsData);
            }
            $qaSectionInfo = $query::updateOrCreate(['lead_id' => $lead_id], $data);
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($qaSectionInfo) {
                DB::commit();
                $qaSectionData = $query::where('id', $qaSectionInfo->id)->first();
                $response['qaSectionData'] = $qaSectionData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }

    public static function updatePrimaryIdentification($request)
    {
        $countryName = null;
        $user = auth()->user();
        $current_date_time = Carbon::now()->toDateTimeString();
        // dd($request['primaryLeadId']);
        $data = [
            'identification_type' => $request['primary_identification_type'],
            'licence_state_code' =>isset($request['primary_licence_state']) ? $request['primary_licence_state'] : null,
            'licence_number' => isset($request['primary_licence_number']) ? $request['primary_licence_number'] : null,
            'licence_expiry_date' => isset($request['primary_lice_id_exp_date']) ? dateTimeFormat($request['primary_lice_id_exp_date']) : null,
            'passport_number' => isset($request['primary_passport_number']) ? $request['primary_passport_number'] : null,
            'passport_expiry_date' => isset($request['primary_passport_exp_date']) ? dateTimeFormat($request['primary_passport_exp_date']) : null,
            'foreign_passport_number' => isset($request['primary_foreign_passport_number']) ? $request['primary_foreign_passport_number'] : null,
            'foreign_passport_expiry_date' => isset($request['primary_passport_exp_date']) ? dateTimeFormat($request['primary_passport_exp_date']) : null,
            'medicare_number' => isset($request['primary_medicare_number']) ? $request['primary_medicare_number'] : null,
            'card_color' => isset($request['primary_medicare_card_color']) ? $request['primary_medicare_card_color'] : null,
            'medicare_card_expiry_date' => isset($request['primary_medicare_card_expiry_date']) ? dateTimeFormat($request['primary_medicare_card_expiry_date']) : null,
            'foreign_country_name' => isset($request['primary_foreign_country_name']) ? $request['primary_foreign_country_name'] : null,
            'foreign_country_code' => isset($request['primary_foreign_country_code']) ? $request['primary_foreign_country_code'] : null,
            'card_middle_name' => isset($request['primary_medicare_card_middle_name']) ? $request['primary_medicare_card_middle_name'] : null,
            'reference_number' => isset($request['primary_medicare_ref_num']) ? $request['primary_medicare_ref_num'] : null,
            'identification_option' => 1,
            'updated_at' => $current_date_time

        ];
        if (!empty($request->primaryId)) {
            $oldVisitorPrimaryData = VisitorIdentification::select('lead_id', 'identification_type', 'licence_state_code', 'licence_number', 'licence_expiry_date', 'passport_number', 'passport_expiry_date', 'foreign_passport_number', 'foreign_passport_expiry_date', 'medicare_number', 'reference_number', 'card_color', 'medicare_card_expiry_date', 'foreign_country_name', 'foreign_country_code', 'card_middle_name', 'identification_option', 'identification_content')->where(['id' => $request->primaryId,'identification_option'=>1])->get()->toArray();
            if (!empty($oldVisitorPrimaryData)) {

                $oldVisitorPrimaryData[0]['lead_id'] = $request['primaryLeadId'];
                $oldVisitorPrimaryData[0]['comment'] = $request['primary_comment'];
                $oldVisitorPrimaryData[0]['changed_by'] = $user->id;
                $oldVisitorPrimaryData[0]['created_at'] =  $current_date_time;
                $res = DB::connection('sale_logs')->table('visitor_identifications_logs')->insert($oldVisitorPrimaryData);
                if ($res) {
                    $updateRes = VisitorIdentification::updateOrCreate(['id' => $request->primaryId], $data);
                    if (!empty($updateRes)) {
                        return response()->json(['status' => 200, 'data' => $updateRes, 'message' => "Primary identification data updated successfully",'verticalId'=>$request->verticalId]);
                    }
                }
            } else {
                return  response()->json(['status' => 400, 'message' => "Data does not exist"]);
            }
        } else {
            $data['identification_option'] = 1;
            $data['lead_id'] = $request->primaryLeadId;
            $data['created_at'] = $current_date_time;

            $res = VisitorIdentification::create($data)->toArray();

            if (!empty($res)) {
                $updatedRes = Lead::where(['lead_id' => $request->primaryLeadId])->update(['visitor_primary_identifications_id' => $res['id']]);
            }
            if ($res) {
                return response()->json(['status' => 200, 'data' => $res, 'message' => "Primary identification data added successfully",'verticalId'=>$request->verticalId]);
            } else {
                return  response()->json(['status' => 400, 'message' => "Something went wrong"]);
            }
        }
    }

    public static function updateSecondaryIdentification($request)
    {
        $countryName = null;
        $user = auth()->user();
        $current_date_time = Carbon::now()->toDateTimeString();
        // dd($request['primaryLeadId']);
        $data = [
            'identification_type' => $request['secondary_identification_type'],
            'licence_state_code' =>isset($request['secondary_licence_state']) ? $request['secondary_licence_state'] : null,
            'licence_number' => isset($request['secondary_licence_number']) ? $request['secondary_licence_number'] : null,
            'licence_expiry_date' => isset($request['secondary_lice_id_exp_date']) ? dateTimeFormat($request['secondary_lice_id_exp_date']) : null,
            'passport_number' => isset($request['secondary_passport_number']) ? $request['secondary_passport_number'] : null,
            'passport_expiry_date' => isset($request['secondary_passport_exp_date']) ? dateTimeFormat($request['secondary_passport_exp_date']) : null,
            'foreign_passport_number' => isset($request['secondary_foreign_passport_number']) ? $request['secondary_foreign_passport_number'] : null,
            'foreign_passport_expiry_date' => isset($request['secondary_passport_exp_date']) ? dateTimeFormat($request['secondary_passport_exp_date']) : null,
            'medicare_number' => isset($request['secondary_medicare_number']) ? $request['secondary_medicare_number'] : null,
            'card_color' => isset($request['secondary_medicare_card_color']) ? $request['secondary_medicare_card_color'] : null,
            'medicare_card_expiry_date' => isset($request['secondary_medicare_card_expiry_date']) ? dateTimeFormat($request['secondary_medicare_card_expiry_date']) : null,
            'foreign_country_name' => isset($request['secondary_foreign_country_name']) ? $request['secondary_foreign_country_name'] : null,
            'foreign_country_code' => isset($request['secondary_foreign_country_code']) ? $request['secondary_foreign_country_code'] : null,
            'card_middle_name' => isset($request['secondary_medicare_card_middle_name']) ? $request['secondary_medicare_card_middle_name'] : null,
            'reference_number' => isset($request['secondary_medicare_ref_num']) ? $request['secondary_medicare_ref_num'] : null,
            'identification_option' => 2,
            'updated_at' => $current_date_time

        ];
        if (!empty($request->secondaryId)) {
            $oldVisitorSecondaryData = VisitorIdentification::select('lead_id', 'identification_type', 'licence_state_code', 'licence_number', 'licence_expiry_date', 'passport_number', 'passport_expiry_date', 'foreign_passport_number', 'foreign_passport_expiry_date', 'medicare_number', 'reference_number', 'card_color', 'medicare_card_expiry_date', 'foreign_country_name', 'foreign_country_code', 'card_middle_name', 'identification_option', 'identification_content')->where(['id' => $request->secondaryId,'identification_option'=>2])->get()->toArray();
            if (!empty($oldVisitorSecondaryData)) {

                $oldVisitorSecondaryData[0]['lead_id'] = $request['secondaryLeadId'];
                $oldVisitorSecondaryData[0]['comment'] = $request['secondary_comment'];
                $oldVisitorSecondaryData[0]['changed_by'] = $user->id;
                $oldVisitorSecondaryData[0]['created_at'] =  $current_date_time;
                $res = DB::connection('sale_logs')->table('visitor_identifications_logs')->insert($oldVisitorSecondaryData);
                if ($res) {
                    $updateRes = VisitorIdentification::updateOrCreate(['id' => $request->secondaryId], $data);
                    if (!empty($updateRes)) {
                        return response()->json(['status' => 200, 'data' => $updateRes, 'message' => "Secondary identification data updated successfully",'verticalId'=>$request->verticalId]);
                    }
                }
            } else {
                return  response()->json(['status' => 400, 'message' => "Data does not exist"]);
            }
        } else {
            $data['identification_option'] = 2;
            $data['lead_id'] = $request->secondaryLeadId;
            $data['created_at'] = $current_date_time;

            $res = VisitorIdentification::create($data)->toArray();

            if (!empty($res)) {
                $updatedRes = Lead::where(['lead_id' => $request->secondaryLeadId])->update(['visitor_secondary_identifications_id' => $res['id']]);
            }
            if ($res) {
                return response()->json(['status' => 200, 'data' => $res, 'message' => "Secondary identification data added successfully",'verticalId'=>$request->verticalId]);
            } else {
                return  response()->json(['status' => 400, 'message' => "Something went wrong"]);
            }
        }
    }

    public static function updateOtherInfo($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['form', 'comment']);
            $lead_id = $request->lead_id;
            $existingOtherInfoDetail = SaleProductEnergyOtherInfo::where('id', $lead_id)->first();
            if ($existingOtherInfoDetail) {
                $logsData = [
                    'lead_id' => $lead_id,
                    'token' => $existingOtherInfoDetail->token,
                    'qa_notes' => $existingOtherInfoDetail->qa_notes,
                    'life_support_notes' => $existingOtherInfoDetail->life_support_notes,
                    'qa_notes_created_date' => $existingOtherInfoDetail->qa_notes_created_date,
                    'retailers_resubmission_comment' => $existingOtherInfoDetail->retailers_resubmission_comment,
                    'pin_number' => $existingOtherInfoDetail->pin_number,
                    'simply_reward_id' => $existingOtherInfoDetail->simply_reward_id,
                    'sale_agent' => $existingOtherInfoDetail->sale_agent,
                    'comment' => $request->comment,
                    'changed_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => now(),
                ];
                $otherInfoLogs = DB::connection('sale_logs')->table('sale_other_info_logs')->insert($logsData);
            }
            $otherInfo = SaleProductEnergyOtherInfo::updateOrCreate(['id' => $lead_id], $data);
            $response = ['status' => 200, 'message' => 'Data saved successfully.'];
            if ($otherInfo) {
                DB::commit();
                $otherInfoData = SaleProductEnergyOtherInfo::where('id', $otherInfo->id)->first();
                $response['otherInfoData'] = $otherInfoData;
                return response()->json($response, 200);
            }
            return response()->json(['status' => 400, 'message' => 'False'], 400);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }
    public static function jointAccountUpdate($request)
    {
        $user = auth()->user();
        $current_date_time = Carbon::now()->toDateTimeString();

        $data = [
            'is_connection_joint_account_holder' => $request->is_connection_joint_account_holder ?? '',
            'joint_acc_holder_title' => $request->joint_account_title ?? '',
            'joint_acc_holder_email' => $request->joint_account_email ?? '',
            'joint_acc_holder_first_name' => $request->joint_account_first_name ?? '',
            'joint_acc_holder_last_name' => $request->joint_account_last_name ?? '',
            'joint_acc_holder_phone_no' => $request->joint_account_phone ?? '',
            'joint_acc_holder_home_phone_no' => $request->joint_account_home_phone ?? '',
            'joint_acc_holder_office_phone_no' => $request->joint_account_office_phone ?? '',
            'joint_acc_holder_dob' => $request->joint_account_dob ?? '',
        ];
        if (isset($request->jointAccountId)) {
            $jointAccountData = VisitorInformationEnergy::select('joint_acc_holder_title', 'joint_acc_holder_first_name', 'joint_acc_holder_last_name', 'joint_acc_holder_email', 'joint_acc_holder_phone_no', 'joint_acc_holder_home_phone_no', 'joint_acc_holder_office_phone_no', 'joint_acc_holder_dob', 'is_connection_joint_account_holder')->where(['id' => $request->jointAccountId])->first()->toArray();
            $jointAccountData['created_at'] = $current_date_time;
            $jointAccountData['visitor_info_energy_id'] = $request->jointAccountId;
            $jointAccountData['updated_at'] = $current_date_time;
            $jointAccountData['changed_by'] = $user->id;
            $jointAccountData['comment'] = $request->joint_account_comment ? $request->joint_account_comment : '';
            if (isset($jointAccountData)) {
                DB::connection('sale_logs')->table('joint_account_info_logs')->insert($jointAccountData);
            }
            $res = VisitorInformationEnergy::where(['id' => $request->jointAccountId])->update($data);
            $updatedData = VisitorInformationEnergy::where(['id' => $request->jointAccountId])->get()->toArray();

            if (isset($res)) {
                return response()->json(['status' => 200, 'data' => $updatedData, 'message' => "Joint Account details updated successfully"]);
            } else {
                return response()->json(['status' => 400, 'message' => "Something went wrong"]);
            }
        } else {

            $res = VisitorInformationEnergy::create($data);
            if (!empty($res)) {
                if (isset($res)) {
                    $updated = Lead::where('lead_id', $request->lead_id)->update(['visitor_info_energy_id' => $res->id]);
                    if ($updated) {
                        return response()->json(['status' => 200, 'data' => $res, 'message' => "Joint account information added successfully"]);
                    } else {
                        return response()->json(['status' => 400, 'message' => "Something went wrong"]);
                    }
                }
            }
        }
    }
    public static function updateIdentificationDocument($request)
    {
        try {
            $user = auth()->user();
            $current_date_time = Carbon::now()->toDateTimeString();
            $visitorDocumentData = VisitorDocument::where('id', $request->visitorDocumentId)->select('id', 'lead_id', 'document_type', 'real_name', 'file_name')->get()->toArray();
            if ($request->has('document')) {
                $file = $request->document;
                $name = time() . $file->getClientOriginalName();
            }
            $updatedData = [
                'lead_id' => $request->leadId,
                'document_type' => $request->document_type,
                'file_name' => $name,
                'real_name' => $name,
            ];
            if ($request->has('document')) {
                $s3fileName =  $request->leadId;
                $s3fileName =  str_replace("<lead-id>", $s3fileName, config('env.IDENTIFICATION_DOCUMENT'));
                $s3fileName = config('env.DEV_FOLDER') . $s3fileName . $name;
                uploadFile($s3fileName, file_get_contents($file), 'public');
                $url = config('env.Public_BUCKET_ORIGIN') . $s3fileName;
                $updatedData['path'] = $url;
            }
            if (count($visitorDocumentData) > 0) {
                $visitorDocumentData[0]['visitor_document_id'] =  $visitorDocumentData[0]['id'];
                unset($visitorDocumentData[0]['id']);
                $visitorDocumentData[0]['comments'] = $request->comment;
                $visitorDocumentData[0]['changed_by'] = $user->id;
                $visitorDocumentData[0]['created_at'] = $current_date_time;
                DB::connection('sale_logs')->table('visitor_documents_logs')->insert($visitorDocumentData);
            }
                $result = VisitorDocument::create($updatedData);
                $updatedData  = VisitorDocument::where('id', $result->id)->get()->toArray();
                return response()->json(['status' => true, 'message' => 'Identifiaction document uploaded successfully', 'data' => $updatedData], 200);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 500);
        }
    }

    public static function getSaleUpdateHistory($id, $section, $verticalId){
        if($section == 'customer_info'){
            $customer_info = DB::connection('sale_logs')->table('customer_info_logs')->where('visitor_id',$id)->orderBy('created_at','desc')->get();
            foreach($customer_info as $customer){
                $user = User::where('id',$customer->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $customer->user_name = ucwords(decryptGdprData($user->first_name)).' '.ucwords(decryptGdprData($user->last_name));
                $customer->user_role = ucwords($userRole);
                $customer->created_at = dateTimeFormat($customer->created_at);
                $customer->first_name = ucwords(decryptGdprData($customer->first_name));
                $customer->middle_name = ucwords(decryptGdprData($customer->middle_name));
                $customer->last_name = ucwords(decryptGdprData($customer->last_name));
                $customer->email = decryptGdprData($customer->email);
                $customer->phone = decryptGdprData($customer->phone);
                $customer->alternate_phone = decryptGdprData($customer->alternate_phone);
            }
            return response()->json(['status' => true, 'customer_info' => $customer_info]);
        }

        elseif($section == 'manual_connection_address'){
            $manual_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->whereNotNull('manual_connection_details')->select('manual_connection_details','changed_by','comments','created_at')->orderBy('created_at','desc')->get();
            foreach($manual_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->created_at = dateTimeFormat($address->created_at);
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
            }
            return response()->json(['status' => true, 'manual_address' => $manual_address]);
        }
         elseif($section == 'connection_address'){
            $connection_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->whereNotNull('address')->orderBy('created_at','desc')->get();
            foreach($connection_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
                $address->created_at = dateTimeFormat($address->created_at);
                $state = States::where('state_id',$address->state)->first();
                $address->state = isset($state) ? $state->state_code : null;
                $unit_type = DB::table('master_employment_details')->where('id',$address->unit_type)->first();
                $address->unit_type = isset($unit_type) ? $unit_type->name : null;
                $street_code = DB::table('master_street_codes')->where('id',$address->street_code)->first();
                $address->street_code = isset($street_code) ? $street_code->value : null;
            }
            return response()->json(['status' => true, 'connection_address' => $connection_address]);
        }
        elseif($section == 'billing_address'){
            $billing_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->orderBy('created_at','desc')->get();
            foreach($billing_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
                $address->created_at = dateTimeFormat($address->created_at);
                $state = States::where('state_id',$address->state)->first();
                $address->state = isset($state) ? $state->state_code : null;
                $unit_type = DB::table('master_employment_details')->where('id',$address->unit_type)->first();
                $address->unit_type = isset($unit_type) ? $unit_type->name : null;
                $street_code = DB::table('master_street_codes')->where('id',$address->street_code)->first();
                $address->street_code = isset($street_code) ? $street_code->value : null;
            }
            return response()->json(['status' => true, 'billing_address' => $billing_address]);
        }
        elseif($section == 'delivery_address'){
            $delivery_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->orderBy('created_at','desc')->get();
            foreach($delivery_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
                $address->created_at = dateTimeFormat($address->created_at);
                $state = States::where('state_id',$address->state)->first();
                $address->state = isset($state) ? $state->state_code : null;
                $unit_type = DB::table('master_employment_details')->where('id',$address->unit_type)->first();
                $address->unit_type = isset($unit_type) ? $unit_type->name : null;
                $street_code = DB::table('master_street_codes')->where('id',$address->street_code)->first();
                $address->street_code = isset($street_code) ? $street_code->value : null;
            }
            return response()->json(['status' => true, 'delivery_address' => $delivery_address]);
        }
        elseif($section == 'gas_address'){
            $gas_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->orderBy('created_at','desc')->get();
            foreach($gas_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
                $address->created_at = dateTimeFormat($address->created_at);
                $state = States::where('state_id',$address->state)->first();
                $address->state = isset($state) ? $state->state_code : null;
                $unit_type = DB::table('master_employment_details')->where('id',$address->unit_type)->first();
                $address->unit_type = isset($unit_type) ? $unit_type->name : null;
                $street_code = DB::table('master_street_codes')->where('id',$address->street_code)->first();
                $address->street_code = isset($street_code) ? $street_code->value : null;
            }
            return response()->json(['status' => true, 'gas_address' => $gas_address]);
        }
         elseif($section == 'pobox_address'){
            $pobox_address = DB::connection('sale_logs')->table('visitor_addresses_logs')->where('visitor_address_id',$id)->orderBy('created_at','desc')->get();
            foreach($pobox_address as $address){
                $user = User::where('id',$address->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $address->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $address->user_role = ucwords($userRole);
                $address->created_at = dateTimeFormat($address->created_at);
                $state = States::where('state_id',$address->state)->first();
                $address->state = isset($state) ? $state->state_code : null;
            }
            return response()->json(['status' => true, 'pobox_address' => $pobox_address]);
        }
         elseif($section == 'qa_section'){
           if($verticalId == 1){
             $qa_sectionData = DB::connection('sale_logs')->table('sale_qa_section_energy_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
           }
           elseif($verticalId == 2){
            $qa_sectionData = DB::connection('sale_logs')->table('sale_qa_section_mobile_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
           }
           else{
            $qa_sectionData = DB::connection('sale_logs')->table('sale_qa_section_broadband_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
           }
            foreach($qa_sectionData as $qa_section){
                $user = User::where('id',$qa_section->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $qa_section->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $qa_section->user_role = ucwords($userRole);
                $qa_section->created_at = dateTimeFormat($qa_section->created_at);
            }
            return response()->json(['status' => true, 'qa_section' => $qa_sectionData]);
        }
         elseif($section == 'concession_detail'){
            $concessionDetails = DB::connection('sale_logs')->table('visitor_concession_details_logs')->where('visitor_id',$id)->orderBy('created_at','desc')->get();
            foreach($concessionDetails as $concessionDetail){
                $user = User::where('id',$concessionDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $concessionDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $concessionDetail->user_role = ucwords($userRole);
                $concessionDetail->created_at = dateTimeFormat($concessionDetail->created_at);
                $connectionTypeName = ConnectionType::select('name')->where(['service_id'=>1,'local_id' => $concessionDetail->concession_type])->first();
                $concessionDetail->concession_type = $connectionTypeName->name;
            }
            return response()->json(['status' => true, 'concession_detail' => $concessionDetails]);
        }
         elseif($section == 'identification_detail'){
           $countryName = null;
            $identificationDetails = DB::connection('sale_logs')->table('visitor_identifications_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
            foreach($identificationDetails as $identificationDetail){
                $user = User::where('id',$identificationDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $identificationDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $identificationDetail->user_role = ucwords($userRole);
                $identificationDetail->created_at = dateTimeFormat($identificationDetail->created_at);
            }
            return response()->json(['status' => true, 'identification_detail' => $identificationDetails]);
        }
        elseif($section == 'other_info'){
            $otherInfoDetails = DB::connection('sale_logs')->table('sale_other_info_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
            foreach($otherInfoDetails as $otherInfoDetail){
                $user = User::where('id',$otherInfoDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $otherInfoDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $otherInfoDetail->user_role = ucwords($userRole);
                $otherInfoDetail->created_at = dateTimeFormat($otherInfoDetail->created_at);
            }
            return response()->json(['status' => true, 'other_info' => $otherInfoDetails]);
        }
        elseif($section == 'site_access'){
            $siteAccessDetails = DB::connection('sale_logs')->table('site_access_info_logs')->where('visitor_info_energy_id',$id)->orderBy('created_at','desc')->get();
            foreach($siteAccessDetails as $siteAccessDetail){
                $user = User::where('id',$siteAccessDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $siteAccessDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $siteAccessDetail->user_role = ucwords($userRole);
                $siteAccessDetail->created_at = dateTimeFormat($siteAccessDetail->created_at);
            }
            return response()->json(['status' => true, 'site_access' => $siteAccessDetails]);
        }
        elseif($section == 'joint_account'){
            $jointAccountDetails = DB::connection('sale_logs')->table('joint_account_info_logs')->where('visitor_info_energy_id',$id)->orderBy('created_at','desc')->get();
            foreach($jointAccountDetails as $jointAccountDetail){
                $user = User::where('id',$jointAccountDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $jointAccountDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $jointAccountDetail->user_role = ucwords($userRole);
                $jointAccountDetail->created_at = dateTimeFormat($jointAccountDetail->created_at);
            }
            return response()->json(['status' => true, 'joint_account' => $jointAccountDetails]);
        }
        elseif($section == 'nmi_number'){
            $nmiNumberDetails = DB::connection('sale_logs')->table('visitor_informations_energy_logs')->where('visitor_info_energy_id',$id)->orderBy('created_at','desc')->get();
            foreach($nmiNumberDetails as $nmiNumberDetail){
                $user = User::where('id',$nmiNumberDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $nmiNumberDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $nmiNumberDetail->user_role = ucwords($userRole);
                $nmiNumberDetail->created_at = dateTimeFormat($nmiNumberDetail->created_at);
            }
            return response()->json(['status' => true, 'nmi_number' => $nmiNumberDetails]);
        }
        elseif($section == 'demand_details'){
            $demandDetails = DB::connection('sale_logs')->table('energy_bill_details_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
            foreach($demandDetails as $demandDetail){
                $user = User::where('id',$demandDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $demandDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $demandDetail->user_role = ucwords($userRole);
                $demandDetail->created_at = dateTimeFormat($demandDetail->created_at);
                $tariffCode = MasterTariffCode::where('id',$demandDetail->demand_tariff_code)->select('tariff_code')->first();
                $demandDetail->demand_tariff_code = $tariffCode->tariff_code;
            }
            return response()->json(['status' => true, 'demand_details' => $demandDetails]);
        }
        elseif($section == 'customer_note'){
            $customerNoteDetails = DB::connection('sale_logs')->table('customer_note_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
            foreach($customerNoteDetails as $customerNoteDetail){
                $user = User::where('id',$customerNoteDetail->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $customerNoteDetail->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $customerNoteDetail->user_role = ucwords($userRole);
                $customerNoteDetail->created_at = dateTimeFormat($customerNoteDetail->created_at);
            }
            return response()->json(['status' => true, 'customer_note' => $customerNoteDetails]);
        }
        elseif($section == 'journey'){
            $elecProvider = $gasProvider = $gasDistributor = $elecDistributor = null;
            $journeyData = DB::connection('sale_logs')->table('journey_logs')->where('lead_id',$id)->orderBy('created_at','desc')->get();
            foreach($journeyData as $data){
                $user = User::where('id',$data->changed_by)->select('id','first_name','last_name')->first();
                $userRole = $user->getRoleNames()[0];
                $data->user_name = decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name);
                $data->user_role = ucwords($userRole);
                $data->created_at = dateTimeFormat($data->created_at);
                if(isset($data->gas_provider_id)){
                    $gasProvider = Providers::where('id',$data->gas_provider_id)->select('legal_name')->first();
                    $gasProvider = $gasProvider ? $gasProvider->legal_name : null;
                }
                if(isset($data->electricity_provider_id)){
                    $elecProvider = Providers::where('id',$data->electricity_provider_id)->select('legal_name')->first();
                    $elecProvider = $elecProvider ? $elecProvider->legal_name : null;
                }
                if(isset($data->gas_distributor_id)){
                    $gasDistributor = Distributor::where('id',$data->gas_distributor_id)->select('name')->first();
                    $gasDistributor = $gasDistributor ? $gasDistributor->name : null;
                }
                if(isset($data->electricity_distributor_id)){
                    $elecDistributor = Distributor::where('id',$data->electricity_distributor_id)->select('name')->first();
                    $elecDistributor = $elecDistributor ? $elecDistributor->name : null;
                }
                $data->gas_provider_name = $gasProvider;
                $data->gas_distributor_name = $gasDistributor;
                $data->electricity_provider_name = $elecProvider;
                $data->electricity_distributor_name = $elecDistributor;
            }
            return response()->json(['status' => true, 'journey' => $journeyData]);
        }
    }
}
