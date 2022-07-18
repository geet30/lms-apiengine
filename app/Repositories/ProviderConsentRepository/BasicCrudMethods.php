<?php

namespace App\Repositories\ProviderConsentRepository;

use App\Imports\SuburbPostcodesImport;
use Illuminate\Support\Facades\DB;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\{
    concessionContents,
    LogoCategory,
    ProviderContent,
    ProviderContentCheckbox,
    ProviderEquipment,
    Providers,
    UserAddress,
    User,
    ProviderSection,
    ProviderSectionOption,
    ProviderSectionSubOption,
    ProviderPermission,
    ProviderDirectDebit,
    ProviderOutboundLink,
    ProvidersIp,
    UserService,
    UserStates,
    UserSuburb,
    UserPostcode,
    Postcode,
    States,
    ProvderMovein,
    ProviderContact,
    SectionCustomFields,
    PlanEnergy,
    ProviderFieldPlan,
    PlanMobile,
    PlansBroadband,
    ProviderLogo
};
use Laravel\Socialite\Contracts\Provider;

trait BasicCrudMethods
{
    //Common function for fetch provider data
    public static function getProviderList($condition = null, $columns = '*', $relations = null, $withPagination = null)
    {
        $query = self::select($columns);

        if ($condition) {
            $query = $query->where($condition);
        }
        // dd($query->toSql());
        $query = self::where($condition)->select($columns)->orderBy('id', 'DESC');
        if ($relations) {
            foreach ($relations as $relation  => $select) {
                $query = $query->with([$relation => function ($query) use ($select) {
                    $query->select($select);
                }]);
            }
        }

        // if($withPagination){
        // 	return $query->paginate(1);
        // }Provider

        return $query->get();
    }

    //Fetch and filters
    public static function getFilters($condition = null, $columns = '*', $relations = null, $filters = null, $relationMandatory = true)
    {
        $data = request()->all();
        $filterColumns = ['service_id'];
        $query = self::select($columns);

        if ($condition) {
            $query = $query->where($condition);
        }
        $query = self::where($condition)->select($columns)->orderBy('id', 'desc');
        if ($relations) {
            foreach ($relations as $relation  => $select) {
                $relationData = ['data' => $data, 'filters' => $filters, 'relation' => $relation, 'filterColumns' => $filterColumns, 'select' => $select];
                if ($relationMandatory) {

                    $query = $query->whereHas($relation, function ($query) use ($relationData) {

                        if ($relationData['relation'] == 'getProviderServices' && $relationData['filters']) {
                            foreach ($relationData['filterColumns'] as $key) {
                                if (isset($relationData['data'][$key]) && !empty($relationData['data'][$key])) {
                                    $query->where($key, $relationData['data'][$key]);
                                }
                            }
                        }
                    });
                }
                $query = $query->with($relation, function ($query) use ($select) {
                    $query->select($select);
                });
            }
        }
        return $query->get();
        // return $query->paginate(config('env.PAGINATION_PERPAGE_COUNT'));
    }

	public static function modifyProviderResponse($provideruser, $info)
	{
		$data = [];
		foreach ($provideruser as $key => $provider) {
			array_push($data, [
				'userid' => $provider['user_id'],
				'name'   => $provider['legal_name'],
				'email'  => decryptGdprData($provider['user']['email']),
				'logo'   => (isset($provider['providersLogo']) && isset($provider['providersLogo']['name'])) ? $provider['providersLogo']['name'] : asset(theme()->getMediaUrlPath() . 'avatars/blank.png'),
				'status' => $provider['status'],
				'id'     => encryptGdprData($provider['user_id']),
				'service_id'     => @$provider->getProviderServices[0]['service_id'],
				'service_id_encrypt'     => encryptGdprData(@$provider->getProviderServices[0]['service_id']),
			]);
		}
		return $data;
	}

    /**
     * Edit provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public static function updateProviderDetail($request)
    {
        try {
            $data = [];
            $updateProvider = 0;
            $status = 'true';
            $case = 1;
            $stateId = 0;
            if ($request->eic_type_checkbox == "state" && $request->select_consent_state) {
                $stateId = $request->select_consent_state;
            }
            // $master_tab_manage_section = config('app.master_tab_manage_section');
            $provider = [];
            switch ($request->request_from) {
                case "terms_and_condition_form":
                    $data['type'] = $request->terms_and_condition_title;
                    $data['title'] = $request->title;
                    $data['provider_id'] = $request->user_id;
                    $data['description'] = $request->term_description;
                    break;
                case "acknowledgement_content_form":
                    $data['status'] = $request->acknowledgment_status;
                    $data['description'] = $request->acknowledgment_content;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "17";
                    break;
                case "footer_content_form":
                    $data['description'] = $request->footer_content;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "13";
                    break;
                case "satellite_eic_form":
                    $data['status'] = $request->satellite_eic_status;
                    $data['description'] = $request->satellite_eic_description;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "15";
                    break;
                case "statewise_consent_form":
                    $data['description'] = $request->statewise_consent_content;
                    $data['state_id'] = $stateId;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "14";
                    break;
                case "post_submission_form":
                    $data['description'] = $request->what_happen_next_content;
                    $data['why_us'] = $request->why_us_content;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "11";
                    $data['service_type'] = $request->service_type_id;
                    break;
                case "apply_now_popup_form":
                    $data['description'] = $request->pop_up_content;
                    $data['show_plan_on'] = json_encode($request->show_plan_on);
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "12";
                    break;
                case "tele_sale_setting_form":
                    $data['status'] = $request->telesale_eic_allow;
                    $data['provider_id'] = $request->user_id;
                    $data['state_id'] = $request->select_tele_sale_state;
                    $data['description'] = $request->tele_sale_setting_content;
                    $data['type'] = "16";
                    break;
                case "billing_preference_form":
                    $data['e_billing_preference_option'] = implode(',', $request->content_allow);
                    $data['status'] = $request->content_allow_status;
                    $data['description'] = $request->paper_bill_content;
                    $data['provider_id'] = $request->user_id;
                    $data['type'] = "10";
                    break;
                case "provider_manage_section_form":
                    $response = self::updateProviderManageSection($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 2;
                    break;
                case "provider_permission_form":
                case "provider_permission_form_sales":
                    return $response = self::createUpdateProviderPermission($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 3;
                    break;
                case "provider_outbound_link_form":
                    return $response = self::createUpdateProviderOutBoundLink($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 4;
                    break;
                case "direct_debit_setting_form":
                    return $response = self::createUpdateProviderDirectDebitSetting($request); //dd($response);

                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 5;
                    break;
                case "life_support_equipments_form":
                    return $response = self::assignEquipment($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 6;
                    break;
                case "concession_details_form":
                    return $response = self::addConcessionProvider($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 6;
                    break;
                case "concession_content_form":
                    return $response = self::addConcessionContent($request);
                    if ($response['status'] == 'true') {
                        $updateProvider = 1;
                    }
                    $case = 7;
                    break;
            }
            if ($case == 1) {
                if (!$data) {
                    //    return response()->json(['status' => 400, 'message' => 'False']);
                    $status = 'false';
                } else {
                    $condition['provider_id'] = $request->user_id;
                    $condition['type'] = $data['type'];
                    if ($request->request_from == "statewise_consent_form" && $request->eic_type_checkbox == "master") {
                        $condition['state_id'] = $stateId;
                    } else if ($request->request_from == "statewise_consent_form" && $request->eic_type_checkbox == "state") {
                        $condition['state_id'] = $request->select_consent_state;
                    }
                    if($request['request_from'] == 'statewise_consent_form'){
                        $existingContent = ProviderContent::where(['provider_id' => $condition['provider_id'], 'type' => $condition['type'], 'state_id' => $condition['state_id']])->first();
                        if($existingContent){
                            $logsData = [
                                'provider_id' => $existingContent->provider_id,
                                'state_id' => $existingContent->state_id,
                                'type' => $existingContent->type,
                                'description' => $existingContent->description,
                                'changed_by' => auth()->user()->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            $providerEicLogs = DB::connection('sale_logs')->table('provider_eic_logs')->insert($logsData);
                        }
                    }
                    $response = ProviderContent::updateOrCreate($condition, $data);
                    if ($request['request_from'] == "terms_and_condition_form") {
                        $optionsData = self::getSetUnsetTnC($request->user_id);

                        $response['unsetTypesArray'] = $optionsData['unsetTypesArray'] ?? [];
                        $response['setTypesArray'] = $optionsData['setTypesArray'] ?? '';
                    }
                    if ($request->request_from == "tele_sale_setting_form") {
                        ProviderPermission::updateOrCreate(['user_id' => $request->user_id], ["is_telecom" => $request->allow_telecom, "is_send_plan" => $request->allow_send_plan]);
                    }
                    $status = 'true';
                }
            }

            if ($status == 'true' || $updateProvider) {
                if ($request->request_from == "acknowledgement_content_form") {
                    return response()->json(['desc' => $data['description'], 'status' => 200, 'message' => 'Acknowledgement Content saved successfully']);
                }
                if ($request->request_from == "apply_now_popup_form") {
                    return response()->json(['status' => 200, 'message' => 'Apply now content saved successfully']);
                } else if ($request->request_from == "billing_preference_form") {
                    return response()->json(['status' => 200, 'message' => 'Billing preference changes saved successfully']);
                } else if ($request->request_from == 'statewise_consent_form' && $request->eic_type_checkbox == "state") {
                    return response()->json(['status' => 200, 'message' => 'Statewise consent added successfully']);
                } else if ($request->request_from == 'statewise_consent_form' && $request->eic_type_checkbox == "master") {
                    return response()->json(['status' => 200, 'message' => 'Master consent added successfully']);
                } else if ($request->request_from == 'acknowledgement_content_form') {
                    return response()->json(['status' => 200, 'message' => 'Acknowledgement added successfully']);
                } else if ($request['request_from'] == "terms_and_condition_form") {
                    return response()->json(['status' => 200, 'data' => $response, 'message' => 'Terms and Conditions data saved successfully']);
                } else {
                    return response()->json(['status' => 200, 'message' => 'Data Saved Successfully']);
                }
            }
            return response()->json(['status' => 400, 'message' => 'False']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    // Concession Data
    public static function getConcessionDetails($request)
    {
        return DB::table('concession_content')->where(
            [
                'state_id' => $request->state_id,
                'provider_id' => $request->provider_id,
                'type' => $request->type_id,
            ]
        )->first();
    }
    // store or upadte provider contact

    public static function storeOrUpdateContact($request)
    {
        try {
            if ($request) {
                $id = '';
                $msg = 'Contact has been added succesfully';
                $email = $request->contact_email;
                $user_id = $request->user_id;
                $contactId = $request->contactId;
                if (!empty($email) && !empty($contactId)) {
                    $editResult = ProviderContact::where(['email' => $email])->whereNotIn('id', [$contactId])->count();
                    if ($editResult >= 1) {
                        $msg = 'Email already exists';
                        return ['contactdata' => '', 'status' => true, 'message' => $msg];
                    }
                } else if (!empty($email) && empty($contactId)) {
                    $addResult = ProviderContact::where(['email' => $email])->count();
                    if ($addResult >= 1) {
                        $msg = 'Email already exists';
                        return ['contactdata' => '', 'status' => true, 'message' => $msg];
                    }
                }
                if (isset($contactId) && $contactId != "") {
                    $id = $contactId; //table id
                    $msg = trans('Contact has been updated succesfully');
                }
                $data = [
                    'name' => $request->contact_name,
                    'provider_id' => $user_id,
                    'email' => $email,
                    'designation' => $request->contact_designation,
                    'description' => $request->contact_description,
                ];
                ProviderContact::updateOrCreate(['id' => $id], $data);
                $contactdata = ProviderContact::where('provider_id', $request->user_id)->orderBy('created_at', 'desc')->get()->toArray();
                return ['contactdata' => $contactdata, 'status' => true, 'message' => $msg];
            }
        } catch (\Exception $err) {
            throw $err;
        }
    }

    public static function deletecontact($request, $id)
    {
        try {
            $response = ProviderContact::where('id', $id)->delete();
            if ($response) {
                $data = ProviderContact::where('provider_id', $request->user_id)->orderBy('created_at', 'desc')->get()->toArray();
                $status = true;
                $message = 'Deleted';
            } else {
                $status = false;
                $message = 'Not deleted';
            }

            return ['data' => $data, 'status' => $status, 'message' => $message];
        } catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get provider data on change of selectbox.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public static function getSpecificTermData($request)
    {
        try {
            $response = ProviderContent::where(['provider_id' => $request->user_id, "type" => $request->type])->with('getcontentcheckbox')->get()->toArray();
            return response()->json(["data" => $response], 200);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public static function getSetUnsetTnC($providerId)
    {
        try {

            $temp = [];
            $unsetTypesArray = [];
            $setTypesArray = [];
            $typesArray = [];
            $t_and_c_types = config('app.terms_and_conditions_types');
            $whereArray = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $typesData = ProviderContent::select('type')->where(['provider_id' => $providerId])->whereIn('type', $whereArray)->distinct()->get()->toArray();
            foreach ($typesData as $data) {
                array_push($typesArray, $data['type']);
            }

            if (!empty($typesArray)) {

                $temp = array_diff(array_keys($t_and_c_types), $typesArray);
                if (!empty($temp)) {
                    foreach ($t_and_c_types as $key => $value) {

                        if (in_array($key, $temp)) {

                            $unsetTypesArray[$key] = $value;
                        }
                    }
                    foreach ($t_and_c_types as $key => $value) {
                        if (in_array($key, $typesArray)) {
                            $setTypesArray[$key] = $value;
                        }
                    }
                } else {
                    $setTypesArray = $typesArray;
                }
            } else {
                $unsetTypesArray = $t_and_c_types;
            }
            return array('setTypesArray' => $setTypesArray, 'unsetTypesArray' => $unsetTypesArray);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }







    /**
     * Store or update checkbox of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public static function storeOrUpdateCheckbox($request)
    {
        // dd($request);
        try {
            $data = [];
            switch ($request->form_name) {
                case "terms_condition_checkbox_form":
                    $data['checkbox_required'] = $request->terms_checkbox_required;
                    $data['validation_message'] = $request->terms_condition_validates;
                    $data['content'] = $request->terms_checkbox_content;
                    $data['status'] = $request->term_checkbox_status_save;
                    $data['order'] = $request->order;
                    break;
                case "provider_ackn_checkbox_formm":
                    $data['checkbox_required'] = $request->ackn_checkbox_required;
                    $data['validation_message'] = $request->ackn_validation_msg;
                    $data['content'] = $request->ackn_checkbox_content;
                    $data['status'] = $request->ackn_checkbox_status_save;
                    $data['order'] = $request->order;
                    $request->request->add(['type' => '17']);
                    break;
                case "tele_sale_setting_checkbox_form":
                    $data['content'] = $request->tele_sale_setting_checkbox_content;
                    $data['checkbox_required'] = $request->tele_sale_setting_checkbox_required;
                    $data['validation_message'] = $request->tele_sale_setting_validation_msg;
                    $data['status'] = $request->tele_sale_setting_checkbox_save_status;
                    $data['type'] = $request->tele_select_eic_type;
                    $data['order'] = $request->order;
                    $request->request->add(['type' => '16']);
                    break;
                case "state_checkbox_form":
                    $data['content'] = $request->state_eic_content_checkbox_content;
                    $data['checkbox_required'] = $request->state_eic_content_checkbox_required;
                    $data['validation_message'] = $request->state_eic_content_validation_msg;
                    $data['status'] = $request->state_eic_content_checkbox_save_status;
                    $data['type'] = $request->statewise_select_eic_type;
                    $data['order'] = $request->order;
                    $request->request->add(['type' => '14']);
                    break;
                case "master_checkbox_form":
                    $data['content'] = $request->state_eic_content_checkbox_content;
                    $data['checkbox_required'] = $request->state_eic_content_checkbox_required;
                    $data['validation_message'] = $request->state_eic_content_validation_msg;
                    $data['status'] = $request->state_eic_content_checkbox_save_status;
                    $data['type'] = $request->statewise_select_eic_type;
                    $data['order'] = $request->order;
                    $request->request->add(['type' => '14']);
                    break;
                case "debit_checkbox_form":
                    $data['content'] = $request->debit_checkbox_content;
                    $data['checkbox_required'] = $request->debit_checkbox_required;
                    $data['validation_message'] = $request->debit_validation_msg;
                    $data['connection_type'] = $request->debit_info_type;
                    $data['type'] = 18;
                    $data['order'] = $request->order;
                    $data['info_type'] = $request->debit_info_type;
                    $request->request->add(['type' => '18']);
                    break;
                case "post_submission_checkbox_form":
                    $data['checkbox_required'] = $request->post_submission_checkbox_required;
                    $data['validation_message'] = $request->post_submission_validation_msg;
                    $data['content'] = $request->post_submission_checkbox_content;
                    $data['order'] = $request->order;
                    $request->request->add(['type' => '11']);
                    break;

                case "movein_provider_eic_content_checkbox_form":
                    $data['checkbox_required'] = $request->movein_eic_content_checkbox_required;
                    $data['validation_message'] = $request->movein_eic_content_validation_msg;
                    $data['content'] = $request->movein_eic_content_checkbox_content;
                    $data['order'] = $request->order;

                    if ($request->form_type_movein == 'move_in_content') {
                        $data['type'] = 19;
                        $request->request->add(['type' => '19']);
                    }
                    if ($request->form_type_movein == 'move_in_eic_content') {
                        $data['type'] = 20;
                        $request->request->add(['type' => '20']);
                    }
					break;

                    case "plan_permission_checkbox_form":
                        $data['checkbox_required'] = $request->plan_permission_checkbox_required;
                        $data['validation_message'] = $request->plan_permission_checkbox_required ==1?$request->provider_permission_validation_msg:'';
                        $data['content'] = $request->plan_permission_checkbox_content;
                        $data['order'] = $request->order;
                        $data['connection_type'] = $request->plan_select_connection_type;
                        $request->request->add(['type' => '22']);
                        $data['type']=22;
                        break;
			}
			//dd($request->all(),$data, $exist_data);
			if ($request->form_name != 'debit_checkbox_form') {
               // dd($data);
				
				$validate = [];
				if ($request->form_name == 'state_checkbox_form') {
					$validate['state_id'] = $request->state;	
				}
				else if ($request->form_name == 'master_checkbox_form') {
					$validate['state_id'] = $request->state;
					
				}
				if($request->form_name == 'movein_provider_eic_content_checkbox_form'){
					$validate['provider_id'] = decryptGdprData($request->user_id);
					$request->user_id = decryptGdprData($request->user_id);
					
				}else{
					$validate['provider_id'] = $request->user_id;
				
				}
				$validate["type"] = $request->type;
                $requestType = $request->type;
                if($request->type == '19' || $request->type == '20'){

                    $exist_data =  ProvderMovein::with(['getMoveinCheckbox' => function($q) use($requestType) {
                        $q->where('type', '=', $requestType);
                    }])
                        ->where('user_id', $request->user_id)
                        ->first();

                    // $exist_data = ProvderMovein::where('user_id',$request->user_id)->with('getMoveinCheckbox')->first();
                }else if($request->type == '22'){
                    $exist_data=ProviderPermission::where(['user_id' => $request->user_id])->first();
                    //dd($exist_data);
                }else{
                    $exist_data = ProviderContent::where($validate)->with('getcontentcheckbox')->first();
                }

				if (!empty($exist_data)) {

					if($request->form_name== 'state_checkbox_form' || $request->form_name== 'master_checkbox_form' || $request->form_name= 'tele_sale_setting_checkbox_form'  ||$request->form_name= 'post_submission_checkbox_form' || $request->form_name= 'movein_provider_eic_content_checkbox_form'){
						$whereCondition=['provider_content_id'=>$exist_data->id,'order'=>$data['order']];
					}else{
						$whereCondition=['provider_content_id'=>$exist_data->id,'type'=>$data['type'],'order'=>$data['order']];
					}
					$pcbData=ProviderContentCheckbox::where($whereCondition);

						if(!empty($request->id)){
							$pcbData=$pcbData->where('id','!=',$request->id);
						}
						$pcbData=$pcbData->select('id')->get();
					if(count($pcbData)>0){
						$errors['order'] = 'Order type already exists.';
						return response()->json(['status' => 422, 'errors' => $errors], 422);
					}
					
					$data['provider_content_id'] = $exist_data->id;
					if (!$data) {
						$status = 'false';
					} else {
					
					ProviderContentCheckbox::updateOrCreate(['id' => $request->id], $data);
                    if($request->type == '19' || $request->type == '20'){
                        $response =  ProvderMovein::select('id')->where(['user_id' => $request->user_id])->with(['getMoveinCheckbox' => function($q) use($requestType) {
                            $q->where('type', '=', $requestType);
                        }])->get()->toArray();

                        // $response = ProvderMovein::select('id')->where(['user_id' => $request->user_id])->with('getMoveinCheckbox')->get()->toArray();
                    
                    }else if($request->type=='22'){
                        $response =  ProviderPermission::select('id')->where(['user_id' => $request->user_id])->with(['getPermissionCheckbox' => function($q) use($exist_data) {
                            $q->where(['provider_content_id'=> $exist_data->id,'type' => 22]);
                        }])->get()->toArray();
                    
                    }else{
                        $response = ProviderContent::select('id')->where(['provider_id' => $request->user_id, "type" => $request->type, "state_id" => $request->state])->with('getcontentcheckbox')->get()->toArray();
                    }


					return response()->json(["data" => $response, 'message' => trans('providers.provider_acknowledgement_checkbox_added'), 'status' => 200]);
					}
				}
			} else {
				$exist_data = ProviderDirectDebit::where(['user_id' => $request->user_id])->first();

				if ($exist_data) {
					// $data['provider_content_id'] = $exist_data->id;
					$pcbData=ProviderContentCheckbox::where(['provider_content_id'=>$exist_data->id,'order'=>$data['order']]);

						if(!empty($request->id)){
							$pcbData=$pcbData->where('id','!=',$request->id);
						}
						$pcbData=$pcbData->select('id')->get();
					if(count($pcbData)>0){
						$errors['order'] = 'Order type already exists.';
						return response()->json(['status' => 422, 'errors' => $errors], 422);
					}
					
					$data['provider_content_id'] = $exist_data->id;
					if (!$data) {
						$status = 'false';
					} else {
					ProviderContentCheckbox::updateOrCreate(['id' => $request->id], $data);

					$response = ProviderDirectDebit::select('id')->where(['user_id' => $request->user_id])->with('getcontentcheckbox')->get()->toArray();
					return response()->json(["data" => $response, 'message' => trans('providers.provider_direct_debit_card_checkbox_added'), 'status' => 200]);
					}
				}
			}
			return response()->json(['status' => 400, 'message' => 'Please add content first.']);
		} catch (\Exception $err) {
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
	}

    /**
     * remove checkbox of provider.
     *
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public static function removeCheckbox($request)
    {
        //dd($request);
        try {
            $response = ProviderContentCheckbox::where('id', $request->id)->delete();
            $checkBoxCount = ProviderContentCheckbox::where('provider_content_id', $request->providerId)->count();
            if ($response) {
                return response()->json(['checkBoxCount' => $checkBoxCount, 'status' => 200, 'message' => "Checkbox deleted successfully", 'data' => $response]);
            }
            return response()->json(['status' => 400, 'message' => 'Failed']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * create provider
     */
    public static function insertProvider($request)
    {
        \DB::beginTransaction();
        try {
            $status = 'true';
            $request['email'] = encryptGdprData(strtolower($request['email']));
            $request['phone'] = encryptGdprData($request['contact_no']);
            $addUser = self::createProviderUser($request, 'provider');

            if ($addUser['status']) {
                $status = 'true';
                $addProvider = 0;
                if ($request['request_from'] == 'provider_basic_detail_form') {
                    $provider['user_id'] = $addUser['user_id'];
                    $provider['service_id']      = $request['service_type_id'];
                    $provider['status']          = 0;
                    $provider['name']            = $request['business_name'];
                    $provider['legal_name']      = $request['legal_name'];
                    $provider['abn_acn_no']      = $request['abn'];
                    $provider['support_email']   = $request['support_email'];
                    $provider['complaint_email'] = $request['complaint_email'];
                    $provider['description']     = $request['description'];
                    if (!$provider) {
                        return response()->json(['status' => 200, 'message' => 'False']);
                    }
                    $addProvider = Providers::updateOrCreate([
                        'user_id' => $addUser['user_id']
                    ], $provider);
                }

                if ($addProvider) {
                    //Add services
                    $services = [];
                    $services['user_id'] = $addUser['user_id'];
                    //$services['service_id'] = $request['service_type_id'];
                    $services['service_id'] = $request['service_type_id'];
                    $services['user_type'] = 2; //dd($services,$request->all());
                    $addServices = UserService::updateOrCreate(['user_id' => $addUser['user_id']], $services);
                    if (!$addServices) {
                        $status = 'false';
                    }

                    //Add address
                    $address['user_id'] = $addUser['user_id'];
                    $address['address'] = $request['address'];
                    $address['address_type'] = 7;
                    $addAddress = UserAddress::updateOrCreate(['user_id' => $addUser['user_id']], $address);
                    if (!$addAddress) {
                        $status = 'false';
                    }
                } else {
                    $status = 'false';
                }
            } else {
                $status = 'false';
            }
            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_created');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_notcreated');
            }

            return ['status' => $http_status, 'message' => $message];
        } catch (\Exception $err) {
            \DB::rollback();
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    /**
     * update provider manage section setting
     */
    public static function updateProviderManageSection($request)
    {
        try {
            $status = 'true';
            $identity_data = [];
            $identity_data['user_id'] = $request['user_id'];
            $identity_data['service_id'] = $request['service_type_id'];
            if ($request['request_sub_from'] == 'personal_details_form') {
                $identity_data['section_id'] = $request['section_type_id'];
                $identity_data['section_status'] = 1;
                $identity_data['section_script'] = $request['personal_detail_script'];
                $identity_data['section_option'] = $request['personal_details'];
            }
            if ($request['request_sub_from'] == 'connection_details_form') {
                $identity_data['section_id'] = $request['section_type_id'];
                $identity_data['section_status'] = $request['conn_detail_status'];
                $identity_data['section_option'] = $request['connection_detail'];
                $identity_data['section_script'] = $request['connection_detail_script'];
            }
            if ($request['request_sub_from'] == 'identification_details_form') {
                $identity_data['section_id'] = $request['section_type_id'];

                $identity_data['acknowledgement'] = $request['identification_details_acknowledgement'];
                $identity_data['section_option'] = $request['identification_details'];
                $identity_data['is_required'] = $request['is_required'];
                $identity_data['section_sub_option'] = $request['identification_details_sub_option'];
                $identity_data['section_script'] = $request['identity_detail_script'];
                $identity_data['section_status'] = 0;
                if (isset($request['identification_details'][1])) {
                    $identity_data['section_status'] = $request['identification_details'][1];
                }
            }
            if ($request['request_sub_from'] == 'employment_details_form') {
                $identity_data['section_id'] = $request['section_type_id'];
                $identity_data['section_status'] = $request['employment_detail_status'];
                $identity_data['section_script'] = $request['employment_detail_script'];
                $identity_data['section_option'] = $request['employment_details'];
            }
            if ($request['request_sub_from'] == 'connection_address_form') {
                $identity_data['section_id'] = $request['section_type_id'];
                $identity_data['section_status'] = $request['conn_address_detail_status'];
                $identity_data['section_script'] = $request['connection_address_script'];
                $identity_data['section_option'] = $request['connection_address'];
            }
            if ($request['request_sub_from'] == 'billing_and_delivery_address_form') {
                $identity_data['section_id'] = $request['section_type_id'];
                $identity_data['section_status'] = $request['billing_delivery_detail_status'];
                //$identity_data['section_option'] = $request['billing_and_delivery_address'];
                $identity_data['section_sub_option'] = $request['billing_and_delivery_address_sub_opt'];
                $identity_data['section_script'] = $request['billing_delivery_detail_script'];
                $identity_data['is_required'] = $request['billing_and_delivery_required'];
                $identity_data['section_option'][1] = $request['billing_delivery_detail_status'];
                $identity_data['section_option'][2] = $request['billing_delivery_detail_status'];
            }
            if ($request['request_sub_from'] == 'other_settings_form') {
                $data['user_id'] =  $request['user_id'];
                $data['is_sclerosis'] = $request['other_setting_sclerosis_status'];
                $data['sclerosis_title'] = $request['other_setting_sclerosis_status']==1?$request['other_setting_sclerosis_title']:'';
                $data['is_medical_cooling'] = $request['other_setting_medical_cooling_status'];
                $data['medical_cooling_title'] = $request['other_setting_medical_cooling_status']==1?$request['other_setting_medical_cooling_title']:'';

                $res=ProviderPermission::updateOrCreate(['user_id' => $request['user_id']],$data);
                if(!empty($res)){
                    return ['status' => 200, 'message' => 'Data updated successfully'];
                }
                    return ['status' => 400, 'message' => 'Something went wrong'];
            }
            //save provider section
            $providerSection = ProviderSection::updateOrCreate(['user_id' => $request['user_id'], 'service_id' => $request['service_type_id'], 'section_id' => $identity_data['section_id']], $identity_data);

            if ($providerSection) {
                $status = 'true';
                $section_id = $providerSection->id;
            }
            $section_option = [];
            ProviderSectionOption::where('provider_section_id', $section_id)->update(['section_option_status' => 0, 'min_value_limit' => 0, 'max_value_limit' => 0, 'is_required' => 0]);
            if ($identity_data['section_status'] == 1) {
                if (!empty($identity_data['section_option'])) {
                    foreach ($identity_data['section_option'] as $key => $value) {
                        if ($request['request_sub_from'] == 'employment_details_form') {
                            $year = $request['employment_details_year_option'] ?? 0;
                            $month = $request['employment_details_month_option'] ?? 0;
                        } else if ($request['request_sub_from'] == 'connection_address_form') {
                            $year = $request['connection_address_year_option'] ?? 0;
                            $month = $request['connection_address_month_option'] ?? 0;
                        } else {
                            $year = 0;
                            $month = 0;
                        }
                        if ($request['request_sub_from'] == 'identification_details_form' || $request['request_sub_from'] == 'billing_and_delivery_address_form') {
                            $section_option = ProviderSectionOption::updateOrCreate(['provider_section_id' => $section_id, 'section_option_id' => $key], ['section_option_status' => $value, 'min_value_limit' => $month, 'max_value_limit' => $year]);
                        } else {
                            $section_option = ProviderSectionOption::updateOrCreate(['provider_section_id' => $section_id, 'section_option_id' => $value], ['section_option_status' => 1, 'min_value_limit' => $month, 'max_value_limit' => $year]);
                        }
                        $section_option_id = $section_option->id;
                        if ($request['section_type_id'] == 3 || $request['section_type_id'] == 6) {
                            if (!empty($identity_data['is_required'][$key])) {
                                ProviderSectionOption::where('id', $section_option_id)->update(['is_required' => $identity_data['is_required'][$key]]);
                            }
                        }
                        //save sub option
                        ProviderSectionSubOption::where('section_option_id', $section_option_id)->update(['section_sub_option_status' => 0]);
                        if (isset($identity_data['section_sub_option'])) {
                            if (isset($request['billing_and_delivery_address_sub_opt'][$key])) {
                                foreach ($request['billing_and_delivery_address_sub_opt'][$key] as $k => $val) {
                                    ProviderSectionSubOption::updateOrCreate(
                                        [
                                            'section_option_id' => $section_option_id,
                                            'section_sub_option_id' => $val
                                        ],
                                        ['section_sub_option_status' => 1]
                                    );
                                }
                            }
                            if (isset($request['identification_details_sub_option'])) {
                                if (isset($request['identification_details_sub_option'][$key])) {
                                    foreach ($request['identification_details_sub_option'][$key] as $kk => $val) {
                                        ProviderSectionSubOption::updateOrCreate(
                                            [
                                                'section_option_id' => $section_option_id,
                                                'section_sub_option_id' => $val
                                            ],
                                            ['section_sub_option_status' => 1]
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                $status = 'true';
            }
            if ($status == 'true') {
                // \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_created');
            } else {
                // \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_notcreated');
            }

            return ['status' => $http_status, 'message' => $message];
        } catch (\Exception $err) {
            // \DB::rollback();
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    /**
     * create user and return userId for provider
     */
    public static function  createProviderUser($request, $role_type)
    {
        try {
            // $role_id = Role::where('name', $role_type)->pluck('id')->first();
            $login_id = Auth::id();
            $user = User::updateOrCreate(['id' => $request['user_id']], [
                'first_name' => '',
                'last_name' => '',
                'email' => $request['email'],
                'phone' => $request['phone'],
                // 'role' => $role_id,
                'status' => '1',
                // 'password' => Hash::make($password),
                'created_by' => $login_id,
                'status' => 1,
            ]);
            if ($user) {
                // $user->assignRole($role_type);
                return ['status' => true, 'user_id' => $user->id];
            }
            return ['status' => false];
        } catch (\Exception $err) {
            return ['status' => false, 'message' => $err->getMessage()];
        }
    }

    public static function getProviderDetails($condition = null, $columns = '*', $relations = null, $withPagination = null)
    {
        $query = self::select($columns);

        if ($condition) {
            $query = $query->where($condition);
        }
        $query = self::where($condition)->select($columns);
        if ($relations) {
            foreach ($relations as $relation  => $select) {
                $query = $query->with([$relation => function ($query) use ($select) {
                    $query->select($select);
                }]);
            }
        }

        // if($withPagination){
        // 	return $query->paginate(1);
        // }Provider

        return $query->get()->toArray();
    }

    // if($withPagination){
    // 	return $query->paginate(1);
    // }Provider

    public static function updateStatus($request)
    {
        \DB::beginTransaction();
        try {
            $status = $request['status'];
            $user_id = decryptGdprData($request['user_id']);
            $providerStatus = Providers::where('user_id', $user_id)->update(['status' => $status]);
            if ($providerStatus) {
                $providerUserStatus = User::where('id', $user_id)->update(['status' => $status]);
                if ($providerUserStatus) {
                    $status = 'true';
                } else {
                    $status = 'false';
                }
            } else {
                $status = 'false';
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_status_update');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_status_notupdate');
            }

            return ['status' => $http_status, 'message' => $message];
        } catch (\Exception $err) {
            \DB::rollback();
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function createUpdateProviderPermission($request)
    {
    
        \DB::beginTransaction();
        try {
            $data = [];
            $status = 'true';
            //'is_telecom','is_send_plan'
            if ($request->service_type_id == 1 || $request->service_type_id == 4) {
                $data['user_id'] = $request->user_id;
                $data['is_life_support'] = $request->life_support_allow;
                $data['life_support_energy_type'] = isset($request->life_support_energy_type) ? $request->life_support_energy_type : 0;
                $data['is_retention'] = $request->e_retention_allow;
                $data['is_gas_only'] = $request->gas_sale_allow;
                $data['is_demand_usage'] = $request->manage_demand_status;
                $data['ea_credit_score_allow'] = $request->ea_credit_score_check_allow;
                $data['credit_score'] = $request->credit_score;
            }
            if ($request->service_type_id != 1 && $request->service_type_id != 4) {
                $data['user_id'] = $request->user_id;
                $data['is_new_connection'] = $request->connection_allow;
                $data['is_port'] = $request->port_allow;
                $data['is_retention'] = $request->retention_allow;
                $data['connection_script'] = $request->plan_permsn_connectn_script;
                $data['port_script'] = $request->plan_port_in_script;
                $data['recontract_script'] = $request->plan_recontract_script;
            }

            if ($request->has('submit_sale_api')) {
                $data['is_submit_sale_api'] = $request->submit_sale_api;
            }

            if (!$data) {
                $status = 'false';
            } else {
                $response = ProviderPermission::updateOrCreate(['user_id' => $request->user_id], $data);
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.providerpermission_updated');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.providerpermission_notupdated');
            }
            return response()->json(['message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            // return ['status' => 400, 'message' => $err->getMessage()];
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function createUpdateProviderOutBoundLink($request)
    {
        \DB::beginTransaction();
        try {
            $data = [];
            $response = '';
            $status = 'true';
            $data['user_id'] = $request->user_id;
            $data['order'] = $request->order;
            $data['link_title'] = $request->link_title;
            $data['link_url'] = $request->link_url;
            //  dd($request->all(),$data);

            $linkCountOrder = ProviderOutboundLink::where('user_id', $request->user_id)->where('order', $request->order);
            if (isset($request->link_id) && $request->link_id != null) {
                $linkCountOrder = $linkCountOrder->where('id', '!=', $request->link_id);
            }
            $linkCountOrder = $linkCountOrder->select('id')->get();
            if (count($linkCountOrder) > 0) {
                // return response()->json(['success' => false,'message'=>'Order type already exists.','status'=>422],422);
                $errors['order'] = 'Order type already exists.';
                return response()->json(['status' => 422, 'errors' => $errors], 422);
            }
            if (!$data) {
                $status = 'false';
            } else {
                ProviderOutboundLink::updateOrCreate(['user_id' => $request->user_id, 'id' => $request->link_id], $data);
                $response = ProviderOutboundLink::where('user_id', $request->user_id)->orderBy('order', 'ASC')->get()->toArray();
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.outbound_link_saved');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.outbound_link_notsaved');
            }
            // return ['status' => $http_status, 'message' => $message];
            return response()->json(["data" => $response, 'message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            // return ['status' => 400, 'message' => $err->getMessage()];
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function createUpdateProviderDirectDebitSetting($request)
    {
        \DB::beginTransaction();
        try {
            $data = [];
            $status = 'true';
            $data['user_id'] = $request->user_id;

            if (!empty($request->payment_method) && count($request->payment_method) == 2) {
                $data['payment_method_type'] = 3;
            } elseif (!empty($request->payment_method) && count($request->payment_method) == 1) {
                $data['payment_method_type'] = (int)implode(",", $request->payment_method);
            } else {
                $data['payment_method_type'] = 0;
            }
            $data['card_information'] = $request->card_info_content;
            $data['bank_information'] = $request->bank_info_content;
            $data['is_card_content'] = $request->card_info_status;
            $data['is_bank_content'] = $request->bank_info_status;
            $data['status'] = $request->direct_debit_status;
            // dd($request->all(),$data);
            if (!$data) {
                $status = 'false';
            } else {
                $response = ProviderDirectDebit::updateOrCreate(['user_id' => $request->user_id], $data);
            }
            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_directdebit_updated');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_directdebit_notupdated');
            }
            // return ['status' => $http_status, 'message' => $message];
            return response()->json(['message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            // return ['status' => 400, 'message' => $err->getMessage()];
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /*
     *
     *
     */
    public static function  postManageIps($request)
    {
        try {
            $ip_data = [];
            $status = 'true';
            $ips = explode(",", $request->ips);
            $ip_range = explode(",", $request->ip_range);
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                } else {
                    if ($ip != "")
                        $errors['ips'] = 'Invaild IP address';
                }
            }
            foreach ($ip_range as $ip) {
                $range = explode("-", $ip);
                if (isset($range[1])) {
                    if (!filter_var($range[0], FILTER_VALIDATE_IP)) {
                        $errors['ip_range'] = 'Invaild IP range address';
                    }
                } else {
                    if ($ip != "")
                        $errors['ip_range'] = 'Invaild IP range address';
                }
            }
            if (isset($errors)) {
                //return response()->json(array('success' => 'false',"message"=>"invaild ip","errors"=>$errors),422);
                return response()->json(['status' => 422, 'errors' => $errors], 422);
            }
            $ip_data['ip_range'] = $request->ip_range;
            $ip_data['ips'] = $request->ips;
            $ip_data['user_id'] = $request->user_id;

            if (!$ip_data) {
                $status = 'false';
            } else {
                ProvidersIp::updateOrCreate(['user_id' => $request->user_id], $ip_data);
                // dd($request->all(),$data);
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_ip_added');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_ip_notadded');
                $data = '';
            }
            return response()->json(['status' => $http_status, 'message' => $message], 200);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()], 400);
        }
    }

    /*
     *
     *
     */
    public static function  getManageIps($request)
    {
        try {

            $providers_ips = ProvidersIp::where('user_id', $request->user_id)->first();
            return response()->json(["data" => $providers_ips, 'message' => 'Success', 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    /*
     *
     *
     */
    public static function  postManageToken($request)
    {
        try {
            $token = [];
            $status = 'true';
            if ($request->has('user_id')) {
                $token['token'] = encryptGdprData(\Str::random(25));
                ProvidersIp::updateOrCreate(['user_id' => $request->user_id], $token);
            } else {
                $status = 'false';
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_token_update');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_token_notupdate');
            }
            return ['status' => $http_status, 'message' => $message, 'token' => $token['token']];
        } catch (\Exception $e) {
            return  $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    public static function setDebitInfoIp($request)
    {
        try {
            $ip_data = [];
            $status = 'true';
            $ips = explode(',', $request->export_leads);
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                } else {
                    if ($ip != "")
                        $errors['export_leads'] = 'Invaild ip address';
                }
            }

            if (isset($errors)) {
                //return response()->json(array('success' => 'false',"message"=>"invaild ip","errors"=>$errors),422);
                return ['status' => 422, 'errors' => $errors];
            }
            $ip_data['debit_info_csv_ip'] = $request->export_leads;
            //store and update sale export password
            if ($request->sale_export_password != '' && $request->sale_export_password != null) {
                $sale_password = base64_encode($request->input('sale_export_password'));
                $ip_data['debit_info_csv_password'] = $sale_password;
            }

            if (!$ip_data) {
                $status = 'false';
            } else {
                $response = ProvidersIp::updateOrCreate(['user_id' => $request->user_id], $ip_data);
                // dd($request->all(),$data);
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_debit_csv_info_update');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_debit_csv_info_notupdate');
            }
            return ['status' => $http_status, 'message' => $message];
        } catch (\Exception $e) {
            return  $result = [
                'exception_message' => $e->getMessage()
            ];
        }
    }

    public static function deleteOutboundLink($request, $id)
    {
        try {
            $response = ProviderOutboundLink::where('id', $id)->delete();
            if ($response) {
                $response = ProviderOutboundLink::where('user_id', $request->user_id)->orderBy('order', 'ASC')->get()->toArray();
                $http_status = 200;
                $message = trans('providers.outboundlink_deleted');
            } else {
                $http_status = 400;
                $message = trans('providers.outboundlink_notdeleted');
            }
            // return ['status' => $http_status, 'message' => $message];
            return response()->json(["data" => $response, 'message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            // return ['status' => 400, 'message' => $err->getMessage()];
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getStateOrTeleData($request)
    {
        try {
            $response = ProviderContent::where(['provider_id' => $request->user_id, "state_id" => $request->state])->with('getcontentcheckbox')->get()->toArray();
            return response()->json(["data" => $response], 200);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getSuburbs($request)
    {
        try {
            $suburbs = States::where('state_id', $request->state_id)->with('suburbs', function ($q) {
                $q->select('id', 'state', 'suburb');
            })->first();

            $assignedSubrubs = UserSuburb::select('suburb_id')->where('user_id', decryptGdprData($request->provider_id))->get()->pluck('suburb_id')->toArray();
            return response()->json(['suburbs' => $suburbs, 'assignedSubrubs' => $assignedSubrubs]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()]);
        }
    }

    public static function getPostcodeSuburbs($request)
    {
        try {
            $assignedSubrubs = UserSuburb::where('user_id', decryptGdprData($request->provider_id))->where('state_id', $request->state_id)->where('status', 1)->with('subrubs')->get();
            return response()->json(['assignedSubrubs' => $assignedSubrubs]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()]);
        }
    }

    public static function getPostcodePostcodes($request)
    {
        try {
            $postcodes = Postcode::where('suburb', $request->suburb)->get();
            return response()->json(['postcodes' => $postcodes]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to get postcodes.', 'exception' => $err->getMessage()]);
        }
    }

    public static function assignSuburbs($request)
    {
        try {
            UserSuburb::where('user_id', decryptGdprData($request->provider_id))->where('state_id', $request->state_id)->delete();
            $dataToInsert =  [];
            foreach ($request->suburb as $key => $value) {
                $dataToInsert[] = ['user_id' => decryptGdprData($request->provider_id), 'state_id' => $request->state_id, 'suburb_id' => $value, 'status' => 1];
            }
            UserSuburb::insert($dataToInsert);
            return response()->json(['message' => 'Suburb(s) assigned successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()]);
        }
    }

    public static function addSuburbs($request, $user_id)
    {

        try {
            $suburb_id = Postcode::insertGetId([
                'postcode' => $request->postcode,
                'state' => $request->state,
                'suburb' => $request->suburb,
            ]);
            $state = States::select('state_id as id')->where('state_code', $request->state)->first();
            UserSuburb::insert([
                'user_id' => decryptGdprData($user_id),
                'state_id' => $state->id,
                'suburb_id' => $suburb_id,
                'status' => $request->status

            ]);
            return response()->json(['status' => 200, 'message' => 'Suburb added successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to assign suburb.', 'exception' => $err->getMessage()]);
        }
    }

    public static function assignPostcodes($request)
    {
        try {
            UserPostcode::create(['user_id' => decryptGdprData($request->provider_id), 'postcode_id' => $request->assign_postcode_postcode_id,  'status' => 1,]);
            return response()->json(['message' => 'Postcode assigned successfully.'], 200);
        } catch (\Exception $err) {
            // return response()->json(['status' => 400, 'message' => $e->getMessage()],400);
            return response()->json(['message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()], 500);
        }
    }

    public static function changeSuburbStatus($request)
    {
        try {
            UserSuburb::where('id', $request->id)->update(['status' => $request->status]);
            return response()->json(['message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update status.', 'exception' => $err->getMessage()]);
        }
    }

    public static function deleteSuburb($request)
    {
        try {
            UserSuburb::where('id', $request->id)->delete();
            return response()->json(['message' => 'Suburb unassigned successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update status.', 'exception' => $err->getMessage()]);
        }
    }

    public static function changePostcodeStatus($request)
    {
        try {
            UserPostcode::where('id', $request->id)->update(['status' => $request->status]);
            return response()->json(['message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update status.', 'exception' => $err->getMessage()]);
        }
    }

    public static function deletePostcode($request)
    {
        try {
            UserPostcode::where('id', $request->id)->delete();
            return response()->json(['message' => 'Postcode unassigned successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to unassign postcode.', 'exception' => $err->getMessage()]);
        }
    }

    public static function postSaleSubmission($request)
    {
        try {
            $sale_submission = DB::table('provider_sale_submissions')
                ->where(['provider_id' => decryptGdprData($request->provider_id), 'sale_submission_type' => $request->sale_submission_type])
                ->get();
            if (count($sale_submission)) { // update
                $sale_submission = $sale_submission[0];
                DB::table('provider_sale_submissions')
                    ->where(['provider_id' => decryptGdprData($request->provider_id), 'sale_submission_type' => $request->sale_submission_type])
                    ->update([
                        'from_name'            => $request->from_name,
                        'from_email'           => encryptGdprData($request->from_email),
                        'subject'              => $request->subject,
                        'to_email_ids'         => encryptGdprData($request->to_email_ids),
                        'cc_emails_ids'        => encryptGdprData($request->cc_email_ids),
                        'bcc_emails_ids'       => encryptGdprData($request->bcc_email_ids),
                        'updated_at'           => now(),
                    ]);

                DB::table('provider_sale_submission_intervals')
                    ->where('provider_sale_emails_id', $sale_submission->id)
                    ->delete();

                foreach ($request->cor_sale_time as $time) {
                    DB::table('provider_sale_submission_intervals')->insert([
                        'provider_sale_emails_id' => $sale_submission->id,
                        'time'                    => $time,
                    ]);
                }
                // return response()->json(['message'=>'Sale submission updated successfully.']);
                $message = 'Sale submission updated successfully.';
                return self::getSaleSubmission($request->provider_id, $request->sale_submission_type, $message);
            }

            // create
            $sale_submission = DB::table('provider_sale_submissions')->insertGetId([
                'provider_id'          => decryptGdprData($request->provider_id),
                'from_name'            => $request->from_name,
                'from_email'           => encryptGdprData($request->from_email),
                'subject'              => $request->subject,
                'to_email_ids'         => encryptGdprData($request->to_email_ids),
                'cc_emails_ids'        => encryptGdprData($request->cc_email_ids),
                'bcc_emails_ids'       => encryptGdprData($request->bcc_email_ids),
                'sale_submission_type' => $request->sale_submission_type,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            foreach ($request->cor_sale_time as $time) {
                DB::table('provider_sale_submission_intervals')->insert([
                    'provider_sale_emails_id' => $sale_submission,
                    'time'                    => $time,
                ]);
            }
            $message = 'Sale submission added successfully.';
            return self::getSaleSubmission($request->provider_id, $request->sale_submission_type, $message);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to add/update sale submission.', 'exception' => $err->getMessage()]);
        }
    }

    public static function postPasswordProtectedSaleSubmission($request)
    {
        try {
            DB::table('providers')->where('user_id', decryptGdprData($request->provider_id))->update([
                'protected_sale_submission' => $request->status,
                'protected_password' => isset($request->password) && ($request->status == 1) ? encryptGdprData($request->password) : null,
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Password protected sale submission updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update password protected sale submission.', 'exception' => $err->getMessage()]);
        }
    }

    public static function addSftp($request)
    {
        try {
            DB::table('provider_sftps')->insert([
                'provider_id' => decryptGdprData($request->provider_id),
                'destination_name' => encryptGdprData($request->destination_name),
                'auth_type' => $request->auth_type,
                'protocol_type' => $request->protocol_type,
                'remote_host' => encryptGdprData($request->remote_host),
                'port' => $request->port,
                'username' => encryptGdprData($request->username),
                'password' => encryptGdprData($request->password),
                'timeout' => isset($request->timeout) ? $request->timeout : '30',
                'directory' => isset($request->directory) ? encryptGdprData($request->directory) : encryptGdprData('/'),
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['status' => true, 'message' => 'SFTP added successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to add SFTP.', 'exception' => $err->getMessage()]);
        }
    }
    // 23-05-2022
    public static function addConcessionProvider($request)
    {
        try {
            $data = DB::table('provider_concession')->select('provider_id')->where([
                'provider_id' => $request->provider_id
            ])->get();
            if (isset($data) && count($data) > 0) {
                DB::table('provider_concession')->where('provider_id', $request->provider_id)->delete();
            }
            foreach ($request->allowed_concession_state as $val) {
                DB::table('provider_concession')->insert([
                    'provider_id' => $request->provider_id,
                    'state_id' => $val,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Concession Details added successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to add Concession Details.', 'exception' => $err->getMessage()]);
        }
    }
    public static function addConcessionContent($request)
    {
        try {
            $data = DB::table('concession_content')->select('state_id')->where([
                'provider_id' => $request->provider_id,
                'state_id' => $request->state,
                'type' => $request->type,
            ])->get()->toArray();
            if (isset($data) && count($data) > 0) {
                DB::table('concession_content')->where(
                    [
                        'provider_id' => $request->provider_id,
                        'state_id' => $request->state,
                        'type' => $request->type,
                    ]
                )->update([
                    'provider_id' => $request->provider_id,
                    'state_id' => $request->state,
                    'type' => $request->type,
                    'content' => $request->concession_content,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('concession_content')->insert(
                    [
                        'provider_id' => $request->provider_id,
                        'state_id' => $request->state,
                        'type' => $request->type,
                        'content' => $request->concession_content,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            return response()->json(['status' => true, 'message' => 'Concession Details added successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to add Concession Details.', 'exception' => $err->getMessage()]);
        }
    }
    // 23-05-2022
    public static function updateSftp($request)
    {
        try {
            DB::table('provider_sftps')->where('id', $request->sftp_id)->update([
                'provider_id' => decryptGdprData($request->provider_id),
                'destination_name' => encryptGdprData($request->destination_name),
                'auth_type' => $request->auth_type,
                'protocol_type' => $request->protocol_type,
                'remote_host' => encryptGdprData($request->remote_host),
                'port' => $request->port,
                'username' => encryptGdprData($request->username),
                'password' => encryptGdprData($request->password),
                'timeout' => isset($request->timeout) ? $request->timeout : '30',
                'directory' => isset($request->directory) ? encryptGdprData($request->directory) : encryptGdprData('/'),
                'status' => $request->status,
                'updated_at' => now(),
            ]);
            return response()->json(['status' => true, 'message' => 'SFTP updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update SFTP.', 'exception' => $err->getMessage()]);
        }
    }

    public static function updateSftpLog($request)
    {
        try {
            DB::table('providers')->where('user_id', decryptGdprData($request->provider_id))->update([
                // 'sftp_enable' => $request->sftp_enable,
                'log_from_email' => encryptGdprData($request->log_from_email),
                'log_from_name' => encryptGdprData($request->log_from_name),
                'log_subject' => $request->log_subject,
                'log_to_emails' => encryptGdprData($request->log_to_emails),
                'updated_at' => now()
            ]);
            return response()->json(['status' => true, 'message' => 'SFTP log updated successfully.', 'sftp' => $request->all()]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update SFTP log.', 'exception' => $err->getMessage()]);
        }
    }

    public static function getSftps($provider_id)
    {
        $sftps = DB::table('provider_sftps')
            ->where('provider_id', decryptGdprData($provider_id))
            ->orderBy('id', 'desc')
            ->get();
        $sftps = $sftps->transform(function ($item, $key) {
            $item->destination_name = decryptGdprData($item->destination_name);
            $item->remote_host = decryptGdprData($item->remote_host);
            $item->username = decryptGdprData($item->username);
            $item->password = decryptGdprData($item->password);
            $item->directory = decryptGdprData($item->directory);
            return $item;
        });
        return response()->json($sftps);
    }

    public static function deleteSftp($sftp_id)
    {
        try {
            DB::table('provider_sftps')->delete($sftp_id);
            return response()->json(['status' => true, 'message' => 'SFTP deleted successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to delete SFTP.', 'exception' => $err->getMessage()]);
        }
    }

    public static function changeSftpStatus($sftp_id)
    {
        try {
            $status = DB::table('provider_sftps')->where('id', $sftp_id)->pluck('status');
            DB::table('provider_sftps')->where('id', $sftp_id)->update(['status' => !$status[0]]);
            return response()->json(['status' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update status.', 'exception' => $err->getMessage()]);
        }
    }

    public static function changeProviderSftpStatus($user_id)
    {
        try {
            $status = DB::table('providers')->where('id', $user_id)->pluck('sftp_enable');
            DB::table('providers')->where('id', $user_id)->update(['sftp_enable' => !$status[0]]);
            return response()->json(['status' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Unable to update status.', 'exception' => $err->getMessage()]);
        }
    }

    public static function getMoveinDistributors($providerId = null, $energyType = null)
    {
        try {
            if (empty($energyType)) {
                $energyType = 1;
            }
            $response = DB::table('distributors')->select('name', 'id')->where([
                'status' => 1,
                'is_deleted' => 0,
                'energy_type' => $energyType
            ])->get()->toArray();
            $data = [];
            $data['distributor'] = $response;
            $days = ProvderMovein::where([
                'is_deleted' => 0,
                'energy_type' => $energyType,
                'distributor_id' => 0,
                'user_id' => decryptGdprData($providerId)
            ])->get();
            $data['residence'] = [];
            $data['sme'] = [];
            foreach ($days as $row) {
                if ($row->property_type == 1) {
                    array_push($data['residence'], [
                        'id' => $row->id,
                        'grace_day' => $row->grace_day,
                        'restricted_start_time' => $row->restricted_start_time,
                    ]);
                }
                if ($row->property_type == 2) {
                    array_push($data['sme'], [
                        'id' => $row->id,
                        'grace_day' => $row->grace_day,
                        'restricted_start_time' => $row->restricted_start_time,
                    ]);
                }
            }
            return $data;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function providerMovinData($request)
    {
        try { //
            // dd($request->all());
       
            $response = [];
            if (empty($request->residence_id)) {
                $data = ProvderMovein::create([
                    'user_id' => decryptGdprData($request->providerid),
                    'property_type' => 1,
                    'energy_type' => $request->energy_type,
                    'distributor_id' => $request->distributor,
                    'restricted_start_time' => $request->restrict_residence,
                    'grace_day' => $request->day_interval_residenced,
                    'is_deleted' => 0
                ]);
                $response['residence'] = [
                    'id' => $data->id,
                    'grace_day' => $data->grace_day,
                    'name' => 'residence',
                    'restricted_start_time' => $request->restrict_residence,
                ];
            } else {

                $data = DB::table('provider_movein')->where('id', '=', $request->residence_id)->update([
                    'grace_day' => $request->day_interval_residenced,
                    'restricted_start_time' => $request->restrict_residence,
                ]);
                $response['residence'] = [
                    'id' => $request->residence_id,
                    'grace_day' => $request->day_interval_residenced,
                    'name' => 'residence',
                    'restricted_start_time' => $request->restrict_residence,
                ];
            }
            if (empty($request->sme_id)) {

                $data = ProvderMovein::create([
                    'user_id' => decryptGdprData($request->providerid),
                    'property_type' => 2,
                    'energy_type' => $request->energy_type,
                    'distributor_id' => $request->distributor,
                    'grace_day' => $request->day_interval_bussiness,
                    'restricted_start_time' => $request->restrict_bussiness,
                    'is_deleted' => 0
                ]);
                $response['sme'] = [
                    'id' => $data->id,
                    'grace_day' => $data->grace_day,
                    'name' => 'sme',
                    'restricted_start_time' => $request->restrict_bussiness
                ];
            } else {

                DB::table('provider_movein')->where('id', '=', $request->sme_id)->update([
                    'grace_day' => $request->day_interval_bussiness,
                    'restricted_start_time' => $request->restrict_bussiness
                ]);
                $response['sme'] = [
                    'id' => $request->sme_id,
                    'grace_day' => $request->day_interval_bussiness,
                    'restricted_start_time' => $request->restrict_bussiness,
                    'name' => 'sme'
                ];
            }
            return response()->json(['data' => $response, 'message' => "Data has been save successfully", 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function getProviderMovinDetail($request)
    {
        try {
            $query = [];
            if (\Request::has('property_type')) {
                $query['property_type'] = $request->property_type;
            }

            $query['user_id'] = decryptGdprData($request->providerid);
            $query['provider_movein.energy_type'] = $request->energy_type;
            $query['distributor_id'] = $request->distributor;
            $query['provider_movein.is_deleted'] = 0;
            $response = DB::table('provider_movein')
                ->selectRaw('provider_movein.*,distributors.name')
                ->leftJoin("distributors", "distributors.id", "=", "provider_movein.distributor_id")
                ->where($query)->get()->toArray();
            $requestType = '';
            if (\Request::has('requestType')) {
                $requestType = $request->requestType;
            }
            $providerContent =  ProvderMovein::select('id')->where(['user_id' => decryptGdprData($request->providerid)])->with(['getMoveinCheckbox' => function ($q) use ($requestType) {
                $q->where('type', '=', $requestType);
            }])->get()->toArray();

            // $providerContent = ProvderMovein::select('id')->where(['user_id' => decryptGdprData($request->providerid)])->with('getMoveinCheckbox')->get()->toArray();
            // $response = DB::table('provider_movein')->where($query)->get()->toArray();

            return response()->json(["data" => $response, 'providerContent' => $providerContent, 'message' => "Data has been fetched successfully", 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function saveEicContentData($request)
    {
        try {
            $query = DB::table('provider_movein')->select('id')->where([
                'property_type' => $request->property_type,
                'user_id' => decryptGdprData($request->providerid),
                'distributor_id' => $request->distributor,
                'energy_type' => $request->energy_type,
                'is_deleted' => 0,
            ])->get()->toArray();
            $update = [];
            $update['property_type'] = $request->property_type;
            $update['user_id'] = decryptGdprData($request->providerid);
            $update['distributor_id'] = $request->distributor;
            $update['is_deleted'] = 0;
            $update['energy_type'] = $request->energy_type;

            if (\Request::has('move_in_eic_content')) {
                $update['move_in_eic_content'] = $request->move_in_eic_content;
                $update['move_in_eic_content_status'] = $request->move_in_eic_content_status;
            }
            if (\Request::has('move_in_content')) {
                $update['move_in_content'] = $request->move_in_content;
                $update['move_in_content_status'] = $request->movin_status;
            }

            $response = ProvderMovein::updateOrCreate(['id' => isset($query[0]->id) ? $query[0]->id : ""], $update);
            return response()->json(["data" => $response->id, 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getSaleSubmission($provider, $type, $message = null)
    {
        try {
            $saleSubmission =  DB::table('provider_sale_submissions')
                ->where('provider_id', decryptGdprData($provider))
                ->where('sale_submission_type', $type)
                ->get();
            if (count($saleSubmission)) {
                $saleSubmission = $saleSubmission[0];
                $saleSubmission->from_email = decryptGdprData($saleSubmission->from_email);
                $saleSubmission->from_name = $saleSubmission->from_name;
                $saleSubmission->to_email_ids = decryptGdprData($saleSubmission->to_email_ids);
                $saleSubmission->cc_emails_ids = decryptGdprData($saleSubmission->cc_emails_ids);
                $saleSubmission->bcc_emails_ids = decryptGdprData($saleSubmission->bcc_emails_ids);
                $saleSubmission->provider_encrypted = encryptGdprData($saleSubmission->provider_id);

                $data['sale_submission'] = $saleSubmission;

                $data['intervals'] = DB::table('provider_sale_submission_intervals')->where('provider_sale_emails_id', $saleSubmission->id)->get();
                $data['status'] = 200;
                $data['message'] = $message;
            } else {
                $data['status'] = 204;
            }
            return response()->json($data);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function saveEditCustomField($request)
    {
        try {
            $data = [];
            $data['user_id'] = $request->user_id;
            $data["section_id"] = $request->section_id;
            if ($request->form_request == 'personal_form') {
                $data['label']         = $request->custom_field_label;
                $data["placeholder"]   = $request->custom_field_placeholder;
                $data["message"]       = $request->custom_field_message;
                $data['mandatory']     = $request->custom_field_mandatory;
            }
            if ($request->form_request == 'connection_form') {
                $data['question']      = $request->connection_custom_field_quest;
                $data['message']       = $request->connection_custom_field_message;
                $data['answer_type']   = $request->connection_custom_field_type;
                $data['mandatory']     = $request->connection_custom_field_mandatory;
                if ($data['answer_type'] == 2) {
                    $data['count'] = $request->connection_custom_field_count;
                }
            }
            $response = SectionCustomFields::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            if ($response) {
                $response = SectionCustomFields::with(['customPlanSection' => function ($q) {
                    $q->select('provider_section_custom_fields_id', 'plan_id');
                }])->where([
                    "user_id" => $request->user_id,
                    "section_id" => $request->section_id,
                ])->get()->toArray();
                return response()->json(["message" => "Data has been saved", "data" => $response, 'status' => 200]);
            }
            return response()->json(["message" => "Something went wrong", 'status' => 500]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function deleteEditCustomField($request)
    {
        try {
            $response = SectionCustomFields::where([
                'id' => $request->id
            ])->delete();
            if ($response) {
                ProviderFieldPlan::where(['provider_section_custom_fields_id' => $request->id])->delete();
                return response()->json(["message" => "Data has been deleted Successfully", 'status' => 200]);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getPlans($request)
    {
        try {
            $service = Providers::where('user_id', $request->user_id)->first()->service_id;
            $plans = [];
            if ($service == 1) {
                $plans = PlanEnergy::where('provider_id', $request->user_id)->pluck('name', 'id');
            } else if ($service == 2) {
                $plans = PlanMobile::where('provider_id', $request->user_id)->pluck('name', 'id');
            } else if ($service == 3) {
                $plans = PlansBroadband::where('provider_id', $request->user_id)->pluck('name', 'id');
            }
            return response()->json(["message" => "success", "data" => $plans, 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function assignPlanToField($request)
    {
        try {
            ProviderFieldPlan::where(['user_id' => $request->user_id, 'provider_section_custom_fields_id' => $request->id])->delete();
            if (isset($request->options)) {
                $options = array_map('intval', explode(',', $request->options));
                $data = [];
                foreach ($options as $option) {
                    array_push($data, [
                        'user_id'                           => $request->user_id,
                        'plan_id'                           => $option,
                        'provider_section_custom_fields_id' => $request->id,
                        'created_at'                        => Carbon::now(),
                        'updated_at'                        => Carbon::now()
                    ]);
                }
                ProviderFieldPlan::insert($data);
            }
            $response = SectionCustomFields::with(['customPlanSection' => function ($q) {
                $q->select('provider_section_custom_fields_id', 'plan_id');
            }])->where([
                "user_id" => $request->user_id,
                "section_id" => 1,
            ])->get()->toArray();
            return response()->json(["message" => "success", 'data' => $response, 'status' => 200]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    static public function getCategory($request)
    {
        try {
            
            $providerCategory = DB::table('provider_logos')->where(['user_id' => $request->provider_id])->pluck('category_id')->toArray();
            $allCategory = LogoCategory::where(['status' => 1])->whereNotIn('id',$providerCategory)->get()->toArray();
              
            return $allCategory;
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    static public function saveProviderLogo($request)
    {
        try {
            $file = $request->Logo;
            if ($file) {
                $s3fileName = $request->provider_id;
                $s3fileName =  str_replace("<pro-id>", $s3fileName, config('env.PROVIDER_LOGO'));
                $name = time() . $file->getClientOriginalName();
                $s3fileName = config('env.DEV_FOLDER') . $s3fileName . $name;
                uploadFile($s3fileName, file_get_contents($file), 'public');
            }
            if ($request->has('id')) {
                $data = [];
                $data['category_id'] = $request->category_id;
                $data['description'] = $request->logo_description;
                if ($file) {
                    $data['name'] = $name;
                }
                ProviderLogo::where('id', $request->id)->update($data);
            } else {
                ProviderLogo::create([
                    'user_id'       => $request->provider_id,
                    'category_id'   => $request->category_id,
                    'name'          => $name,
                    'description'   => $request->logo_description,
                    'status'        => 1
                ]);
            }

            $data = self::getProviderLogo($request->provider_id);
            return response()->json(["message" => "Logo has been saved successfully", 'data' => $data, 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }
    static public function getProviderLogo($provider_id)
    {
        return  ProviderLogo::select('logo_categories.title', 'provider_logos.*')
            ->join('logo_categories', 'logo_categories.id', 'provider_logos.category_id')
            ->where('provider_logos.user_id', $provider_id)->get()->toArray();
    }

    public static function getAllEquipments()
    {
        try {
            return DB::table('life_support_equipments')->where('status', 1)->select('id', 'title')->get();
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getProviderEquipments($provider_id)
    {
        try {
            return DB::table('provider_equipments')->select('provider_equipments.id', 'provider_equipments.life_support_equipment_id', 'provider_equipments.provider_id', 'life_support_equipments.title', 'provider_equipments.status', 'provider_equipments.order')
                ->join('life_support_equipments', 'life_support_equipments.id', 'provider_equipments.life_support_equipment_id')
                ->where('life_support_equipments.status', 1)
                ->where('provider_equipments.provider_id', decryptGdprData($provider_id))
                ->orderBy('provider_equipments.order', 'asc')
                ->orderBy('life_support_equipments.title', 'asc')
                ->get();
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function assignEquipment($request)
    {
        \DB::beginTransaction();
        try {
            $data = [];
            $response = '';
            $status = 'true';
            $data['provider_id'] = $request->user_id;
            $data['order'] = $request->order;
            $data['status'] = $request->status;
            $data['life_support_equipment_id'] = $request->equipment;

            if (!$data) {
                $status = 'false';
            } else {
                ProviderEquipment::updateOrCreate(['provider_id' => $request->user_id, 'id' => $request->equipment_id], $data);
                $response = DB::table('provider_equipments')->select('provider_equipments.id', 'provider_equipments.provider_id', 'provider_equipments.life_support_equipment_id', 'life_support_equipments.title', 'provider_equipments.status', 'provider_equipments.order')
                    ->join('life_support_equipments', 'life_support_equipments.id', 'provider_equipments.life_support_equipment_id')
                    ->where('life_support_equipments.status', 1)
                    ->where('provider_equipments.provider_id', $request->user_id)
                    ->orderBy('provider_equipments.order', 'asc')
                    ->orderBy('life_support_equipments.title', 'asc')
                    ->get();
            }

            if ($status == 'true') {
                \DB::commit();
                $http_status = 200;
                $message = trans('providers.provider_created');
            } else {
                \DB::rollback();
                $http_status = 400;
                $message = trans('providers.provider_notcreated');
            }
            return response()->json(["data" => $response, 'message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function deleteEquipment($request, $id)
    {
        try {
            $response = ProviderEquipment::where('id', $id)->delete();
            if ($response) {
                $response = DB::table('provider_equipments')->select('provider_equipments.id', 'provider_equipments.provider_id', 'provider_equipments.life_support_equipment_id', 'life_support_equipments.title', 'provider_equipments.status', 'provider_equipments.order')
                    ->join('life_support_equipments', 'life_support_equipments.id', 'provider_equipments.life_support_equipment_id')
                    ->where('life_support_equipments.status', 1)
                    ->where('provider_equipments.provider_id', $request->provider_id)
                    ->orderBy('provider_equipments.order', 'asc')
                    ->orderBy('life_support_equipments.title', 'asc')
                    ->get();
                $http_status = 200;
                $message = 'Equipment deleted successfully';
            } else {
                $http_status = 400;
                $message = 'Error deleting equipment';
            }
            // return ['status' => $http_status, 'message' => $message];
            return response()->json(["data" => $response, 'message' => $message, 'status' => $http_status]);
        } catch (\Exception $err) {
            \DB::rollback();
            // return ['status' => 400, 'message' => $err->getMessage()];
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function changeEquipmentStatus($id)
    {
        try {
            $equipment = ProviderEquipment::where('id', $id)->first();
            $equipment->update(['status' => !$equipment->status]);
            return response()->json(['message' => 'Status changed successfully', 'status' => true]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
    public static function checkUserGetPermission($request){

        try {
            $exist_data = ProviderPermission::where('user_id', $request->user_id)->first();
            if(!empty($exist_data)){
                return response()->json(['message' => 'Success', 'status' => true]);

            }
            return response()->json(['message' => 'Plan/Permission does not exist', 'status' => false]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}