<?php
namespace App\Repositories\ProviderConsentRepository;
use App\Models\{States,UserStates};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
trait StatesMethods
{
	
	public static function states($providerId = null){
		$getassignedStates = DB::table('user_states')->where('user_type', '2')->where('user_id', $providerId)->pluck('state_id');
		return States::selectRaw('state_id,state_code')->whereNotIn('state_id', $getassignedStates)->get();
	}

	public static function assginStatesToProviders($request){
		try{
			$data = [];
			foreach ($request->states as $state) {
				array_push($data,[
					'user_id' => decryptGdprData($request->id),
					'state_id' => $state,
					'user_type' => $request->user_type,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);
			}
			UserStates::insert($data);
			$getstates = self::states(decryptGdprData($request->id));
			$getresult = self::providerassignedStates(decryptGdprData($request->id));
			return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $getresult,'states' => $getstates]);
		}catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
	}

	public static function providerassignedStates($providerId){
		
		// return UserStates::where('user_type', '2')->where('user_id', $providerId)->with('userSubrubs')->get();

		return  DB::table('user_states')
		->selectRaw('user_states.*,states.state_code')
		->join("states", "states.state_id", "=", "user_states.state_id")
		->where('user_type', '2')->where('user_id', $providerId)
		->get();
	}


	public static function updateStateStatus($request){
		try {

			UserStates::where('user_state_id', $request->id)->update(['status' => $request->status]);
			$httpStatus = 200;
			$message = trans('affiliates.affiliate_status_update');
			return response()->json(['status' => $httpStatus, 'message' => $message]);

		} catch (\Exception $err) {
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
	}

	public static function updateRetention($request){
		try {

			UserStates::where('user_state_id', $request->id)->update(['retention_alloweded' => $request->retention_alloweded]);
			$httpStatus = 200;
			$message = trans('affiliates.affiliate_retention_update');
			return response()->json(['status' => $httpStatus, 'message' => $message]);

		} catch (\Exception $err) {
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
	}


	public static function deleteState($request){
		try {	

			UserStates::where('user_state_id', $request->id)->delete();
			$getstates = self::states(decryptGdprData($request->providerid));
			$httpStatus = 200;
			$message = trans('affiliates.delete');
			return response()->json(['status' => $httpStatus, 'message' => $message,'states' => $getstates]);

		}catch (\Exception $err) {
			return response()->json(['status' => 400, 'message' => $err->getMessage()]);
		}
		
	}

}

?>