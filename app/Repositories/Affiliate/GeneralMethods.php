<?php

namespace App\Repositories\Affiliate;

use App\Models\{AffiliateTags, UserService, AssignedUsers};

use Illuminate\Support\Facades\DB;

trait GeneralMethods
{

	public static function getAffiliateIdByUserId($id)
	{
		return DB::table('affiliates')->where('user_id', $id)->pluck('id')->first();
	}

	public static function getSubaffiliatesId($id)
	{
		return DB::table('affiliates')->where('parent_id', $id)->pluck('user_id')->toArray();
	}

	public static function checkSubaffiliatesServices($subaffiliateId, $service, $type)
	{

		return DB::table('user_services')->whereIn('user_id', $subaffiliateId)->where('service_id', $service)->where('user_type', $type)->count();
	}

	public static function getServices($serviceId = null)
	{
		if (empty($serviceId)) {
			return DB::table('services')->where('status', 1)->select('id', 'service_title')->get();
		}
		return DB::table('services')->where('status', 1)->whereNotIn('id', $serviceId)->select('id', 'service_title')->get();
	}

	public static function getUserAddr($userId = null)
	{
		return DB::table('user_address')->select('address')->where('user_id', decryptGdprData($userId))->first();
	}

	public static function getAffiliateIdById($id)
	{

		return DB::table('affiliates')->where('id', $id)->pluck('user_id')->first();
	}
	public static function getSubaffByParentId($id)
	{
		return DB::table('affiliates')->where('parent_id', $id)->pluck('user_id')->toArray();
	}

	public static function getAffiliateIdByParentId($id)
	{
		$query =  DB::table('affiliates')->where('user_id', $id)->pluck('parent_id')->first();
		$getuserid = self::getAffiliateIdById($query);
		return $getuserid;
	}


	public static function modifyResponse($affiliateuser, $info)
	{
		$data = [];
		foreach ($affiliateuser as $affiliate) {

			array_push($data, [
				'userid' => $affiliate['user_id'],
				'name'   => $affiliate['company_name'],
				'email'  => decryptGdprData($affiliate['user']['email']),
				'logo'   => ($affiliate['logo'] == null) ? asset(theme()->getMediaUrlPath() . 'avatars/blank.png') : $affiliate['logo'],
				'status' => $affiliate['status'],
				'twofa'    => $affiliate['two_factor_secret'],
				'id'     => encryptGdprData($affiliate['user_id']),
				'twofaroute' => route('2fa.settings', ['id' => encryptGdprData($affiliate['user_id']), 'mode' => theme()->getCurrentMode()])

			]);
		}
		return $data;
	}

	public static function getUserByToken($token)
	{
		return DB::table('users')->where('token', '=', $token)->first();
	}
	public static function getTags($userId = null, $request = null)
	{
		$tagId = "";
		$tags = DB::table('tags')->where(['is_deleted' => 0, 'status' => 1])->orderBy('id', 'desc')->pluck('name', 'id');
		if (count($tags) > 0) {
			$tagId = array_keys($tags->toArray())[0];
		}
		if (isset($request['tag_id'])) {
			$tagId = $request['tag_id'];
		}
		$tagArr = [];
		if (count($tags) != 0) {

			$tagArr['default_tags'] = DB::table('affiliate_tags')->where('tag_id', $tagId)->where('user_id', decryptGdprData($userId))->first();
		}
		$tagArr['tags'] = $tags;
		return $tagArr;
	}
	public static function saveAffTags($request)
	{
		if ($request) {

			$requiredArray =   ['is_advertisement', 'is_any_time', 'is_remarketing', 'is_cookies'];
			foreach ($requiredArray as $field) {
				if (!$request->exists($field) && !$request->{$field}) {
					$request[$field] = 0;
				}
			}
			AffiliateTags::where('tag_id', $request->input('tag_id'))->where('user_id', decryptGdprData(($request->input('user_id'))))->update($request->except('_token', 'tag_id', 'user_id'));
			return ['status' => true, 'message' => trans('affiliates.tags.tag_sucsess')];
		}
	}

	public static function getUserServices($userId, $service = null, $userType = null)
	{
		$type = 1;
		if (!empty($userType)) {
			$type = $userType;
		}

		$services = DB::table('user_services')
			->selectRaw('user_services.service_id,services.service_title,user_services.service_id as id,user_services.status')
			->leftJoin("services", "services.id", "=", "user_services.service_id")
			->where('user_id', $userId)->where('user_type', $type);
		if (!empty($service)) {
			$services->whereNotIn('user_services.service_id', $service);
		}
		$services =	$services->get()->toArray();
		return $services;
	}

	public static function getUserServiceById($request)
	{
		$relationUser =  decryptGdprData($request->id);
		$serviceId = $request->userservice;

		if ($request->type == 2) {
			$serviceId = $request->providerservice;
			$realationType = 1;
			if ($request->user == 'sub-affiliates') {
				$realationType = 4;

				$getAlreadyAssignedusers = DB::table('assigned_users')->select('relational_user_id')->where('source_user_id', $relationUser)->where('service_id', $serviceId)->where('relation_type', $realationType)->pluck('relational_user_id')->toArray();

				//Get AffiliateId
				$affId = AssignedUsers::getAffiliateIdByParentId($relationUser);
				$getAffiliateProviders = DB::table('assigned_users')
					->selectRaw('relational_user_id as user_id,providers.name')->where('source_user_id', $affId)
					->join('providers', "providers.user_id", "=", "assigned_users.relational_user_id")
					->where('assigned_users.service_id', $serviceId)->where('relation_type', 1)
					->whereNotIn('assigned_users.relational_user_id', $getAlreadyAssignedusers)
					->get()->toArray();
				return self::modifyProvidersResult($getAffiliateProviders);
			}

			if ($request->has('providertype')) {
				//get affiliates
				$getAlreadyAssignedusers = DB::table('assigned_users')->where('relational_user_id', $relationUser)->where('service_id', $serviceId)->where('relation_type', $realationType)->pluck('source_user_id')->toArray();

				$services = UserService::selectRaw('affiliates.user_id,affiliates.company_name')
					->join("affiliates", "affiliates.user_id", "=", "user_services.user_id")
					->where('user_services.service_id', $serviceId)->where('user_type', 1)
					->whereNotIn('user_services.user_id', $getAlreadyAssignedusers)
					->get();
				return $services;
			}
			//get providers
			$getAlreadyAssignedusers = DB::table('assigned_users')->select('relational_user_id')->where('source_user_id', $relationUser)->where('service_id', $serviceId)->where('relation_type', $realationType)->pluck('relational_user_id')->toArray();
			$services = UserService::selectRaw('providers.user_id,providers.name')
				->join("providers", "providers.user_id", "=", "user_services.user_id")
				->where('user_services.service_id', $serviceId)->where('user_type', $request->type)
				->whereNotIn('user_services.user_id', $getAlreadyAssignedusers)
				->get();

			return self::modifyProvidersResult($services);
		}

		$realationType = 2;
		if ($request->user == 'sub-affiliates') {
			$realationType = 3;
		}

		$getAlreadyAssignedusers = DB::table('assigned_users')->select('relational_user_id')->where('source_user_id', $relationUser)->where('service_id', $serviceId)->where('relation_type', $realationType)->pluck('relational_user_id')->toArray();

		$services = UserService::selectRaw('users.first_name,users.last_name,users.id,roles.name as rolename')
			->join("users", "users.id", "=", "user_services.user_id")
			->leftJoin("roles", "roles.id", "=", "users.role")
			->where('service_id', $serviceId)->where('user_type', $request->type)
			->whereNotIn('user_services.user_id', $getAlreadyAssignedusers)
			->get();
		return self::modifyResult($services);
	}

	public static function modifyResult($services)
	{
		$data = [];
		foreach ($services as  $value) {
			array_push($data, [
				'id' => $value->id,
				'first_name' => ucfirst(decryptGdprData($value->first_name)) . ' ' . ucfirst(decryptGdprData($value->last_name)),
				'rolename' => strtoupper($value->rolename)
			]);
		}
		return $data;
	}


	public static function modifyProvidersResult($services)
	{
		$data = [];
		foreach ($services as  $value) {
			array_push($data, [
				'id' => $value->user_id,
				'name' => ucfirst($value->name)
			]);
		}
		return $data;
	}


	public static function getDistributorsByServiceId($request)
	{
		$relationUser =  decryptGdprData($request->id);
		$serviceId = $request->distributorservice;

		$realationType = 5;
		if ($request->user == 'sub-affiliates') {
			$realationType = 6;
		}

		$getAlreadyAssignedusers = DB::table('assigned_users')->select('relational_user_id')->where('source_user_id', $relationUser)->where('service_id', $serviceId)->where('relation_type', $realationType)->pluck('relational_user_id')->toArray();

		return DB::table('distributors')->where('energy_type', $request->distributorservice)
			->select('id', 'name')
			->whereNotIn('id', $getAlreadyAssignedusers)
			->get();
	}

	public static function checkAffiliateIdInleads($id, $serviceId)
	{
		$status = false;
		$query =  DB::table('leads')->where('affiliate_id', $id)->pluck('lead_id')->first();
		if (empty($query)) {
			return $status;
		}

		$data = '';
		switch ($serviceId) {
			case '1':
				$data = DB::table('sale_products_energy')->where([['lead_id', $query], ['service_id', $serviceId]])->count();
				break;

			case '2':
				$data = DB::table('sale_products_mobile')->where([['lead_id', $query], ['service_id', $serviceId]])->count();
				break;

			case '3':
				$data = DB::table('sale_products_broadband')->where([['lead_id', $query], ['service_id', $serviceId]])->count();
				break;

			default:
				$data = 0;
				break;
		}

		if ($data > 0) {
			$status = true;
		}
		return $status;
	}

	public static function getAssignedServices()
	{
		$services = UserService::join('services', 'user_services.service_id', '=', 'services.id')->select('services.id','services.service_title')->where('user_services.user_id',auth()->user()->id)->get();
		return $services;
	}
}
