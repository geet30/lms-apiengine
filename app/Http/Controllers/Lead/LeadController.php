<?php

namespace App\Http\Controllers\Lead;
use File;
use Zip;
use App\Http\Controllers\Controller;
use App\Models\{Providers, Affiliate, SaleAssignedEnergyQa, SaleAssignedBroadbandQa, SaleAssignedMobileQa, SaleStatusHistoryBroadband, User, Status, SaleStatusHistoryEnergy, SaleStatusHistoryMobile, SaleProductsEnergy, SaleProductsMobile, SaleProductsBroadband, StatusHierarchy, Lead, AffiliateKeys, ConnectionType, Contract, CostType, MasterTariffCode, ProviderLogo, SaleQaSectionBroadband, SaleQaSectionEnergy, SaleQaSectionMobile,States,SaleProductEnergyOtherInfo, Settings,Visitor, PlanEnergy,AffiliateTemplate, SmsLog, EmailTemplate,AssignUser,SalesQaLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Sales\{CustomerNoteRequest,ConcessionDetailRequest,saleEditRequest,CustomerInfoRequest,DemandDetailRequest,NmiNumberRequest,SiteAccessInfoRequest,SalesQaSectionRequest,SaleOtherInfoRequest,jointAccountInfoRequest,IdentificationDetailsRequest,EmailFromLeadsRequest};
use Illuminate\Support\Facades\Session;
use App\Repositories\SparkPost\NodeMailer;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Sales\LeadsSmsRequest;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return Lead::getListing($request);
    }
    public function updateCustomerNote(CustomerNoteRequest $request){
        $response= Lead::updateCustomerNote($request);
        return $response;
    }
    public function detail($verticalId, $leadId)
    {
        $saleType = explode('.', \Request::route()->getName())[0];
        $appPermissions = getAppPermissions();
        $user = auth()->user();
        $userRole = $user->role ?? '';
        if(in_array($userRole,[2,3,8,9]))
        {
            $userPermissions = getServiceBasedPermissions($verticalId);
        }
        else
        {
            $userPermissions = getUserPermissions();
        }
        $permissionList = [
                            'visits' => 'show_visits',
                            'leads' => 'show_leads',
                            'sales' => 'show_sales'
                            ];
        $checkPermissions = isset($permissionList[$saleType])? $permissionList[$saleType]:'';
        if(!checkPermission($checkPermissions,$userPermissions,$appPermissions))
        {
            Session::flash('error', trans('auth.permission_error'));
            return redirect('/');
        }
        return Lead::getLeadDetail($verticalId, $leadId,$saleType,$userPermissions,$appPermissions);
    }



    public function getQaList()
    {
        $qas = User::users(4);
        return response()->json(['qas' => $qas]);
    }

    public function getAssignedQaList(Request $request)
    {
		$userPermissions = getUserPermissions(); 
        $appPermissions = getAppPermissions();
		$affiliateIds = [];
		$saleCreatedDts = [];
		foreach ($request->lead_id as $key => $value) {
			if(!in_array($request->sales[$value['id']]['affiliateId'],$affiliateIds))
				$affiliateIds[] = $request->sales[$value['id']]['affiliateId'];
			$saleCreatedDts[] = $request->sales[$value['id']]['saleCreatedDt'];
		}
        $qas = User::users(4,$affiliateIds);
		$assigned = AssignUser::whereIn('relational_user_id',$affiliateIds)->where('relation_type',2)->whereHas('affiliateQas')->with('affiliateQas.userSetting')->get();
		
		$affQas = [];
		foreach ($assigned as $single) {
			$affQas[$single['relational_user_id']][] = $single->affiliateQas;
		}


		$saleQas = [];
		foreach ($request->sales as $key => $value) {
			// $saleQas[$key] = isset($affQas[$value['affiliateId']]) ? $affQas[$value['affiliateId']] : [];
			$saleDate = $value['saleCreatedDt'];
			if(isset($affQas[$value['affiliateId']])){
				foreach ($affQas[$value['affiliateId']] as $qa) {
					if($qa->userSetting){
					   $dateFrom = $saleDate;
					   $dateTo = now();
					   if($qa->userSetting['date_range_from']){
						   $qaDateFrom = explode('/',$qa->userSetting['date_range_from']);
						   $dateFrom = $qaDateFrom[2].'-'.$qaDateFrom[1].'-'.$qaDateFrom[0].' 00:00:00';
					   }
					   if(!$qa->userSetting['date_range_checkbox']){
						   $qaDateTo = explode('/',$qa->userSetting['date_range_to']);
						   $dateTo = $qaDateTo[2].'-'.$qaDateTo[1].'-'.$qaDateTo[0].' 00:00:00';
					   }
					   if($saleDate > $dateFrom && $saleDate < $dateTo){
						   $saleQas[$key][] = $qa;
					   }
					}else{
					   $saleQas[$key][] = $qa;
					}
					   
			   }
			}
			
		}

        $saleProduct = new SaleProductsEnergy;
        if ($request->serviceId == 2) {
            $saleProduct = new SaleProductsMobile;
        } elseif ($request->serviceId == 3) {
            $saleProduct = new SaleProductsBroadband;
        }
		
        $data = $saleProduct->with(['getAssignedQa' => function ($query) {
            $query->select('id', 'lead_id', 'user_id','type');
        }])->select('lead_id')->whereIn('lead_id', array_column($request->lead_id, 'id'))->get()->toArray();

		$saleAssinedQas = [];
		foreach ($data as $key => $value) {
			$saleAssinedQas[$value['lead_id']] = $value['get_assigned_qa'];
		}

        return response()->json(['qas' => $qas, 'assigned'=>$assigned, 'saleAssinedQas'=>$saleAssinedQas,'saleQas'=>$saleQas,'assigned_qas' => $data,'userPermissions' => $userPermissions,'appPermissions' => $appPermissions]);
    }

    public function assignQa(Request $request)
    {
        try {
            $authUser = auth()->user();
            $dataToInsert = [];
            $leadIds = [];

            $assignedUsers = DB::table('lead_assigned_users')->select('lead_id', 'assigned_user', 'type')->whereIn('lead_id', $leadIds)->get()->toArray();

            $assignedQas =  array_filter($assignedUsers, function ($qa) {
                return $qa->type == 1;
            });
            $assignedCollaborators =  array_filter($assignedUsers, function ($qa) {
                return $qa->type == 2;
            });

            return response()->json(['assignedQas' => $assignedQas, 'assignedCollaborators' => $assignedCollaborators]);

            return response()->json(['message' => 'QA assigned successfully']);
        } catch (\Throwable $th) {
            return response()->json(['exception' => $th->getMessage() . $th->getLine()]);
        }
    }


    public function assginQaTOsale(Request $request)
    {
        try {
            switch ($request->verticalId) {
                case '1':
                    return  SaleAssignedEnergyQa::assginQaTOsale($request);
                    break;
                case '2':
                    return SaleAssignedMobileQa::assginQaTOsale($request);
                    break;
                case '3':
                    return SaleAssignedBroadbandQa::assginQaTOsale($request);
                    break;
            }
            return response()->json(['message' => "Failed to assign QA/collaborator"], 400);
        } catch (\Exception $e) {

            $result = [
                'exception_message_front' => $e->getMessage(),
                'exception_message_line' => $e->getLine(),
                'success' => 'false'
            ];
            return response()->json($result, 400);
        }
    }

    public function getSubStatus(Request $request)
    {
        try {
            return StatusHierarchy::where('status_id', $request->status)->where('type', 2)->with('getStatus')->get();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Whoops! Unable to fetch sub status.', 'exception' => $th->getMessage() . $th->getLine()], 500);
        }
    }
    public function changeStatus(Request $request)
    {
        try {
            switch ($request->service_id) {
                case '1':
                    return SaleProductsEnergy::updateStats($request);
                    break;
                case '2':
                    return SaleProductsMobile::updateStats($request);
                    break;
                case '3':
                    return SaleProductsBroadband::updateStats($request);
                    break;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAffiliateData(Request $request)
    {
        try {
            $affiliates = Affiliate::where('status', 1);
            if ($request->type != "sub-affiliate") {
                $affiliates =  $affiliates->where('parent_id', 0);
            } else {
                $affiliateId = Affiliate::where('user_id', $request->affiliate_id)->value('id');
                $subAffiliateId = Affiliate::select('id', 'user_id', 'company_name')->where('parent_id', $affiliateId)->get()->toArray();
                $subAffiliateId = array_column($subAffiliateId, 'user_id');
                $affiliates =  $affiliates->whereIn('user_id', $subAffiliateId);
            }
            $affiliates =  $affiliates->select('user_id', 'legal_name', 'company_name')->get()->toArray();
            return response()->json(['data' => $affiliates, 200]);
        } catch (\Exception $e) {
            $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    public function changeAffiliate(Request $request)
    {
        try {
            $response = Lead::changeAffiliate($request);
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            $result = [
                'message' => $e->getMessage()
            ];
            return response()->json($result, 400);
        }
    }

    public function getAffiliateByService(Request $request)
    {
        $response = Lead::getAffiliateByService($request);
        return response()->json($response,200);
    }

    public function getSubAffiliateList(Request $request)
    {
        $response = Lead::getSubAffiliateList($request);
        return response()->json($response,200);
    }
	public function getGenerateCsv(Request $request)
	{
		try {
			$active = 'sales';
			$type = ['visits' => 0, 'leads' => 1, 'sales' => 2];
        	$info = auth()->user()->info;
			$user = auth()->user();
			$userRole = auth()->user()->role ?? '';
			$statuses = Status::pluck('title', 'id')->toArray();
            $data = Lead::getFilteredListing($request,$type,$info,$statuses,$userRole,$user);
			$leads = $data['leads'];
			$role = '';
			$orderBy = 'ASC';
			$affiliate = '';
			$subaffiliates = '';
			$order = $this->csv_header_data($request->selected_data);
			$table = [];
			$csv_select = $request->selected_data;
			$i = 1;
			$exportType = isset($request->saleType) ? $request->saleType : 'sales';
			$leadfilename = $exportType . \Carbon::now()->timestamp;	
			$directory_arr = []; 
			$directory_arr['leads'] = $exportType; //year
			$directory_arr['year'] = \Carbon::now()->format('Y'); //year
			$directory_arr['month'] = \Carbon::now()->format('m'); //month
			$directory_arr['date'] = \Carbon::now()->format('d'); //date
			$temp_dir_string = realpath(base_path() . "/") . '/uploads/reports';
			foreach ($directory_arr as $key => $value) {
				$temp_dir_string = $temp_dir_string . '/' . $value;
				// check if file exists or not
				if (!file_exists($temp_dir_string)) {
					mkdir($temp_dir_string, 0777, true); //create directory
				}
			} 
			$temp_name = realpath(base_path() . "/") . '/uploads/reports/'. $exportType . '/' . $directory_arr['year'] . '/' . $directory_arr['month'] . '/' . $directory_arr['date'] . '/';
			$filename = $temp_name . $leadfilename . '.csv';
			$temp_path = realpath(base_path() . "/") . '/reports/'. $exportType . '/' . $directory_arr['year'] . '/' . $directory_arr['month'] . '/' . $directory_arr['date'] . '/';
			$s3bukcetpath = $temp_path . $leadfilename . '.csv';
			$handle = fopen($filename, 'w');
			fputcsv($handle, $order); 
			$sale_data = Lead::where('leads.lead_id', '!=', '');
			/*Custom filter code for export process starts--Same as filters*/ 
			$page = 0;
			if (isset($type[$request->page])) {
				$page = $request->page - 1; 
			 }
			$filterData = Lead::filter($request);   
			//dd($filterData);
			$filterAssigned = 0;
			if (isset($type[$request->saleType]))
			{
				$sale_data = $sale_data->where('status', '=', $type[$request->saleType]);
			}
			if($request->verticalId == 1)
			{
				$getCustomerJourney = 'getCustomerJourneyEnergy';
			}
			else if($request->verticalId == 2)
			{
				$getCustomerJourney = 'getCustomerJourneyMobile';
			}	
			/*Custom filter code for export process ends--Same as filters*/ 
			$sale_data = $sale_data->whereHas(
				'getAffsubAddInfo' , function ($q) use($filterData) {
					if (isset($filterData['affiliateId']))
					{  
						$q->where('user_id', '=', $filterData['affiliateId']); 
					}
				})->whereHas(
				'getVisitors' , function ($q) use($filterData) {
					if (isset($filterData['first_name']))
					{ 
						$q->where('first_name', '=', encryptGdprData($filterData['first_name']));
					}
					if (isset($filterData['last_name']))
					{ 
						$q->where('last_name', '=', encryptGdprData($filterData['last_name']));
					}
					if (isset($filterData['email']))
					{ 
						$q->where('email', '=', encryptGdprData($filterData['email']));
					}
					if (isset($filterData['phone']))
					{ 
						$q->where('phone', '=', encryptGdprData($filterData['phone']));
					}
				})->whereHas(
				$getCustomerJourney , function ($q) use($filterData,$request) {
						if (isset($filterData['providerId']))
						{
							if($filterAssigned == 0) { $q->where('provider_id', '=', $filterData['providerId']); }
						}	
						if (isset($filterData['propertyType']) && $filterData['verticalId'] == 1)
						{ 
							$q->where('property_type', '=', $filterData['propertyType']);
						}
						if (isset($filterData['productType']) && $filterData['verticalId'] == 1)
						{ 
							$q->where('energy_type', '=', $filterData['productType']);
						}
						if (isset($filterData['connectionType']) && in_array($filterData['verticalId'],[2,3]))
						{ 
							$q->where('connection_type', '=', $filterData['connectionType']);
						}
						if (isset($filterData['planType']) && $filterData['verticalId'] == 2)
						{ 
							$q->where('plan_type', '=', $filterData['planType']);
						} 
						if (isset($filterData['referenceNo']))
						{ 
							$q->where('reference_no', '=', $filterData['referenceNo']);
						} 
						if (isset($filterData['moveIn']))
						{ 
							$q->where('moving_at', '=', $filterData['moveIn']);
						}
						if (isset($filterData['moveInDate']))
						{   
							$q->whereBetween('is_moving', [$filterData['fromMovinDate'], $filterData['toMovinDate']]);
						}
						if (isset($filterData['fromCreatedAt']) && isset($filterData['toCreatedAt']))
						{ 
							$q->whereBetween('created_at', [$filterData['fromCreatedAt'], $filterData['toCreatedAt']]);
						}
						if (isset($filterData['fromCreatedAt']) && isset($filterData['toCreatedAt']))
						{ 
							$q->whereBetween('sale_created_at', [$filterData['fromCreatedAt'], $filterData['toCreatedAt']]);
						}
				})->with(['getVisitors' => function ($q) use($filterData){
					$q->select('id', 'title', 'first_name', 'middle_name', 'last_name', 'email', 'dob', 'phone_status', 'alternate_phone', 'phone', 'domain');
				},
				'getVisitorEmploymentDetails' => function ($q){
					$q->select('lead_id', 'occupation', 'occupation_started_month', 'user_have_cc', 'employment_type', 'occupation_type', 'occupation_industry', 'occupation_status', 'occupation_started_yr');
				},
				'getUtmParameters' => function ($q) {
					$q->select('lead_id', 'customer_user_id', 'cui', 'rc', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_rm', 'utm_rm_source', 'utm_rm_date', 'utm_content', 'gclid', 'fbclid', 'msclkid');
				},
				'getConcessionInfo' => function ($q) {
					$q->select('visitor_id', 'energy_concession', 'concession_type', 'concession_code', 'card_start_date', 'card_expiry_date', 'card_number');
				},
				'getAffsubAddInfo' => function ($q) use($filterData) {
					$q->select('id', 'user_id', 'parent_id', 'company_name', 'sub_affiliate_type', 'referal_code', 'support_phone_number');	 
				},
				'getCustomerJourneyEnergy' => function ($q) use($filterData,$request){
					if($request->verticalId == 1)
					{
						$q->select('id', 'lead_id', 'service_id', 'product_type', 'provider_id', 'plan_id', 'cost_type', 'cost', 'reference_no', 'is_moving', 'moving_at', 'connection_address_id', 'sale_created_at', 'sale_status', 'sale_sub_status');
					}	
				},
				'getCustomerJourneyEnergy.providers' => function ($q) use($request) {
					if($request->verticalId == 1)
					{
						$q->select('id', 'user_id', 'name');
					}	
				},
				'getCustomerJourneyEnergy.services' => function ($q) use($request) {
					if($request->verticalId == 1)
					{
						$q->select('id', 'service_title');
					}	
				},
				'getCustomerJourneyMobile' => function ($q) use($filterData,$request){
					if($request->verticalId == 2)
					{
						$q->select('id', 'lead_id', 'service_id', 'product_type', 'provider_id', 'plan_id', 'handset_id', 'variant_id', 'contract_id', 'color_id', 'own_or_lease', 'cost_type', 'cost', 'reference_no', 'is_moving', 'moving_at', 'sale_created_at', 'sale_status', 'sale_sub_status', 'is_duplicate');
					}	
				},
				'getCustomerJourneyMobile.provider' => function ($q) use($filterData,$request){
					if($request->verticalId == 2)
					{
						$q->select('id', 'user_id', 'name', 'legal_name');
					}	
				},
				'getCustomerJourneyMobile.planinfo' => function ($q) use($request){
					if($request->verticalId == 2)
					{
						$q->select('id', 'provider_id', 'name', 'connection_type', 'plan_type', 'sim_type', 'host_type', 'business_size', 'bdm_available', 'bdm_contact_number', 'bdm_details', 'cost_type_id', 'cost', 'plan_data', 'plan_data_unit', 'network_type', 'contract_id', 'activation_date_time', 'deactivation_date_time', 'billing_preference', 'details', 'new_connection_allowed', 'port_allowed', 'retention_allowed', 'amazing_extra_facilities', 'national_voice_calls', 'national_video_calls', 'national_text', 'national_mms', 'national_directory_assist', 'national_diversion', 'national_call_forwarding', 'national_voicemail_deposits', 'national_toll_free_numbers', 'national_internet_data', 'national_special_features', 'national_additonal_info', 'international_voice_calls', 'international_video_calls', 'international_text', 'international_mms', 'international_diversion', 'international_additonal_info', 'roaming_charge', 'roaming_voice_incoming', 'roaming_voice_outgoing', 'roaming_video_calls', 'roaming_text', 'roaming_mms', 'roaming_voicemail_deposits', 'roaming_internet_data', 'roaming_additonal_info', 'cancellation_fee', 'lease_phone_return_fee', 'activation_fee', 'late_payment_fee', 'delivery_fee', 'express_delivery_fee', 'paper_invoice_fee', 'payment_processing_fee', 'card_payment_fee', 'minimum_total_cost', 'other_fee_charges', 'remarketing_allow', 'status');
					}	
				},	
				'getCustomerJourneyMobile.planinfo.getconnectiontypes' => function ($q) use($request) {
					if($request->verticalId == 2)
					{
						$q->select('id', 'name');
					}	
				},		
				'getNmiMirnNumbers' => function ($q) {
					$q->select('visitor_id', 'nmi_number', 'dpi_mirn_number', 'electricity_network_code', 'gas_network_code');
				},
				'getIdentificationDetails' => function ($q) {
					$q->select('id', 'lead_id', 'identification_type', 'licence_state_code', 'licence_number', 'licence_expiry_date', 'passport_number', 'passport_expiry_date', 'foreign_passport_number', 'foreign_passport_expiry_date', 'medicare_number', 'reference_number', 'card_color', 'medicare_card_expiry_date', 'foreign_country_name', 'foreign_country_code', 'card_middle_name', 'identification_option', 'identification_content',);
				},
				'getConnAndBillDetails' => function ($q) use($filterData){
					$q->select('id', 'visitor_id', 'address', 'address_type', 'lot_number', 'unit_number', 'unit_type', 'unit_type_code', 'floor_number', 'floor_level_type', 'floor_type_code', 'street_number', 'street_number_suffix', 'street_name', 'street_suffix', 'street_code', 'house_number', 'house_number_suffix', 'suburb', 'state', 'postcode', 'property_name', 'residential_status', 'living_year', 'living_month', 'gnf_no', 'deleted_at', 'created_at', 'updated_at', 'manual_connection_details', 'connection_details');
				},
				'getBrowserInfo' => function ($q) {
					$q->select('lead_id', 'browser', 'platform', 'device', 'user_agent', 'screen_resolution', 'ip_address', 'latitude', 'longitude');
				},
				'getLeadJourneyDataEnergy' => function ($q) {
					$q->select( 'lead_id', 'distributor_id', 'previous_provider_id', 'current_provider_id', 'bill_available', 'is_dual', 'plan_bundle_code', 'property_type', 'energy_type', 'solar_panel', 'solar_options', 'life_support', 'life_support_energy_type', 'life_support_value', 'moving_house', 'moving_date', 'prefered_move_in_time', 'elec_concession_rebate_ans', 'elec_concession_rebate_amount', 'gas_concession_rebate_ans', 'gas_concession_rebate_amount', 'screen_name', 'credit_score', 'filters', 'step_name', 'percentage');
				},
				'getLeadJourneyDataMobile' => function ($q) {
					$q->select( 'lead_id', 'connection_type', 'plan_type', 'current_provider', 'plan_cost_min', 'plan_cost_max', 'data_usage_min', 'sim_type', 'contract', 'created_at', 'updated_at', 'percentage');
				},
				])->select('leads.lead_id', 'leads.visitor_id', 'leads.affiliate_id', 'leads.sub_affiliate_id', 'leads.post_code', 'leads.address', 'leads.sale_source', 'leads.is_duplicate', 'leads.sale_comment', 'leads.connection_address_id', 'leads.billing_preference', 'leads.email_welcome_pack', 'leads.delivery_preference', 'leads.billing_address_id', 'leads.delivery_date', 'leads.is_po_box', 'leads.billing_po_box_id', 'leads.note', 'leads.status', 'leads.sale_created', 'leads.created_at')->get();
					$sale_data_array = $sale_data->toArray();
					//dd($sale_data_array);
					if (isset($data['verticalId'])) {  } else {$data['verticalId'] = 1;}
					if (count($sale_data_array)>0) {
						//checking the status of csv data and adding accordingly
						foreach ($sale_data_array as $lead) {
							$table[$i]['sale_date'] = isset($lead['created_at']) ? date('d,M Y H:i a', strtotime($lead['created_at'])) : 'N/A';
							$table[$i]['lead_id'] = isset($lead['lead_id']) ? $lead['lead_id'] : 'N/A';
							$table[$i]['reference_number'] = isset($lead['get_products'][0]['reference_no']) ? $lead['get_products'][0]['reference_no'] : 'N/A';
							$status = 'Pending';
							if (isset($lead['get_products'][0]['sale_status'])) 
							{
								$sale_status = $lead['get_products'][0]['sale_status'];

								switch ($sale_status) {
								case "0":
									$status = 'Pending';
									break;
								case "1":
									$status = 'Pending';
									break;
								case "2":
									$status = 'Pending';
									break;
								case "3":
									$status = 'Cancelled';
									break;
								case "4":
									$status = 'Submitted';
									break;
								case "5":
									$status = 'Retailer Rejected';
									break;
								case "6":
									$status = 'Accepted';
									break;
								case "7":
									$status = 'Recon Sale';
									break;
								case "8":
									$status = 'Paid';
									break;
								case "9":
									$status = 'In Question';
									break;
								case "12":
									$status = 'Resubmit';																
								default:
									$status = 'Pending';
								}
							}	
							//Sale status check if exists
							$table[$i]['sale_status'] = $status;
							$substatus = 'Pending';
							if (isset($lead['get_products'][0]['sale_status'])) 
							{
								$sale_sub_status = $lead['get_products'][0]['sale_sub_status'];

								switch ($sale_sub_status) {
								case "0":
									$substatus = 'Pending';
									break;
								case "1":
									$substatus = 'Pending';
									break;
								case "2":
									$substatus = 'Pending';
									break;
								case "3":
									$substatus = 'Cancel';
									break;
								case "4":
									$substatus = 'Submit';
									break;
								case "5":
									$substatus = 'Retailer Rejected';
									break;
								case "6":
									$substatus = 'Accepted';
									break;
								case "7":
									$substatus = 'Recon Sale';
									break;
								case "8":
									$substatus = 'Paid';
									break;
								case "9":
									$substatus = 'In  Question';
									break;
								case "12":
									$substatus = 'Resubmit';																
								default:
									$substatus = 'Pending';
								}
							}	
							$table[$i]['sale_sub_status'] = $substatus;
							$table[$i]['sale_source'] = 'N/A';
							if (isset($csv_select['Sale sub status'])) {
							$sale_source = 'N/A';
							if (!is_null($lead['sale_source'])) 
							{
								if($lead['sale_source'] == 1)
								{
									$sale_source = 'Email';
								}
								else 
								{
									$sale_source = 'SMS';
								}	
							}
							$table[$i]['sale_source'] = $sale_source;
						}	
						$table[$i]['sale_completed_by'] = 'N/A';
						$table[$i]['electricity_duplicate_lead'] = 'N/A';
						$table[$i]['gas_duplicate_lead'] = 'N/A';
						$table[$i]['is_unique'] = isset($lead['is_duplicate']) ? $lead['is_duplicate'] : 'N/A';
						if($lead['is_duplicate'] == 1)
						{
							$table[$i]['is_unique'] = 'No';
						}
						$table[$i]['sale_submission_date_time'] = date('d,M Y H:i a', strtotime($lead['sale_created']));
						$table[$i]['lead_create_date'] = date('d,M Y H:i a', strtotime($lead['sale_created']));
						$table[$i]['sale_created_date'] = date('d,M Y H:i a', strtotime($lead['sale_created']));
					//Customer information
						$table[$i]['customer_title'] = isset($lead['get_visitors'][0]['title']) ? $lead['get_visitors'][0]['title'] : 'N/A';
						$table[$i]['customer_first_name'] = isset($lead['get_visitors'][0]['first_name']) ? decryptGdprData($lead['get_visitors'][0]['first_name']) : 'N/A';
						$table[$i]['customer_last_name'] = isset($lead['get_visitors'][0]['last_name']) ? decryptGdprData($lead['get_visitors'][0]['last_name']) : 'N/A';
						$table[$i]['customer_email'] =  isset($lead['get_visitors'][0]['email']) ? decryptGdprData($lead['get_visitors'][0]['email']) : 'N/A';
						$table[$i]['customer_phone'] = isset($lead['get_visitors'][0]['phone']) ? decryptGdprData($lead['get_visitors'][0]['phone']) : 'N/A';
						$table[$i]['customer_dob'] = isset($lead['get_visitors'][0]['dob']) ? $lead['get_visitors'][0]['dob'] : 'N/A';
						$table[$i]['user_browser_information'] = isset($lead['get_browser_info'][0]['browser']) ? $lead['get_browser_info'][0]['browser'] : 'N/A';
						$table[$i]['platform'] = isset($lead['get_browser_info'][0]['platform']) ? $lead['get_browser_info'][0]['platform'] : 'N/A';
						$table[$i]['device'] = isset($lead['get_browser_info'][0]['platform']) ? $lead['get_browser_info'][0]['platform'] : 'N/A';
						$table[$i]['browser'] = isset($lead['get_browser_info'][0]['browser']) ? $lead['get_browser_info'][0]['browser'] : 'N/A';
						$table[$i]['user_browser_version'] = isset($lead['get_browser_info'][0]['user_agent']) ? $lead['get_browser_info'][0]['user_agent'] : 'N/A';
						$table[$i]['sale_ip'] = isset($lead['get_browser_info'][0]['ip_address']) ? $lead['get_browser_info'][0]['ip_address'] : 'N/A';
						$table[$i]['lead_ip'] = isset($lead['get_browser_info'][0]['ip_address']) ? $lead['get_browser_info'][0]['ip_address'] : 'N/A';
						$table[$i]['latitude'] = isset($lead['get_browser_info'][0]['latitude']) ? $lead['get_browser_info'][0]['latitude'] : 'N/A';
						$table[$i]['longitude'] = isset($lead['get_browser_info'][0]['longitude']) ? $lead['get_browser_info'][0]['longitude'] : 'N/A';
						$table[$i]['state'] = isset($lead['get_conn_and_bill_details'][0]['state']) ? $lead['get_conn_and_bill_details'][0]['state'] : 'N/A';
						$table[$i]['suburb'] = isset($lead['get_conn_and_bill_details'][0]['suburb']) ? $lead['get_conn_and_bill_details'][0]['suburb'] : 'N/A';
					//UTM Parameters Information
						$table[$i]['rc'] = isset($lead['get_utm_parameters'][0]['rc']) ? $lead['get_utm_parameters'][0]['rc'] : 'N/A';
						$table[$i]['cui'] = isset($lead['get_utm_parameters'][0]['cui']) ? $lead['get_utm_parameters'][0]['cui'] : 'N/A';
						$table[$i]['utm_source'] = isset($lead['get_utm_parameters'][0]['utm_source']) ? $lead['get_utm_parameters'][0]['utm_source'] : 'N/A';
						$table[$i]['utm_medium'] = isset($lead['get_utm_parameters'][0]['utm_medium']) ? $lead['get_utm_parameters'][0]['utm_medium'] : 'N/A';
						$table[$i]['utm_campaign'] = isset($lead['get_utm_parameters'][0]['utm_campaign']) ? $lead['get_utm_parameters'][0]['utm_campaign'] : 'N/A';
						$table[$i]['utm_term'] = isset($lead['get_utm_parameters'][0]['utm_term']) ? $lead['get_utm_parameters'][0]['utm_term'] : 'N/A';
						$table[$i]['utm_content'] = isset($lead['get_utm_parameters'][0]['utm_content']) ? $lead['get_utm_parameters'][0]['utm_content'] : 'N/A';
						$table[$i]['gclid'] = isset($lead['get_utm_parameters'][0]['gclid']) ? $lead['get_utm_parameters'][0]['gclid'] : 'N/A';
						$table[$i]['fbclid'] = isset($lead['get_utm_parameters'][0]['fbclid']) ? $lead['get_utm_parameters'][0]['fbclid'] : 'N/A';
						$table[$i]['utm_rm'] = isset($lead['get_utm_parameters'][0]['utm_rm']) ? $lead['get_utm_parameters'][0]['utm_rm'] : 'N/A';
						$table[$i]['utm_rm_source'] = isset($lead['get_utm_parameters'][0]['utm_rm_source']) ? $lead['get_utm_parameters'][0]['utm_rm_source'] : 'N/A';
						$table[$i]['utm_rm_date'] = isset($lead['get_utm_parameters'][0]['utm_rm_date']) ? $lead['get_utm_parameters'][0]['utm_rm_date'] : 'N/A';
						$table[$i]['customer_user_id'] = isset($lead['get_utm_parameters'][0]['customer_user_id']) ? $lead['get_utm_parameters'][0]['customer_user_id'] : 'N/A';
					//Concession Information
						$table[$i]['concession_type'] = isset($lead['get_concession_info'][0]['concession_card_type']) ? $lead['get_concession_info'][0]['concession_card_type'] : 'N/A';
						$table[$i]['concession_code'] = isset($lead['get_concession_info'][0]['concession_code']) ? $lead['get_concession_info'][0]['concession_code'] : 'N/A';
						$table[$i]['card_number'] = isset($lead['get_concession_info'][0]['card_number']) ? $lead['get_concession_info'][0]['card_number'] : 'N/A';
						$table[$i]['card_start_date'] = isset($lead['get_concession_info'][0]['card_start_date']) ? $lead['get_concession_info'][0]['card_start_date'] : 'N/A';
						$table[$i]['card_expiry_date'] = isset($lead['get_concession_info'][0]['card_expiry_date']) ? $lead['get_concession_info'][0]['card_expiry_date'] : 'N/A';
					//affiliate Information 
						if(count($lead['get_affsub_add_info']) > 0)
						{
							if((isset($lead['get_affsub_add_info'][0]['sub_affiliate_type']) == 1) && $lead['get_affsub_add_info'][0]['sub_affiliate_type'] == 1)
							{
								$table[$i]['affiliate_name'] = isset($lead['get_affsub_add_info'][0]['parent_id']) ? $lead['get_affsub_add_info'][0]['parent_id'] : 'N/A';
								$table[$i]['sub_affiliate_name'] = isset($lead['get_affsub_add_info'][0]['company_name']) ? $lead['get_affsub_add_info'][0]['company_name'] : 'N/A';
								$table[$i]['affiliate_phone'] = isset($lead['get_affsub_add_info'][0]['support_phone_number']) ? $lead['get_affsub_add_info'][0]['support_phone_number'] : 'N/A';
								
							}
							else
							{
								$table[$i]['affiliate_name'] = isset($lead['get_affsub_add_info'][0]['company_name']) ? $lead['get_affsub_add_info'][0]['company_name'] : 'N/A';
								$table[$i]['sub_affiliate_name'] = 'N/A';
								$table[$i]['affiliate_phone'] = isset($lead['get_affsub_add_info'][0]['support_phone_number']) ? $lead['get_affsub_add_info'][0]['support_phone_number'] : 'N/A';
							}
							$table[$i]['affiliate_comment'] = isset($lead['sale_comment']) ? $lead['sale_comment'] : 'N/A';
							$table[$i]['other_services'] = isset($lead['other_services']) ? $lead['other_services'] : 'N/A';
							$table[$i]['referal_code'] = isset($lead['get_affsub_add_info'[0]]['referal_code']) ? $lead['get_affsub_add_info'][0]['referal_code'] : 'N/A';
						}
						if($request->verticalId == 1)
						{
							//Customer Journey Information Energy
							$table[$i]['energy_provider_name'] = isset($lead['get_customer_journey_energy'][0]['provider_id']) ? $lead['get_customer_journey_energy'][0]['provider_id'] : 'N/A';
							$table[$i]['energy_plan_name'] = isset($lead['get_customer_journey_energy'][0]['service_id']) ? $lead['get_customer_journey_energy'][0]['service_id'] : 'N/A';
							$table[$i]['energy_plan_product_code'] = isset($lead['get_customer_journey_energy'][0]['service_id']) ? $lead['get_customer_journey_energy'][0]['service_id'] : 'N/A';
							$table[$i]['energy_distributor'] = isset($lead['get_customer_journey_energy'][0]['energy_distributor']) ? $lead['get_customer_journey_energy'][0]['energy_distributor'] : 'N/A';
							$table[$i]['energy_price_fact_sheet_url'] = isset($lead['get_customer_journey_energy'][0]['energy_price_fact_sheet_url']) ? $lead['get_customer_journey_energy'][0]['energy_price_fact_sheet_url'] : 'N/A';
							$table[$i]['resale_type'] = isset($lead['get_customer_journey_energy'][0]['resale_type']) ? $lead['get_customer_journey_energy'][0]['resale_type'] : 'N/A';
							
							//Lead journey_data_energy
							$table[$i]['credit_score'] = isset($lead['get_lead_journey_data_energy'][0]['credit_score']) ? $lead['get_lead_journey_data_energy'][0]['credit_score'] : 'N/A';
							$table[$i]['percentage'] = isset($lead['get_lead_journey_data_energy'][0]['percentage']) ? $lead['get_lead_journey_data_energy'][0]['percentage'] : 'N/A';	
							$table[$i]['step_name'] = isset($lead['get_lead_journey_data_energy'][0]['step_name']) ? $lead['get_lead_journey_data_energy'][0]['step_name'] : 'N/A';
							$table[$i]['property_type'] = isset($lead['get_lead_journey_data_energy'][0]['property_type']) ? $lead['get_lead_journey_data_energy'][0]['property_type'] : 'N/A';
							$table[$i]['energy_type'] = isset($lead['get_customer_journey_energy'][0]['service_id']) ? $lead['get_customer_journey_energy'][0]['service_id'] : 'N/A';
							$table[$i]['life_support'] = isset($lead['get_lead_journey_data_energy'][0]['life_support']) ? $lead['get_lead_journey_data_energy'][0]['life_support'] : 'N/A';
							$table[$i]['life_support_equipment'] = isset($lead['get_lead_journey_data_energy'][0]['life_support_equipment']) ? $lead['get_lead_journey_data_energy'][0]['life_support_equipment'] : 'N/A';
							$table[$i]['life_support_energy_type'] = isset($lead['get_lead_journey_data_energy'][0]['life_support_energy_type']) ? $lead['get_lead_journey_data_energy'][0]['life_support_energy_type'] : 'N/A';
							$table[$i]['solar'] = isset($lead['get_lead_journey_data_energy'][0]['solar_panel']) ? $lead['get_lead_journey_data_energy'][0]['solar_panel'] : 'N/A';
							$table[$i]['solar_options'] = isset($lead['get_lead_journey_data_energy'][0]['solar_options']) ? $lead['get_lead_journey_data_energy'][0]['solar_options'] : 'N/A';
							$table[$i]['move_in'] = isset($lead['get_lead_journey_data_energy'][0]['moving_house']) ? $lead['get_lead_journey_data_energy'][0]['moving_house'] : 'N/A';
							$table[$i]['move_in_date'] = isset($lead['get_lead_journey_data_energy'][0]['moving_date']) ? $lead['get_lead_journey_data_energy'][0]['moving_date'] : 'N/A';
							$table[$i]['current_retailer'] = isset($lead['get_lead_journey_data_energy'][0]['current_retailer']) ? $lead['get_lead_journey_data_energy'][0]['current_retailer'] : 'N/A';
							$table[$i]['current_provider'] = isset($lead['get_lead_journey_data_energy'][0]['name']) ? $lead['get_lead_journey_data_energy'][0]['name'] : 'N/A';
							$table[$i]['service_title'] = isset($lead['get_lead_journey_data_energy']['services'][0]['service_title']) ? $lead['get_lead_journey_data_energy']['services'][0]['service_title'] : 'N/A';								
							$table[$i]['electricity_bill_handy'] = isset($lead['get_lead_journey_data_energy'][0]['elec_concession_rebate_ans']) ? $lead['get_lead_journey_data_energy'][0]['elec_concession_rebate_ans'] : 'N/A';
							$table[$i]['gas_bill_handy'] = isset($lead['get_lead_journey_data_energy'][0]['name']) ? $lead['get_lead_journey_data_energy'][0]['gas_concession_rebate_ans'] : 'N/A';
						}
						else if($request->verticalId == 2)
						{	
							//Customer Journey Information Mobile
							$table[$i]['mobile_plan_name'] = isset($lead['get_customer_journey_mobile'][0]['planinfo']['name']) ? $lead['get_customer_journey_mobile'][0]['planinfo']['name'] : 'N/A';
							$table[$i]['connection_type'] = isset($lead['get_customer_journey_mobile'][0]['planinfo']['getconnectiontypes']['Connection Type']) ? $lead['get_customer_journey_mobile'][0]['planinfo']['getconnectiontypes']['Connection Type'] : 'N/A';
							$table[$i]['total_plan_cost'] = isset($lead['get_customer_journey_mobile'][0]['planinfo']['cost']) ? $lead['get_customer_journey_mobile'][0]['planinfo']['cost'] : 'N/A';
							$table[$i]['provider'] = isset($lead['get_customer_journey_mobile'][0]['provider']['legal_name']) ? decryptGdprData($lead['get_customer_journey_mobile'][0]['provider']['legal_name']) : 'N/A';
							
							
							
							$table[$i]['energy_plan_product_code'] = isset($lead['get_customer_journey_mobile'][0]['service_id']) ? $lead['get_customer_journey_mobile'][0]['service_id'] : 'N/A';
							$table[$i]['energy_distributor'] = isset($lead['get_customer_journey_mobile'][0]['energy_distributor']) ? $lead['get_customer_journey_mobile'][0]['energy_distributor'] : 'N/A';
							$table[$i]['energy_price_fact_sheet_url'] = isset($lead['get_customer_journey_mobile'][0]['energy_price_fact_sheet_url']) ? $lead['get_customer_journey'][0]['energy_price_fact_sheet_url'] : 'N/A';
							$table[$i]['resale_type'] = isset($lead['get_customer_journey_mobile'][0]['resale_type']) ? $lead['get_customer_journey_mobile'][0]['resale_type'] : 'N/A';

							$table[$i]['credit_score'] = isset($lead['get_lead_journey_data_energy'][0]['credit_score']) ? $lead['get_lead_journey_data_energy'][0]['credit_score'] : 'N/A';
							$table[$i]['percentage'] = isset($lead['get_lead_journey_data_energy'][0]['percentage']) ? $lead['get_lead_journey_data_energy'][0]['percentage'] : 'N/A';	
							$table[$i]['step_name'] = isset($lead['get_lead_journey_data_energy'][0]['step_name']) ? $lead['get_lead_journey_data_energy'][0]['step_name'] : 'N/A';
							$table[$i]['property_type'] = isset($lead['get_lead_journey_data_energy'][0]['property_type']) ? $lead['get_lead_journey_data_energy'][0]['property_type'] : 'N/A';
							$table[$i]['energy_type'] = isset($lead['get_customer_journey_energy'][0]['service_id']) ? $lead['get_customer_journey_energy'][0]['service_id'] : 'N/A';
							$table[$i]['life_support'] = isset($lead['get_lead_journey_data_energy'][0]['life_support']) ? $lead['get_lead_journey_data_energy'][0]['life_support'] : 'N/A';
							$table[$i]['life_support_equipment'] = isset($lead['get_lead_journey_data_energy'][0]['life_support_equipment']) ? $lead['get_lead_journey_data_energy'][0]['life_support_equipment'] : 'N/A';
							$table[$i]['life_support_energy_type'] = isset($lead['get_lead_journey_data_energy'][0]['life_support_energy_type']) ? $lead['get_lead_journey_data_energy'][0]['life_support_energy_type'] : 'N/A';
							$table[$i]['solar'] = isset($lead['get_lead_journey_data_energy'][0]['solar_panel']) ? $lead['get_lead_journey_data_energy'][0]['solar_panel'] : 'N/A';
							$table[$i]['solar_options'] = isset($lead['get_lead_journey_data_energy'][0]['solar_options']) ? $lead['get_lead_journey_data_energy'][0]['solar_options'] : 'N/A';
							$table[$i]['move_in'] = isset($lead['get_lead_journey_data_energy'][0]['moving_house']) ? $lead['get_lead_journey_data_energy'][0]['moving_house'] : 'N/A';
							$table[$i]['move_in_date'] = isset($lead['get_lead_journey_data_energy'][0]['moving_date']) ? $lead['get_lead_journey_data_energy'][0]['moving_date'] : 'N/A';
							$table[$i]['current_retailer'] = isset($lead['get_lead_journey_data_energy'][0]['current_retailer']) ? $lead['get_lead_journey_data_energy'][0]['current_retailer'] : 'N/A';
							$table[$i]['current_provider'] = isset($lead['get_lead_journey_data_energy'][0]['name']) ? $lead['get_lead_journey_data_energy'][0]['name'] : 'N/A';
							$table[$i]['service_title'] = 'Mobile';								
							$table[$i]['electricity_bill_handy'] = isset($lead['get_lead_journey_data_energy'][0]['elec_concession_rebate_ans']) ? $lead['get_lead_journey_data_energy'][0]['elec_concession_rebate_ans'] : 'N/A';
							$table[$i]['gas_bill_handy'] = isset($lead['get_lead_journey_data_energy'][0]['name']) ? $lead['get_lead_journey_data_energy'][0]['gas_concession_rebate_ans'] : 'N/A';
						}	
						// Get Employement details
						$table[$i]['employer_name'] = isset($lead['get_visitor_employment_details'][0]['occupation_employer_name']) ? $lead['get_visitor_employment_details'][0]['occupation_employer_name'] : 'N/A';
						$table[$i]['occupation'] = isset($lead['get_visitor_employment_details'][0]['occupation']) ? $lead['get_visitor_employment_details'][0]['occupation'] : 'N/A';
						$table[$i]['employment_duration'] = isset($lead['get_visitor_employment_details'][0]['occupation_started_month']) ? $lead['get_visitor_employment_details'][0]['occupation_started_month'] : 'N/A';
						$table[$i]['have_credit_card'] = isset($lead['get_visitor_employment_details'][0]['user_have_cc']) ? $lead['get_visitor_employment_details'][0]['user_have_cc'] : 'N/A';
						$table[$i]['occupation_type'] = isset($lead['get_visitor_employment_details'][0]['occupation_type']) ? $lead['get_visitor_employment_details'][0]['occupation_type'] : 'N/A';
						$table[$i]['industry'] = isset($lead['get_visitor_employment_details'][0]['occupation_industry']) ? $lead['get_visitor_employment_details'][0]['occupation_industry'] : 'N/A';
						$table[$i]['employment_status'] = isset($lead['get_visitor_employment_details'][0]['occupation_status']) ? $lead['get_visitor_employment_details'][0]['occupation_status'] : 'N/A';
						//NMI/MIRN Numbers Information
							switch ($data['verticalId']) {
								case "1": // if Vertical is Energy
									$table[$i]['nmi_mirn_numbers'] = isset($lead['get_nmi_mirn_numbers'][0]['nmi_number']) ? $lead['get_nmi_mirn_numbers'][0]['nmi_number'] : 'N/A';
									$table[$i]['site_network_code'] = isset($lead['get_nmi_mirn_numbers'][0]['electricity_network_code']) ? $lead['get_nmi_mirn_numbers'][0]['electricity_network_code'] : 'N/A';
									break;
								case "2": // if Vertical is Gas
									$table[$i]['nmi_mirn_numbers'] = isset($lead['get_nmi_mirn_numbers'][0]['dpi_mirn_number']) ? $lead['get_nmi_mirn_numbers'][0]['dpi_mirn_number'] : 'N/A';
									$table[$i]['site_network_code'] = isset($lead['get_nmi_mirn_numbers'][0]['gas_network_code']) ? $lead['get_nmi_mirn_numbers'][0]['gas_network_code'] : 'N/A';
									break;
							}
						//Identification Details Information
							$table[$i]['identification_option'] = isset($lead['get_identification_details'][0]['identification_option']) ? $lead['get_identification_details'][0]['identification_option'] : 'N/A';
							$table[$i]['identification_type'] = isset($lead['get_identification_details'][0]['identification_type']) ? $lead['get_identification_details'][0]['identification_type'] : 'N/A';
							$table[$i]['primary_identification_type'] ='N/A'; 
							$table[$i]['primary_identification_number'] = 'N/A';
							$table[$i]['primary_identification_expiry'] = 'N/A';
							$table[$i]['primary_medicare_individual_reference_number'] = 'N/A';
							$table[$i]['primary_medicare_middle_name_on_card'] = 'N/A';
							$table[$i]['primary_medicare_card_color'] = 'N/A';
							$table[$i]['primary_license_state_code'] = 'N/A';
							$table[$i]['secondary_identification_type'] ='N/A'; 
							$table[$i]['secondary_identification_number'] = 'N/A';
							$table[$i]['secondary_identification_expiry'] = 'N/A';
							$table[$i]['secondary_medicare_individual_reference_number'] = 'N/A';
							$table[$i]['secondary_medicare_middle_name_on_card'] = 'N/A';
							$table[$i]['secondary_medicare_card_color'] = 'N/A';
							$table[$i]['secondary_license_state_code'] = 'N/A';

							/*Getting primary and secondary details*/ 
							if($table[$i]['identification_option'] == 1) //Primary details
							{
								switch ($table[$i]['identification_type']) {
									case "Passport":
										$table[$i]['primary_identification_number'] = isset($lead['get_identification_details'][0]['passport_number']) ? $lead['get_identification_details'][0]['passport_number'] : 'N/A';
										$table[$i]['primary_identification_expiry'] = isset($lead['get_identification_details'][0]['passport_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';

										break;
									case "Drivers Licence":
										$table[$i]['primary_identification_number'] = isset($lead['get_identification_details'][0]['licence_number']) ? $lead['get_identification_details'][0]['licence_number'] : 'N/A';
										$table[$i]['primary_identification_expiry'] = isset($lead['get_identification_details'][0]['licence_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';
										break;
									case "Foreign Passport":
										$table[$i]['primary_identification_number'] = isset($lead['get_identification_details'][0]['foreign_passport_number']) ? $lead['get_identification_details'][0]['foreign_passport_number'] : 'N/A';
										$table[$i]['primary_identification_expiry'] = isset($lead['get_identification_details'][0]['foreign_passport_expiry_date']) ? $lead['get_identification_details'][0]['foreign_passport_expiry_date'] : 'N/A';
										break;															
									default:
									$table[$i]['primary_identification_type'] = isset($lead['get_identification_details'][0]['identification_type']) ? $lead['get_identification_details'][0]['identification_type'] : 'N/A';
									$table[$i]['primary_identification_number'] = isset($lead['get_identification_details'][0]['licence_number']) ? $lead['get_identification_details'][0]['licence_number'] : 'N/A';
									$table[$i]['primary_identification_expiry'] = isset($lead['get_identification_details'][0]['passport_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';
									}
								$table[$i]['primary_medicare_individual_reference_number'] = isset($lead['get_identification_details'][0]['medicare_number']) ? $lead['get_identification_details'][0]['medicare_number'] : 'N/A';
								$table[$i]['primary_medicare_middle_name_on_card'] = isset($lead['get_identification_details'][0]['card_middle_name']) ? $lead['get_identification_details'][0]['card_middle_name'] : 'N/A';
								$table[$i]['primary_medicare_card_color'] = isset($lead['get_identification_details'][0]['card_color']) ? $lead['get_identification_details'][0]['card_color'] : 'N/A';
								$table[$i]['primary_license_state_code'] = isset($lead['get_identification_details'][0]['foreign_country_code']) ? $lead['get_identification_details'][0]['foreign_country_code'] : 'N/A';
							}
							else if($table[$i]['identification_option'] == 2) //Secondary details
							{
								switch ($table[$i]['identification_type']) {
									case "Passport":
										$table[$i]['secondary_identification_number'] = isset($lead['get_identification_details'][0]['passport_number']) ? $lead['get_identification_details'][0]['passport_number'] : 'N/A';
										$table[$i]['secondary_identification_expiry'] = isset($lead['get_identification_details'][0]['passport_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';

										break;
									case "Drivers Licence":
										$table[$i]['secondary_identification_number'] = isset($lead['get_identification_details'][0]['licence_number']) ? $lead['get_identification_details'][0]['licence_number'] : 'N/A';
										$table[$i]['secondary_identification_expiry'] = isset($lead['get_identification_details'][0]['licence_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';
										break;
									case "Foreign Passport":
										$table[$i]['secondary_identification_number'] = isset($lead['get_identification_details'][0]['foreign_passport_number']) ? $lead['get_identification_details'][0]['foreign_passport_number'] : 'N/A';
										$table[$i]['secondary_identification_expiry'] = isset($lead['get_identification_details'][0]['foreign_passport_expiry_date']) ? $lead['get_identification_details'][0]['foreign_passport_expiry_date'] : 'N/A';
										break;															
									default:
									$table[$i]['secondary_identification_number'] = isset($lead['get_identification_details'][0]['licence_number']) ? $lead['get_identification_details'][0]['licence_number'] : 'N/A';
									$table[$i]['secondary_identification_expiry'] = isset($lead['get_identification_details'][0]['passport_expiry_date']) ? $lead['get_identification_details'][0]['licence_expiry_date'] : 'N/A';
									}
								$table[$i]['secondary_identification_type'] = isset($lead['get_identification_details'][0]['identification_type']) ? $lead['get_identification_details'][0]['identification_type'] : 'N/A';
								$table[$i]['secondary_medicare_individual_reference_number'] = isset($lead['get_identification_details'][0]['medicare_number']) ? $lead['get_identification_details'][0]['medicare_number'] : 'N/A';
								$table[$i]['secondary_medicare_middle_name_on_card'] = isset($lead['get_identification_details'][0]['card_middle_name']) ? $lead['get_identification_details'][0]['card_middle_name'] : 'N/A';
								$table[$i]['secondary_medicare_card_color'] = isset($lead['get_identification_details'][0]['card_color']) ? $lead['get_identification_details'][0]['card_color'] : 'N/A';
								$table[$i]['secondary_license_state_code'] = isset($lead['get_identification_details'][0]['foreign_country_code']) ? $lead['get_identification_details'][0]['foreign_country_code'] : 'N/A';
							}

						//Connection And Billing Address Information
							
							$table[$i]['billing_preferences'] = 'N/A';
							$table[$i]['other_billing_address'] = 'N/A';
							$table[$i]['billing_address'] = 'N/A';
							$table[$i]['billing_address_suburb'] = 'N/A';
							$table[$i]['billing_address_state_code'] = 'N/A';
							$table[$i]['billing_address_post_code'] = 'N/A';
							$table[$i]['manual_connection_address'] = 'N/A';
							$table[$i]['connection_address_state_code'] = 'N/A';
							$table[$i]['connection_address_postcode'] = 'N/A';
							$table[$i]['connection_address'] = 'N/A';
							$table[$i]['connection_address_suburb'] = 'N/A';
							$table[$i]['complete_address'] =  isset($lead['get_conn_and_bill_details']['address']) ? $lead['get_conn_and_bill_details']['address'] : 'N/A';
							foreach($lead['get_conn_and_bill_details'] as $get_conn_and_bill_details)
							{
								//Residential Address
								if($get_conn_and_bill_details['address_type'] == 1)
								{
									$table[$i]['connection_address'] =  isset($get_conn_and_bill_details['address']) ? $get_conn_and_bill_details['address'] : 'N/A';
									$table[$i]['connection_address_suburb'] = isset($get_conn_and_bill_details['suburb']) ? $get_conn_and_bill_details['suburb'] : 'N/A';
									$table[$i]['manual_connection_address'] = isset($get_conn_and_bill_details['manual_connection_details']) ? $get_conn_and_bill_details['manual_connection_details'] : 'N/A';
									$table[$i]['connection_address_state_code'] = isset($get_conn_and_bill_details['state']) ? $get_conn_and_bill_details['state'] : 'N/A';
									$table[$i]['connection_address_postcode'] = isset($get_conn_and_bill_details['postcode']) ? $get_conn_and_bill_details['postcode'] : 'N/A';
								}
								//Previous Address
								if($get_conn_and_bill_details['address_type'] == 2)
								{
								}
								//Business Address
								if($get_conn_and_bill_details['address_type'] == 3)
								{									
								}								
								//Billing Address
								if($get_conn_and_bill_details['address_type'] == 4)
								{
									$table[$i]['billing_preferences'] = isset($get_conn_and_bill_details['address']) ? $get_conn_and_bill_details['address'] : 'N/A';
									$table[$i]['other_billing_address'] = isset($get_conn_and_bill_details['manual_connection_details']) ? $get_conn_and_bill_details['manual_connection_details'] : 'N/A';
									$table[$i]['billing_address'] = isset($get_conn_and_bill_details['address']) ? $get_conn_and_bill_details['address'] : 'N/A';
									$table[$i]['billing_address_suburb'] = isset($get_conn_and_bill_details['suburb']) ? $get_conn_and_bill_details['suburb'] : 'N/A';
									$table[$i]['billing_address_state_code'] = isset($get_conn_and_bill_details['state']) ? $get_conn_and_bill_details['state'] : 'N/A';
									$table[$i]['billing_address_post_code'] = isset($get_conn_and_bill_details['postcode']) ? $get_conn_and_bill_details['postcode'] : 'N/A';
								}

							}	

						//QA Section Information
							$table[$i]['qa_comment'] = isset($lead['get_conn_and_bill_details'][0]['address']) ? $lead['get_conn_and_bill_details'][0]['address'] : 'N/A';
							$table[$i]['rework_comment'] = isset($lead['get_conn_and_bill_details'][0]['identification_type']) ? $lead['get_conn_and_bill_details'][0]['identification_type'] : 'N/A';	
							$table[$i]['assigned_agent'] = isset($lead['get_conn_and_bill_details'][0]['identification_type']) ? $lead['get_conn_and_bill_details'][0]['identification_type'] : 'N/A';
							$table[$i]['email_unsubscribe_status'] = 'N/A';	
							$table[$i]['sms_unsubscribe_status'] = 'N/A';		
							$table[$i]['email_unsubscribe_date'] = 'N/A';	
							$table[$i]['sms_unsubscribe_date'] = 'N/A';
							$table[$i]['post_code'] = isset($lead['postcode']) ? $lead['postcode'] : 'N/A';	
							$table[$i]['po_box_full_address'] = isset($lead['is_po_box']) ? $lead['is_po_box'] : 'N/A';
						
							//dd($request->selected_data);	
							$csv_row_data = $this->csv_row_data($table[$i], $request->selected_data);
							fputcsv($handle, $csv_row_data);
							$i++;
						}
					}
			fclose($handle);
			$authUser = auth()->user();
			if($request->saleType == 'sales')
			{
				$export_password_type = "sale_export_password";
				$export_path = config('env.SALE_EXPORT_PATH');
			}
			else
			{
				$export_password_type = "lead_export_password";
				$export_path = config('env.LEAD_EXPORT_PATH');
			}
			if(($authUser->role == 2) || ($authUser->role == 3)) // Incase of affiliate/subaffiliate user.
			{
				$sale_password_array = Affiliate::select('id','lead_export_password','sale_export_password')->where('user_id',$authUser->id)->get()->toArray();
				if(count($sale_password_array) > 0)
				{
					$export_password = decryptGdprData($sale_password_array[0][$export_password_type]);
				}
				else // Default user role.
				{
					$export_password = Settings::where('key', '=', $export_password_type)->value('value');
				}
			}
			else // Default user role.
			{
				$export_password = Settings::where('key', '=', $export_password_type)->value('value');
			}
			$returnStatus = false;
			$fileLink = [];
			if ($export_password) {
				$real_path = realpath(base_path() . "/../");
				$zip_path = str_replace('csv', 'zip', $filename);
				exec('zip -P ' . $export_password . '  -j ' . $zip_path . ' ' . $filename);
				$s3Folder = str_replace("<year>", $directory_arr['year'], $export_path);
				$s3Folder = str_replace("<month>", $directory_arr['month'], $s3Folder);
				$s3Folder = str_replace("<day>", $directory_arr['date'], $s3Folder);
				$name = $leadfilename . '.zip';
				$s3fileName = config('env.DEV_FOLDER') . $s3Folder . $name;
				uploadFile($s3fileName, file_get_contents($zip_path), 'public');
				$returnStatus = true;
				$fileLink = $s3fileName;
				$path = $zip_path;
			} else {
				$s3Folder = str_replace("<year>", $directory_arr['year'], $export_path);
				$s3Folder = str_replace("<month>", $directory_arr['month'], $s3Folder);
				$s3Folder = str_replace("<day>", $directory_arr['date'], $s3Folder);
				$name = $leadfilename . '.csv';
				$s3fileName = config('env.DEV_FOLDER') . $s3Folder . $name;
				uploadFile($s3fileName, file_get_contents($filename), 'public');
				$returnStatus = true;
				$fileLink = $s3fileName;
				$path = $filename;
			}		
			if ($returnStatus) {
					if (file_exists($filename)) { 
						unlink($filename);
						//rmdir($temp_dir_string);
					}
					if (file_exists($zip_path)) { 
						unlink($zip_path);
						//rmdir($temp_dir_string);
					}
					
					$disk = \Storage::disk('s3');
					$command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
						'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
						'Key' => $s3fileName,
						'ResponseContentDisposition' => 'attachment;'
					]);
					$request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+' . env('s3_TIMEOUT', 5) . ' minutes');
					/*Sending Email to Admin for export logging starts*/
					$date = date('Y-m-d H:i:s');  
					$name = encryptGdprData(auth()->user()->first_name).encryptGdprData(auth()->user()->last_name);
					$email = encryptGdprData(auth()->user()->email);
					$browser = \Agent::browser();
					$version = \Agent::version($user['browser']);
					$platform = \Agent::platform();
					$device = \Agent::platform();
					$ip = getClientIp();
					$email = EmailTemplate::whereId(5)->select("title","subject","description","from_name","from_email","status")->first();
					$find = ['@Name@', '@email@', '@date@', '@ip@', '@browser@', '@version@', '@platform@', '@device@'];
					$values = [$name,$email,$date, $ip, $browser, $version, $platform, $device];
					$html = str_replace($find, $values, $email->description); 
					$mailData = [];
					$mailData['text'] = '';
					$mailData['from_email'] = $email->from_email;
					$mailData['from_name'] = $email->from_name;
					$mailData['subject'] =$email->subject;  
					$mailData['html']  = $html;
					$mailData['user_email'] = '';
					$mailData['service_id'] = '1';  
					$mailData['cc_mail'] =[];  
					$mailData['bcc_mail'] =[];  
					$mailData['attachments'] =[];
					$nodeMailer = new NodeMailer();
					$nodeMailer->sendMail($mailData, true); 
					/*Sending Email to Admin for export logging ends*/
					return response()->json(['status' => true, 'url' => (string) $request->getUri(), 'message' => 'Selected data has been exported successfully'],200);	
					//return response()->json(array('data' => $zip_path, 's3' => false, 'status' => 1), 200);
			} else {
				return response()->json(array('data' => $zip_path, 's3' => false, 'status' => 1), 200);
			}
		} catch (\Exception $err) {
			return response()->json(array('message' => 'Whoops! something went wrong', 'status' => 0, 'exception_error' => $err->getMessage()), 500);
		}
	}
		/*
	 *Getting s3 bucket download url for specified file
	 * */
	public function csv_document_link($s3bukcetpath, $s3_bucket = 's3')
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
		} else {
			return ['success' => true, 'message' => 'no-data'];
		}
	}

    	/*
	 * DESC: to return sale csv header row on behalf of selected fields
	 * */
	function csv_header_data($csv_select)
	{
		$order = [];
		$order = array_keys($csv_select);
		return $order;
	}
 	/*
	 * DESC : to return array for csv rows on behalf of selected fields.
	 * */
	function csv_row_data($row, $selected_data)
	{
		$csv_row = [];
		foreach ($selected_data as $csv_selected=>$val) {
			$csv_select = strtolower($csv_selected);
			if ($csv_select == 'sale date') {
				$csv_row[] = $row['sale_date'];
			}
			if ($csv_select == 'lead id') {
				$csv_row[] = $row['lead_id'];
			}
			if ($csv_select == 'sale id') {
				$csv_row[] = $row['lead_id'];
			}
			if ($csv_select == 'reference number') {
				$csv_row[] = $row['reference_number'];
			}
			if ($csv_select == 'sale status') {
				$csv_row[] = $row['sale_status'];
			}
			if ($csv_select == 'sale sub status') {
				$csv_row[] = $row['sale_sub_status'];
			}
            if ($csv_select == 'sale source') {
				$csv_row[] = $row['sale_source'];
			}
			if ($csv_select == 'source') {
				$csv_row[] = $row['sale_source'];
			}
			if ($csv_select == 'lead source') {
				$csv_row[] = $row['sale_source'];
			}
			if ($csv_select == 'sale completed by') {
				$csv_row[] = $row['sale_completed_by'];
			}
            if ($csv_select == 'sale submission date time') {
				$csv_row[] = $row['sale_submission_date_time'];
			}
            if ($csv_select == 'customer title') {
				$csv_row[] = $row['customer_title'];
			}
			if ($csv_select == 'customer first name') {
				$csv_row[] = $row['customer_first_name'];
			}
			if ($csv_select == 'customer last name') {
				$csv_row[] = $row['customer_last_name'];
			}
			if ($csv_select == 'customer email') {
				$csv_row[] = $row['customer_email'];
			}
			if ($csv_select == 'customer phone') {
				$csv_row[] = $row['customer_phone'];
			}
			if ($csv_select == 'customer dob') {
				if ($row['customer_dob'] == '0000-00-00') {
					$csv_row[] = " ";
				} else {
					$csv_row[] = $row['customer_dob'];
				}
			}
			if ($csv_select == 'postcode') {
				$csv_row[] = $row['post_code'];
			}
			if ($csv_select == 'state') {
				$csv_row[] = $row['state'];
			}
			if ($csv_select == 'suburb') {
				$csv_row[] = $row['suburb'];
			}
			if ($csv_select == 'user browser information') {
				$csv_row[] = $row['user_browser_information'];
			}
			if ($csv_select == 'user browser version') {
				$csv_row[] = $row['browser'];
			}
			if ($csv_select == 'platform') {
				$csv_row[] = $row['platform'];
			}
			if ($csv_select == 'device type') {
				$csv_row[] = $row['device'];
			}
			if ($csv_select == 'sale ip') {
				$csv_row[] = $row['sale_ip'];
			}
			if ($csv_select == 'lead ip') {
				$csv_row[] = $row['lead_ip'];
			}
			if ($csv_select == 'lattitude') {
				$csv_row[] = $row['latitude'];
			}
			if ($csv_select == 'longitude') {
				$csv_row[] = $row['longitude'];
			}
            if ($csv_select == 'utm source') {
				$csv_row[] = $row['utm_source'];
			}
			if ($csv_select == 'utm medium') {
				$csv_row[] = $row['utm_medium'];
			}
			if ($csv_select == 'utm campaign') {
				$csv_row[] = $row['utm_campaign'];
			}
			if ($csv_select == 'utm term') {
				$csv_row[] = $row['utm_term'];
			}
			if ($csv_select == 'utm content') {
				$csv_row[] = $row['utm_content'];
			}
			if ($csv_select == 'gclid') {
				$csv_row[] = $row['gclid'];
			}
			if ($csv_select == 'fbclid') {
				$csv_row[] = $row['fbclid'];
			}
			if ($csv_select == 'utm rm') {
				$csv_row[] = $row['utm_rm'];
			}
			if ($csv_select == 'utm rm date') {
				$csv_row[] = $row['utm_rm_date'];
			}
			if ($csv_select == 'utm rm source') {
				$csv_row[] = $row['utm_rm_source'];
			}
			if ($csv_select == 'concession card type') {
				$csv_row[] = $row['concession_type'];
			}
			if ($csv_select == 'concession number') {
				$csv_row[] = $row['card_number'];
			}
			if ($csv_select == 'concession code') {
				$csv_row[] = $row['concession_code'];
			}
			if ($csv_select == 'concession card issue date') {
				$csv_row[] = $row['card_start_date'];
			}
			if ($csv_select == 'concession card expiry date') {
				$csv_row[] = $row['card_expiry_date'];
			}
			if ($csv_select == 'affiliate name') {
				$csv_row[] = $row['affiliate_name'];
			}
			if ($csv_select == 'subaffiliate name') {
				$csv_row[] = $row['sub_affiliate_name'];
			}
			if ($csv_select == 'sub affiliate referal code') {
				$csv_row[] = $row['referal_code'];
			}
			if ($csv_select == 'referral code') {
				$csv_row[] = $row['referal_code'];
			}
			if ($csv_select == 'cid/cui') {
				$csv_row[] = $row['customer_user_id'];
			}
			if ($csv_select == 'rc') {
				$csv_row[] = $row['rc'];
			}
			if ($csv_select == 'cui') {
				$csv_row[] = $row['cui'];
			}
			if ($csv_select == 'energy type') {
				$csv_row[] = $row['service_title'];
			}
			if ($csv_select == 'property type') {
				$csv_row[] = $row['property_type'];
			}
			if ($csv_select == 'life support') {
				$csv_row[] = $row['life_support'];
			}
			if ($csv_select == 'life support yes/no') {
				$csv_row[] = $row['life_support'];
			}
			if ($csv_select == 'life support equipment') {
				$csv_row[] = $row['life_support_equipment'];
			}
            if ($csv_select == 'life support energy type') {
				$csv_row[] = $row['life_support_energy_type'];
			}
			if ($csv_select == 'solar electricity') {
				$csv_row[] = $row['solar'];
			}
			if ($csv_select == 'solar') {
				$csv_row[] = $row['solar'];
			}
            if ($csv_select == 'solar options') {
				$csv_row[] = $row['solar_options'];
			}
			if ($csv_select == 'move in') {
				$csv_row[] = $row['move_in'];
			}
			if ($csv_select == 'move in date') {
				$csv_row[] = $row['move_in_date'];
			}
			if ($csv_select == 'current retailer') {
				$csv_row[] = $row['current_retailer'];
			}
			if ($csv_select == 'energy provider name') {
				$csv_row[] = $row['energy_provider_name'];
			}
			if ($csv_select == 'energy plan name') {
				$csv_row[] = $row['energy_plan_name'];
			}
			if ($csv_select == 'energy plan product code') {
				$csv_row[] = $row['energy_plan_product_code'];
			}
			if ($csv_select == 'energy distributor') {
				$csv_row[] = $row['energy_distributor'];
			}
			if ($csv_select == 'energy price fact sheet url') {
				$csv_row[] = $row['energy_price_fact_sheet_url'];
			}
            if ($csv_select == 'is unique') {
				$csv_row[] = $row['is_unique'];
			}
            if ($csv_select == 'resale type') {
                $csv_row[] = $row['resale_type'];
            }
			if ($csv_select == 'nmi/mirn numbers') {
				$csv_row[] = $row['nmi_mirn_numbers'];
			}
			if ($csv_select == 'site network code') {
				$csv_row[] = $row['site_network_code'];
			}
			if ($csv_select == 'primary identification type') {
				$csv_row[] = $row['primary_identification_type'];
			}
			if ($csv_select == 'primary identification number') {
				$csv_row[] = $row['primary_identification_number'];
			}
			if ($csv_select == 'primary identification expiry') {
				$csv_row[] = $row['primary_identification_expiry'];
			}
			if ($csv_select == 'primary medicare individual reference number') {
				$csv_row[] = $row['primary_medicare_individual_reference_number'];
			}
			if ($csv_select == 'primary medicare middle name on card') {
				$csv_row[] = $row['primary_medicare_middle_name_on_card'];
			}
			if ($csv_select == 'primary medicare card color') {
				$csv_row[] = $row['primary_medicare_card_color'];
			}
			if ($csv_select == 'primary license state code') {
				$csv_row[] = $row['primary_license_state_code'];
			}
			if ($csv_select == 'secondary identification type') {
				$csv_row[] = $row['secondary_identification_type'];
			}
			if ($csv_select == 'secondary identification number') {
				$csv_row[] = $row['secondary_identification_number'];
			}
			if ($csv_select == 'secondary identification expiry') {
				$csv_row[] = $row['secondary_identification_expiry'];
			}
			if ($csv_select == 'secondary medicare individual reference number') {
				$csv_row[] = $row['secondary_medicare_individual_reference_number'];
			}
			if ($csv_select == 'secondary medicare middle name on card') {
				$csv_row[] = $row['secondary_medicare_middle_name_on_card'];
			}
			if ($csv_select == 'secondary medicare card color') {
				$csv_row[] = $row['secondary_medicare_card_color'];
			}
			if ($csv_select == 'secondary license state code') {
				$csv_row[] = $row['secondary_license_state_code'];
			}
			if ($csv_select == 'connection address') {
				$csv_row[] = $row['connection_address'];
			}
			if ($csv_select == 'connection address suburb') {
				$csv_row[] = $row['connection_address_suburb'];
			}
            if ($csv_select == 'manual connection address') {
				$csv_row[] = $row['manual_connection_address'];
			}
			if ($csv_select == 'connection address state code') {
				$csv_row[] = $row['connection_address_state_code'];
			}
			if ($csv_select == 'connection address postcode') {
				$csv_row[] = $row['connection_address_postcode'];
			}
			if ($csv_select == 'billing preferences') {
				$csv_row[] = $row['billing_preferences'];
			}
			if ($csv_select == 'other billing address') {
				$csv_row[] = $row['other_billing_address'];
			}
			if ($csv_select == 'billing address') {
				$csv_row[] = $row['billing_address'];
			}
			if ($csv_select == 'billing address suburb') {
				$csv_row[] = $row['billing_address_suburb'];
			}
			if ($csv_select == 'billing address state code') {
				$csv_row[] = $row['billing_address_state_code'];
			}
			if ($csv_select == 'billing address postcode') {
				$csv_row[] = $row['billing_address_post_code'];
			}
			if ($csv_select == 'complete address') {
				$csv_row[] = $row['complete_address'];
			}
			if ($csv_select == 'po box full address') {
				$csv_row[] = $row['po_box_full_address'];
			}
            if ($csv_select == 'qa comment') {
				$csv_row[] = $row['qa_omment'];
			}
			if ($csv_select == 'rework comment') {
				$csv_row[] = $row['rework_comment'];
			}
			if ($csv_select == 'assigned agent') {
				$csv_row[] = $row['assigned_agent'];
			}
			if ($csv_select == 'email unsubscribe status') {
				$csv_row[] = $row['email_unsubscribe_status'];
			}
			if ($csv_select == 'email unsubscribe date') {
				$csv_row[] = $row['email_unsubscribe_date'];
			}
			if ($csv_select == 'sms unsubscribe status') {
				$csv_row[] = $row['sms_unsubscribe_status'];
			}
			if ($csv_select == 'sms unsubscribe date') {
				$csv_row[] = $row['sms_unsubscribe_date'];
			}
			if ($csv_select == 'lead create date') {
				$csv_row[] = $row['lead_create_date'];
			}
			if ($csv_select == 'lead date time') {
				$csv_row[] = $row['lead_create_date'];
			}
			if ($csv_select == 'sale create date') {
				$csv_row[] = $row['sale_created_date'];
			}
			if ($csv_select == 'current provider') {
				$csv_row[] = $row['current_provider'];
			}
			if ($csv_select == 'provider') {
				$csv_row[] = $row['current_provider'];
			}
			if ($csv_select == 'affiliate comment') {
				$csv_row[] = $row['affiliate_comment'];
			}
			if ($csv_select == 'other services') {
				$csv_row[] = $row['other_services'];
			}
			if ($csv_select == 'credit score') {
				$csv_row[] = $row['credit_score'];
			}
			if ($csv_select == 'journey percentage') {
				$csv_row[] = $row['percentage'];
			}
			if ($csv_select == 'step name') {
				$csv_row[] = $row['step_name'];
			}
			if ($csv_select == 'electricity duplicate lead') {
				$csv_row[] = $row['electricity_duplicate_lead'];
			}
			if ($csv_select == 'gas duplicate lead') {
				$csv_row[] = $row['gas_duplicate_lead'];
			}
			if ($csv_select == 'electricity bill handy') {
				$csv_row[] = $row['electricity_bill_handy'];
			}
			if ($csv_select == 'gas bill handy') {
				$csv_row[] = $row['gas_bill_handy'];
			}
			if ($csv_select == 'sale created date') {
				$csv_row[] = $row['sale_created_date'];
			}
			if ($csv_select == 'plan name') {
				$csv_row[] = $row['mobile_plan_name'];
			}
			if ($csv_select == 'connection type') {
				$csv_row[] = $row['connection_type'];
			}
			if ($csv_select == 'service type') {
				$csv_row[] = $row['service_title'];
			}
			if ($csv_select == 'total plan cost') {
				$csv_row[] = $row['total_plan_cost'];
			}
			if ($csv_select == 'provider name') {
				$csv_row[] = $row['provider'];
			}
			if ($csv_select == 'employer name') {
				$csv_row[] = $row['employer_name'];
			}
			if ($csv_select == 'occupation') {
				$csv_row[] = $row['occupation'];
			}
			if ($csv_select == 'employment duration') {
				$csv_row[] = $row['employment_duration'];
			}
			if ($csv_select == 'have credit card') {
				$csv_row[] = $row['have_credit_card'];
			}
			if ($csv_select == 'occupation type') {
				$csv_row[] = $row['occupation_type'];
			}
			if ($csv_select == 'industry') {
				$csv_row[] = $row['industry'];
			}
			if ($csv_select == 'employment status') {
				$csv_row[] = $row['employment_status'];
			}
			
			
			

		}
		return $csv_row;
	}

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCustomerInfoData(CustomerInfoRequest $request)
    {
        return Lead::updateCustomerData($request);
    }
    public function updateStage(saleEditRequest $request)
    {
        try {
            return Lead::updateStage($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }

    public function updateJourney(saleEditRequest $request)
    {
        try {
            return Lead::updateJourney($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }
    public function updateAddress(saleEditRequest $request)
    {
        try {
            return Lead::updateAddress($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }

     /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDemandDetailsData(DemandDetailRequest $request)
    {
        return Lead::updateDemandDetailInfo($request);
    }

     /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNmiNumbersData(NmiNumberRequest $request)
    {
        return Lead::updateNmiNumberInfo($request);
    }

    public function updateConcessionDetails(ConcessionDetailRequest $request){
        $response= Lead::updateConcessionDetails($request);
        return $response;
    }

     /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSiteAccessData(SiteAccessInfoRequest $request)
    {
        return Lead::updateSiteAccessInfo($request);
    }

     /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateQaSectionData(SalesQaSectionRequest $request)
    {
        return Lead::updateQaSectionInfo($request);
    }

    public function updatePrimaryIdentification(IdentificationDetailsRequest $request){
        return Lead::updatePrimaryIdentification($request);
    }
    public function updateSecondaryIdentification(IdentificationDetailsRequest $request){
        return Lead::updateSecondaryIdentification($request);
    }

     /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function updateOtherInfoData(SaleOtherInfoRequest $request)
    {
        return Lead::updateOtherInfo($request);
    }

    public function jointAccountUpdate(jointAccountInfoRequest $request){
        return Lead::jointAccountUpdate($request);
    }

    public function updateIdentificationDocument(saleEditRequest $request)
    {
        try {
            return Lead::updateIdentificationDocument($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }

    public function getSaleUpdateHistory($verticalId, $section, $id)
    {
        try {
            return Lead::getSaleUpdateHistory($id, $section, $verticalId);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }
	public function emailFromLead(EmailFromLeadsRequest $request)
	{
		try {
			$mailData = [];
			$mailData['text'] = '';
			$mailData['from_email'] = $request->emailFrom;	// EMAIL FROM
			$mailData['from_name'] = $request->emailFromName; // EMAIL FROM NAME
			$mailData['subject'] = $request->emailSubject;	// EMAIL SUBJECR
			$mailData['html']  = $request->emailContent;	// EMAIL BODY
			$mailData['user_email'] = $request->emailTo;	// EMAIL TO
			$mailData['service_id'] = '1';
			$mailData['lead_id'] = encryptGdprData($request->leadId);
			$mailData['cc_mail'] =$request->emailCC?[$request->emailCC]:[];
			$mailData['bcc_mail'] =$request->emailBcc?[$request->emailBcc]:[];
			$mailData['attachments'] =[];
			$nodeMailer = new NodeMailer();
			$response  = $nodeMailer->sendMail($mailData, true);
			
			return json_decode($response->getBody());
		} catch (\Exception $err) {
			throw new \Exception($err->getMessage(), 0, $err);
		}
	}
	public function addSMSTemplate(LeadsSmsRequest $request)
	{	
		try {
			// $senderId, $destination, $message, $smsType, $leadId
            return SmsLog::createSms($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
	}
	public function getPlivoData(Request $request)
	{	
		try {
			$plivoNumbers = AffiliateTemplate::getPlivoNumbers($request->userId, '2');
			return $plivoNumbers;
		} catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
	}
    public function resendWelcomeEmail(Request $request)
    {

		// echo encryptGdprData('geetanjali.sharma@cimet.com.au');die;
		$leadId = $request->lead_id;
		
        try {
			$service_id = $request->service_id;
			$service = Lead::getService($service_id);

			$columns = ['visitors.*', 'sale_products_' . $service . '.product_type', 'leads.status', 'leads.visitor_id', 'leads.sale_created', 'affiliate_id', 'sub_affiliate_id', 'billing_address_id', 'reference_no', 'visitor_addresses.address', 'suburb', 'state', 'postcode'];
			if (in_array($service, ['energy','mobile'])) {
				array_push($columns, 'sale_product_' . $service . '_connection_details.*'); 
			}
			$visitor = Lead::getFirstLead(['leads.lead_id' => $leadId],$service_id, $columns, true, true, true, true, null, true);

			$columns = ['id as product_id', 'lead_id', 'service_id', 'product_type', 'plan_id', 'provider_id', 'cost', 'reference_no'];
			$mobileColumns = ['handset_id', 'variant_id', 'own_or_lease', 'contract_id'];
			$energyColumns = ['id as product_id', 'lead_id', 'service_id', 'product_type', 'plan_id', 'provider_id', 'reference_no'];
			$verticals = ['energy' => $energyColumns, 'mobile' => array_merge($columns, $mobileColumns), 'broadband' => $columns];
		
			$products = Lead::getLeadProducts($verticals, $leadId, ['user_id', 'legal_name'], ['id', 'name', 'nbn_key_url', 'plan_document', 'show_price_fact', 'terms_condition'], true);
			
			$products = collect($products);
			
			$referenceNos = Lead::addReferenceNo($leadId, $products);
			return AffiliateTemplate::sendEmailAndSms($service_id,$products, $visitor, $referenceNos);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }	
	
	public function assignedQaLogsData(Request $request)
	{
		try {
			SalesQaLog::saveQaLogs($request);
			// return $getData;
		} catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
	}
}

