<?php
namespace App\Repositories\PlansEnergy\Uploads; 
use App\Models\Plans\{EnergyPlanRate,EnergyPlanRateLimit,LpgPlanRate};
use App\Models\{Distributor, PlanEnergy};
trait PlanRateUpload
{  
	public static $numberArray,$number_array;
    public function __construct()
	{ 
		self::$numberArray = ['1st' => 1,'2nd' => 2,'3rd' => 3,'4th' => 4,'5th' =>5,'6th' =>6,'7th' => 7,'8th' =>8,'9th' =>9,'remaining' => 32768];  
        self::$number_array = ['first' => 1, 'second' => 2, 'third' => 3, 'fourth' => 4, 'fifth' => 5, 'sixth' => 6, 'seventh' => 7, 'eighth' => 8, 'ninth' => 9, 'remaining' => 32768];	
	}
	
	/**
     * upload electricity plan rates.
     */
	public static function genratePlanRateData($data,$request)
    {
		try
		{
			$error = $planRates = $insertedRates = $allErrors = [];
			$saved_record = $error_record = 0;
			$statusArr = [
				'yes' => 1, 'no' => 0,
				'YES' => 1, 'NO' => 0,
				'Yes' => 1, 'No' => 0
			];

			$conditionalArray = [
				'less' => 1, 'equal' => 2, 'more' => 3
			];

			$rateTypeArray = [
				'normal' => 1, 'premium' => 2
			];

			$saved_record = 0;
			$total_row = 2;
			if ($data === null) { 
				$data = 	 \Request::input('data'); 
				$saved_record = (\Request::input('upload_records'));
				$total_row = (\Request::input('total_records'));
			}

			$distributors = Distributor::pluck('id','name')->toArray(); 
			$planId = decryptGdprData($request->plan_id);
			$plan = PlanEnergy::select('id','provider_id')->where('id',$planId)->first();
			foreach ($data as $key => $row) { 
				if ((!empty($row['Distributor']) && $row['Distributor']) && isset($distributors[$row['Distributor']])) {
					
						$ratedata = [];
						$singleRate = ['peak_only', 'demand_peakonly'];
						$doubleRate = ['two_rate_only', 'peak_c1', 'peak_c2', 'peak_c1_c2', 'demand_peak_c1', 'demand_peak_c2', 'demand_peak_c1_c2'];
						$timeOfUse = ['timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2', 'demand_timeofuse_only', 'demand_timeofuse_c1', 'demand_timeofuse_c2', 'demand_timeofuse_c1_c2']; 
						
						$demand_usage_desc = '';
						$demand_supply_charges_daily = 0;
						$demand_usage_charges = 0;
						$control_load_1_daily_supply_charges = 0;
						$control_load_2_daily_supply_charges = 0;
						$daily_supply_charges = 0;
						$meter_type = $row['Rate-3 Meter Type'];
						
						if (in_array($row['Type'], ["peak_only", "summer_only"])) {
							$daily_supply_charges = $row['Rate-1 Daily Supply Charges'];
						}
						else if (in_array($row['Type'], ["two_rate_only", "winter_only"])) {
							$daily_supply_charges = $row['Rate-2 Daily Supply Charges'];
						}
						else if (in_array($row['Type'], ["timeofuse_only", "summer_winter_tou_only"])) {
							$daily_supply_charges = $row['Rate-3 Daily Supply Charges (summer/Winter)'];
						}
						else if (in_array($row['Type'], ["peak_c1", "winter_c1", "peak_c1_c2", "winter_c1_c2", 'demand_peak_c1', 'demand_peak_c1_c2'])) {
							$control_load_1_daily_supply_charges = $row['Rate-2 Daily Supply Charges for Control Load 1'];
							$daily_supply_charges = $row['Rate-2 Daily Supply Charges'];
						}
						else if (in_array($row['Type'], ["peak_c2", "winter_c2", "peak_c1_c2", "winter_c1_c2", 'demand_peak_c2', 'demand_peak_c1_c2'])) {
							$daily_supply_charges = $row['Rate-2 Daily Supply Charges'];
							$control_load_2_daily_supply_charges = $row['Rate-2 Daily Supply Charges for Control Load 2'];
						}
						else if (in_array($row['Type'], ["timeofuse_c1", "timeofuse_c1_c2", "summer_winter_tou_c1", "summer_winter_tou_c1_c2"])) {
							$daily_supply_charges = $row['Rate-3 Daily Supply Charges (summer/Winter)'];
							$control_load_1_daily_supply_charges = $row['Rate-3 Daily Supply Charges for Control Load 1'];
						}
						else if (in_array($row['Type'], ["timeofuse_c2", "timeofuse_c1_c2", "summer_winter_tou_c2", "summer_winter_tou_c1_c2"])) {
							$daily_supply_charges = $row['Rate-3 Daily Supply Charges (summer/Winter)'];
							$control_load_2_daily_supply_charges = $row['Rate-3 Daily Supply Charges for Control Load 2'];
						}
						else if (in_array($row['Type'], ["summer_c1", "summer_c1_c2"])) {
							$daily_supply_charges = $row['Rate-1 Daily Supply Charges'];
							$control_load_1_daily_supply_charges = $row['Rate-1 Daily Supply Charges for Control Load 1'];
						}
						else if (in_array($row['Type'], ["summer_c2", "summer_c1_c2"])) {
							$daily_supply_charges = $row['Rate-1 Daily Supply Charges'];
							$control_load_2_daily_supply_charges = $row['Rate-1 Daily Supply Charges for Control Load 2'];
						}
						else if (in_array($row['Type'], ['demand_timeofuse_only', 'demand_timeofuse_c1', 'demand_timeofuse_c2', 'demand_timeofuse_c1_c2', 'demand_summer_winter_tou_only', 'demand_summer_winter_tou_c1', 'demand_summer_winter_tou_c2', 'demand_summer_winter_tou_c1_c2'])) {
							$daily_supply_charges = $row['Rate-3 Daily Supply Charges (summer/Winter)'];
							$demand_usage_desc = $row['Rate-3 Capacity/Demand Usage Description'];
							$demand_supply_charges_daily = $row['Rate-3 Daily Capacity/Demand Supply Charges'];
							$demand_usage_charges = $row['Rate-3 Capacity/Demand Usage Charges'];
						}
						else if (in_array($row['Type'], ['demand_winter_only', 'demand_winter_c1', 'demand_winter_c2', 'demand_winter_c1_c2', 'demand_peak_c1', 'demand_peak_c2', 'demand_peak_c1_c2'])) {
							$daily_supply_charges = $row['Rate-2 Daily Supply Charges'];
							$demand_usage_desc = $row['Rate-2 Capacity/Demand Usage Description'];
							$demand_supply_charges_daily = $row['Rate-2 Daily Capacity/Demand Supply Charges'];
							$demand_usage_charges = $row['Rate-2 Capacity/Demand Usage Charges'];
						}
						else if (in_array($row['Type'], ['demand_summer_only', 'demand_summer_c1', 'demand_summer_c2', 'demand_summer_c1_c2', "demand_peakonly"])) {
							$daily_supply_charges = $row['Rate-1 Daily Supply Charges'];
							$demand_usage_desc = $row['Rate-1 Capacity/Demand Usage Description'];
							$demand_supply_charges_daily = $row['Rate-1 Daily Capacity/Demand Supply Charges'];
							$demand_usage_charges = $row['Rate-1 Capacity/Demand Usage Charges'];
						}

						$dmo_content = 0; 
						if (strtolower($row['DMO/VDO Content']) == 'yes') {
							$dmo_content = 1;
						} 
						$dmo_master_check = 1;
						if (strtolower($row['Consider Master Content']) == 'no') {
							$dmo_master_check = 0;
						} 
						$date = null;
						if($row['Effective From'] != '' || $row['Effective From'] != null)
						{
							$date = str_replace('/', '-', $row['Effective From']);
							$date = date("Y-m-d", strtotime($date));
						}

						$record = array(
							'type' => $row['Type'], 
							'rate_type' => trim(strtolower($row['Rate Type'])),
							'plan_id' => $planId,
							'provider_id' => isset($plan->provider_id)?$plan->provider_id:0,
							'distributor_id' => $distributors[$row['Distributor']], 
							'exit_fee_option' => substr($row['Exit Fee Option'], 0, 2000),
							'exit_fee' => substr($row['Exit Fee'], 0, 2000),
							'tariff_desc' => substr($row['Tariff Description'], 0, 2000),
							'daily_supply_charges' => trim($daily_supply_charges) != '' ?substr($daily_supply_charges, 0, 10):'0',  
							
							'control_load_1_daily_supply_charges' => trim($control_load_1_daily_supply_charges) != '' ?substr($control_load_1_daily_supply_charges, 0, 10):'0',

							'control_load_2_daily_supply_charges' => trim($control_load_2_daily_supply_charges) != '' ? substr($control_load_2_daily_supply_charges, 0, 10):0,

							'late_payment_fee' => $row['Late payment fee'],
							'late_fee_title' => substr($row['Late payment fee title'], 0, 1000),
							'demand_usage_desc' => substr($demand_usage_desc, 0, 2000),
							'demand_supply_charges_daily' => substr($demand_supply_charges_daily, 0, 10),
							'demand_usage_charges' => trim($demand_usage_charges) != '' ? substr($demand_usage_charges, 0, 10):0,
							'dual_fuel_discount_usage' => substr($row['Dual Fuel Discount on Usage'], 0, 10),
							'dual_fuel_discount_supply' => substr($row['Dual Fuel Discount on Supply'], 0, 10),
							'dual_fuel_discount_desc' => $row['Dual Fuel Discount Description'],
							'pay_day_discount_usage' => $row['Pay Day Discount on Usage'],
							'pay_day_discount_usage_desc' => substr($row['Pay Day Discount on Usage Description'], 0, 2000),
							'pay_day_discount_supply' => substr($row['Pay Day Discount on Supply'], 0, 10),
							'pay_day_discount_supply_desc' => substr($row['Pay Day Discount on Supply Description'], 0, 2000),
							'gurrented_discount_usage' => substr($row['Guaranteed Discount on Usage'], 0, 10),
							'gurrented_discount_usage_desc' => substr($row['Guaranteed Discount on Usage Description'], 0, 2000),
							'gurrented_discount_supply' => substr($row['Guaranteed Discount on Supply'], 0, 10),
							'gurrented_discount_supply_desc' => substr($row['Guaranteed Discount on Supply Description'], 0, 2000),
							'direct_debit_discount_usage' => substr($row['Direct Debit Discount on Usage'], 0, 10),
							'direct_debit_discount_supply' => substr($row['Direct Debit Discount on Supply'], 0, 10),
							'direct_debit_discount_desc' => substr($row['Direct Debit Discount Description'], 0, 2000),
							'meter_type' => substr($meter_type, 0, 200),
							'gst_rate' => substr($row['GST Percentage'], 0, 10),
							'connection_fee' => substr($row['Connection fee'], 0, 1000),
							'disconnection_fee' => substr($row['Disconnection fee'], 0, 1000),
							'tariff_type_title' => substr($row['Tariff Type Title'], 0, 200),
							'tariff_type_code' => $row['Tariff Type code'],
							'effective_from' => $date,
							'price_fact_sheet' => substr($row['Price Fact Sheet/BPID/VEFS URL'], 0, 1000),
							'offer_id' => substr($row['Offer Id'], 0, 200),
							'batch_id' => substr($row['Batch Id'], 0, 200),
							'time_of_use_rate_type' => $row['Time of use rate type'],
							'dmo_content_status' => $dmo_content,
							'master_content_status' => $dmo_master_check,
							'dmo_vdo_content' => mb_convert_encoding($row['DMO/VDO ConteDescription'], 'UTF-8', 'ISO-8859-2'), 
							'dmo_static_content_status' => strtolower($row['Enable static content']),
							'lowest_annual_cost' => $row['Lowest Possible Annual Cost'],
							'without_conditional_value' => $row['Percentage Difference to Reference Bill Without Conditional Discount'],
							'with_conditional_value' => $row['Percentage Difference to Reference Bill With Conditional Discount'],
							'without_conditional' => strtolower($row['Set condition without conditional discount']),
							'with_conditional' => strtolower($row['Set condition with conditional discount']),
							'demand_charge_type' => $row['Demand Charge Type'],
						);
						if (isset($record['time_of_use_rate_type'])) {
							$record['time_of_use_rate_type'] = strtolower($record['time_of_use_rate_type']) == 'flexible' ? '1' : '2';
						}
						
						if (isset($row['total_record'])) {
							$error = self::planRateValidation($record, $row['total_record'], 'electricity');
						} 
						else {
							$error = self::planRateValidation($record, $total_row, 'electricity');
						} 
						
						$record['exit_fee_option'] = isset($statusArr[$record['exit_fee_option']])?$statusArr[$record['exit_fee_option']]:0;
						$record['rate_type'] = isset($rateTypeArray[$record['rate_type']])? $rateTypeArray[$record['rate_type']]: 0;

						if ($record['dmo_static_content_status'] == 'yes') {
							$record['dmo_static_content_status'] = 1; 

							$record['without_conditional'] = isset($conditionalArray[$record['without_conditional']])?$conditionalArray[$record['without_conditional']]:null;

							$record['with_conditional'] = isset($conditionalArray[$record['with_conditional']])?$conditionalArray[$record['with_conditional']]:null;
						} else { 
							$record['dmo_static_content_status'] = $record['lowest_annual_cost'] = $record['without_conditional'] = $record['with_conditional']= 0;
							$record['without_conditional_value'] =  $record['with_conditional_value']  = '';
						}

						if (empty($error)) {
							array_push($planRates, $record);
							array_push($insertedRates, $row); 
							$saved_record++;
						} 
						else {
							$error_record++;
							array_push($allErrors, $error);
						}
					}  
					else 
					{
						$row['total_record'] = $total_row;
						$missed_record[] = $row;
					}  
					$total_row++;
			}  
			$result = EnergyPlanRate::insert($planRates);  
			if($result)
			{
				$newRecordsLength = count($planRates);
				$lastIds = EnergyPlanRate::orderBy('id', 'desc')->take($newRecordsLength)->pluck('id')->toArray(); 
				$rateLimitData = []; 
				foreach($insertedRates as $row) 
				{
					--$newRecordsLength;
					$planRateId = decryptGdprData($lastIds[$newRecordsLength]); 
					if (!empty($planRateId)) 
					{  
						if (in_array($row['Type'], $singleRate)) {
							$ratedata = self::singleRate($row, $planRateId); 
						} 
						else if (in_array($row['Type'], $doubleRate)) {
							$ratedata = self::doubleRate($row, $planRateId);
						} 
						else if (in_array($row['Type'], $timeOfUse)) {
							$ratedata = self::timeOfUsage($row, $planRateId);
						} 

						if (!empty($ratedata)) { 
							$rateLimitData = array_merge($rateLimitData, $ratedata);
						}
					}
				}
				EnergyPlanRateLimit::insert($rateLimitData); 
			}
			
			if (isset($missed_record) && !empty($missed_record)) {
				$result = ['success' => 'true', 'missed_record' => $missed_record, 'suggestion_distributor' => $distributors, 'errors' => $allErrors, 'total_records' => $total_row - 2, 'saved_record' => $saved_record];
				return $result;
			} 
			$result = ['success' => 'true', 'errors' => $allErrors, 'total_records' => $total_row - 1, 'saved_record' => $saved_record]; 
			return $result;
		}
        catch (\Exception $err) {
            throw $err;
        }
    }
	/**
     * upload lpg plan rates.
     */
	public static function genrateLpgPlanRateData($data,$request)
    {
		try
		{
			$error = $planRates = $insertedRates = $allErrors = [];
			$saved_record = 0;
			$statusArr = [
				'yes' => 1, 'no' => 0,
				'YES' => 1, 'NO' => 0,
				'Yes' => 1, 'No' => 0
			];
			$saved_record = $error_record = 0;
			$total_row = 2;
			if ($data === null) { 
				$data = \Request::input('data');
				$saved_record = \Request::input('upload_records');
				$total_row = \Request::input('total_records');
			}  
			$distributors = Distributor::pluck('id','name')->toArray(); 
			$planId = decryptGdprData($request->plan_id);
			$plan = PlanEnergy::select('id','provider_id')->where('id',$planId)->first();
			
			foreach ($data as $row)
			{
			
				if ((!empty($row['Distributor Name']) && $row['Distributor Name']) && isset($distributors[$row['Distributor Name']])){
				 

					$record = array(
						
						'plan_id' => $planId,
						'provider_id' => isset($plan->provider_id)?$plan->provider_id:0,
						'distributor_id' => $distributors[$row['Distributor Name']],  
						'exit_fee_option' => $row['Exit Fee Option'],
						'exit_fee' => substr($row['Exit Fee'], 0, 2000),
						'annual_equipment_fees_rental_fees' => substr($row['Annual Equipment fees/ Rental Fees'], 0, 10),
						'annual_equipment_fees_rental_fees_desc' => substr($row['Annual Equipment fees/ Rental Fees(desc)'], 0, 2000),
						'delivery_charges' => substr($row['Delivery Charges'], 0, 10),
						'delivery_charges_desc' =>substr($row['Delivery Charges(Description)'], 0, 2000), 
						'account_establishment_fees' => substr($row['Account establishment fees'], 0, 10),
						'account_establishment_fees_desc' => substr($row['Account establishment fees(Description)'], 0, 2000),
						'urgent_delivery_fees' => substr($row['Urgent Delivery Fees'], 0, 10),
						'urgent_delivery_fees_desc' => substr($row['Urgent Delivery Fees(Description)'], 0, 2000),
						'service_and_installation_charges' => substr($row['Service and installation charges'], 0, 10),
						'service_and_installation_charges_desc' => substr($row['Service and installation charges(Description)'], 0, 2000),
						'green_LPG_fees' => substr($row['Green LPG fees'], 0, 10),
						'min_quantity_with_discount' => $row['Min. Quantity with discount'],
						'max_quantity_with_discount' => $row['Max. Quantity with discount'],
						'cash_discount_per_bottle' => $row['Cash discount per bottle'],
						'cash_credits' => substr($row['Cash credits'], 0, 10),
						'discount_percent' => $row['% Discount (to get the standard cost)'],
						'optional_fees_1' => substr($row['Optional fees 1'], 0, 10),
						'optional_fees_1_desc' =>substr($row['Optional fees 1 Description'], 0, 2000),

						'optional_fees_2' => substr($row['Optional fees 2'], 0, 10),
						'optional_fees_2_desc' => substr($row['Optional fees 2 Description'], 0, 2000),
						'optional_fees_3' => substr($row['Optional fees 3'], 0, 10),
						'optional_fees_3_desc' =>substr($row['Optional fees 3 Description'], 0, 2000),
						'optional_fees_4' => substr($row['Optional fees 4'], 0, 10),
						'optional_fees_4_desc' => substr($row['Optional fees 4 Description'], 0, 2000),
						'optional_fees_5' => substr($row['Optional fees 5'], 0, 10),
						'optional_fees_5_desc' =>substr($row['Optional fees 5 Description'], 0, 2000),
						'optional_fees_6' => substr($row['Optional fees 6'], 0, 10),
						'optional_fees_6_desc' => substr($row['Optional fees 6 Description'], 0, 2000),
						'optional_fees_7' => substr($row['Optional fees 7'], 0, 10),
						'optional_fees_7_desc' => substr($row['Optional fees 7 Description'], 0, 2000),
						'optional_fees_8' => substr($row['Optional fees 8'], 0, 10),
						'optional_fees_8_desc' => substr($row['Optional fees 8 Description'], 0, 2000),
						'optional_fees_9' => substr($row['Optional fees 9'], 0, 10),
						'optional_fees_9_desc' => substr($row['Optional fees 9 Description'], 0, 2000),
						'optional_fees_10' =>substr($row['Optional fees 10'], 0, 10),
						'optional_fees_10_desc' => substr($row['Optional fees 10 Description'], 0, 2000),
						'urgent_delivery_window' => $row['Urgent Delivery Window'],
						'late_payment_fee' => $row['Late Payment Fee'],
						'connection_fee' => substr($row['Connection Fee'], 0, 1000),
						'disconnection_fee' => substr($row['Disconnection Fee'], 0, 1000),
						'price_fact_sheet' => substr($row['Price Fact Sheet/BPID/VEFS URL'], 0, 1000),
						'offer_ID' => substr($row['Offer ID'], 0, 200),
						'batch_ID' => substr($row['Batch ID'], 0, 200),
					);  
					
					$error = self::lpgPlanRateValidation($record, $total_row);
			
					$record['exit_fee_option'] = isset($statusArr[$record['exit_fee_option']])?$statusArr[$record['exit_fee_option']]:0;


					if (empty($error)) {
						array_push($planRates, $record);
						array_push($insertedRates, $row); 
						$saved_record++;
					} 
					else {
						array_push($allErrors, $error);
						$error_record++;
					}  
				}
				else
				{ 
					$row['total_record'] = $total_row;
					$missed_record[] = $row;
				} 
				$total_row++;
			}
		
			$result = LpgPlanRate::insert($planRates);
			if($result)
			{
				$newRecordsLength = count($planRates);
				$lastIds = LpgPlanRate::orderBy('id', 'desc')->take($newRecordsLength)->pluck('id')->toArray(); 
				
			}
		
			if (isset($missed_record) && !empty($missed_record)) {
				$result = ['success' => 'true', 'missed_record' => $missed_record, 'suggestion_distributor' => $distributors ,'errors' => $allErrors, 'total_records' => $total_row - 2  , 'saved_record' => $saved_record];
				return $result;
			}
			$result = ['success' => 'true', 'errors' => $allErrors, 'total_records' => $total_row - 1 , 'saved_record' => $saved_record]; 
			return $result;
		}
        catch (\Exception $err) {
            throw $err;
        }
    }	
	/**
     * upload gas plan rates. 
     */
	public static function genrateGasPlanRateData($data,$request)
    {
		try
		{
			$error = $planRates = $insertedRates = $allErrors = [];
			$saved_record = 0;
			$statusArr = [
				'yes' => 1, 'no' => 0,
				'YES' => 1, 'NO' => 0,
				'Yes' => 1, 'No' => 0
			];
			$rateTypeArray = [
				'normal' => 1, 'premium' => 2
			];
			$saved_record = $error_record = 0;
			$total_row = 2;
			if ($data === null) { 
				$data = \Request::input('data');
				$saved_record = \Request::input('upload_records');
				$total_row = \Request::input('total_records');
			}  
			$distributors = Distributor::pluck('id','name')->toArray(); 
			$planId = decryptGdprData($request->plan_id);
			$plan = PlanEnergy::select('id','provider_id')->where('id',$planId)->first();
			//dd($data);
			foreach ($data as $key => $row)
			{
				if ((!empty($row['Distributor']) && $row['Distributor']) && isset($distributors[$row['Distributor']]))
				{
						//generates rates table data 
						$demand_usage_desc = '';
						$demand_supply_charges_daily = 0;
						$demand_usage_charges = 0;
						$control_load_1_daily_supply_charges = 0;
						$control_load_2_daily_supply_charges = 0;
						$daily_supply_charges = $row['Rate-1 Winter Daily Supply Charges'];
						
						$date = null;
						if($row['Effective From'] != '' || $row['Effective From'] != null)
						{
							$date = str_replace('/', '-', $row['Effective From']);
							$date = date("Y-m-d", strtotime($date));
						}  

						$meter_type = '';
						$record = array(
							'type' => $row['Type'], 
							'rate_type' => trim(strtolower($row['Rate Type'])),
							'plan_id' => $planId,
							'provider_id' => isset($plan->provider_id)?$plan->provider_id:0,
							'distributor_id' => $distributors[$row['Distributor']],  
							'tariff_desc' => substr($row['Tariff Description'], 0, 2000),
							'exit_fee_option' => $row['Exit Fee Option'],
							'exit_fee' => substr($row['Exit Fee'], 0, 2000),

							'daily_supply_charges' => trim($daily_supply_charges) != '' ?substr($daily_supply_charges, 0, 10):'0',

							'control_load_1_daily_supply_charges' => trim($control_load_1_daily_supply_charges) != '' ? substr($control_load_1_daily_supply_charges, 0, 10): 0,

							'control_load_2_daily_supply_charges' =>  trim($control_load_2_daily_supply_charges) != '' ? substr($control_load_2_daily_supply_charges, 0, 10): 0,

							'late_payment_fee' => substr($row['Late payment fee'], 0, 1000),
							'late_fee_title' => '',
							'demand_usage_desc' => substr($demand_usage_desc, 0, 2000),
							'demand_supply_charges_daily' => substr($demand_supply_charges_daily, 0, 10),
							'demand_usage_charges' => trim($demand_usage_charges) != '' ? substr($demand_usage_charges, 0, 10):0,
							'dual_fuel_discount_usage' => substr($row['Dual Fuel Discount on Usage'], 0, 10),
							'dual_fuel_discount_supply' => substr($row['Dual Fuel Discount on Supply'], 0, 10),
							'dual_fuel_discount_desc' => $row['Dual Fuel Discount Description'],
							'pay_day_discount_usage' => $row['Pay Day Discount on Usage'],
							'pay_day_discount_usage_desc' => substr($row['Pay Day Discount on Usage Description'], 0, 2000),
							'pay_day_discount_supply' => substr($row['Pay Day Discount on Supply'], 0, 10),
							'pay_day_discount_supply_desc' => substr($row['Pay Day Discount on Supply Description'], 0, 2000),
							'gurrented_discount_usage' => substr($row['Guaranteed Discount on Usage'], 0, 10),
							'gurrented_discount_usage_desc' => substr($row['Guaranteed Discount on Usage Description'], 0, 2000),
							'gurrented_discount_supply' => substr($row['Guaranteed Discount on Supply'], 0, 10),
							'gurrented_discount_supply_desc' => substr($row['Guaranteed Discount on Supply Description'], 0, 2000),
							'direct_debit_discount_usage' => substr($row['Direct Debit Discount on Usage'], 0, 10),
							'direct_debit_discount_supply' => substr($row['Direct Debit Discount on Supply'], 0, 10),
							'direct_debit_discount_desc' => substr($row['Direct Debit Discount Description'], 0, 2000),
							'meter_type' => substr($meter_type, 0, 200),
							'gst_rate' => substr($row['GST Percentage'], 0, 10),
							'connection_fee' => substr($row['Connection fee'], 0, 1000),
							'disconnection_fee' => substr($row['Disconnection fee'], 0, 1000),
							'tariff_type_title' => substr($row['Tariff Type Title'], 0, 200),
							'tariff_type_code' => $row['Tariff Type code'],
							'effective_from' => $date,
							'price_fact_sheet' => substr($row['Price Fact Sheet/BPID/VEFS URL'], 0, 1000),
							'offer_id' => substr($row['Offer Id'], 0, 200),
							'batch_id' => substr($row['Batch Id'], 0, 200),
							'time_of_use_rate_type' => $row['Time of use rate type'],
						);  
						if (isset($record['time_of_use_rate_type'])) {
							$record['time_of_use_rate_type'] = strtolower($record['time_of_use_rate_type']) == 'flexible' ? '1' : '2';
						} 
						if (isset($row['total_record'])) {
							$error = self::planRateValidation($record, $row['total_record'], 'gas');
						} 
						else {
							$error = self::planRateValidation($record, $total_row, 'gas');
						} 

						$record['exit_fee_option'] = isset($statusArr[$record['exit_fee_option']])?$statusArr[$record['exit_fee_option']]:0;

						$record['rate_type'] = isset($rateTypeArray[$record['rate_type']])? $rateTypeArray[$record['rate_type']]: 0;

						if (empty($error)) {
							array_push($planRates, $record);
							array_push($insertedRates, $row); 
							$saved_record++;
						} 
						else {
							array_push($allErrors, $error);
							$error_record++;
						}  
				}
				else
				{
					$row['total_record'] = $total_row;
					$missed_record[] = $row;
				} 
				$total_row++;
			}
			$result = EnergyPlanRate::insert($planRates);
			if($result)
			{
				$newRecordsLength = count($planRates);
				$lastIds = EnergyPlanRate::orderBy('id', 'desc')->take($newRecordsLength)->pluck('id')->toArray(); 
				$rateLimitData = []; 
				foreach($insertedRates as $row) 
				{
					--$newRecordsLength;
					$planRateId = decryptGdprData($lastIds[$newRecordsLength]); 
					if (!empty($planRateId)) 
					{  
						$rateData = self::getGasRate($row, $planRateId);  
					} 
					if (!empty($rateData)) {  
						$rateLimitData = array_merge($rateLimitData, $rateData);
					}
				}
				EnergyPlanRateLimit::insert($rateLimitData);
			}
			//dump($total_row);
			if (isset($missed_record) && !empty($missed_record)) {
				$result = ['success' => 'true', 'missed_record' => $missed_record, 'suggestion_distributor' => $distributors ,'errors' => $allErrors, 'total_records' => $total_row - 2  , 'saved_record' => $saved_record];
				return $result;
			}
			$result = ['success' => 'true', 'errors' => $allErrors, 'total_records' => $total_row - 1 , 'saved_record' => $saved_record]; 
			return $result;
		}
        catch (\Exception $err) {
            throw $err;
        }
    }
    
	/**
     * get all single rates. 
     */
    private static  function singleRate($row = null, $planRateId = null)
	{
		try
		{
			$peak = 'peak';
			$status = 1;
			$is_deleted = 0; 
			$limit_data = self::rate1And2Limit($peak, $status, $is_deleted, $planRateId, $row,1);
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * get all double rates. 
     */
    private static  function doubleRate($row = null, $planRateId = null)
	{ 
		try
		{
			$peak = 'peak';
			$type = $row['Type'];
			$status = 1;
			$is_deleted = 0; 
			$limit_data = self::rate2limit($peak, $status, $is_deleted, $planRateId, $row, $type);
			return $limit_data;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}

	/**
     * get all time of use rates. 
     */
    private static function timeOfUsage($row = null, $planRateId = null)
	{ 
		try
		{
			$peak = 'peak';
			$type = $row['Type'];
			$status = 1;
			$is_deleted = 0; 
			$shoulder_yes = 'yes';
			$limit_data = self::rate3limit($peak, $status, $is_deleted, $planRateId, $row, $type, $shoulder_yes);
			return $limit_data;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}
	
	/**
     * get all gas rates. 
     */
	private static function getGasRate($row = null, $planRateId = null)
	{ 
		try
		{
			$peak = 'peak';
			$status = 1;
			$is_deleted = 0; 
			$limit_data = self::rate1And2Limit($peak, $status, $is_deleted, $planRateId, $row,1);
			$peak = 'offpeak';
			$gas_off_peak = self::getOffPeakData($peak, $status, $is_deleted, $planRateId, $row);
			$limit_data = array_merge($limit_data, $gas_off_peak);
			return $limit_data;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}

	/**
     * set default value of plan rate limits 
     */
	private static function setRateDefaultValue($dataInput)
	{
		try
		{
			$dataInput['limit_year'] = ($dataInput['limit_year'] != '' && is_numeric($dataInput['limit_year'])) ? $dataInput['limit_year']: '0';
			$dataInput['limit_daily'] = ($dataInput['limit_daily'] != '' && is_numeric($dataInput['limit_daily'])) ? $dataInput['limit_daily']: '0';
			$dataInput['limit_charges'] = is_numeric($dataInput['limit_charges']) ? $dataInput['limit_charges']: '0';
			return $dataInput;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}

	/**
     * common method to get rate 1 and rate 2 peak limits. 
     */
	private static function rate1And2Limit($peak, $status, $is_deleted, $planRateId, $row,$rate)
	{
		try
		{
			$limit_data = [];
			$types = ['1st','2nd','3rd','4th','5th','6th' ,'7th','8th' ,'9th'];
			foreach($types as $type)
			{
				if (!empty($row['Rate-'.$rate.' '.$type.' Peak Usage Charges']))
				{
					$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $peak, 
					'limit_level' => self::$numberArray[$type], 
					'limit_desc' => $row['Rate-'.$rate.' '.$type.' Peak Description'], 
					'limit_year' => $row['Rate-'.$rate.' '.$type.' Peak Usage Limit Yearly'], 'limit_daily' => $row['Rate-'.$rate.' '.$type.' Peak Usage Limit Per day'], 
					'limit_charges' => $row['Rate-'.$rate.' '.$type.' Peak Usage Charges'], 
					'status' => $status, 
					'is_deleted' => $is_deleted
					]);

					array_push($limit_data, $dataInput);
				}
			}
			
			//remaining
			if (!empty($row['Rate-'.$rate.' Remaining Peak Usage Charges'])) {
				$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $peak, 
					'limit_level' => self::$number_array['remaining'], 
					'limit_desc' => $row['Rate-'.$rate.' Remaining Peak Description'], 
					'limit_year' => 0, 'limit_daily' => 12, 
					'limit_charges' => $row['Rate-'.$rate.' Remaining Peak Usage Charges'], 
					'status' => $status, 
					'is_deleted' => $is_deleted
					]);

				array_push($limit_data, $dataInput);
			}   
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * common method to get off peak limits. 
     */
	private static function getOffPeakData($peak, $status, $is_deleted, $planRateId, $row)
	{
		try
		{
			$limit_data = [];
			//first
			$types = ['1st','2nd','3rd','4th','5th','6th' ,'7th','8th' ,'9th'];
			foreach($types as $type)
			{
				if (!empty($row['Rate-1 '.$type.' Off-Peak Usage Charges']))
				{
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $peak, 
						'limit_level' => self::$numberArray[$type], 
						'limit_desc' => $row['Rate-1 '.$type.' Off-Peak Description'], 
						'limit_year' => $row['Rate-1 '.$type.' Off-Peak Usage Limit Yearly'],
						'limit_daily' => $row['Rate-1 '.$type.' Off-Peak Usage Limit Per day'], 
						'limit_charges' => $row['Rate-1 '.$type.' Off-Peak Usage Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted]);

					array_push($limit_data, $dataInput);
				}
			}
			
			//remaining
			if (!empty($row['Rate-1  Remaining Off-Peak Usage Charges'])) {
				$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $peak, 
						'limit_level' => self::$number_array['remaining'], 
						'limit_desc' => $row['Rate-1 Rate-1 Remaining  Off-Peak Description'],
						'limit_year' => 0, 
						'limit_daily' => 0, 
						'limit_charges' => $row['Rate-1  Remaining Off-Peak Usage Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
						]);
				array_push($limit_data, $dataInput);
			}

			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * get rate 2 limits. 
     */
    private static function rate2limit($peak, $status, $is_deleted, $planRateId, $row, $type)
	{ 
		try
		{
			$control_load_1_array = ['peak_c1', 'peak_c1_c2', 'winter_c1', 'winter_c1_c2', 'demand_peak_c1', 'demand_peak_c1_c2'];
			$control_load_2_array = ['peak_c2', 'peak_c1_c2', 'winter_c2', 'winter_c1_c2', 'demand_peak_c2', 'demand_peak_c1_c2'];
	
			$limit_data = self::rate1And2Limit($peak, $status, $is_deleted, $planRateId, $row,2);
			
			$rateDate = self::getRateControlLoad($status, $is_deleted, $planRateId, $row,$type, $control_load_1_array,2,'1');
			$limit_data = array_merge($limit_data, $rateDate);

			$rateDate = self::getRateControlLoad($status, $is_deleted, $planRateId, $row,$type, $control_load_2_array,2,'2');
			$limit_data = array_merge($limit_data, $rateDate);

			$rateDate = self::getRateControlLoadAndPeak( $status, $is_deleted, $planRateId, $row,2);
			$limit_data = array_merge($limit_data, $rateDate);
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * get rate 3 limits. 
     */
	private static function rate3limit($peak, $status, $is_deleted, $planRateId, $row, $type, $shoulder_yes)
	{
		try
		{
			$control_load_1_array = ['timeofuse_c1', 'timeofuse_c1_c2', 'summer_winter_tou_c1', 'summer_winter_tou_c1_c2', 'demand_timeofuse_c1', 'demand_timeofuse_c1_c2', 'demand_summer_winter_tou_c1', 'demand_summer_winter_tou_c1_c2'];
			
			$control_load_2_array = ['timeofuse_c2', 'timeofuse_c1_c2', 'summer_winter_tou_c2', 'summer_winter_tou_c1_c2', 'demand_timeofuse_c2', 'demand_timeofuse_c1_c2', 'demand_summer_winter_tou_c2', 'demand_summer_winter_tou_c1_c2'];
			
			$timeOfUseArray = ['timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2'];

			$limit_data = self::getSummerWinterData($peak,$status, $is_deleted, $planRateId, $row,'summer');

			$offpeakData = self::getOffpeakShoulderData( $status, $is_deleted, $planRateId, $row,$shoulder_yes,$timeOfUseArray);
			$limit_data = array_merge($limit_data, $offpeakData);

			$rateDate = self::getRateControlLoad($status, $is_deleted, $planRateId, $row,$type, $control_load_1_array,3,'1');
			$limit_data = array_merge($limit_data, $rateDate);

			$rateDate = self::getRateControlLoad($status, $is_deleted, $planRateId, $row,$type, $control_load_2_array,3,'2');
			$limit_data = array_merge($limit_data, $rateDate);

			$rateDate = self::getRateControlLoadAndPeak( $status, $is_deleted, $planRateId, $row,3);
			$limit_data = array_merge($limit_data, $rateDate);

			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * common method to get rate + control load limits. 
     */
    private static function getRateControlLoad($status, $is_deleted, $planRateId, $row,$type, $control_load_array,$rate,$load)
    {
		try
		{
			$limit_type = 'c'.$load;
			$control_load = []; 
			if (in_array($type, $control_load_array)) {
				$peakTypes = ['first','second','third','fourth'];
				foreach($peakTypes as $peakType)
				{
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $limit_type, 
						'limit_level' => self::$number_array[$peakType], 
						'limit_desc' => $row['Rate-'.$rate.' Control load '.$load.' '.$peakType.' limit description'], 
						'limit_year' => 0, 
						'limit_daily' => $row['Rate-'.$rate.' Control Load '.$load.' '.$peakType.' limit usage daily'], 
						'limit_charges' => $row['Rate-'.$rate.' Control Load '.$load.' '.$peakType.' limit charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
					]);
					if (!empty($row['Rate-'.$rate.' Control Load '.$load.' '.$peakType.' limit charges'])) {
						array_push($control_load, $dataInput);
					}
				} 
				
				if (!empty($row['Rate-'.$rate.' Remaining Control Load '.$load.' Charges'])) {
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $limit_type, 
						'limit_level' => self::$number_array['remaining'], 
						'limit_desc' => $row['Rate-'.$rate.' Remaining Control Load '.$load.' description'], 
						'limit_year' => 0, 
						'limit_daily' => 0, 
						'limit_charges' => $row['Rate-'.$rate.' Remaining Control Load '.$load.' Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
					]);
					array_push($control_load, $dataInput);
				}
			}
			return $control_load;
		}
        catch (\Exception $err) {
            throw $err;
        }
    }

	/**
     * common method to get offpeak and shoulder rate limits. 
     */
	private static function getOffpeakShoulderData( $status, $is_deleted, $planRateId, $row,$shoulder_yes,$timeOfUseArray)
	{
		try
		{
			$limit_data = [];
			$limit_type = 'offpeak';
			//offpeak first
			$offpeak = [];
			if (!empty($row['Rate-3 First Off-Peak Charges'])) {
				$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $limit_type, 
					'limit_level' => self::$number_array['first'], 
					'limit_desc' => $row['Rate-3 First Off-Peak Charges Description'], 
					'limit_year' => 0, 
					'limit_daily' => $row['Rate-3 First Off-Peak Usage Limit Per Day'], 
					'limit_charges' => $row['Rate-3 First Off-Peak Charges'], 
					'status' => $status, 
					'is_deleted' => $is_deleted
					]);
				array_push($offpeak, $dataInput);
			}
			//offpeak second
			if (!empty($row['Rate-3 Second Off-Peak Charges'])) {
				$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $limit_type, 
					'limit_level' => self::$number_array['second'], 
					'limit_desc' => $row['Rate-3 Second Off-Peak Charges Description'], 
					'limit_year' => 0, 
					'limit_daily' => $row['Rate-3 Second Off-Peak Usage Limit Per Day'], 
					'limit_charges' => $row['Rate-3 Second Off-Peak Charges'], 
					'status' => $status, 
					'is_deleted' => $is_deleted
					]);
				array_push($offpeak, $dataInput);
			}
			//remaining off peak
			if (!empty($row['Rate-3 Remaining Off-Peak Charges'])) {
				$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $limit_type, 
					'limit_level' => self::$number_array['remaining'], 
					'limit_desc' => $row['Rate-3 Remaining Off-Peak Charges Description'], 'limit_year' => 0, 'limit_daily' => 0, 
					'limit_charges' => $row['Rate-3 Remaining Off-Peak Charges'], 
					'status' => $status, 
					'is_deleted' => $is_deleted
					]);
				array_push($offpeak, $dataInput);
			}
			$limit_data = array_merge($limit_data, $offpeak);
			
			if ($shoulder_yes == 'yes') {
				$limit_type = 'shoulder';
				$shoulder_limit = [];
				//shoulder first
				if (!empty($row['Rate-3 First Shoulder Charges'])) {
					//chek if time of use type the update the time of use to flexible.
					// if (in_array($type, $timeOfUseArray)) {
						//updating it as flexible.
						//PlanRate::where('id', $planRateId)->update(array('time_of_use_rate_type' => '1'));
					// }
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $limit_type, 
						'limit_level' => self::$number_array['first'], 
						'limit_desc' => $row['Rate-3 First Shoulder Charges Description'], 
						'limit_year' => 0, 
						'limit_daily' => $row['Rate-3 First Shoulder Usage Limit Per Day'], 
						'limit_charges' => $row['Rate-3 First Shoulder Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
						]);
					array_push($shoulder_limit, $dataInput);
				}
				//shoulder second
				if (!empty($row['Rate-3 Second Shoulder Charges'])) {
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $limit_type, 
						'limit_level' => self::$number_array['second'], 
						'limit_desc' => $row['Rate-3 Second Shoulder Charges Description'], 
						'limit_year' => 0, 
						'limit_daily' => $row['Rate-3 Second Shoulder Usage Limit Per Day'], 
						'limit_charges' => $row['Rate-3 Second Shoulder Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
						]);
					array_push($shoulder_limit, $dataInput);
				}
				//remaining shoulder
				if (!empty($row['Rate-3 Remaining Shoulder Charges'])) {
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $limit_type, 
						'limit_level' => self::$number_array['remaining'], 
						'limit_desc' => $row['Rate-3 Remaining Shoulder Charges Description'], 
						'limit_year' => 0, 
						'limit_daily' => 0, 
						'limit_charges' => $row['Rate-3 Remaining Shoulder Charges'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
					]);
					array_push($shoulder_limit, $dataInput);
				}
				$limit_data = array_merge($limit_data, $shoulder_limit);
			}
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}

	/**
     * common method to get rate +control load + peak limits. 
     */
    private static function getRateControlLoadAndPeak( $status, $is_deleted, $planRateId, $row,$rate)
    {
		try
		{
			$limit_data = [];
			$loadTypes =['1','2'];
			$limitTypes =['offpeak','shoulder'];
			foreach($loadTypes as $loadType)
			{
				foreach($limitTypes as $limitType)
				{	 
					$limitTypeName = 'c'.$loadType.'_'.$limitType;
					if (!empty($row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' first limit charges'])) {
						$dataInput = self::setRateDefaultValue([
							'plan_rate_id' => $planRateId, 
							'limit_type' => $limitTypeName, 
							'limit_level' => self::$number_array['first'], 
							'limit_desc' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' first limit description'], 
							'limit_year' => 0, 'limit_daily' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' first limit daily usage'], 
							'limit_charges' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' first limit charges'], 
							'status' => $status, 
							'is_deleted' => $is_deleted
						]);

						array_push($limit_data, $dataInput);
					} 

					if (!empty($row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' second limit charges'])) {
						$dataInput = self::setRateDefaultValue([
							'plan_rate_id' => $planRateId, 
							'limit_type' => $limitTypeName, 
							'limit_level' => self::$number_array['second'], 'limit_desc' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' second limit description'], 
							'limit_year' => 0, 
							'limit_daily' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' second limit daily usage'], 
							'limit_charges' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' second limit charges'], 
							'status' => $status, 
							'is_deleted' => $is_deleted
						]);
						array_push($limit_data, $dataInput);
					}
					
					if (!empty($row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' remaining limit charges'])) {
						$dataInput = self::setRateDefaultValue([
							'plan_rate_id' => $planRateId, 
							'limit_type' => $limitTypeName, 
							'limit_level' => self::$number_array['remaining'], 
							'limit_desc' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' remaining limit description'], 
							'limit_year' => 0, 'limit_daily' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' remaining limit daily usage'], 
							'limit_charges' => $row['Rate-'.$rate.' Control Load '.$loadType.' '.$limitType.' remaining limit charges'], 
							'status' => $status, 
							'is_deleted' => $is_deleted
						]);

						array_push($limit_data, $dataInput);
					}
				}
			} 
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
    }

	/**
     * common method to get summer winter peak limits. 
     */
	private static function getSummerWinterData($peak,$status, $is_deleted, $planRateId, $row,$type)
	{
		try
		{
			$limit_data = [];
			$peakTypes = ['1st','2nd','3rd','4th','5th','6th' ,'7th','8th' ,'9th'];
			foreach($peakTypes as $peakType)
			{
				if (!empty($row['Rate-3 '.$peakType.' Peak Usage Charges ('.$type.')']))
				{
					$dataInput = self::setRateDefaultValue([
						'plan_rate_id' => $planRateId, 
						'limit_type' => $peak,
						'limit_level' => self::$numberArray[$peakType], 
						'limit_desc' => $row['Rate-3 '.$peakType.' Peak Description ('.$type.')'], 'limit_year' => $row['Rate-3 '.$peakType.' Peak Usage Limit Yearly ('.$type.')'],
						'limit_daily' => $row['Rate-3 '.$peakType.' Peak Usage Limit Per day ('.$type.')'],
						'limit_charges' => $row['Rate-3 '.$peakType.' Peak Usage Charges ('.$type.')'], 
						'status' => $status, 
						'is_deleted' => $is_deleted
					]);
					array_push($limit_data, $dataInput);
				}
			}   
			if (!empty($row['Rate-3 Remaining Peak Usage Charges ('.$type.')'])) {
				$dataInput = self::setRateDefaultValue([
					'plan_rate_id' => $planRateId, 
					'limit_type' => $peak, 
					'limit_level' => self::$number_array['remaining'], 
					'limit_desc' => $row['Rate-3 Remaining Peak Description ('.$type.')'],
					'limit_year' => 0, 'limit_daily' => 0, 
					'limit_charges' => $row['Rate-3 Remaining Peak Usage Charges ('.$type.')'], 
					'status' => $status, 
					'is_deleted' => $is_deleted]);

				array_push($limit_data, $dataInput);
			}
			return $limit_data;
		}
        catch (\Exception $err) {
            throw $err;
        }
	}
}