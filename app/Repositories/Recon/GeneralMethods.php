<?php

namespace App\Repositories\Recon;

use Illuminate\Support\Facades\DB;
use App\Models\{Affiliate,MasterReconPermission,EmailTemplate};

trait GeneralMethods
{

	public static function getReconAffiliates($request){
		      
		$filterrole = (isset($request->rolefilter) && !empty($request->rolefilter)) ? $request->rolefilter : '';

		$filteraffiliate = (isset($request->affiliates) && !empty($request->affiliates)) ? $request->affiliates : [];

		$filtersubaffiliate = (isset($request->subaffiliates) && !empty($request->subaffiliates)) ? $request->subaffiliates : [];

		$filterreconmethod = (isset($request->reconmethod) && !empty($request->reconmethod)) ? $request->reconmethod : '';
        
		$affiliates =  Affiliate::with('getreconAffiliates')->where('status',1);	
        if (!empty($filterrole)) {
        	if($filterrole == 1){
        		$affiliates = $affiliates->where('parent_id', '=', '0');
        	}
        	
        	if($filterrole == 2){
        		$affiliates = $affiliates->where('parent_id','!=', '0');
        	}
        }

        if (!empty($filteraffiliate) && empty($filtersubaffiliate)) {
            $affiliates = $affiliates->whereIn('affiliates.id', $filteraffiliate);
        }

        if (!empty($filtersubaffiliate)) {
            $affiliates = $affiliates->whereIn('affiliates.id', $filtersubaffiliate);
        }

        if (!empty($filterreconmethod)) {
            $affiliates = $affiliates->where('affiliates.reconmethod', $filterreconmethod);
        }
        
		$affiliates = $affiliates->paginate(config('env.PAGINATION_PERPAGE_COUNT'));
		
		if ($request->isMethod('post')) {
			return self::modifyResult($affiliates);
		}

		return $affiliates;
	}

	public static function getMasterReconPermissions(){
		return MasterReconPermission::get();
	}


	/**
     * Get Affiliates and Sub Affiliates
     *
     */
	public static function getAffiliates($id = null){
		$parentId = [0];
		if (!empty($id)) { 
			$parentId = $id;
		}

		return Affiliate::select('id','user_id','company_name')->where('status',1)->whereIn('parent_id',$parentId)->get();
	}


	/**
     * Store Permissions
     *
     */
	public static function store($request){
		DB::beginTransaction();
		try{
			self::where('user_id',$request['id'])->delete();
			$permissions = [];
			foreach ($request['permission'] as $value) {
				array_push($permissions, [
					'user_id' => $request['id'],
					'permission_id' => $value,
				]);
			}
			$query = self::insert($permissions);
			if($query == true){
				$status = Affiliate::where('user_id', $request['id'])->update(['reconmethod' => $request['status']]);
				if($status == true){
					DB::commit();
					return response()->json(['status' => 200, 'message' => trans('recon.success')]);
				}
				return response()->json(['status' => 400, 'message' => trans('recon.failue')]);
			}
			DB::rollback();
			return response()->json(['status' => 400, 'message' => trans('recon.failue')]);
		}catch (\Exception $err) {
			DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
	}


	public static function updateTemplate($request){
		try{
			$data = [];
			$data['status'] = $request->status;
			$data['from_name'] = $request->fromname;
			$data['from_email'] = $request->fromemail;
			$data['to_email'] = $request->reciveremails;
			$data['subject'] = $request->emailsubject;
			$query = EmailTemplate::where('id',decryptGdprData($request->templateid))->update($data);
			if($query == 1){
				return response()->json(['status' => 200, 'message' => trans('recon.update')]);
			}
				return response()->json(['status' => 400, 'message' => trans('recon.notupdate')]);
		}catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }

	}


	public static function getReconTemplate(){
		return EmailTemplate::where('title','recon_email_template')->get();
	}

	public static function subaffiliatesParentName($parentId){
		$name = Affiliate::where('id',$parentId)->pluck('company_name')->toArray();
		return $name[0];
	}

	public static function modifyResult($result){
		$returnData = [];
		if(count($result)>0){
			foreach($result as $data ){
				$myArray = array();
				foreach($data['getreconAffiliates'] as $permissions ){
					$myArray[] = $permissions['permission_id'];
				}
				$setpermissions = implode( ',', $myArray );

				$role = trans('recon.subaffiliate');
				if($data['parent_id'] == 0){
					$role = trans('recon.affiliate');
				}

				$parentname = 'N/A';
				if($data['parent_id'] != 0){
					$parentname = self::subaffiliatesParentName($data['parent_id']);
				}

				$reconmethod = trans('affiliates.monthly');
				if($data['reconmethod'] == 2){
					$reconmethod = trans('affiliates.bimonthly');
				}

				array_push($returnData,[
					'companyname' 		=> $data['company_name'],
					'setpermissions' 	=> $setpermissions,
					'role'              => $role,
					'parentname'        => $parentname,
					'reconmethod'       => $reconmethod,
					'userid'            => $data['user_id'],
					'recon'       		=> $data['reconmethod']
 				]);
				
			}
		}
		return $returnData;
	}

}
