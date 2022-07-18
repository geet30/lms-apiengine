<?php

namespace App\Repositories\Affiliate;

use Illuminate\Support\Facades\DB;
use App\Models\{
    AssignedUsers,
    PlanEnergy,
    PlanMobile,
    PlansBroadband,
    Providers,
    Userip
};
use Carbon\Carbon;
use Illuminate\Http\Request;

trait ManageUsers
{
    /**
     * Assigned Users
     */
    public static function assginUsersWithService($request)
    {
        try {
            $addAssignedUsers = [];
            $realationType = 2;
            if ($request->user == 'sub-affiliates') {
                $realationType = 3;
            }
            foreach ($request->users as $user) {
                array_push($addAssignedUsers, [
                    'service_id' => $request->userservice,
                    'source_user_id' => decryptGdprData($request->id),
                    'relational_user_id' => $user,
                    'relation_type' => $realationType,
                    'assigned_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            AssignedUsers::insert($addAssignedUsers);
            $data = self::getAssignedUsers($realationType, decryptGdprData($request->id));
            $users = AssignedUsers::getUserServiceById($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $data, 'users' => $users]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Assigned Providers
     */
    public static function assginProvidersWithService($request)
    {
        try {
            $addAssignedUsers = [];
            $realationType = 1;
            if ($request->user == 'sub-affiliates') {
                $realationType = 4;
            }
            foreach ($request->providers as $provider) {
                if ($request->has('requesttype')) {
                    array_push($addAssignedUsers, [
                        'service_id' => $request->providerservice,
                        'source_user_id' =>  $provider,
                        'relational_user_id' => decryptGdprData($request->id),
                        'relation_type' => $realationType,
                        'assigned_by' => auth()->user()->id,
                        'status'     => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    array_push($addAssignedUsers, [
                        'service_id' => $request->providerservice,
                        'source_user_id' => decryptGdprData($request->id),
                        'relational_user_id' => $provider,
                        'relation_type' => $realationType,
                        'assigned_by' => auth()->user()->id,
                        'status'     => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
            AssignedUsers::insert($addAssignedUsers);
            if ($request->has('requesttype')) {
                $data = self::getAssignedProviders($realationType, '', '', decryptGdprData($request->id));
                $request = new Request([
                    'id'   => $request->id,
                    'providerservice' => 1,
                    'type'  => 2,
                    'providertype'  => 1
                ]);
                $users = AssignedUsers::getUserServiceById($request);
                return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $data, 'users' => $users]);
            }
            $data = self::getAssignedProviders($realationType, decryptGdprData($request->id));
            $users = AssignedUsers::getUserServiceById($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $data, 'users' => $users]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Assigned Distributors
     */
    public static function assignDistributorsWithService($request)
    {
        try {
            $addAssignedDistributors = [];
            $realationType = 5;
            if ($request->user == 'sub-affiliates') {
                $realationType = 6;
            }
            foreach ($request->distributors as $distributor) {
                array_push($addAssignedDistributors, [
                    'service_id' => $request->distributorservice,
                    'source_user_id' => decryptGdprData($request->id),
                    'relational_user_id' => $distributor,
                    'relation_type' => $realationType,
                    'assigned_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            AssignedUsers::insert($addAssignedDistributors);
            $data = self::getAssignedDistributors($realationType, decryptGdprData($request->id));
            $distributors = AssignedUsers::getDistributorsByServiceId($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.usersuccess'), 'result' => $data, 'distributors' => $distributors]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getAssignedUsers($realationType, $id, $serviceId = null)
    {
        $query = DB::table('assigned_users as au')
            ->selectRaw('au.*,source_user.first_name as sourcename,source_user.last_name as sourcelname,roles.name as rolename,services.service_title,assigned_users.first_name as aname,assigned_users.last_name as alname')
            ->leftJoin("users as source_user", "source_user.id", "=", "au.relational_user_id")
            ->leftJoin("roles", "roles.id", "=", "source_user.role")
            ->leftJoin("services", "services.id", "=", "au.service_id")
            ->leftJoin("users as assigned_users", "assigned_users.id", "=", "au.assigned_by")
            ->where('source_user_id', $id)->where('relation_type', $realationType);
        if (!empty($serviceId)) {
            $query->where('au.service_id', $serviceId);
        }
        $query = $query->get()->toArray();
        return self::modifyUserResult($query);
    }

    public static function modifyUserResult($usersdata)
    {
        $data = [];
        foreach ($usersdata as  $value) {
            array_push($data, [
                'id' => $value->id,
                'first_name' => ucfirst(decryptGdprData($value->sourcename)) . ' ' . ucfirst(decryptGdprData($value->sourcelname)),
                'assignedby' => ucfirst(decryptGdprData($value->aname)) . ' ' . ucfirst(decryptGdprData($value->alname)),
                'rolename' => ucfirst($value->rolename),
                'service' => $value->service_title,
                'created' => $value->created_at
            ]);
        }
        return $data;
    }

    public static function deleteUserById($request)
    {
        try {
            AssignedUsers::where('id', $request->did)->delete();
            $users = AssignedUsers::getUserServiceById($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.userdelete'), 'users' => $users]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

  public static function getAssignedProviders($realationType, $id, $serviceId = null, $providerId = null)
    {
        $query = DB::table('assigned_users as au')
            ->selectRaw('au.*,services.service_title,assigned_users.first_name as aname,assigned_users.last_name as alname,providers.id as providerPrimaryID, providers.name,au.source_user_id,affiliates.company_name,roles.name as rolename')
            ->leftJoin("services", "services.id", "=", "au.service_id")
            ->leftJoin("users as assigned_users", "assigned_users.id", "=", "au.assigned_by")
            ->leftJoin("roles", "roles.id", "=", "au.assigned_by")
            ->leftJoin("affiliates", "affiliates.user_id", "=", "au.source_user_id")
            ->leftJoin("providers", "providers.user_id", "=", "au.relational_user_id")
            ->where('relation_type', $realationType);
        if (empty($id)) {
            $query->where('relational_user_id', $providerId);
        } else {
            $query->where('source_user_id', $id);
        }
        if (!empty($serviceId)) {
            $query->where('au.service_id', $serviceId);
        }
        $query = $query->get()->toArray();
        return self::modifyProviderResult($query);
    }

    public static function modifyProviderResult($usersdata)
    {
        $data = [];
        foreach ($usersdata as  $value) {
            array_push($data, [
                'id' => encryptGdprData($value->id),
                'provider_primary_id' => encryptGdprData($value->providerPrimaryID),
                'source_user_id' => encryptGdprData($value->source_user_id),
                'name' => ucfirst($value->name),
                'assignedby' => ucfirst(decryptGdprData($value->aname)) . ' ' . ucfirst(decryptGdprData($value->alname)),
                'rolename' => ucfirst($value->rolename),
                'service' => $value->service_title,
                'created' => $value->created_at,
                'servive_id' => encryptGdprData($value->service_id),
                'relationaluser' => encryptGdprData($value->relational_user_id),
                'status'      => $value->status,
                'company_name' => $value->company_name
            ]);
        }
        return $data;
    }

    public static function deleteProviderById($request)
    {
        try {
            $service = decryptGdprData($request->service);
            $relation = decryptGdprData($request->relation);
            $source = decryptGdprData($request->source);
            if ($request->user == 'sub-affiliates') {
                //delete record when come from sub-affiliates
                AssignedUsers::where('id', decryptGdprData($request->did))->delete();
                $users = AssignedUsers::getUserServiceById($request);
                return response()->json(['status' => 200, 'message' => trans('affiliates.providerdelete'), 'users' => $users]);
            }
            $id = AssignedUsers::getAffiliateIdByUserId($source);
            $subaffilatesId = AssignedUsers::getSubaffiliatesId($id);
            if (empty($subaffilatesId)) {
                AssignedUsers::where('id', decryptGdprData($request->did))->delete();
                $users = AssignedUsers::getUserServiceById($request);
                return response()->json(['status' => 200, 'message' => trans('affiliates.providerdelete'), 'users' => $users]);
            }
            $query = DB::table('assigned_users')
                ->whereIn('source_user_id', $subaffilatesId)
                ->where('service_id', $service)
                ->where('relation_type', 4)
                ->where('relational_user_id', $relation)
                ->pluck('id');
            $quries = DB::getQueryLog();
            if (empty($query)) {
                AssignedUsers::where('id', decryptGdprData($request->did))->delete();
                $users = AssignedUsers::getUserServiceById($request);
                return response()->json(['status' => 200, 'message' => trans('affiliates.providerdelete'), 'users' => $users]);
            }
            AssignedUsers::whereIn('id', $query)->delete();
            AssignedUsers::where('id', decryptGdprData($request->did))->delete();
            $users = AssignedUsers::getUserServiceById($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.providerdelete'), 'users' => $users]);
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function providerChangeStatus($request)
    {
        DB::beginTransaction();
        try {
            $status = 'false';
            $httpStatus = 400;
            $userId = decryptGdprData($request['id']);
            $providerStatus = AssignedUsers::where('id', $userId)->update(['status' => $request['status']]);
            if ($providerStatus) {
                $status = 'true';
            }
            if ($status == 'true') {
                DB::commit();
                $httpStatus = 200;
                $message = trans('affiliates.affiliate_status_update');
                return response()->json(['status' => $httpStatus, 'message' => $message]);
            }
            DB::rollback();
            $message = trans('affiliates.affiliate_status_notupdate');
            return response()->json(['status' => $httpStatus, 'message' => $message]);
        } catch (\Exception $err) {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getAssignedDistributors($realationType, $id, $serviceId = null)
    {
        $query = DB::table('assigned_users as au')
            ->selectRaw('au.*,services.service_title,assigned_users.first_name as aname,assigned_users.last_name as alname,distributors.name')
            ->leftJoin("services", "services.id", "=", "au.service_id")
            ->leftJoin("users as assigned_users", "assigned_users.id", "=", "au.assigned_by")
            ->leftJoin("distributors", "distributors.id", "=", "au.relational_user_id")
            ->where('source_user_id', $id)->where('relation_type', $realationType);
        if (!empty($serviceId)) {
            $query->where('au.service_id', $serviceId);
        }
        $query = $query->get();
        return self::modifyDistributorResult($query);
    }

    public static function modifyDistributorResult($usersdata)
    {
        $data = [];
        foreach ($usersdata as $value) {
            array_push($data, [
                'id' => $value->id,
                'name' => $value->name,
                'assignedby' => ucfirst(decryptGdprData($value->aname)) . ' ' . ucfirst(decryptGdprData($value->alname)),
                'rolename' => 'Distributor',
                'service' => $value->service_title,
                'created' => $value->created_at
            ]);
        }
        return $data;
    }

    public static function deleteDistributorById($request)
    {
        try {
            AssignedUsers::where('id', $request->did)->delete();
            $distributors = AssignedUsers::getDistributorsByServiceId($request);
            return response()->json(['status' => 200, 'message' => trans('affiliates.distributordelete'), 'distributors' => $distributors]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function getProviderRelatedPlans($request)
    {
        //dd(decryptGdprData($request->user_id));
        //dd(decryptGdprData($request->service_id));
        try {
            $disallowed_plans = DB::table('provider_disallow_plans')
                ->where(['affiliate_id' => decryptGdprData($request->aff_id), 'status'=>1]);
            $provider = Providers::where(['user_id' => decryptGdprData($request->user_id), 'service_id' => decryptGdprData($request->service_id)])->first();
            $plans = [];
            if($provider){
                if($provider->service_id == 1){
                    $plans = PlanEnergy::where(['provider_id' => $provider->user_id, 'status' => 1])->get();
                    $disallowed_plans = $disallowed_plans->where(['provider_id' => $provider->id]);
                }elseif($provider->service_id == 2){
                    $plans = PlanMobile::where(['provider_id' => $provider->user_id, 'status' => 1])->get();
                    $disallowed_plans = $disallowed_plans->where(['provider_id' => $provider->id]);
                }elseif($provider->service_id == 3){
                    $plans = PlansBroadband::where(['provider_id' => $provider->user_id, 'status' => 1])->get();
                    $disallowed_plans = $disallowed_plans->where(['provider_id' => $provider->id]);
                }
                if(count($plans)) {
                    $disallowed_plans = $disallowed_plans->pluck('plan_id')->toArray();
                    $plans = $plans->map(function ($plan, $key) use ($disallowed_plans) {
                        in_array($plan->id, $disallowed_plans) ? $plan->disallowed = 1 : $plan->disallowed = 0;
                        return $plan;
                    });
                    return $plans->toArray();
                }
            }
            return $plans;
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function setProviderDisallowPlans($request)
    {
        try {
            DB::table('provider_disallow_plans')
                ->where(['affiliate_id' => decryptGdprData($request->affiliate_id), 'provider_id' => decryptGdprData($request->provider_id)])
                ->delete();
            if($request->assigned_plans != null) 
            { 
                foreach($request->assigned_plans as $plan_id) {
                    $data[] = [
                        'affiliate_id' => decryptGdprData($request->affiliate_id),
                        'provider_id' => decryptGdprData($request->provider_id),
                        'plan_id' => $plan_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } 
                DB::table('provider_disallow_plans')->insert($data);
            }
            return ['status' => 200, 'message' => 'Data saved successfully.'];
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }
}