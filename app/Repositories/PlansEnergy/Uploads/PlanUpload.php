<?php
namespace App\Repositories\PlansEnergy\Uploads;
use App\Models\{PlanEnergy,PlanEicContent,PlanRemarketingInformation}; 
use Carbon\Carbon; 
use Config;

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
			$arr=['yes','no','YES','NO','Yes','No'];
			$property=['business','residential']; 
			$contractLength = Config::get('planData.contract_length');
			$benefitTerms = Config::get('planData.benefit_terms');
			$billingOption = Config::get('planData.billing_option');
			
			$columns = ['Discount','Exit fee','Benefit Terms','Contract','Plan Name','Plan Description' , 'Paper bill fee', 'Counter Fee',
			'Credit Card Service Fee', 'Cooling Off Period', 'Other fee Section',
			'Payment Options', 'Plan Features', 'Terms & Conditions'];
			if($energyType=='lpg'){
				array_push($columns, "Plan Offer", "Eligibility","Offer Details");
			}
			// echo "<pre>";print_r($data);die;
			
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

			if(isset($data['Plan Type'])&& empty($data['Plan Type'])){				
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Plan Type';
				$error['error']=  '<b>Plan Type</b> is required';
				
				array_push($errors,$error);

			}elseif(!in_array($data['Plan Type'],$property)){				
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Plan Type';
				$error['error']=  'please enter valid <b>Plan Type</b>';
				array_push($errors,$error);
			}
			if($energyType=='electricity' || $energyType=='gas'){
				if(isset($data['Show Price Fact Sheet'])&& empty($data['Show Price Fact Sheet'])){	
					
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Show Price Fact Sheet';
					$error['error']=  '<b>Show Price Fact Sheet</b> field is required';
					array_push($errors,$error);

				}
				elseif(!in_array($data['Show Price Fact Sheet'],$arr)){	
								
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Show Price Fact Sheet';
					$error['error']=  'please enter valid value in <b>Show Price Fact Sheet</b>';
					array_push($errors,$error);
				}
			}
		
			if(isset($data['Is this plan is dual only'])&& empty($data['Is this plan is dual only'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'this plan is dual only';
				$error['error']=  '<b>this plan is dual only</b> field is required';
				array_push($errors,$error);
			}elseif(!in_array($data['Is this plan is dual only'],$arr)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'this plan is dual only';
				$error['error']=  'please enter valid value in  <b>this plan is dual only</b>';
				array_push($errors,$error);
			}
			if(isset($data['Green Options'])&& empty($data['Green Options'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Green Options';
				$error['error']=  '<b>Green Options</b>  field is required';
				array_push($errors,$error);
			}elseif(!in_array($data['Green Options'],$arr)){
				
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Green Options';
				$error['error']=  'please enter valid value in <b>Green Options</b>';
				array_push($errors,$error);
			}
			if(isset($data['Green Options'])&& strtolower($data['Green Options']) == 'yes'){
				if(isset($data['Green Options Desc'])&& empty($data['Green Options Desc'])){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Green Options Desc';
					$error['error']=  '<b>Green Options Desc</b>  field is required';
					array_push($errors,$error);
				}
			}

			if(isset($data['Contract Length']) && empty($data['Contract Length'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Contract Length';
				$error['error']=  '<b>Contract Length</b> field is required.';
				array_push($errors,$error);
			}elseif(!in_array($data['Contract Length'],$contractLength)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Contract Length';
				$error['error']=  'please enter valid value in <b>Contract Length</b>';
				array_push($errors,$error);
			}

			if(isset($data['Benefit Term']) && empty($data['Benefit Term'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Benefit Term';
				$error['error']=  '<b>Benefit Term</b> field is required.';
				array_push($errors,$error);
			}elseif(!in_array($data['Benefit Term'],$benefitTerms)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Benefit Term';
				$error['error']=  'please enter valid value in <b>Benefit Term</b>';
				array_push($errors,$error);
			}
			if($energyType=='electricity' || $energyType=='gas'){
				if(isset($data['Billing Options']) && empty($data['Billing Options'])  ){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Billing Options';
					$error['error']=  '<b>Billing Options</b> field is required.';
					array_push($errors,$error);
				}
				elseif(!in_array($data['Billing Options'],$billingOption)){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Billing Options';
					$error['error']=  'please enter valid value in <b>Billing Options</b>';
					array_push($errors,$error);
				}
			}

			//solar validation only when energy type is electricity
			if($energyType=='electricity'){
				if(isset($data['Solar Compatible'])&& empty($data['Solar Compatible'])){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Solar Compatible';
					$error['error']=  '<b>Solar Compatible</b> field is required';
					array_push($errors,$error);
				}elseif(!in_array($data['Solar Compatible'],$arr)){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Solar Compatible';
					$error['error']=  'please enter valid value in <b>Solar Compatible</b>';
					array_push($errors,$error);
				}
		
				if(isset($data['Show this plan only when solar option is yes'])&& empty($data['Show this plan only when solar option is yes'])){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Show this plan only when solar option is yes';
					$error['error']=  '<b>Show this plan only when solar option is yes</b> field is required';
					array_push($errors,$error);
				}elseif(!in_array($data['Show this plan only when solar option is yes'],$arr)){
					$error=[];
					$error['key'] = $key;
					$error['column'] = 'Solar Compatible';
					$error['error']=  'please enter valid value in <b>Show this plan only when solar option is yes</b>';
					array_push($errors,$error);
				}
			}
			// else if($energyType=='lpg'){
			
				
			// }
			if(isset($data['Is this plan is a bundle dual plan (Same Family)'])&& empty($data['Is this plan is a bundle dual plan (Same Family)'])){
				$error[]= ['<b>Is this plan is a bundle dual plan (Same Family)</b> field is required'];
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Is this plan is a bundle dual plan (Same Family)';
				$error['error']=  '<b>Is this plan is a bundle dual plan (Same Family)</b> field is required';
				array_push($errors,$error);
			}elseif(!in_array($data['Is this plan is a bundle dual plan (Same Family)'],$arr)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Solar Compatible';
				$error['error']= 'please enter valid value in <b>Is this plan is a bundle dual plan (Same Family)</b>';
				array_push($errors,$error);
			}
			
			if(isset($data['Recurring Meter Charges in Dollar (Yearly)']) && !is_numeric($data['Recurring Meter Charges in Dollar (Yearly)'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Recurring Meter Charges in Dollar (Yearly)';
				$error['error']=  '<b>Recurring Meter Charges in Dollar (Yearly)</b> field should be numeric only.';
				array_push($errors,$error);
			}
			if(isset($data['Credit/Bonus in Dollar (Yearly)']) && !is_numeric($data['Credit/Bonus in Dollar (Yearly)'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Credit/Bonus in Dollar (Yearly)';
				$error['error']=  '<b>Credit/Bonus in Dollar (Yearly)</b> field should be numeric only.';
				array_push($errors,$error);
			} 

			//remarketing validation
			if(isset($data['Remarketing Allow']) && empty($data['Remarketing Allow'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Remarketing Allow';
				$error['error']=  '<b>Remarketing Allow</b> field is required.';
				array_push($errors,$error);
			}elseif(!in_array($data['Remarketing Allow'],$arr)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Remarketing Allow';
				$error['error']=  'please enter valid value in <b>Remarketing Allow</b> column”.';
				array_push($errors,$error);
			}
			//if remarketing is yes 
			if(isset($data['Remarketing Allow']) && strtolower($data['Remarketing Allow'])=='yes'){
				
				$columns = ['Marketing Discount','Discount Title','Contract Terms','Termination Fee','Marketing Terms & Conditions'];
			
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
			}

			if(isset($data['Apply Now Content']) && empty($data['Apply Now Content'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Apply Now Content';
				$error['error']=  '<b>Apply Now Content</b> field is required.';
				array_push($errors,$error);
			}elseif(!in_array($data['Apply Now Content'],$arr)){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Apply Now Content';
				$error['error']=  'please enter valid value in <b>Apply Now Content</b> column”.';
				array_push($errors,$error);
			}

			if(isset($data['Apply Now Content']) && strtolower($data['Apply Now Content'])=='yes'){
				if(isset($data['Apply Now Content (Description)']) && empty($data['Apply Now Content (Description)'])){
				$error=[];
				$error['key'] = $key;
				$error['column'] = 'Apply Now Content (Description):';
				$error['error']=  '<b>Apply Now Content (Description):</b> field is required.';
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
			$statusArr = [
					'yes' => 1, 'no' => 0,
					'YES' => 1, 'NO' => 0,
					'Yes' => 1, 'No' => 0
				];
			$propertyTypes = [
					'residential' => 1, 
					'business' => 2, 
				];
			$energyTypes = [
					'electricity' => 1, 
					'gas' => 2,
					'lpg' =>3
				];
			$currentTimeStamp = Carbon::now()->toDateTimeString();
			$allErrors = $insertRecords = $remarketRecords = $eicRecords = $planRecords =  [];   
			foreach ($totalRecords as $key => $row) {
				$errors = self::validatePlan($row,$key,$energyType);
				if($errors)
				{
					array_push($allErrors,$errors);
				}
				else
				{
				
					array_push($insertRecords, $row);
					$plan['provider_id'] = $providerId;
					$plan['energy_type'] = isset($energyTypes[$energyType])?$energyTypes[$energyType]:0;
					$plan['view_discount'] = substr($row['Discount'], 0, 1000);
					$plan['view_bonus'] = substr($row['Bonus'], 0, 1000);
					$plan['view_contract'] = substr($row['Contract'], 0, 1000);
					$plan['view_exit_fee'] = substr($row['Exit fee'], 0, 1000);
					$plan['view_benefit'] = substr($row['Benefit Terms'], 0, 1000);
					$plan['name'] = substr($row['Plan Name'], 0, 100);
					$plan['plan_desc'] = substr($row['Plan Description'], 0, 1000);
					$plan['plan_type'] = isset($propertyTypes[trim(strtolower($row['Plan Type']))])?$propertyTypes[trim(strtolower($row['Plan Type']))]: NULL;

				

					$plan['dual_only'] = isset($statusArr[$row['Is this plan is dual only']])?$statusArr[$row['Is this plan is dual only']]:0;
					
					$plan['green_options'] = isset($statusArr[$row['Green Options']])?$statusArr[$row['Green Options']]:0;

					$plan['green_options_desc'] = substr($row['Green Options Desc'], 0, 1500);

					$plan['is_bundle_dual_plan'] = isset($statusArr[$row['Is this plan is a bundle dual plan (Same Family)']])?$statusArr[$row['Is this plan is a bundle dual plan (Same Family)']]:0;					
					$plan['offer_code'] = substr($row['Offer Code'], 0, 500);
					$plan['bundle_code'] = substr($row['Bundle Code'], 0, 500);										
					$plan['credit_bonus'] = substr($row['Credit/Bonus in Dollar (Yearly)'], 0, 20);
					$plan['plan_campaign_code'] = substr($row['Plan Campaign Code'], 0, 100);
					$plan['offer_type'] = substr($row['Offer Type'], 0, 100);
					$plan['promotion_code'] = substr($row['Promotion Code'], 0, 100);
				
					$plan['contract_length'] = $row['Contract Length'];
					$plan['benefit_term'] = $row['Benefit Term'];
					$plan['paper_bill_fee'] = substr($row['Paper bill fee'], 0, 5000);
					$plan['counter_fee'] = substr($row['Counter Fee'], 0, 5000);
					$plan['credit_card_service_fee'] = substr($row['Credit Card Service Fee'], 0, 5000);
					
					$plan['other_fee_section'] = substr($row['Other fee Section'], 0, 5000);
					$plan['plan_bonus'] = substr($row['Plan Bonus'], 0, 250);
					$plan['plan_bonus_desc'] = $row['Plan Bonus Description'];
				
					$plan['payment_options'] = substr($row['Payment Options'], 0, 1500);
					$plan['plan_features'] = $row['Plan Features'];
					$plan['terms_condition'] = $row['Terms & Conditions'];

					$plan['apply_now_status'] = isset($statusArr[$row['Apply Now Content']])?$statusArr[$row['Apply Now Content']]:0; 

					$plan['apply_now_content'] = substr($row['Apply Now Content (Description)'], 0, 5);
					$plan['generate_token'] = 1;  
					$plan['solar_compatible'] = $plan['show_solar_plan'] = 0;
					$plan['upload_on'] = $currentTimeStamp;  
					$plan['status'] = 1;
            		$plan['active_on'] = $currentTimeStamp;  
					if($energyType == 'electricity')
					{
					
						$plan['solar_compatible'] = isset($statusArr[$row['Solar Compatible']])?$statusArr[$row['Solar Compatible']]:0;
					    $plan['show_solar_plan'] = isset($statusArr[$row['Show this plan only when solar option is yes']])?$statusArr[$row['Show this plan only when solar option is yes']]:0;
						$plan['campaign_code'] = substr($row['Campaign Code Sme Elec'], 0, 100);
						$plan['product_code'] = substr($row['Product Code E'], 0, 100);
						if(trim(strtolower($row['Plan Type'])) == 'residential')
						{
							$plan['campaign_code'] = substr($row['Campaign Code Res Elec'], 0, 100);
						}
						$plan['show_price_fact'] = isset($statusArr[$row['Show Price Fact Sheet']])? $statusArr[$row['Show Price Fact Sheet']]:0;
						$plan['recurring_meter_charges'] = substr($row['Recurring Meter Charges in Dollar (Yearly)'], 0, 20);
						$plan['billing_options'] = ($row['Billing Options']);
						$plan['cooling_off_period'] = substr($row['Cooling Off Period'], 0, 5000);
						
					}
					else if($energyType == 'lpg'){
					
						$plan['plan_offer_status'] = $row['Plan Offer Status'];
						$plan['plan_offer'] = $row['Plan Offer'];
						$plan['eligibility'] = $row['Eligibility'];
						$plan['offer_details'] = $row['Offer Details'];
						$plan['product_code'] = substr($row['Product Code E'], 0, 100);
						if(trim(strtolower($row['Plan Type'])) == 'residential')
						{
							$plan['campaign_code'] = substr($row['Campaign Code Res Elec'], 0, 100);
						}
					}
					else if($energyType == 'gas'){
						$plan['product_code'] = substr($row['Product Code G'], 0, 100);
						$plan['campaign_code'] = substr($row['Campaign Code Sme Gas'], 0, 100);
						if(trim(strtolower($row['Plan Type'])) == 'residential')
						{
							$plan['campaign_code'] = substr($row['Campaign Code Res Gas'], 0, 100);
						}
						$plan['show_price_fact'] = isset($statusArr[$row['Show Price Fact Sheet']])? $statusArr[$row['Show Price Fact Sheet']]:0;
						$plan['recurring_meter_charges'] = substr($row['Recurring Meter Charges in Dollar (Yearly)'], 0, 20);
						$plan['billing_options'] = ($row['Billing Options']);
						$plan['cooling_off_period'] = substr($row['Cooling Off Period'], 0, 5000);
					}
					
					array_push($planRecords, $plan);
				}   

			}  

			//Plan Bonus Description check this as well
			// echo "<pre>";print_r($planRecords);die;
			$result = PlanEnergy::insert(mb_convert_encoding($planRecords, 'UTF-8', 'UTF-8')); 
			if($result)
			{
				$newRecordsLength = count($planRecords);
				$lastIds = PlanEnergy::orderBy('id', 'desc')->take($newRecordsLength)->pluck('id')->toArray(); 
				foreach($insertRecords as $row) 
				{ 
					--$newRecordsLength;
					$remarketing['plan_id'] = $lastIds[$newRecordsLength]; 
					$remarketing['remarketing_allow'] = isset($statusArr[$row['Remarketing Allow']])?$statusArr[$row['Remarketing Allow']]:0;
					$remarketing['discount'] = substr($row['Marketing Discount'], 0, 10);
					$remarketing['contract_term'] = $row['Contract Terms'];
					$remarketing['discount_title'] = substr($row['Discount Title'], 0, 150); 
					$remarketing['termination_fee'] = substr($row['Termination Fee'], 0, 5);
					$remarketing['remarketing_terms_conditions'] = $row['Marketing Terms & Conditions']; 
					
					array_push($remarketRecords, $remarketing);

					$eic['status'] = 0;
					$eic['plan_id'] = $lastIds[$newRecordsLength];
					array_push($eicRecords, $eic);    
				}
				PlanRemarketingInformation::insert(mb_convert_encoding($remarketRecords, 'UTF-8', 'UTF-8'));
				PlanEicContent::insert(mb_convert_encoding($eicRecords, 'UTF-8', 'UTF-8'));
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
					'Discount',
					'Bonus',
					'Contract',
					'Exit fee',
					'Benefit Terms',
					'Plan Name',
					'Plan Description',
					'Plan Type',
					'Show Price Fact Sheet',
					'Is this plan is dual only',
					'Green Options',
					'Green Options Desc',
					'Solar Compatible',
					'Show this plan only when solar option is yes',
					'Is this plan is a bundle dual plan (Same Family)',
					'Offer Code',
					'Bundle Code',
					'Recurring Meter Charges in Dollar (Yearly)',
					'Credit/Bonus in Dollar (Yearly)',
					'Plan Campaign Code',
					'Offer Type',
					'Product Code E',
					'Campaign Code Sme Elec',
					'Campaign Code Res Elec',
					'Promotion Code',
					'Contract Length',
					'Benefit Term',
					'Paper bill fee',
					'Counter Fee',
					'Credit Card Service Fee',
					'Cooling Off Period',
					'Other fee Section',
					'Plan Bonus',
					'Plan Bonus Description',
					'Billing Options',
					'Payment Options',
					'Plan Features',
					'Terms & Conditions',
					'Remarketing Allow',
					'Marketing Discount',
					'Discount Title',
					'Contract Terms',
					'Termination Fee',
					'Marketing Terms & Conditions',
					'Apply Now Content',
					'Apply Now Content (Description)'
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

	/**
     * check format of gas plan sheet file
     */
	public static function readgasPlanCSV($path)
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
					'Discount',
					'Bonus',
					'Contract',
					'Exit fee',
					'Benefit Terms',
					'Plan Name',
					'Plan Description',
					'Plan Type',
					'Show Price Fact Sheet',
					'Is this plan is dual only',
					'Green Options',
					'Green Options Desc',
					'Is this plan is a bundle dual plan (Same Family)',
					'Offer Code',
					'Bundle Code',
					'Recurring Meter Charges in Dollar (Yearly)',
					'Credit/Bonus in Dollar (Yearly)',
					'Plan Campaign Code',
					'Offer Type',
					'Product Code G',
					'Campaign Code Sme Gas',
					'Campaign Code Res Gas',
					'Promotion Code',
					'Contract Length',
					'Benefit Term',
					'Paper bill fee',
					'Counter Fee',
					'Credit Card Service Fee',
					'Cooling Off Period',
					'Other fee Section',
					'Plan Bonus',
					'Plan Bonus Description',
					'Billing Options',
					'Payment Options',
					'Plan Features',
					'Terms & Conditions',
					'Remarketing Allow',
					'Marketing Discount',
					'Discount Title',
					'Contract Terms',
					'Termination Fee',
					'Marketing Terms & Conditions',
					'Apply Now Content',
					'Apply Now Content (Description)'
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
		/**
     * check format of lpg plan sheet file
     */
    public static function readlpgPlanCSV($path)
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
					'Discount',
					'Bonus',
					'Contract',
					'Exit fee',
					'Benefit Terms',
					'Plan Name',
					'Plan Description',
					'Plan Type',
					'Is this plan is dual only',
					'Green Options',
					'Green Options Desc',
					'Is this plan is a bundle dual plan (Same Family)',
					'Offer Code',
					'Bundle Code',
					'Credit/Bonus in Dollar (Yearly)',
					'Plan Campaign Code',
					'Offer Type',
					'Product Code E',
					'Campaign Code Res Elec',
					'Promotion Code',
					'Contract Length',
					'Benefit Term',
					'Paper bill fee',
					'Counter Fee',
					'Credit Card Service Fee',
					'Other fee Section',
					'Plan Bonus',
					'Plan Bonus Description',
					'Payment Options',
					'Plan Features',
					'Terms & Conditions',
					'Remarketing Allow',
					'Marketing Discount',
					'Discount Title',
					'Contract Terms',
					'Termination Fee',
					'Plan Offer Status',
					'Marketing Terms & Conditions',
					'Apply Now Content',
					'Apply Now Content (Description)'
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
