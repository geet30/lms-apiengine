<?php
namespace App\Repositories\PlansEnergy\Uploads; 

trait PlanRateUploadValidation
{ 
    public static function readPlanRateCSV($path)
	{
		try
        {
			ini_set('auto_detect_line_endings', true);
			if (!file_exists($path) || !is_readable($path))
				return false;
			$data = array();
			if (($handle = fopen($path, 'r')) !== false) {
				$data = array();
				$header = fgetcsv($handle);
				$target = array(
							"Distributor", 
							"Type",
							"Where we need to add these rates", 
							"Rate Type", "Tariff Description", 
							"Exit Fee Option", "Exit Fee", 
							"Late payment fee title", 
							"Late payment fee", 
							"Dual Fuel Discount on Usage", 
							"Dual Fuel Discount on Supply", 
							"Dual Fuel Discount Description", 
							"Pay Day Discount on Usage", 
							"Pay Day Discount on Supply", 
							"Pay Day Discount on Usage Description", 
							"Pay Day Discount on Supply Description", 
							"Guaranteed Discount on Usage", 
							"Guaranteed Discount on Supply", 
							"Guaranteed Discount on Usage Description", 
							"Guaranteed Discount on Supply Description", 
							"Direct Debit Discount on Usage", 
							"Direct Debit Discount on Supply", 
							"Direct Debit Discount Description", 
							"Demand Charge Type",

							"Rate-1 Daily Supply Charges", 
							"Rate-1 Daily Capacity/Demand Supply Charges", 
							"Rate-1 Capacity/Demand Usage Description", 
							"Rate-1 Capacity/Demand Usage Charges", 
							
							"Rate-1 1st Peak Description", 
							"Rate-1 1st Peak Usage Limit Yearly", 
							"Rate-1 1st Peak Usage Limit Per day", 
							"Rate-1 1st Peak Usage Charges", 
							"Rate-1 2nd Peak Description", 
							"Rate-1 2nd Peak Usage Limit Yearly", 
							"Rate-1 2nd Peak Usage Limit Per day", 
							"Rate-1 2nd Peak Usage Charges", 
							"Rate-1 3rd Peak Description", 
							"Rate-1 3rd Peak Usage Limit Yearly", 
							"Rate-1 3rd Peak Usage Limit Per day", 
							"Rate-1 3rd Peak Usage Charges",
							"Rate-1 4th Peak Description",
							"Rate-1 4th Peak Usage Limit Yearly", 
							"Rate-1 4th Peak Usage Limit Per day", 
							"Rate-1 4th Peak Usage Charges", 
							"Rate-1 5th Peak Description", 
							"Rate-1 5th Peak Usage Limit Yearly", 
							"Rate-1 5th Peak Usage Limit Per day", 
							"Rate-1 5th Peak Usage Charges", 
							"Rate-1 6th Peak Description", 
							"Rate-1 6th Peak Usage Limit Yearly", 
							"Rate-1 6th Peak Usage Limit Per day", 
							"Rate-1 6th Peak Usage Charges", 
							"Rate-1 7th Peak Description", 
							"Rate-1 7th Peak Usage Limit Yearly", 
							"Rate-1 7th Peak Usage Limit Per day", 
							"Rate-1 7th Peak Usage Charges", 
							"Rate-1 8th Peak Description", 
							"Rate-1 8th Peak Usage Limit Yearly", 
							"Rate-1 8th Peak Usage Limit Per day",
							"Rate-1 8th Peak Usage Charges", 
							"Rate-1 9th Peak Description", 
							"Rate-1 9th Peak Usage Limit Yearly", 
							"Rate-1 9th Peak Usage Limit Per day", 
							"Rate-1 9th Peak Usage Charges", 
							"Rate-1 Remaining Peak Description", 
							"Rate-1 Remaining Peak Usage Charges", 
							
							"Rate-1 Daily Supply Charges for Control Load 1", 
							"Rate-1 Control load 1 first limit description", 
							"Rate-1 Control Load 1 first limit usage daily", 
							"Rate-1 Control Load 1 first limit charges", 
							"Rate-1 Control load 1 second limit description", 
							"Rate-1 Control Load 1 second limit usage daily", 
							"Rate-1 Control Load 1 second limit charges", 
							"Rate-1 Control load 1 third limit description", 
							"Rate-1 Control Load 1 third limit usage daily", 
							"Rate-1 Control Load 1 third limit charges", 
							"Rate-1 Control load 1 fourth limit description", 
							"Rate-1 Control Load 1 fourth limit usage daily", 
							"Rate-1 Control Load 1 fourth limit charges", 
							"Rate-1 Remaining Control Load 1 description", 
							"Rate-1 Remaining Control Load 1 Charges", 
							"Rate-1 Daily Supply Charges for Control Load 2", 
							"Rate-1 Control load 2 first limit description", 
							"Rate-1 Control Load 2 first limit usage daily", 
							"Rate-1 Control Load 2 first limit charges", 
							"Rate-1 Control load 2 second limit description", 
							"Rate-1 Control Load 2 second limit usage daily", 
							"Rate-1 Control Load 2 second limit charges", 
							"Rate-1 Control load 2 third limit description", 
							"Rate-1 Control Load 2 third limit usage daily", 
							"Rate-1 Control Load 2 third limit charges", 
							"Rate-1 Control load 2 fourth limit description", 
							"Rate-1 Control Load 2 fourth limit usage daily", 
							"Rate-1 Control Load 2 fourth limit charges", 
							"Rate-1 Remaining Control Load 2 description", 
							"Rate-1 Remaining Control Load 2 Charges", 



							"Rate-2 Daily Supply Charges", 
							"Rate-2 Daily Capacity/Demand Supply Charges", 
							"Rate-2 Capacity/Demand Usage Description", 
							"Rate-2 Capacity/Demand Usage Charges", 

							"Rate-2 1st Peak Description", 
							"Rate-2 1st Peak Usage Limit Yearly", 
							"Rate-2 1st Peak Usage Limit Per day", 
							"Rate-2 1st Peak Usage Charges", 
							"Rate-2 2nd Peak Description", 
							"Rate-2 2nd Peak Usage Limit Yearly", 
							"Rate-2 2nd Peak Usage Limit Per day", 
							"Rate-2 2nd Peak Usage Charges", 
							"Rate-2 3rd Peak Description", 
							"Rate-2 3rd Peak Usage Limit Yearly", 
							"Rate-2 3rd Peak Usage Limit Per day", 
							"Rate-2 3rd Peak Usage Charges", 
							"Rate-2 4th Peak Description", 
							"Rate-2 4th Peak Usage Limit Yearly", 
							"Rate-2 4th Peak Usage Limit Per day", 
							"Rate-2 4th Peak Usage Charges", 
							"Rate-2 5th Peak Description", 
							"Rate-2 5th Peak Usage Limit Yearly", 
							"Rate-2 5th Peak Usage Limit Per day", 
							"Rate-2 5th Peak Usage Charges", 
							"Rate-2 6th Peak Description", 
							"Rate-2 6th Peak Usage Limit Yearly", 
							"Rate-2 6th Peak Usage Limit Per day", 
							"Rate-2 6th Peak Usage Charges", 
							"Rate-2 7th Peak Description", 
							"Rate-2 7th Peak Usage Limit Yearly", 
							"Rate-2 7th Peak Usage Limit Per day", 
							"Rate-2 7th Peak Usage Charges", 
							"Rate-2 8th Peak Description", 
							"Rate-2 8th Peak Usage Limit Yearly", 
							"Rate-2 8th Peak Usage Limit Per day", 
							"Rate-2 8th Peak Usage Charges", 
							"Rate-2 9th Peak Description", 
							"Rate-2 9th Peak Usage Limit Yearly", 
							"Rate-2 9th Peak Usage Limit Per day", 
							"Rate-2 9th Peak Usage Charges", 
							"Rate-2 Remaining Peak Description", 
							"Rate-2 Remaining Peak Usage Charges",

							"Rate-2 Daily Supply Charges for Control Load 1",
							"Rate-2 Control load 1 first limit description",
							"Rate-2 Control Load 1 first limit usage daily",
							"Rate-2 Control Load 1 first limit charges",
							"Rate-2 Control load 1 second limit description",
							"Rate-2 Control Load 1 second limit usage daily",
							"Rate-2 Control Load 1 second limit charges",
							"Rate-2 Control load 1 third limit description",
							"Rate-2 Control Load 1 third limit usage daily",
							"Rate-2 Control Load 1 third limit charges",
							"Rate-2 Control load 1 fourth limit description",
							"Rate-2 Control Load 1 fourth limit usage daily",
							"Rate-2 Control Load 1 fourth limit charges",
							"Rate-2 Remaining Control Load 1 description",
							"Rate-2 Remaining Control Load 1 Charges",
							"Rate-2 Daily Supply Charges for Control Load 2",
							"Rate-2 Control load 2 first limit description",
							"Rate-2 Control Load 2 first limit usage daily",
							"Rate-2 Control Load 2 first limit charges",
							"Rate-2 Control load 2 second limit description",
							"Rate-2 Control Load 2 second limit usage daily",
							"Rate-2 Control Load 2 second limit charges",
							"Rate-2 Control load 2 third limit description",
							"Rate-2 Control Load 2 third limit usage daily",
							"Rate-2 Control Load 2 third limit charges",
							"Rate-2 Control load 2 fourth limit description",
							"Rate-2 Control Load 2 fourth limit usage daily",
							"Rate-2 Control Load 2 fourth limit charges",
							"Rate-2 Remaining Control Load 2 description",
							"Rate-2 Remaining Control Load 2 Charges",
							
							"Rate-3 Meter Type",
							"Rate-3 Daily Capacity/Demand Supply Charges",
							"Rate-3 Capacity/Demand Usage Description",
							"Rate-3 Capacity/Demand Usage Charges",
							"Rate-3 Daily Supply Charges (summer/Winter)",
							
							"Rate-3 1st Peak Description (summer)",
							"Rate-3 1st Peak Usage Limit Yearly (summer)",
							"Rate-3 1st Peak Usage Limit Per day (summer)",
							"Rate-3 1st Peak Usage Charges (summer)",
							"Rate-3 2nd Peak Description (summer)",
							"Rate-3 2nd Peak Usage Limit Yearly (summer)",
							"Rate-3 2nd Peak Usage Limit Per day (summer)",
							"Rate-3 2nd Peak Usage Charges (summer)",
							"Rate-3 3rd Peak Description (summer)",
							"Rate-3 3rd Peak Usage Limit Yearly (summer)",
							"Rate-3 3rd Peak Usage Limit Per day (summer)",
							"Rate-3 3rd Peak Usage Charges (summer)",
							"Rate-3 4th Peak Description (summer)",
							"Rate-3 4th Peak Usage Limit Yearly (summer)",
							"Rate-3 4th Peak Usage Limit Per day (summer)",
							"Rate-3 4th Peak Usage Charges (summer)",
							"Rate-3 5th Peak Description (summer)",
							"Rate-3 5th Peak Usage Limit Yearly (summer)",
							"Rate-3 5th Peak Usage Limit Per day (summer)",
							"Rate-3 5th Peak Usage Charges (summer)",
							"Rate-3 6th Peak Description (summer)",
							"Rate-3 6th Peak Usage Limit Yearly (summer)",
							"Rate-3 6th Peak Usage Limit Per day (summer)",
							"Rate-3 6th Peak Usage Charges (summer)",
							"Rate-3 7th Peak Description (summer)",
							"Rate-3 7th Peak Usage Limit Yearly (summer)",
							"Rate-3 7th Peak Usage Limit Per day (summer)",
							"Rate-3 7th Peak Usage Charges (summer)",
							"Rate-3 8th Peak Description (summer)",
							"Rate-3 8th Peak Usage Limit Yearly (summer)",
							"Rate-3 8th Peak Usage Limit Per day (summer)",
							"Rate-3 8th Peak Usage Charges (summer)",
							"Rate-3 9th Peak Description (summer)",
							"Rate-3 9th Peak Usage Limit Yearly (summer)",
							"Rate-3 9th Peak Usage Limit Per day (summer)",
							"Rate-3 9th Peak Usage Charges (summer)",
							"Rate-3 Remaining Peak Description (summer)",
							"Rate-3 Remaining Peak Usage Charges (summer)",
							
							"Rate-3 1st Peak Description (Winter)",
							"Rate-3 1st Peak Usage Limit Yearly (Winter)",
							"Rate-3 1st Peak Usage Limit Per day (Winter)",
							"Rate-3 1st Peak Usage Charges (Winter)",
							"Rate-3 2nd Peak Description (Winter)",
							"Rate-3 2nd Peak Usage Limit Yearly (Winter)",
							"Rate-3 2nd Peak Usage Limit Per day (Winter)",
							"Rate-3 2nd Peak Usage Charges (Winter)",
							"Rate-3 3rd Peak Description (Winter)",
							"Rate-3 3rd Peak Usage Limit Yearly (Winter)",
							"Rate-3 3rd Peak Usage Limit Per day (Winter)",
							"Rate-3 3rd Peak Usage Charges (Winter)",
							"Rate-3 4th Peak Description (Winter)",
							"Rate-3 4th Peak Usage Limit Yearly (Winter)",
							"Rate-3 4th Peak Usage Limit Per day (Winter)",
							"Rate-3 4th Peak Usage Charges (Winter)",
							"Rate-3 5th Peak Description (Winter)",
							"Rate-3 5th Peak Usage Limit Yearly (Winter)",
							"Rate-3 5th Peak Usage Limit Per day (Winter)",
							"Rate-3 5th Peak Usage Charges (Winter)",
							"Rate-3 6th Peak Description (Winter)",
							"Rate-3 6th Peak Usage Limit Yearly (Winter)",
							"Rate-3 6th Peak Usage Limit Per day (Winter)",
							"Rate-3 6th Peak Usage Charges (Winter)",
							"Rate-3 7th Peak Description (Winter)",
							"Rate-3 7th Peak Usage Limit Yearly (Winter)",
							"Rate-3 7th Peak Usage Limit Per day (Winter)",
							"Rate-3 7th Peak Usage Charges (Winter)",
							"Rate-3 8th Peak Description (Winter)",
							"Rate-3 8th Peak Usage Limit Yearly (Winter)",
							"Rate-3 8th Peak Usage Limit Per day (Winter)",
							"Rate-3 8th Peak Usage Charges (Winter)",
							"Rate-3 9th Peak Description (Winter)",
							"Rate-3 9th Peak Usage Limit Yearly (Winter)",
							"Rate-3 9th Peak Usage Limit Per day (Winter)",
							"Rate-3 9th Peak Usage Charges (Winter)",
							"Rate-3 Remaining Peak Description (Winter)",
							"Rate-3 Remaining Peak Usage Charges (Winter)",
							
							"Rate-3 First Off-Peak Charges Description",
							"Rate-3 First Off-Peak Usage Limit Per Day",
							"Rate-3 First Off-Peak Charges",
							"Rate-3 Second Off-Peak Charges Description",
							"Rate-3 Second Off-Peak Usage Limit Per Day",
							"Rate-3 Second Off-Peak Charges",
							"Rate-3 Remaining Off-Peak Charges Description",
							"Rate-3 Remaining Off-Peak Charges",
							"Rate-3 First Shoulder Charges Description",
							"Rate-3 First Shoulder Usage Limit Per Day",
							"Rate-3 First Shoulder Charges",
							"Rate-3 Second Shoulder Charges Description",
							"Rate-3 Second Shoulder Usage Limit Per Day",
							"Rate-3 Second Shoulder Charges",
							"Rate-3 Remaining Shoulder Charges Description",
							"Rate-3 Remaining Shoulder Charges",
							
							"Rate-3 Daily Supply Charges for Control Load 1",
							"Rate-3 Control load 1 first limit description",
							"Rate-3 Control Load 1 first limit usage daily",
							"Rate-3 Control Load 1 first limit charges",
							"Rate-3 Control load 1 second limit description",
							"Rate-3 Control Load 1 second limit usage daily",
							"Rate-3 Control Load 1 second limit charges",
							"Rate-3 Control load 1 third limit description",
							"Rate-3 Control Load 1 third limit usage daily",
							"Rate-3 Control Load 1 third limit charges",
							"Rate-3 Control load 1 fourth limit description",
							"Rate-3 Control Load 1 fourth limit usage daily",
							"Rate-3 Control Load 1 fourth limit charges",
							"Rate-3 Remaining Control Load 1 description",
							"Rate-3 Remaining Control Load 1 Charges",
							"Rate-3 Daily Supply Charges for Control Load 2",
							"Rate-3 Control load 2 first limit description",
							"Rate-3 Control Load 2 first limit usage daily",
							"Rate-3 Control Load 2 first limit charges",
							"Rate-3 Control load 2 second limit description",
							"Rate-3 Control Load 2 second limit usage daily",
							"Rate-3 Control Load 2 second limit charges",
							"Rate-3 Control load 2 third limit description",
							"Rate-3 Control Load 2 third limit usage daily",
							"Rate-3 Control Load 2 third limit charges",
							"Rate-3 Control load 2 fourth limit description",
							"Rate-3 Control Load 2 fourth limit usage daily",
							"Rate-3 Control Load 2 fourth limit charges",
							"Rate-3 Remaining Control Load 2 description",
							"Rate-3 Remaining Control Load 2 Charges",
							"GST Percentage",
							"Connection fee",
							"Disconnection fee",
					
							'Rate-2 Control Load 1 offpeak first limit description',
							'Rate-2 Control Load 1 offpeak first limit daily usage',
							'Rate-2 Control Load 1 offpeak first limit charges', 
							'Rate-2 Control Load 1 offpeak second limit description',
							'Rate-2 Control Load 1 offpeak second limit daily usage',
							'Rate-2 Control Load 1 offpeak second limit charges',
							'Rate-2 Control Load 1 offpeak remaining limit description',
							'Rate-2 Control Load 1 offpeak remaining limit daily usage',
							'Rate-2 Control Load 1 offpeak remaining limit charges',
							'Rate-2 Control Load 1 shoulder first limit description',
							'Rate-2 Control Load 1 shoulder first limit daily usage',
							'Rate-2 Control Load 1 shoulder first limit charges',
							'Rate-2 Control Load 1 shoulder second limit description',
							'Rate-2 Control Load 1 shoulder second limit daily usage',
							'Rate-2 Control Load 1 shoulder second limit charges',
							'Rate-2 Control Load 1 shoulder remaining limit description',
							'Rate-2 Control Load 1 shoulder remaining limit daily usage',
							'Rate-2 Control Load 1 shoulder remaining limit charges',
							'Rate-2 Control Load 2 offpeak first limit description',
							'Rate-2 Control Load 2 offpeak first limit daily usage',
							'Rate-2 Control Load 2 offpeak first limit charges', 
							'Rate-2 Control Load 2 offpeak second limit description',
							'Rate-2 Control Load 2 offpeak second limit daily usage',
							'Rate-2 Control Load 2 offpeak second limit charges',
							'Rate-2 Control Load 2 offpeak remaining limit description',
							'Rate-2 Control Load 2 offpeak remaining limit daily usage',
							'Rate-2 Control Load 2 offpeak remaining limit charges',
							'Rate-2 Control Load 2 shoulder first limit description',
							'Rate-2 Control Load 2 shoulder first limit daily usage',
							'Rate-2 Control Load 2 shoulder first limit charges',
							'Rate-2 Control Load 2 shoulder second limit description',
							'Rate-2 Control Load 2 shoulder second limit daily usage',
							'Rate-2 Control Load 2 shoulder second limit charges',
							'Rate-2 Control Load 2 shoulder remaining limit description',
							'Rate-2 Control Load 2 shoulder remaining limit daily usage',
							'Rate-2 Control Load 2 shoulder remaining limit charges',

							'Rate-3 Control Load 1 offpeak first limit description',
							'Rate-3 Control Load 1 offpeak first limit daily usage',
							'Rate-3 Control Load 1 offpeak first limit charges', 
							'Rate-3 Control Load 1 offpeak second limit description',
							'Rate-3 Control Load 1 offpeak second limit daily usage',
							'Rate-3 Control Load 1 offpeak second limit charges',
							'Rate-3 Control Load 1 offpeak remaining limit description',
							'Rate-3 Control Load 1 offpeak remaining limit daily usage',
							'Rate-3 Control Load 1 offpeak remaining limit charges',
							'Rate-3 Control Load 1 shoulder first limit description',
							'Rate-3 Control Load 1 shoulder first limit daily usage',
							'Rate-3 Control Load 1 shoulder first limit charges',
							'Rate-3 Control Load 1 shoulder second limit description',
							'Rate-3 Control Load 1 shoulder second limit daily usage',
							'Rate-3 Control Load 1 shoulder second limit charges',
							'Rate-3 Control Load 1 shoulder remaining limit description',
							'Rate-3 Control Load 1 shoulder remaining limit daily usage',
							'Rate-3 Control Load 1 shoulder remaining limit charges',
							'Rate-3 Control Load 2 offpeak first limit description',
							'Rate-3 Control Load 2 offpeak first limit daily usage',
							'Rate-3 Control Load 2 offpeak first limit charges', 
							'Rate-3 Control Load 2 offpeak second limit description',
							'Rate-3 Control Load 2 offpeak second limit daily usage',
							'Rate-3 Control Load 2 offpeak second limit charges',
							'Rate-3 Control Load 2 offpeak remaining limit description',
							'Rate-3 Control Load 2 offpeak remaining limit daily usage',
							'Rate-3 Control Load 2 offpeak remaining limit charges',
							'Rate-3 Control Load 2 shoulder first limit description',
							'Rate-3 Control Load 2 shoulder first limit daily usage',
							'Rate-3 Control Load 2 shoulder first limit charges',
							'Rate-3 Control Load 2 shoulder second limit description',
							'Rate-3 Control Load 2 shoulder second limit daily usage',
							'Rate-3 Control Load 2 shoulder second limit charges',
							'Rate-3 Control Load 2 shoulder remaining limit description',
							'Rate-3 Control Load 2 shoulder remaining limit daily usage',
							'Rate-3 Control Load 2 shoulder remaining limit charges',
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

	public static function readGasPlanRateCSV($path)
	{
		try
        {
			ini_set('auto_detect_line_endings', true);
			if (!file_exists($path) || !is_readable($path))
				return false;
			$data = array();
			if (($handle = fopen($path, 'r')) !== false) {
				$data = array();
				$header = fgetcsv($handle);
				$target = array(
					"Distributor", 
					"Type", 
					"Rate Type", 
					"Tariff Description", 
					"Exit Fee Option", 
					"Exit Fee", 
					"Late payment fee", 
					"Dual Fuel Discount on Usage", 
					"Dual Fuel Discount on Supply",
					"Dual Fuel Discount Description", 
					"Direct Debit Discount on Usage", 
					"Direct Debit Discount on Supply", 
					"Direct Debit Discount Description", 
					"Pay Day Discount on Usage", 
					"Pay Day Discount on Usage Description", 
					"Pay Day Discount on Supply", 
					"Pay Day Discount on Supply Description", 
					"Guaranteed Discount on Usage", 
					"Guaranteed Discount on Usage Description", 
					"Guaranteed Discount on Supply", 
					"Guaranteed Discount on Supply Description", 
					"Rate-1 Winter Daily Supply Charges", 
					"Rate-1 1st Peak Description", 
					"Rate-1 1st Peak Usage Limit Yearly", 
					"Rate-1 1st Peak Usage Limit Per day", 
					"Rate-1 1st Peak Usage Charges", 
					"Rate-1 2nd Peak Description", 
					"Rate-1 2nd Peak Usage Limit Yearly", 
					"Rate-1 2nd Peak Usage Limit Per day", 
					"Rate-1 2nd Peak Usage Charges", 
					"Rate-1 3rd Peak Description", 
					"Rate-1 3rd Peak Usage Limit Yearly", 
					"Rate-1 3rd Peak Usage Limit Per day", 
					"Rate-1 3rd Peak Usage Charges", 
					"Rate-1 4th Peak Description", 
					"Rate-1 4th Peak Usage Limit Yearly", 
					"Rate-1 4th Peak Usage Limit Per day", 
					"Rate-1 4th Peak Usage Charges", 
					"Rate-1 5th Peak Description", 
					"Rate-1 5th Peak Usage Limit Yearly", 
					"Rate-1 5th Peak Usage Limit Per day", 
					"Rate-1 5th Peak Usage Charges", 
					"Rate-1 6th Peak Description", 
					"Rate-1 6th Peak Usage Limit Yearly", 
					"Rate-1 6th Peak Usage Limit Per day", 
					"Rate-1 6th Peak Usage Charges", 
					"Rate-1 7th Peak Description", 
					"Rate-1 7th Peak Usage Limit Yearly", 
					"Rate-1 7th Peak Usage Limit Per day", 
					"Rate-1 7th Peak Usage Charges", 
					"Rate-1 8th Peak Description", 
					"Rate-1 8th Peak Usage Limit Yearly", 
					"Rate-1 8th Peak Usage Limit Per day", 
					"Rate-1 8th Peak Usage Charges", 
					"Rate-1 9th Peak Description", 
					"Rate-1 9th Peak Usage Limit Yearly", 
					"Rate-1 9th Peak Usage Limit Per day", 
					"Rate-1 9th Peak Usage Charges", 
					"Rate-1 Remaining Peak Description", 
					"Rate-1 Remaining Peak Usage Charges", 

					"Rate-1 1st Off-Peak Description", 
					"Rate-1 1st Off-Peak Usage Limit Yearly", 
					"Rate-1 1st Off-Peak Usage Limit Per day", 
					"Rate-1 1st Off-Peak Usage Charges", 
					"Rate-1 2nd Off-Peak Description", 
					"Rate-1 2nd Off-Peak Usage Limit Yearly", 
					"Rate-1 2nd Off-Peak Usage Limit Per day", 
					"Rate-1 2nd Off-Peak Usage Charges", 
					"Rate-1 3rd Off-Peak Description", 
					"Rate-1 3rd Off-Peak Usage Limit Yearly", 
					"Rate-1 3rd Off-Peak Usage Limit Per day", 
					"Rate-1 3rd Off-Peak Usage Charges", 
					"Rate-1 4th Off-Peak Description", 
					"Rate-1 4th Off-Peak Usage Limit Yearly", 
					"Rate-1 4th Off-Peak Usage Limit Per day", 
					"Rate-1 4th Off-Peak Usage Charges", 
					"Rate-1 5th Off-Peak Description", 
					"Rate-1 5th Off-Peak Usage Limit Yearly", 
					"Rate-1 5th Off-Peak Usage Limit Per day", 
					"Rate-1 5th Off-Peak Usage Charges", 
					"Rate-1 6th Off-Peak Description", 
					"Rate-1 6th Off-Peak Usage Limit Yearly", 
					"Rate-1 6th Off-Peak Usage Limit Per day", 
					"Rate-1 6th Off-Peak Usage Charges", 
					"Rate-1 7th Off-Peak Description", 
					"Rate-1 7th Off-Peak Usage Limit Yearly", 
					"Rate-1 7th Off-Peak Usage Limit Per day", 
					"Rate-1 7th Off-Peak Usage Charges", 
					"Rate-1 8th Off-Peak Description", 
					"Rate-1 8th Off-Peak Usage Limit Yearly", 
					"Rate-1 8th Off-Peak Usage Limit Per day", 
					"Rate-1 8th Off-Peak Usage Charges", 
					"Rate-1 9th Off-Peak Description", 
					"Rate-1 9th Off-Peak Usage Limit Yearly", 
					"Rate-1 9th Off-Peak Usage Limit Per day", 
					"Rate-1 9th Off-Peak Usage Charges", 
					"Rate-1 Rate-1 Remaining  Off-Peak Description", 
					"Rate-1  Remaining Off-Peak Usage Charges", 
					"GST Percentage", 
					"Connection fee", 
					"Disconnection fee"
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
    public static function readLpgPlanRateCSV($path)
	{
		try
        {
			ini_set('auto_detect_line_endings', true);
			if (!file_exists($path) || !is_readable($path))
				return false;
			$data = array();
			if (($handle = fopen($path, 'r')) !== false) {
				$data = array();
				$header = fgetcsv($handle);
				$target = array(
							"Distributor Name", 
							"Exit Fee Option",
							"Exit Fee", 
							"Annual Equipment fees/ Rental Fees", 
							"Annual Equipment fees/ Rental Fees(desc)", 
							"Delivery Charges", 
							"Delivery Charges(Description)", 
							"Account establishment fees", 
							"Account establishment fees(Description)", 
							"Urgent Delivery Fees", 
							"Urgent Delivery Fees(Description)", 
							"Service and installation charges", 
							"Service and installation charges(Description)", 
							"Green LPG fees", 
							"Min. Quantity with discount", 
							"Max. Quantity with discount", 
							"Cash discount per bottle", 
							"Cash credits", 
							"% Discount (to get the standard cost)", 
							"Optional fees 1", 
							"Optional fees 1 Description",
							"Optional fees 2", 
							"Optional fees 2 Description", 
							"Optional fees 3", 
							"Optional fees 3 Description", 
							"Optional fees 4", 
							"Optional fees 4 Description", 
							"Optional fees 5", 
							"Optional fees 5 Description", 
							"Optional fees 6", 
							"Optional fees 6 Description", 
							"Optional fees 7", 
							"Optional fees 7 Description", 
							"Optional fees 8", 
							"Optional fees 8 Description", 
							"Optional fees 9", 
							"Optional fees 9 Description",
							"Optional fees 10",
							"Optional fees 10 Description", 
							"Urgent Delivery Window", 
							"Late Payment Fee", 
							"Connection Fee", 
							"Disconnection Fee", 
							"Price Fact Sheet/BPID/VEFS URL", 
							"Offer ID", 
							"Batch ID", 


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
	public static function planRateValidation($data, $key, $energy_type)
	{
		try
        {
			$errors = [];
			$tarif_type = ['peak_only', 'two_rate_only', 'peak_c1', 'peak_c2', 'peak_c1_c2', 'timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2', 'demand_timeofuse_only', 'demand_timeofuse_c1', 'demand_timeofuse_c2', 'demand_timeofuse_c1_c2', 'timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2', 'timeofuse_only', 'timeofuse_c1', 'timeofuse_c2', 'timeofuse_c1_c2', 'gas_peak_offpeak', 'demand_peakonly', 'demand_peak_c1', 'demand_peak_c2', 'demand_peak_c1_c2'];
			$time_of_use = ['flexible', 'normal'];
			$arr = ['yes','no'];
			$price_type = ['less', 'more', 'equal'];
			if (!isset($data['type']) || empty($data['type'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Type';
				$error['error'] = '<b>Type</b> field is required';
				array_push($errors, $error);
			} 
			elseif (!in_array(strtolower($data['type']), $tarif_type)) {
				$error['key'] = $key;
				$error['column'] = 'Type';
				$error['error'] = 'please enter valid value in <b>Type</b>';
				array_push($errors, $error);
			}
 
			if (isset($data['rate_type']) && empty($data['rate_type'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Plan Rate Type ';
				$error['error'] = '<b>Plan Rate Type </b> field is required';
				array_push($errors, $error);
			}
			elseif (!in_array(strtolower($data['rate_type']), ['normal','premium'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Plan Rate Type ';
				$error['error'] = 'please enter valid value in <b>Plan Rate</b>';
				array_push($errors, $error);
			}

			if (isset($data['exit_fee_option']) && empty($data['exit_fee_option'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Exit Fee Option ';
				$error['error'] = '<b>Exit Fee Option </b> field is required';
				array_push($errors, $error);
			} elseif (!in_array(strtolower($data['exit_fee_option']), $arr)) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Exit Fee Option ';
				$error['error'] = 'please enter valid value in <b>Exit Fee Option</b>';
				array_push($errors, $error);
			}
			if (isset($data['exit_fee_option']) && strtolower($data['exit_fee_option']) == 'yes') {
				if (isset($data['exit_fee']) && empty($data['exit_fee'])) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Exit Fee ';
					$error['error'] = '<b>Exit Fee </b> field is required';
					array_push($errors, $error);
				}
			}

			if (isset($data['type']) && $data['type'] == 'timeofuse_only') {
				if (isset($data['time_of_use_rate_type']) && empty($data['time_of_use_rate_type'])) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Time of use rate type';
					$error['error'] = '<b>Time of use rate type</b> field is required';
					array_push($errors, $error);
				} elseif (isset($data['time_of_use_rate_type']) && !in_array($data['time_of_use_rate_type'], ['1','2'])) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Time of use rate type';
					$error['error'] = 'please enter valid value in <b>Time of use rate type</b>';
					array_push($errors, $error);
				}
			}
			if (isset($data['tariff_type_title']) && empty($data['tariff_type_title'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Tariff Type Title';
				$error['error'] = '<b>Tariff Type Title</b> field is required';
				array_push($errors, $error);
			}

			if (!empty($data['dual_fuel_discount_supply']) && !is_numeric($data['dual_fuel_discount_supply'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Dual Fuel Discount on Supply';
				$error['error'] = '<b>Dual Fuel Discount on Supply</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['pay_day_discount_usage']) && !is_numeric($data['pay_day_discount_usage'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Pay Day Discount on Usage';
				$error['error'] = '<b>Pay Day Discount on Usage</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['pay_day_discount_supply']) && !is_numeric($data['pay_day_discount_supply'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Pay Day Discount on Supply';
				$error['error'] = '<b>Pay Day Discount on Supply</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['gurrented_discount_usage']) && !is_numeric($data['gurrented_discount_usage'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Gurrented Discount on Usage';
				$error['error'] = '<b>Gurrented Discount on Usage</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['dual_fuel_discount_usage']) && !is_numeric($data['dual_fuel_discount_usage'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Dual Fuel Discount on Usage';
				$error['error'] = '<b>Dual Fuel Discount on Usage</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['gurrented_discount_supply']) && !is_numeric($data['gurrented_discount_supply'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Gurrented Discount on Supply';
				$error['error'] = '<b>Gurrented Discount on Supply</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['direct_debit_discount_usage']) && !is_numeric($data['direct_debit_discount_usage'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Direct Debit Discount On Usage ';
				$error['error'] = '<b>Direct Debit Discount On Usage </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['direct_debit_discount_usage']) && !is_numeric($data['direct_debit_discount_usage'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Direct Debit Discount On Usage ';
				$error['error'] = '<b>Direct Debit Discount On Usage </b> field should be numeric only.';
				array_push($errors, $error);
			}

			if (!empty($data['direct_debit_discount_supply']) && !is_numeric($data['direct_debit_discount_supply'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Direct Debit Discount On Supply ';
				$error['error'] = '<b>Direct Debit Discount On Supply </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['daily_supply_charges']) && !is_numeric($data['daily_supply_charges'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Daily Supply Charges ';
				$error['error'] = '<b>Daily Supply Charges </b> field should be numeric only.';
				array_push($errors, $error);
			}

			if (isset($data['gst_rate']) && $data['gst_rate'] == '') {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Gst Rate';
				$error['error'] = '<b>Gst Rate</b> field is required';
				array_push($errors, $error);
			} elseif (!empty($data['gst_rate']) && !is_numeric($data['gst_rate'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Gst Rate ';
				$error['error'] = '<b>Gst Rate </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['control_load_1_daily_supply_charges']) && !is_numeric($data['control_load_1_daily_supply_charges'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Control Load 1 Daily Supply Charges ';
				$error['error'] = '<b>Control Load 1 Daily Supply Charges </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['control_load_2_daily_supply_charges']) && !is_numeric($data['control_load_2_daily_supply_charges'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Control Load 2 Daily Supply Charges ';
				$error['error'] = '<b>Control Load 2 Daily Supply Charges </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['demand_supply_charges_daily']) && !is_numeric($data['demand_supply_charges_daily'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Demand Supply Charges Daily ';
				$error['error'] = '<b>Demand Supply Charges Daily </b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['demand_usage_charges']) && !is_numeric($data['demand_usage_charges'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Demand Usage Charges ';
				$error['error'] = '<b>Demand Usage Charges </b> field should be numeric only.';
				array_push($errors, $error);
			}

			if ($energy_type == 'electricity') {
				if (!empty($data['dmo_content_status']) && ($data['dmo_content_status']) == 1) {
					if (isset($data['dmo_vdo_content']) && empty($data['dmo_vdo_content'])) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'DMO/VDO ConteDescription';
						$error['error'] = '<b>DMO/VDO ConteDescription </b> field is required.';
						array_push($errors, $error);
					}
				}

				if (!empty($data['dmo_static_content_status']) && !in_array($data['dmo_static_content_status'], $arr)) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Enable static content';
					$error['error'] = 'please enter valid value in <b>Enable static content</b>';
					array_push($errors, $error);
				}

				if ($data['dmo_static_content_status'] == 'yes') {

					if (!isset($data['lowest_annual_cost']) || trim($data['lowest_annual_cost']) == '')
					{
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Lowest Possible Annual Cost';
						$error['error'] = '<b>Lowest Possible Annual Cost </b> field is required.';
						array_push($errors, $error);
					} elseif (!empty($data['lowest_annual_cost']) && !is_numeric($data['lowest_annual_cost'])) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Lowest Possible Annual Cost ';
						$error['error'] = '<b>Lowest Possible Annual Cost </b> field should be numeric only.';
						array_push($errors, $error);
					}

					if (isset($data['without_conditional_value']) && $data['without_conditional_value'] == '') {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Percentage Difference to Reference Bill Without Conditional Discount';
						$error['error'] = '<b>Percentage Difference to Reference Bill Without Conditional Discount </b> field is required.';
						array_push($errors, $error);
					} elseif (strlen($data['without_conditional_value']) > 6) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Percentage Difference to Reference Bill Without Conditional Discount ';
						$error['error'] = 'Max length for<b>Percentage Difference to Reference Bill Without Conditional Discount </b> field is 4.';
						array_push($errors, $error);
					}
					if (isset($data['with_conditional_value']) && $data['with_conditional_value'] == '') {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Percentage Difference to Reference Bill With Conditional Discount';
						$error['error'] = '<b>Percentage Difference to Reference Bill With Conditional Discount </b> field is required.';
						array_push($errors, $error);
					} elseif (strlen($data['with_conditional_value']) > 6) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Percentage Difference to Reference Bill With Conditional Discount ';
						$error['error'] = 'Max length for<b>Percentage Difference to Reference Bill With Conditional Discount </b> field is 4.';
						array_push($errors, $error);
					}

					if (isset($data['without_conditional']) && empty($data['without_conditional'])) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Set condition without conditional discount';
						$error['error'] = '<b>Set condition without conditional discount </b> field is required.';
						array_push($errors, $error);
					} elseif (!empty($data['without_conditional']) && !in_array($data['without_conditional'], $price_type)) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Set condition without conditional discount';
						$error['error'] = 'please enter valid value in <b>Set condition without conditional discount</b>';
						array_push($errors, $error);
					}

					if (isset($data['with_conditional']) && empty($data['with_conditional'])) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Set condition with conditional discount';
						$error['error'] = '<b>Set condition with conditional discount </b> field is required.';
						array_push($errors, $error);
					} elseif (!empty($data['with_conditional']) && !in_array($data['with_conditional'], $price_type)) {
						$error = [];
						$error['key'] = $key;
						$error['column'] = 'Set condition with conditional discount';
						$error['error'] = 'please enter valid value in <b> Set condition with conditional discount</b>';
						array_push($errors, $error);
					}
				}
			}
			return $errors;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}
	public static function lpgPlanRateValidation($data, $key)
	{
		
		try
        {
			$errors = [];
			$arr = ['yes','no'];
			if (isset($data['distributor_id']) && $data['distributor_id'] == '') {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Distributor Name';
				$error['error'] = '<b>Distributor Name</b> field is required';
				array_push($errors, $error);
			}
			
			if (!empty($data['min_quantity_with_discount']) && !is_numeric($data['min_quantity_with_discount'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Min. Quantity with discount';
				$error['error'] = '<b>Min. Quantity with discount</b> field should be a numeric only.';
				array_push($errors, $error);
			}
			else if(!empty($data['min_quantity_with_discount']) && is_numeric($data['min_quantity_with_discount'])){
				if(floor( $data['min_quantity_with_discount'] ) != $data['min_quantity_with_discount']) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Min. Quantity with discount';
					$error['error'] = 'Decimals are not allowed in <b>Min. Quantity with discount</b> field.';
					array_push($errors, $error);
				   
				}
				if(!empty($data['min_quantity_with_discount']) &&  $data['min_quantity_with_discount'] < 0){
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Min. Quantity with discount';
					$error['error'] = '<b>Min. Quantity with discount</b> field should not be a negative value';
					array_push($errors, $error);
				}
				if(!empty($data['min_quantity_with_discount']) &&  $data['min_quantity_with_discount'] > 20){
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Min. Quantity with discount';
					$error['error'] = '<b>Min. Quantity with discount</b> field should not be greater than 20';
					array_push($errors, $error);
					
				}

				
			}
			
			if (!empty($data['max_quantity_with_discount']) && !is_numeric($data['max_quantity_with_discount'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Max. Quantity with discount';
				$error['error'] = '<b>Max. Quantity with discount</b> field should be numeric only.';
				array_push($errors, $error);
			}
			else if(!empty($data['max_quantity_with_discount']) && is_numeric($data['max_quantity_with_discount'])){
				if(floor( $data['max_quantity_with_discount'] ) != $data['max_quantity_with_discount']) {
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Max. Quantity with discount';
					$error['error'] = 'Decimals are not allowed in <b>Max. Quantity with discount</b> field.';
					array_push($errors, $error);
				   
				}
				if(!empty($data['max_quantity_with_discount']) && $data['max_quantity_with_discount'] < 0){
					
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Max. Quantity with discount';
					$error['error'] = '<b>Max. Quantity with discount</b> field should not be a negative value';
					array_push($errors, $error);
				}
				if(!empty($data['max_quantity_with_discount']) &&  $data['max_quantity_with_discount'] > 20){
					$error = [];
					$error['key'] = $key;
					$error['column'] = 'Max. Quantity with discount';
					$error['error'] = '<b>Max. Quantity with discount</b> field should not be greater than 20';
					array_push($errors, $error);
					
				}
			}
			if (!empty($data['cash_discount_per_bottle']) && !is_numeric($data['cash_discount_per_bottle'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Cash discount per bottle';
				$error['error'] = '<b>Cash discount per bottle</b> field should be numeric only.';
				array_push($errors, $error);
			}
			if (!empty($data['discount_percent']) && !is_numeric($data['discount_percent'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = '% Discount (to get the standard cost)';
				$error['error'] = '<b>% Discount (to get the standard cost)</b> field should be numeric only.';
				array_push($errors, $error);
			}

			if (isset($data['exit_fee_option']) && empty($data['exit_fee_option'])) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Exit Fee Option';
				$error['error'] = '<b>Exit Fee Option </b> field is required';
				array_push($errors, $error);
			} elseif (!in_array(strtolower($data['exit_fee_option']), $arr)) {
				$error = [];
				$error['key'] = $key;
				$error['column'] = 'Exit Fee Option';
				$error['error'] = 'please enter valid value in <b>Exit Fee Option</b>';
				array_push($errors, $error);
			}
			
			


			
			return $errors;
		}
		catch (\Exception $err) {
			throw $err;
		}
	}
}
