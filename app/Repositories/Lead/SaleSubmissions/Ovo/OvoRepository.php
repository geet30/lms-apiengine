<?php

namespace App\Repositories\Lead\SaleSubmissions\Ovo;
use App\Models\{ 
	DmoVdo,
	Lead,
	Settings,
	SaleProductsEnergy
};
use Carbon\Carbon; 
use DB; 
use App\Traits\SaleSubmission\CommonGuzzelTrait;

class OvoRepository
{
	use CommonGuzzelTrait;
	/**
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter) 
	 */
	public function setDataForOvoApi($leadID, $energy, $provider, $test,$groupDetails)
	{	   
		$health_care_card 	= array(
			"Commonwealth Senior Health Card",
			"Centrelink Healthcare Card"
		);
		$dva_card = array(
			"DVA Gold Card",
			"DVA Gold Card(Extreme Disablement Adjustment)",
			"DVA Gold Card(TPI)",
			"DVA Gold Card(War Widow)"
		);
		$pension_card = array(
			"Pensioner Concession Card",
			"DVA Pension Concession Card"
		);
		$qld_card 			= array(
			"Queensland Government Seniors Card",
			"QLD Government Seniors Card"
		);
		$dmo_state			= array(
			"NSW", "QLD", "SA"
		);
		$leadsData 			= $exports = [];
		$dmo_state_arr 		= [];
		$provider_ids 		= []; 

		$enabled_dmo_state 	= Settings::select('value')->where('key', 'dmo_state')->first();
		if ($enabled_dmo_state)
			$dmo_state_arr = explode(',', $enabled_dmo_state->value);

		if ($energy != 3) 
		{
			$leadsData = Lead::join('lead_journey_data_energy', 'lead_journey_data_energy.lead_id', '=', 'leads.lead_id')
			->join('sale_products_energy', function ($join) use ($energy) {
				$join->on('sale_products_energy.lead_id', '=', 'leads.lead_id')
				->where('sale_products_energy.product_type',$energy)
				->whereNotNull('plan_id');
			})
			->where('leads.lead_id', $leadID) 
		   ->get(['leads.*', 'lead_journey_data_energy.*']);
		}
		else {
			$leadsData = Lead::join('lead_journey_data_energy', 'lead_journey_data_energy.lead_id', '=', 'leads.lead_id')
			->join('sale_products_energy', function ($join) {
				$join->on('sale_products_energy.lead_id', '=', 'leads.lead_id')
				->whereNotNull('plan_id');
			}) 
			->where('leads.lead_id', $leadID)
		   ->get(['leads.*', 'lead_journey_data_energy.*']);
		   $energy = 1;
		}  

		$TITLE 	=  $NAME_FIRST 	=  $NAME_LAST = $DOB =  $EMAIL = $PHONE = $PROPERTYNAME	= '';

		$HAS_CONCESSIONCARD = $CONCESSION_TYPE 	=  $CONCESSION_NUMBER 	= '';

		$IDENTIFICATIONTYPE = $DRIVERSLICENSE_NUMBER = $DRIVERSLICENSE_EXPIRY = $DRIVERSLICENSE_ISSUINGSTATE	= $DRIVERSLICENSE_ISSUINGAUSSTATE	= '';

		$MEDICARE_NUMBER =  $MEDICARE_COLOUR =  $MEDICARE_EXPIRY = '';

		$PASSPORT_NUMBER = $PASSPORT_ISSUINGCOUNTRY = $PASSPORT_EXPIRY				= '';

		$LOTNUMBER 				= '';
		$UNITNUMBER 			= '';
		$UNITTYPE				= '';
		$LEVELTYPE 				= '';
		$LEVELNUMBER 			= '';
		$STREETNUMBER 			= '';
		$STREETNUMBERSUFFIX		= '';
		$STREETTYPE 			= '';
		$STREETNAME				= '';
		$SUBURB 				= '';
		$STATEORTERRITORY 		= '';
		$POSTCODE 				= '';
		$LIFESUPPORTREQUIRED 	= false;

		$SALE_REF_NUMBER 		= '';
		$ORDER_TYPE				= '';
		$CUSTOMER_TYPE 			= '';
		$DATE_OF_SALE 			= '';
		$MOVE_IN_DATE 			= '';
		$NMI 					= '';
		$ELEC_CODE 				= '';
		$ELEC_DESCRIPTION 		= '';
		$ELEC_CAMPAIGN_CODE		= '';
		$ELEC_MONTHLY_COST		= '';
		$ELEC_MONTHLY_USAGE		= '';
		$ELEC_METHOD_USED		= '';
		$ELEC_NOTES				= '';
		$NOTES 					= '';
		$ACCOUNT_TOKEN 			= '';
		$DIRECT_DEBIT_CONSENT 	= true;
		$MARKETING_CONSENT 		= false;
		$EXPLICIT_INFORMED_CONSENT = true;
		$CONCESSION_CONSENT		= '';
 
		// get distributor id for energy type electricity
		if ($energy == 1 && in_array(trim($leadsData[0]->state), $dmo_state_arr)) {

			$distributor_id = $leadsData[0]->distributor_id;
			if ($leadsData[0]->property_type == 'business') {
				$peak_only_data = DmoVdo::where(['distributor_id' => $distributor_id, 'property_type' => 'business', 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price')->first();
			} else {
				$peak_only_data = DmoVdo::where(['distributor_id' => $distributor_id, 'property_type' => 'residential', 'tariff_type' => 'peak_only'])->select('peak_only', 'annual_price')->first();
			}

			$ELEC_MONTHLY_USAGE = isset($peak_only_data->peak_only) ? round($peak_only_data->peak_only / 365 * 30) : '';
			$ELEC_MONTHLY_COST = isset($peak_only_data->annual_price) ? round($peak_only_data->annual_price / 365 * 30) : '';
			if (in_array(trim($leadsData[0]->state), $dmo_state)) {
				$ELEC_METHOD_USED = "DMO";
			} elseif (trim($leadsData[0]->state) == 'VIC') {
				$ELEC_METHOD_USED = "VDO";
			}
		}
		 
		foreach ($leadsData as $value) {
			$provider_ids[] = $value["current_provider"];
		}

		if ($energy == 3) { 
			$sale = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
			$gasSale = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null; 
		} else { 
			$sale = isset($groupDetails[$energy][0]) ? $groupDetails[$energy][0] : null;
		}    
				 
		$TITLE 			= $sale->v_title;
		$NAME_FIRST 	= decryptGdprData($sale->v_first_name);
		$NAME_LAST 		= decryptGdprData($sale->v_last_name);
		$DOB 			= Carbon::parse(decryptGdprData($sale->v_dob))->format('Y-m-d');
		$EMAIL 			= decryptGdprData($sale->v_email);
		$PHONE 			= decryptGdprData($sale->v_phone);

		if ($sale->journey_property_type == '2' || (isset($sale->vcd_concession_type) &&  $sale->vcd_concession_type == 'Not Applicable') || $sale->journey_moving_house == 1) {
			$CONCESSION_TYPE 	= '';
			$CONCESSION_NUMBER 	= '';
			$HAS_CONCESSIONCARD = false;
			$CONCESSION_CONSENT = false;
		}

		if (in_array( $sale->vcd_concession_type, $dva_card)) {
			$CONCESSION_TYPE 	= 'VETERANS';
			$CONCESSION_NUMBER 	= $sale->vcd_card_number;
			$HAS_CONCESSIONCARD = true;
			$CONCESSION_CONSENT = true;
		} 
		elseif (in_array($sale->vcd_concession_type, $health_care_card)) {
			$CONCESSION_TYPE 	= 'HEALTH_CARE';
			$CONCESSION_NUMBER 	= $sale->vcd_card_number;
			$HAS_CONCESSIONCARD = true;
			$CONCESSION_CONSENT = true;
		} 
		elseif (in_array($sale->vcd_concession_type, $pension_card)) {
			$CONCESSION_TYPE 	= 'PENSIONER';
			$CONCESSION_NUMBER 	= $sale->vcd_card_number;
			$HAS_CONCESSIONCARD = true;
			$CONCESSION_CONSENT = true;
		} 
		elseif (in_array($sale->vcd_concession_type, $qld_card)) {
			$CONCESSION_TYPE 	= 'QUEENSLAND_SENIOR';
			$CONCESSION_NUMBER 	= $sale->vcd_card_number;
			$HAS_CONCESSIONCARD = true;
			$CONCESSION_CONSENT = true;
		} else {
			$CONCESSION_TYPE 	= '';
			$CONCESSION_NUMBER 	= '';
		}
	 
		if (isset($sale->vi_identification_type) && $sale->vi_identification_type == 'Drivers Licence') {
			$IDENTIFICATIONTYPE = "DRIVERS_LICENSE";
			$DRIVERSLICENSE_NUMBER 			= $sale->vi_licence_number;
			$DRIVERSLICENSE_ISSUINGSTATE	= $sale->vi_licence_state_code;
			$DRIVERSLICENSE_ISSUINGAUSSTATE = $sale->vi_licence_state_code;
			$DRIVERSLICENSE_EXPIRY 			= Carbon::parse($sale->vi_licence_expiry_date)->format('Y-m-d');
		}
		if (isset($sale->vi_identification_type) && ($sale->vi_identification_type == 'Passport' || $sale->vi_identification_type == 'Foreign Passport')) 
		{
			$IDENTIFICATIONTYPE = "PASSPORT";
			if ($sale->vi_identification_type == 'Foreign Passport') {
				$IDENTIFICATIONTYPE = "FOREIGN PASSPORT";
				$PASSPORT_ISSUINGCOUNTRY = strtoupper(substr($sale->vi_foreign_country_name, 0, 3));
			} else {
				$PASSPORT_ISSUINGCOUNTRY = "AUS";
			}
			$PASSPORT_NUMBER 	= $sale->vi_passport_number;

			$PASSPORT_EXPIRY = Carbon::parse($sale->vi_passport_expiry_date)->format('Y-m-d');
		}

		if (isset($sale->vi_identification_type) && $sale->vi_identification_type == 'Medicare Card') 
		{
			$IDENTIFICATIONTYPE = "MEDICARE";
			$MEDICARE_NUMBER = $sale->vi_medicare_number;
			if ($sale->vi_card_color == 'G') {
				$MEDICARE_COLOUR = "GREEN";
			} 
			elseif ($sale->vi_card_color == 'B') {
				$MEDICARE_COLOUR = "BLUE";
			} 
			else {
				$MEDICARE_COLOUR = "YELLOW";
			}
			$MEDICARE_EXPIRY = Carbon::parse($sale->vi_medicare_card_expiry_date)->format('Y-m-d');
		}

		/*Site address*/
		$PROPERTYNAME	= isset($sale->va_property_name) ? $sale->va_property_name : '';
		$LOTNUMBER 		= isset($sale->va_lot_number) ? $sale->va_lot_number : '';
		$UNITNUMBER 	= isset($sale->va_unit_no) ? $sale->va_unit_no : '';
		$UNITTYPE 		= isset($sale->va_unit_type_code) ? strtoupper($sale->va_unit_type_code) : '';
		$LEVELTYPE 		= isset($sale->va_floor_type_code) ? $sale->va_floor_type_code : '';
		$LEVELNUMBER	= isset($sale->va_floor_no) ? $sale->va_floor_no : '';
		$STREETNUMBER 	= isset($sale->va_street_number) ? $sale->va_street_number : '';
		$STREETNUMBERSUFFIX	= isset($sale->va_street_number_suffix) ? $sale->va_street_number_suffix : '';
		$STREETNAME 	= isset($sale->va_street_name) ? $sale->va_street_name : '';
		$STREETTYPE 	= isset($sale->va_street_code) ? strtoupper($sale->va_street_code) : '';
		$SUBURB 		= isset($sale->va_suburb) ? $sale->va_suburb : '';
		$STATEORTERRITORY = isset($sale->va_state) ? $sale->va_state : '';
		$POSTCODE 		= isset($sale->va_postcode) ? $sale->va_postcode : '';

		/*Order*/
		$SALE_REF_NUMBER 	= $sale->sale_product_reference_no;

		$DATE_OF_SALE = Carbon::parse($sale->l_sale_created)->format('Y-m-d');
		$createdDateArr = explode('/', $sale->vie_qa_notes_created_date);
		if (count($createdDateArr) == 3) {
			$DATE_OF_SALE = Carbon::createFromDate($createdDateArr[2],$createdDateArr[1],$createdDateArr[0], config('app.timezone'))->format('Y-m-d');
		}

		$CUSTOMER_TYPE 		= (isset($sale->journey_property_type) && $sale->journey_property_type == '2') ? 'SME' : 'RESIDENTIAL';
		
		$ORDER_TYPE			= (isset($sale->journey_moving_house) && $sale->journey_moving_house == '1') ? 'MOVE_IN' : 'TRANSFER';
		
		if ($ORDER_TYPE == 'MOVE_IN') {
			if(isset($sale->journey_moving_date))
			{
				$mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $sale->journey_moving_date);
				$MOVE_IN_DATE = $mydate->format('Y-m-d');
			}
		}
		$NMI = isset($sale->vie_nmi_number) ? $sale->vie_nmi_number : '';

		$ELEC_CODE = '';
		if (!empty($sale->plan_product_code) && $sale->plan_product_code != 'N/A') {
			$ELEC_CODE = $sale->plan_product_code;
		}  

		$ELEC_DESCRIPTION = isset($sale->plan_name) ? $sale->plan_name : '';
		$ELEC_CAMPAIGN_CODE = isset($sale->plan_campaign_code) ? $sale->plan_campaign_code : '';

		if (isset($exports['medical_equipment']) && ($exports['medical_equipment'] == 'yes') && ($exports['medical_equipment_energytype'] == 0)) {
			$LIFESUPPORTREQUIRED = true;
		}
		$NOTES = isset($sale->vie_qa_notes) ? $sale->vie_qa_notes : '';

		$ACCOUNT_TOKEN = isset($sale->vie_token) ? $sale->vie_token : '';

		//set data into array 
		$data = [];
		if (!empty($TITLE))
			$data['person']['title'] 		= $TITLE;
		if (!empty($NAME_FIRST))
			$data['person']['firstName'] 	= $NAME_FIRST;
		if (!empty($NAME_LAST))
			$data['person']['lastName'] 	= $NAME_LAST;
		if (!empty($DOB))
			$data['person']['dateOfBirth'] 	= $DOB;

		/*contact details*/
		if (!empty($EMAIL))
			$data['person']['contactDetails']['emailAddress'] 	= $EMAIL;
		if (!empty($PHONE))
			$data['person']['contactDetails']['mobilePhone'] 	= $PHONE;
		if (!empty($PROPERTYNAME))
			$data['person']['contactDetails']['propertyName'] 	= $PROPERTYNAME;

		/*concession details*/
		if (!empty($CONCESSION_TYPE))
			$data['person']['concessionDetails']['cardType'] 	= $CONCESSION_TYPE;
		if (!empty($CONCESSION_NUMBER))
			$data['person']['concessionDetails']['cardNumber'] 	= $CONCESSION_NUMBER;

		/*identification details*/
		if (!empty($IDENTIFICATIONTYPE))
			$data['person']['identification']['identificationType'] = $IDENTIFICATIONTYPE;
		if (!empty($DRIVERSLICENSE_NUMBER))
			$data['person']['identification']['driversLicense']['number'] = $DRIVERSLICENSE_NUMBER;
		if (!empty($DRIVERSLICENSE_ISSUINGSTATE))
			$data['person']['identification']['driversLicense']['issuingStateorTerritory'] = $DRIVERSLICENSE_ISSUINGSTATE;
		if (!empty($DRIVERSLICENSE_ISSUINGAUSSTATE))
			$data['person']['identification']['driversLicense']['issuingAustralianStateorTerritory'] = $DRIVERSLICENSE_ISSUINGAUSSTATE;
		if (!empty($DRIVERSLICENSE_EXPIRY))
			$data['person']['identification']['driversLicense']['expiry'] = $DRIVERSLICENSE_EXPIRY;
		if (!empty($MEDICARE_NUMBER))
			$data['person']['identification']['medicare']['number'] = $MEDICARE_NUMBER;
		if (!empty($MEDICARE_COLOUR))
			$data['person']['identification']['medicare']['colour'] = $MEDICARE_COLOUR;
		if (!empty($MEDICARE_EXPIRY))
			$data['person']['identification']['medicare']['expiry'] = $MEDICARE_EXPIRY;
		if (!empty($PASSPORT_NUMBER))
			$data['person']['identification']['passport']['number'] = $PASSPORT_NUMBER;
		if (!empty($PASSPORT_ISSUINGCOUNTRY))
			$data['person']['identification']['passport']['issuingCountry'] = $PASSPORT_ISSUINGCOUNTRY;
		if (!empty($PASSPORT_EXPIRY))
			$data['person']['identification']['passport']['expiry'] = $PASSPORT_EXPIRY;

		/*Site address*/
		if (!empty($LOTNUMBER))
			$data['site']['address']['lotNumber'] 		= $LOTNUMBER;
		if (!empty($UNITNUMBER))
			$data['site']['address']['unitNumber'] 		= $UNITNUMBER;
		if (!empty($UNITTYPE))
			$data['site']['address']['unitType'] 		= $UNITTYPE;
		if (!empty($LEVELTYPE))
			$data['site']['address']['levelType'] 		= $LEVELTYPE;
		if (!empty($LEVELNUMBER))
			$data['site']['address']['levelNumber'] 	= $LEVELNUMBER;
		if (!empty($STREETNUMBER))
			$data['site']['address']['streetNumber'] 	= $STREETNUMBER;
		if (!empty($STREETNUMBERSUFFIX))
			$data['site']['address']['streetNumberSuffix'] 	= $STREETNUMBERSUFFIX;
		if (!empty($STREETNAME))
			$data['site']['address']['streetName'] 		= $STREETNAME;
		if (!empty($STREETTYPE))
			$data['site']['address']['streetType'] 		= $STREETTYPE;
		if (!empty($SUBURB))
			$data['site']['address']['suburb'] 			= $SUBURB;
		if (!empty($STATEORTERRITORY))
			$data['site']['address']['stateOrTerritory'] = $STATEORTERRITORY;
		if (!empty($POSTCODE))
			$data['site']['address']['postcode'] 		= $POSTCODE;

		$data['site']['lifeSupportRequired'] 		= $LIFESUPPORTREQUIRED;
		$data['person']['hasConcessionCard'] 		= $HAS_CONCESSIONCARD;

		/*Order*/
		$data['order']['brokerId'] 			= 'cimet';
		if (!empty($SALE_REF_NUMBER))
			$data['order']['correlationId'] 	= $SALE_REF_NUMBER;
		if (!empty($DATE_OF_SALE))
			$data['order']['dateOfSale'] 		= $DATE_OF_SALE;
		$data['order']['customerType'] 		= $CUSTOMER_TYPE;
		$data['order']['orderType'] 		= $ORDER_TYPE;
		if (!empty($MOVE_IN_DATE))
			$data['order']['moveInDate'] 		= $MOVE_IN_DATE;
		if (!empty($NMI))
			$data['order']['electricity']['nmi'] = $NMI;
		if (!empty($ELEC_CODE))
			$data['order']['electricity']['product']['code']		= $ELEC_CODE;
		if (!empty($ELEC_DESCRIPTION))
			$data['order']['electricity']['product']['description']	= $ELEC_DESCRIPTION;
		if (!empty($ELEC_CAMPAIGN_CODE))
			$data['order']['electricity']['campaignCode']			= $ELEC_CAMPAIGN_CODE;
		if (!empty($ELEC_MONTHLY_COST))
			$data['order']['electricity']['estimate']['monthlyCost'] = $ELEC_MONTHLY_COST;
		if (!empty($ELEC_MONTHLY_USAGE))
			$data['order']['electricity']['estimate']['monthlyUsage'] = $ELEC_MONTHLY_USAGE;
		if (!empty($ELEC_METHOD_USED))
			$data['order']['electricity']['estimate']['methodUsed']	= $ELEC_METHOD_USED;
		$data['order']['electricity']['estimate']['notes']		= $ELEC_NOTES;
		if (!empty($NOTES))
			$data['order']['notes']								= $NOTES;
		if (!empty($ACCOUNT_TOKEN))
			$data['paymentMethod']['accountToken']				= $ACCOUNT_TOKEN;

		$data['consent']['directDebitConsent']			= $DIRECT_DEBIT_CONSENT;
		$data['consent']['explicitInformedConsent']		= $EXPLICIT_INFORMED_CONSENT;
		$data['consent']['marketingConsent']			= $MARKETING_CONSENT;
		$data['consent']['concessionConsent']			= $CONCESSION_CONSENT;
		$data = json_encode($data); 
		$test = true; 
		if ($test) {
			$headers =  [
				'Content-Type'=>'application/json',
				'x-api-key'=> config('app.ovo_api_key')
			];
			$url = config('app.ovo_broker_url') . '/api/sales-queue';
			$response = self::submitJsonDataToProvider($headers,$url,$data,'POST');
			if(isset($response['status']) && $response['status'] == 400)
			{
				return $response = ['message' => "Something went wrong.", 'output' => $response['message'],'data' => $data, 'header' => "Ovo Submission", 'code' => 400];
			}
			$responseData = json_decode((string) $response['response']->getBody(), true);  
			if ($energy == 3) {
				SaleProductsEnergy::where('lead_id', $sale->l_lead_id)->update(['correlation_id' => $sale->sale_product_reference_no]);
			} else {
				SaleProductsEnergy::where('lead_id', $sale->l_lead_id)->where('product_type', $energy)->update(['correlation_id' => $sale->sale_product_reference_no]);
			}
			$apirequest['api_name'] 	= "Ovo Submission";
			$apirequest['api_response'] = $responseData['message'];
			$apirequest['header_data'] 	= json_encode($headers);
			$apirequest['api_request'] 	= $data;
			$apirequest['lead_id'] 	= $sale->l_lead_id;
			DB::connection('sale_logs')->table('sale_submission_api_responses')->insert($apirequest);
			if ($responseData['message'] == 'Sale successfully queued') {
				$response = ['data' => $data, 'code' => 200, 'header' => $headers, 'output' => $responseData['message']];
				return $response;
			}
			return $response = ['message' => "Something went wrong.", 'code' => 400];
		} 
	}
	/*End of function*/

}
