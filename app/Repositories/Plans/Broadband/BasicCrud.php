<?php
namespace App\Repositories\Plans\Broadband; 
use App\Models\{
        Providers,
        PlansBroadband,
        PlansTelcoContent, 
        PlansBroadbandAddon,
        PlansBroadbandEicContent,
        PlansBroadbandContentCheckbox,
        PlansBroadbandTechnology,
        PlanAddonsMaster
    }; 

use DB;
trait BasicCrud
{   
    /**
     *get a listing of the broadband plans.
     *
     * @return Array
     */
    public static function getPlanListing($request,$userPermissions,$appPermissions)
    {
        try
        {
            $plans = PlansBroadband::select('id','connection_type','name','provider_id','status')->with('connectionData')->where('provider_id',decryptGdprData($request->providerId));
            $plans = self::filter($plans,$request->all());  
            $filterVars = $request->only('name','connectionType','status'); 
            $providerUser = Providers::where('user_id' , decryptGdprData($request->providerId))
                        ->with(['user' => function ($query) {
                            $query->select(['id','email','phone']);
                        }])
                        ->select(['id','user_id','name'])->get()->toArray(); 
            $connectionTypes = self::getConnectionType(); 
            $selectedProvider = Providers::with([
                'providersLogo' => function($query){
                    $query->select('user_id','name','category_id');
                },
            ])->where('user_id',decryptGdprData($request->providerId))->first();
            return ['compact' => compact('providerUser','plans','connectionTypes','filterVars','selectedProvider','userPermissions','appPermissions')];
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /*
    *  filter plan listing based on filter selected.
    *
    *  @return Collection object
    */
    public static function filter($model, $inputs)
    {
        try
        { 
            $filter = ['status' => 1];
            if (isset($inputs['status'])) {
                $filter = [];
                if($inputs['status'] != 2)
                {
                    $filter['status'] = $inputs['status'];
                }
            } 
            $model = $model->where($filter);  
            if (isset($inputs['connectionType'])) {
                $model = $model->where('connection_type', $inputs['connectionType']);
            } 
            if (isset($inputs['name'])) {
                $model = $model->where('name', 'like', "%" . $inputs['name'] . "%");
            }
            return $model->get();
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get data from database for create plan .
     *
     * @return Array
     */
    public static function getCreatePlan($request)
    { 
        try
        {
            $providerUser = Providers::where('user_id' , decryptGdprData($request->providerId))
                        ->with(['user' => function ($query) {
                            $query->select(['id','email','phone']);
                        }])->select(['id','user_id','name'])->get()->toArray(); 
            if(!count($providerUser))
            {
                return redirect('/');
            }
            $connectionTypes = self::getConnectionType(); 
            $technologyTypes = $assignedTechnolgy = [];
            $contracts = self::getContracts(); 
            $dataLimit = config('broadbandPlan.data_limit'); 
            $costTypes = self::getCostTypes(); 
            $feeTypes = self::getFeeTypes(); 
            $type = ADD_BROADBAND_PLAN;
            $plan = null;
            $selectedProvider = Providers::where('user_id',decryptGdprData($request->providerId))->first();
            $dataUnit = config('broadbandPlan.data_unit');
            return ['compact' => compact('providerUser','type','plan','connectionTypes','contracts','dataLimit','costTypes','feeTypes','technologyTypes','assignedTechnolgy','selectedProvider','dataUnit')];
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get data from database for edit plan .
     *
     * @param  int  $planId
     * @return Array
     */
    public static function getEditPlan($planId)
    {
        try
        {
            $planId = decryptGdprData($planId);
            $plan = PlansBroadband::with(['technologies','terms','planEicContents','planEicContentCheckbox','planFees','planFees.feeType','planFees.costType'])->where('id',$planId)->first(); 
            if(!isset($plan))
            {
                return redirect('/');
            }
            $providerUser = Providers::where('user_id' , $plan->provider_id)
                        ->with(['user' => function ($query) {
                            $query->select(['id','email','phone']);
                        }])
                        ->select(['id','user_id','name'])->get()->toArray(); 
            $connectionTypes = self::getConnectionType(); 
            $technologyTypes =  self::getTechType($plan->connection_type); 
            $assignedTechnolgy = array_column($plan->technologies->toArray(),'id');
            $contracts = self::getContracts(); 
            $dataLimit = config('broadbandPlan.data_limit'); 
            $costTypes = self::getCostTypes();
            $feeTypes = self::getFeeTypes();
            $type = EDIT_BROADBAND_PLAN;
            $phoneHomeConnection = self::getHomeConnection($plan->provider_id);
            $broadbandModem = self::getModems($plan->connection_type,$assignedTechnolgy);
            $additionalAddons = self::getAddons(); 
            $defaultIncludedAddon = PlansBroadbandAddon::whereIn('category',[HOME_CONNECTION_CATEGORY ,MODEM_CATEGORY ,ADDON_CATEGORY])->where('is_default','1')->where('plan_id', $planId)->get()->groupBy('category')->toArray();
            //dd($defaultIncludedAddon);
            $otherAddons = self::getOtherAddonData($phoneHomeConnection,$additionalAddons,$broadbandModem,$planId);  
            $selectedProvider = Providers::where('user_id',$plan->provider_id)->first();
            $dataUnit = config('broadbandPlan.data_unit'); 
            return ['compact' => compact('providerUser','type','plan','connectionTypes','contracts','dataLimit','costTypes','feeTypes','technologyTypes','phoneHomeConnection','additionalAddons','broadbandModem','assignedTechnolgy','defaultIncludedAddon','otherAddons','selectedProvider','dataUnit')];
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get data from database for edit plan .
     *
     * @param  int  $planId
     * @return Array
     */
    public static function getOtherAddonData($phoneHomeConnection,$additionalAddons,$broadbandModem,$planId)
    { 
        try{
            $otherPhoneHomeLine = $phoneHomeConnection->toArray();    
            $otherAddonModem = $broadbandModem->toArray();
            $otherAddon = $additionalAddons->toArray(); 
            $assignAddonsList = PlansBroadbandAddon::whereIn('category',[HOME_CONNECTION_CATEGORY ,MODEM_CATEGORY ,ADDON_CATEGORY])->where('plan_id', $planId)->get()->groupBy(['is_default']);  
            
            $assignedinclAddons = isset($assignAddonsList[1])? $assignAddonsList[1]->groupBy('category'): []; 
            $defaultHome = isset($assignedinclAddons[3])? $assignedinclAddons[3][0]['addon_id'] :0;
            $defaultModem = isset($assignedinclAddons[4])? $assignedinclAddons[4][0]['addon_id'] :0;
            $defaultAddon = isset($assignedinclAddons[5])? $assignedinclAddons[5][0]['addon_id'] :0;  
            $assignedOtherAddons = isset($assignAddonsList[0])? $assignAddonsList[0]->groupBy(['category','addon_id'])->toArray(): [];  
            $resultHomeConnection = self::getOtherPhoneHomeConnection($otherPhoneHomeLine,$defaultHome,$assignedOtherAddons); 
            $resultModem = self::getModemConnection($otherAddonModem,$defaultModem,$assignedOtherAddons); 
            $resultAddon = self::getOtherAddonConnection($otherAddon,$defaultAddon,$assignedOtherAddons); 
            return ['homeConnection' => $resultHomeConnection ,'modem' =>$resultModem ,'addon' => $resultAddon];
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get list of all home line connection with values.
     * 
     * @return Array
     */
    public static function getOtherPhoneHomeConnection($otherPhoneHomeLine,$defaultHome,$assignedOtherPhone)
    {
        try
        {
            $assignedOtherPhone = isset($assignedOtherPhone[3])?$assignedOtherPhone[3] :[];
            $resultHomeConnection = [];
            foreach ($otherPhoneHomeLine as $value) {
                if($value['id'] == $defaultHome)
                    continue;
                $value['exist'] = 0;
                if(isset($assignedOtherPhone[$value['id']])){
                    $value['exist'] = 1;
                }
                array_push($resultHomeConnection,$value);
            }
            return $resultHomeConnection;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get list of all modems with values.
     * 
     * @return Array
     */
    public static function getModemConnection($otherAddonModem,$defaultModem,$assignedOtherModem)
    {
        try
        {
            $assignedOtherModem = isset($assignedOtherModem[4])?$assignedOtherModem[4] :[];
            $resultModem = [];
            foreach ($otherAddonModem as $value) {
                if($value['id'] == $defaultModem)
                    continue;
                $value['exist'] = 0;
                $value['cost_type_id'] = 0;
                $value['price'] = 0.00;
                $value['script'] = '';
                if(isset($assignedOtherModem[$value['id']])){
                    $value['cost_type_id'] = $assignedOtherModem[$value['id']][0]['cost_type_id'];
                    $value['price'] = $assignedOtherModem[$value['id']][0]['price'];
                    $value['script'] = $assignedOtherModem[$value['id']][0]['script']; 
                    $value['exist'] = 1;
                }
                array_push($resultModem,$value);
            }
            return $resultModem;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * get list of all addons with values.
     * 
     * @return Array
     */
    public static function getOtherAddonConnection($otherAddon,$defaultAddon,$assignedOtherAddon)
    {
        try
        {
            $assignedOtherAddon = isset($assignedOtherAddon[5])?$assignedOtherAddon[5] :[];
            $resultAddon = [];
            foreach ($otherAddon as $value) {
                if($value['id'] == $defaultAddon)
                    continue;
                $value['exist'] = 0;
                $value['cost_type_id'] = 0;
                $value['price'] = 0.00;
                $value['script'] = '';
                if(isset($assignedOtherAddon[$value['id']])){
                    $value['cost_type_id'] = $assignedOtherAddon[$value['id']][0]['cost_type_id'];
                    $value['price'] = $assignedOtherAddon[$value['id']][0]['price'];
                    $value['script'] = $assignedOtherAddon[$value['id']][0]['script']; 
                    $value['exist'] = 1;
                }
                array_push($resultAddon,$value);
            }
            return $resultAddon;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * save the bradband plan form.
     *
     * @param  int  $providerId
     * @return Boolean
     */
    public static function insertPlan($request,$providerId)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->only('name','contract_id','connection_type','technology_type','satellite_inclusion','inclusion','connection_type_info','internet_speed','internet_speed_info','plan_cost_type_id','plan_cost','plan_cost_info','plan_cost_description','nbn_key','is_boyo_modem','billing_preference');
            $data['provider_id'] =decryptGdprData($providerId);
            $data['version'] =1; 
            $plan = PlansBroadband::create($data);
            if($plan && $request->has('tech_type')) {
                $insertTech =[];
                foreach ($request->tech_type as $value) {
                    $insertTech[] = [
                                'plan_id'=>$plan->id,
                                'technology_id'=>$value, 
                               ];
                }
                PlansBroadbandTechnology::insert($insertTech); 
            }
            self::generatePlanTermsContent($plan->id);
            $nbnKey = self::createNbnKeyFacts($request,$plan->id); 
            PlansBroadband::where('id', $plan->id)->update($nbnKey);
            DB::commit();
            return true;
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }

    /**
     * save broadband plan plans term and condition while adding a new plan.
     *
     * @return Boolean
     */
    public static function generatePlanTermsContent($planId)
    {
        try
        {
            $plan_terms = config('broadbandPlan.plan_terms');
            $insertData = [];
            foreach ($plan_terms as $key => $value) {
                $array = [];
                $array['plan_id'] = $planId;
                $array['title'] = $value;
                $array['slug'] = $key;
                $array['service_id'] = 3;
                $array['description'] = '';
                $array['status'] = 1;
                $array['created_at'] = \Carbon\Carbon::now();
                $array['updated_at'] = \Carbon\Carbon::now();
                $insertData[] = $array;
            }
            return PlansTelcoContent::insert($insertData);
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * update the broadband plan form.
     * 
     * @return Array
     */
    public static function updatePlan($request)
    {
        try
        {
            DB::beginTransaction();
            $formType = $request->formType;
            $addondata = '';
            if($formType == 'basic_details_form')
            {
                $data = $request->only('name','contract_id','connection_type','technology_type','satellite_inclusion','inclusion','connection_type_info','internet_speed','internet_speed_info','plan_cost_type_id','plan_cost','plan_cost_info','plan_cost_description','nbn_key','is_boyo_modem','billing_preference');  
                $planId = decryptGdprData($request->plan_id);  
                $plan = PlansBroadband::select('id','provider_id','connection_type')->where('id',$planId)->first();
                $nbnKey = self::createNbnKeyFacts($request,$planId);
                $data['nbn_key_url'] = $nbnKey['nbn_key_url'];
                $addondata = self::getAddondata($request,$plan->provider_id,$plan);
                self::updatePlanTechType($request,$planId);
            }
            else if($formType == 'plan_info_form')
            {
                $data = $request->only('download_speed','upload_speed','typical_peak_time_download_speed','data_limit','speed_description','additional_plan_information','plan_script'); 
            }
            else if($formType == 'plan_data_form')
            {
                $data = $request->only('data_unit_id','total_data_allowance','off_peak_data','peak_data'); 
            }
            else if($formType == 'critical_information_form')
            {
                $data = self::storeCriticalInfo($request,$request->plan_id); 
            }
            else if($formType == 'remarketing_informatio_form')
            {
                $data = $request->only('remarketing_allow'); 
            }
            else if($formType == 'special_offer_form')
            {
                $data = $request->only('special_offer_status');
                if($request->special_offer_status == 1)
                {
                    $data = $request->only('special_offer_status','special_cost_id','special_offer_price','special_offer');
                }
            }
            $response = PlansBroadband::where('id',decryptGdprData($request->plan_id))->update($data);
            DB::commit();
            return ['status' => $response,'plan_data' => $data, 'addondata' => $addondata];
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }
    
    /**
     * get included and other addons data.
     * 
     * @return Array
     */
    public static function getAddondata($request,$providerId,$plan)
    {
        try{
            $status = 'yes';
            if($plan->connection_type == $request->connection_type)
            {
                $techTypes = isset($request->tech_type)?$request->tech_type:[];
                $oldTechTypes = array_column($plan->technologies->toArray(),'id');  
                $result = array_diff($techTypes,$oldTechTypes) == array_diff($oldTechTypes,$techTypes);
                if ($result) {
                    $status = "no";
                } 
                if(!$result && count($techTypes) > 0)
                {   
                    $addonMasterId = PlanAddonsMaster::with('technologies')->where('category','4')->whereHas('technologies', function($q) use($techTypes){
                        $q->whereIn('tech_type', $techTypes);
                    })->pluck('id')->toArray(); 
                    PlansBroadbandAddon::where('category',MODEM_CATEGORY)->where('plan_id', $plan->id)->whereNotIn('addon_id',$addonMasterId)->delete();
                }  
            }
            else
            {
                PlansBroadbandAddon::where('category',MODEM_CATEGORY)->where('plan_id', $plan->id)->delete();
            } 
            $phoneHomeConnection = self::getHomeConnection($providerId);
            $broadbandModem = self::getModems($request->connection_type,$request->tech_type);
            $additionalAddons = self::getAddons();   
            $otherAddons = self::getOtherAddonData($phoneHomeConnection,$additionalAddons,$broadbandModem,$plan->id);
            return ['connenction_change' => $status, 'phoneHomeConnection' => $phoneHomeConnection, 'broadbandModem' =>$broadbandModem , 'additionalAddons' =>$additionalAddons, 'otherAddons' => $otherAddons];
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }

    /**
     * update plan tech type.
     * 
     * @return Boolean
     */
    public static function updatePlanTechType($request,$planId)
    {
        try{
            if($request->has('tech_type')) {
                $selectedTech =  $request->tech_type;
                $assignTech = PlansBroadbandTechnology::where('plan_id',$planId)->pluck('technology_id')->toArray(); 

                $deleteTechs=array_diff($assignTech,$selectedTech); 
                $insertTechs = array_diff($selectedTech,$assignTech);

                PlansBroadbandTechnology::where('plan_id',$planId)->whereIn('technology_id',$deleteTechs)->delete();
                $insertTech =[];
                foreach ($insertTechs as $value) {
                    $insertTech[] = [
                                'plan_id' => $planId,
                                'technology_id' => $value, 
                               ];
                }
                PlansBroadbandTechnology::insert($insertTech); 
                return true;
            }  
            PlansBroadbandTechnology::where('plan_id',$planId)->delete();
            return true;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }
    /**
     * create nbn key facts.
     * 
     * @return Array
     */
    public static function createNbnKeyFacts($request,$planId)
    {
        try{
            $response['nbn_key_url'] = trim($request->nbn_key_url);
            if($request['nbn_key'] == '2')
            {
                $file = $request->nbn_key_file;
				$s3fileName = 'plan/broadband/'.$planId.'/nbn_key/document/';
				$name = time() . $file->getClientOriginalName();
				\Storage::disk('s3')->put($s3fileName . '/' . $name, file_get_contents($file), 'public');
				$response['nbn_key_url'] = "https://" . config('env.AWS_BUCKET') . ".s3." . config('env.DEFAULT_REGION') . ".amazonaws.com/" . $s3fileName . $name; 
            }
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * store critical info file on s3 bucket.
     * 
     * @return Array
     */
    public static function storeCriticalInfo($request,$planId)
    {
        try{
            $planId = decryptGdprData($planId); 
            $url = trim($request->critical_info_url);
            if($request['critical_info_type'] == '2')
            {
                $file = $request->critical_info_file;
				$s3fileName = 'plan/broadband/'.$planId.'/critical_info/document/';
				$name = time() . $file->getClientOriginalName(); 
				\Storage::disk('s3')->put($s3fileName . '/' . $name, file_get_contents($file), 'public');   
				$url = "https://" . config('env.AWS_BUCKET') . ".s3." . config('env.DEFAULT_REGION') . ".amazonaws.com/" . $s3fileName . $name;   
            } 
            $response['critical_info_type'] = $request->critical_info_type;
            $response['critical_info_url'] = $url;
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * update the included addons data.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updateIncludedAddonRepo($request)
    {
        try
        {
            DB::beginTransaction();
            $planId = decryptGdprData($request->plan_id);
            $existDefaultAddons = PlansBroadbandAddon::where('plan_id',$planId)->where('category',$request->category)->get(); 
            $updateId = $nonDefaultId = '';
            foreach ($existDefaultAddons as $value) {
                if($value->is_default == 1){
                    $updateId = $value->id;            
                }
                else if($value->addon_id == $request->addon_id && $value->is_default == 0) {                    
                    $nonDefaultId = $value->id;
                }
            } 
            $result = self::updateIncludedAddonData($request,$updateId,$nonDefaultId,$planId);
            //get all master table data for broadband plans
            $plan = PlansBroadband::select('id','provider_id','connection_type')->where('id',$planId)->first(); 
            $phoneHomeConnection = self::getHomeConnection($plan->provider_id);
            $assignedTechnolgy = array_column($plan->technologies->toArray(),'id');
            $broadbandModem = self::getModems($plan->connection_type,$assignedTechnolgy);
            $additionalAddons = self::getAddons(); 
            $otherAddons = self::getOtherAddonData($phoneHomeConnection,$additionalAddons,$broadbandModem,$planId);
            DB::commit();
            return response()->json(['status' => $result , 'message' => trans('plans/broadband.default_addon_toastr') , 'otherAddons' => $otherAddons]);
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }

    public static function updateIncludedAddonData($request,$updateId,$nonDefaultId,$planId)
    {
        try
        { 
            $result = true;
            if($request->status) {
                $data = $request->only(['addon_id','cost_type_id','price','script','status','is_mandatory']);
                $data['is_default'] = 1; 
                if($updateId != ''){                    
                    $result = PlansBroadbandAddon::where('id',$updateId)->update($data);
                    if($nonDefaultId != ''){
                        $result = PlansBroadbandAddon::where('id',$nonDefaultId)->delete();
                    }
                } 
                else {
                    if($nonDefaultId != '' ){
                        $result = PlansBroadbandAddon::where('id',$nonDefaultId)->update($data);
                    } 
                    else {
                        $data['plan_id'] = $planId;
                        $data['category'] = $request->category;
                        $result = PlansBroadbandAddon::create($data);
                    } 
                }
            }
            else if($updateId != '')
            { 
                $result = PlansBroadbandAddon::where('id',$updateId)->delete(); 
            } 
            return $result;
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }
    /**
     * update the plan term and condition.
     * 
     * @return Boolean
     */
    public static function updateTermConditionRepo($request)
    {
        try
        {
            $data =[
                'title' => ucwords($request->input('title')),
                'description' => $request->input('term_title_content')
            ];  
            $response = PlansTelcoContent::where('id',$request->id)->update($data); 
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }
    
    /** 
     * update the plan EIC content.
     * 
     * @return Boolean
     */
    public static function updateEicContentRepo($request)
    {  
        try
        {
            $planId = decryptGdprData($request->plan_id); 
            $planEic['type'] = 1;
            $planEic['content'] = $request->content;
            $planEic['status'] = $request->status;
            $response = PlansBroadbandEicContent::updateOrCreate(['plan_id' => $planId],$planEic);
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     * update the EIC content checkbox.
     * 
     * @return Array
     */
    public static function updateEicContentCheckboxRepo($request)
    {
        try
        {
            $planId = decryptGdprData($request->plan_id);
            $planEic = [
                        'type' => '1',
                        'plan_id'=>  $planId,
                        'required'=>$request->required,
                        'status'=> $request->status,
                        'content' => $request->checkbox_content,
                        'validation_message' => $request->validation_message??''
                    ];
            $checkboxId = $request->checkbox_id;
            $contentLheckboxList = PlansBroadbandContentCheckbox::where('plan_id','=',$planId)->where('type',1);
            if($request->has('action') && ($request->action == 'add' || $request->action == 'edit')){
                PlansBroadbandContentCheckbox::updateOrCreate(['id' => $checkboxId],$planEic);
                $response['data'] = array('status'=>true,'message'=> trans('plans/broadband.content_checkbox_add_toastr') ,'checboxList' => $contentLheckboxList->get()); 
                $response['status'] = 200;
                return $response;
            } 
            $response['data'] = array('success'=>'true','message' => trans('plans/broadband.server_error_toastr') ,'checboxList' => $contentLheckboxList->get());
            $response['status'] = 400;
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

     /**
     * delete the plan EIC content checkbox.
     * 
     * @return Array
     */
    public static function deleteEicContentCheckboxRepo($request)
    {   
        try
        {
            $checkboxId = $request->checkbox_id;
            $planId = decryptGdprData($request->plan_id);
            $deleteEic = PlansBroadbandContentCheckbox::where('id',$checkboxId)->delete();   
            $contentLheckboxList = PlansBroadbandContentCheckbox::where('plan_id','=',$planId)->where('type',1)->get();
            if($deleteEic)
            {
                $response['data'] = array('success'=>true,'message' => trans('plans/broadband.content_checkbox_delete_toastr') ,'checboxList' => $contentLheckboxList); 
                $response['status'] = 200;
                return $response;
            }
            $response['data'] = array('success'=>true,'message'=> trans('plans/broadband.content_checkbox_not_delete_toastr') ,'checboxList' => $contentLheckboxList); 
            $response['status'] = 400;
            return $response;
        }
        catch (\Exception $err) {
            throw $err;
        }
    }

    /**
     *store other addons in database.
     * 
     * @return Boolean
     */
    public static function saveOtherAddonRepo($request)
    {   
        try{
            DB::beginTransaction();
            $planId = decryptGdprData($request->plan_id);
            PlansBroadbandAddon::where('plan_id',$planId)->where('category',$request->category)->where('is_default','0')->delete();
            $data =[];
            if(isset($request->addon_id) && count($request->addon_id)){
                $data = $request->addon_id;
                $cost_type_id=$request->cost_type;
                $price=$request->amount;
                $script=$request->script;
            } 
            $addonData =[];
            foreach ($data as $key => $value) {
                $addonData[] = [
                    'plan_id' => $planId,
                    'addon_id'=>$value,
                    'category'=>$request->category,
                    'cost_type_id'=>isset($cost_type_id[$key]) ? $cost_type_id[$key] : 0,
                    'price'=>isset($price[$key]) ? $price[$key] : 0,
                    'script'=>isset($script[$key]) ? $script[$key] : '',
                    'status'=>'1',
                    'is_default'=>'0',
                    'is_mandatory'=>'0'
                ];
            }  
            $planInfo = PlansBroadbandAddon::insert($addonData);  
            DB::commit();
            return $planInfo;
        }
        catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }
    }

    /**
     *store other addons in database.
     * 
     * @return Boolean
     */
    public static function changeStatusRepo($request)
    {   
        try
        {
            $planId = decryptGdprData($request->id);
            return PlansBroadband::where('id', $planId)->update(['status' => $request['status']]);
        }
        catch (\Exception $err) { 
            throw $err;
        }
    }
}


