<?php
namespace App\Repositories\Plans\Mobile\Uploads;
use App\Models\{ConnectionType,CostType,PlanMobile,Contract}; 
use Carbon\Carbon; 
use Config;
use DB;
trait PlanUpload
{ 
	/**
     * validate sheet data
     */
    public static function validatePlan($data,$key,$energyType)
	{
	
		try
		{
			$errors =[];
			
			$columns = ['Plan Name','Connection Type','Plan Type','Plan Cost Type','Monthly Plan Cost','Data per Month' , 'Plan Data Unit', 'Network Host',
			'Network Host Information', 'Network Type', 'Plan Duration',
			'Plan Compatible', 'Plan Inclusion', 'Special offer title','Special offer cost','Special offer description'];
		
	
			
			foreach($columns as $column)
			{
				if(isset($data[$column]) && empty($data[$column])){
					$error=[];
					$error['key'] = $key;
					$error['column'] = $column;
					$error['error']= '<b>'.$column.'</b> field is required';
					array_push($errors,$error);
				}
				
			}

			
		
			return $errors;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}

	/**
     * common method for electricity and gas to upload plans. 
     */
    public static function genratePlanData($totalRecords, $providerId,$energyType)
	{
		
		try
		{
			
	
			$connectionTypes = ConnectionType::select('name', 'id')->where('service_id', 2)->where('status', 1)->where('connection_type_id', 1)->get()->toArray();
			$connectionTypes = array_column($connectionTypes,'name','id');
			$connectionTypesArr = array_map('strtolower', $connectionTypes);
			$connectionTypes = array_flip($connectionTypesArr);
			$planTypes = [
				'sim' => 1, 
				'sim + mobile' => 2, 
			];
			$planCostType = CostType::select('id', 'cost_name')->where('status', '1')->orderBy('order')->get()->toArray();
			$planCostType = array_column($planCostType,'cost_name','id');
			$planCostTypesArr = array_map('strtolower', $planCostType);
			$planCostType = array_flip($planCostTypesArr);
			$planDataUnits = [
				"mb" => 1,
				"gb"=> 2,
				"tb" => 3
			];
			$hostTypes = ConnectionType::select('name', 'local_id','connection_type_id')->where('service_id', 2)->where('connection_type_id',4)->where('status', 1)->get()->toArray();
			$hostTypes = array_column($hostTypes,'name','local_id');
			$hostTypesArr = array_map('strtolower', $hostTypes);
			$hostTypes = array_flip($hostTypesArr);
			
			$planCompatible = [
				'esim' => 0,
				'physical' => 1,
				'both' => 2
			]; 

			$networkTypes = config('mobilePlan.networkTypes');
		    $contracts = Contract::select('contract_name','id')->where('status', 1)->get()->toArray();
			$contracts = array_column($contracts,'contract_name','id');
			$contractsArr = array_map('strtolower', $contracts);
			$contracts = array_flip($contractsArr);
			

			$allErrors= $insertRecords =  $updateplanRecords =  $planRecords =  [];   
		
			foreach ($totalRecords as $key => $row) {
				$errors = self::validatePlan($row,$key,$energyType);
				if($errors)
				{
					array_push($allErrors,$errors);
				}
				else
				{

		
					array_push($insertRecords, $row);
					
					$plan['provider_id'] = decryptGdprData($providerId);
					
					
					$plan['name'] = substr($row['Plan Name'], 0, 1000);
					$plan['connection_type'] = isset($connectionTypes[trim(strtolower($row['Connection Type']))])?$connectionTypes[trim(strtolower($row['Connection Type']))]: NULL;
					$plan['plan_type'] = isset($planTypes[trim(strtolower($row['Plan Type']))])?$planTypes[trim(strtolower($row['Plan Type']))]: NULL;
					$plan['cost_type_id'] = isset($planCostType[trim(strtolower($row['Plan Cost Type']))])?$planCostType[trim(strtolower($row['Plan Cost Type']))]: NULL;
					

					$plan['cost'] = $row['Monthly Plan Cost'];
					$plan['plan_data'] = $row['Data per Month'];
					
					$plan['plan_data_unit'] =  isset($planDataUnits[trim(strtolower($row['Plan Data Unit']))])?$planDataUnits[trim(strtolower($row['Plan Data Unit']))]: NULL;
					$plan['host_type'] =  isset($hostTypes[trim(strtolower($row['Network Host']))])?$hostTypes[trim(strtolower($row['Network Host']))]: NULL;
					$plan['network_host_information'] = substr($row['Network Host Information'], 0, 1000);
					

					$plan['network_type'] = isset($networkTypes[trim($row['Network Type'])])?$networkTypes[trim($row['Network Type'])]: NULL;

					$plan['contract_id'] = isset($contracts[trim(strtolower($row['Plan Duration']))])?$contracts[trim(strtolower($row['Plan Duration']))]: NULL;
					
					$plan['sim_type'] =  isset($planCompatible[trim(strtolower($row['Plan Compatible']))])?$planCompatible[trim(strtolower($row['Plan Compatible']))]: NULL;
					
					$plan['inclusion'] = substr($row['Plan Inclusion'], 0, 1000);
					
					$plan['special_offer_status'] = $row['Special offer status'];
					$plan['special_offer_title'] = $row['Special offer title'];
					$plan['special_offer_cost'] = $row['Special offer cost'];
					$plan['special_offer_description'] = substr($row['Special offer description'], 0, 1000);
					
					$plan['details'] = substr($row['Plan Detail'], 0, 1000);
					$plan['amazing_extra_facilities'] = substr($row['Extra Facilities'], 0, 1000);
					$plan['national_voice_calls'] = substr($row['National Voice Calls'], 0, 1000);
					$plan['national_video_calls'] = substr($row['National Video Calls'], 0, 1000);
					$plan['national_text'] = substr($row['National SMS'], 0, 1000);
					$plan['national_mms'] = substr($row['National MMS'], 0, 1000);
					$plan['national_directory_assist'] = substr($row['National Directory Assistance'], 0, 1000);
					$plan['national_diversion'] = substr($row['National Diversion'], 0, 1000);
					$plan['national_call_forwarding'] = substr($row['National Call Forwarding'], 0, 1000);
					$plan['national_voicemail_deposits'] = substr($row['Voicemail Deposits and Retrivals'], 0, 1000);
					
					$plan['national_toll_free_numbers'] = substr($row['Tollfree Number(s)'], 0, 1000);
					$plan['national_additonal_info'] = substr($row['National Additional Information'], 0, 1000);
					$plan['international_voice_calls'] = substr($row['International Voice calls'], 0, 1000);
					$plan['international_video_calls'] = substr($row['International video calls'], 0, 1000);
					$plan['international_text'] = substr($row['International SMS'], 0, 1000);
					$plan['international_mms'] = substr($row['International MMS'], 0, 1000);
					$plan['international_diversion'] = substr($row['International Diversion'], 0, 1000);
					$plan['roaming_charge'] = substr($row['International Roaming'], 0, 1000);
					$plan['international_additonal_info'] = substr($row['International Additional Information'], 0, 1000);
					$plan['status'] = 1;
					
					if($row['Plan ID'] !=''){
						$plan['id'] =   $row['Plan ID'];
						array_push($updateplanRecords, $plan);
					}	
	
					else{
						unset($plan['id']);
						array_push($planRecords, $plan);
					}
				
				
				}   

			}  
		
			if(!empty($updateplanRecords)){
				foreach($updateplanRecords as $records){
					$result = DB::table('plans_mobile')->where('id', $records['id'])->update($records);
				}
				
			}
			
			if(!empty($planRecords)){
				$result = PlanMobile::insert(mb_convert_encoding($planRecords, 'UTF-8', 'UTF-8')); 
			}
			return ['status' => $result, 'errors' => $allErrors, 'inserted' => count($insertRecords) ,'total' => count($totalRecords)];
		}
        catch (\Exception $err) {
            throw $err;
        }
	}
	
	/**
     * check format of electricity plan sheet file
     */
    public static function readPlanCSV($path)
	{
		
		try
		{
			ini_set('auto_detect_line_endings', true);
			if (!file_exists($path) || !is_readable($path))
				return false;

			$data = array();
			if (($handle = fopen($path, 'r')) !== false) {
				$header = fgetcsv($handle);

				$target = array(
					'Plan ID',
					'Plan Name',
					'Connection Type',
					'Plan Type',
					'Plan Cost Type',
					'Monthly Plan Cost',
					'Data per Month',
					'Plan Data Unit',
					'Network Host',
					'Network Host Information',
					'Network Type',
					'Plan Duration',
					'Plan Compatible',
					'Plan Inclusion',
					'Special offer status',
					'Special offer title',
					'Special offer cost',
					'Special offer description',
					'Plan Detail',
					'Extra Facilities',
					'National Voice Calls',
					'National Video Calls',
					'National SMS',
					'National MMS',
					'National Directory Assistance',
					'National Diversion',
					'National Call Forwarding',
					'Voicemail Deposits and Retrivals',
					'Tollfree Number(s)',
					'National Additional Information',
					'International Voice calls',
					'International video calls',
					'International SMS',
					'International MMS',
					'International Diversion',
					'International Roaming',
					'International Additional Information'
					
				); 
			
				
				if (array_diff($target, $header)) {
					return 'invalid';
				}  
				while ($plans = fgetcsv($handle)) {
					$data[] = array_combine($header, $plans);
				} 
			} 
			return $data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

}
