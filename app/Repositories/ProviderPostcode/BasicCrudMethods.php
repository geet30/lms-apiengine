<?php

namespace App\Repositories\ProviderPostcode;


trait BasicCrudMethods
{
	public static function assignPostcodes($request)
	{
		\DB::beginTransaction();
		try {
			$postcodes = $request->assign_postcode_postcode_id != '' ? explode(',', $request->assign_postcode_postcode_id) : [];
			self::where('provider_id', decryptGdprData($request->provider_id))->where('distributor_id', $request->distributor)->delete();
			$data = [];
			foreach ($postcodes as $postcode) {
				$data[] = ['provider_id' => decryptGdprData($request->provider_id), 'distributor_id' => $request->distributor, 'postcode' => $postcode, 'type' => 0, 'status' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];
			}
			self::insert($data);
			\DB::commit();
			return response()->json(['message' => 'Postcodes assigned.', 'data' => $data], 200);
		} catch (\Exception $err) {
			\DB::rollback();
			return response()->json(['message' => 'Unable to assign postcodes.', 'exception' => $err->getMessage()], 500);
		}
	}
}
