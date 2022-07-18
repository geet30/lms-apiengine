<?php

namespace App\Repositories\Usagelimits;
use App\Models\{Postcodelimits};
trait BasicCrudMethods
{
	public static function add($request){
		try {
			$usageLimits = self::create($request->all());
			//Store post codes
			$data = [];
			foreach (json_decode($request['post_codes']) as $postcode) {
				array_push($data,[
					'suburb_usage_limit_id' => $usageLimits->id,
					'usage_type' => $request['usage_type'],
					'post_code' => $postcode->value
				]);
			}
			
			Postcodelimits::insert($data);
		 	return ['status' => 200, 'message' => trans('usagelimits.added')];
		}
		catch (\Exception $err) {
			
			return ['status' => 400, 'message' => $err->getMessage()];
		}
	}

	public static function getUsage($usagetype = null){
		$usageType = 1;
		if($usagetype == 2){
			$usageType = $usagetype;
		}
		return self::whereHas('postcodes',function($q) use ($usageType){
			$q->where('usage_type',$usageType);
		}	)->with('postcodes')->get();
	}

	public static function updateUsageData($request){
		try {
			$data = [];
			$data['elec_low_range'] = $request->elec_low_range;
			$data['elec_medium_range'] = $request->elec_medium_range;
			$data['elec_high_range'] = $request->elec_high_range;
			$data['gas_low_range'] = $request->gas_low_range;
			$data['gas_medium_range'] = $request->gas_medium_range;
			$data['gas_high_range'] = $request->gas_high_range;
			$usageLimits = self::where('id', $request->id)->update($data);

			Postcodelimits::where('suburb_usage_limit_id',$request->id)->delete();

			//Store post codes
			$postcodes = [];
			foreach (json_decode($request['post_codes']) as $postcode) {
				array_push($postcodes,[
					'suburb_usage_limit_id' => $request->id,
					'usage_type' => $request['usageset'],
					'post_code' => $postcode->value
				]);
			}
			
			Postcodelimits::insert($postcodes);
			return ['status' => 200, 'message' => trans('usagelimits.updated')];
		}
		catch (\Exception $err) {
			return ['status' => 400, 'message' => $err->getMessage()];
		}
	}


}
