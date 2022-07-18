<?php

use Illuminate\Support\Facades\Redis;

/**
 * all application permission and user based permissions.
 *
 * @return array
 */
if (!function_exists('getUserPermissions')) {
    function getUserPermissions()
    {
        try {
            $userId = auth()->user()->id;
            if (Redis::exists('user_permission:' . $userId)) {
                $userPermissions = json_decode(Redis::get('user_permission:' . $userId));
            } else {
                $userPermissions = getPermissions($userId);
                Redis::set('user_permission:' . $userId, json_encode($userPermissions));
                $userPermissions = (object)$userPermissions;
            }
            $userPermissions = isset($userPermissions->all_permissions) ? $userPermissions->all_permissions : [];

            return $userPermissions;
        } catch (\Exception $err) {
            return [];
        }
    }
}


/**
 * all affiliate permission and user based permissions.
 *
 * @return array
 */

if (!function_exists('getServiceBasedPermissions')) {
    function getServiceBasedPermissions($serviceId)
    {
        try {
            $userId = auth()->user()->id;
            if (Redis::exists('user_permission:' . $userId)) {
                $userPermissionsObj = json_decode(Redis::get('user_permission:' . $userId));
            } else {
                $userPermissionsObj = getPermissions($userId);
                Redis::set('user_permission:' . $userId, json_encode($userPermissionsObj));
                $userPermissionsObj = (object)$userPermissionsObj;
            }

            $userPermissions = [];
            if ($serviceId == 1) {
                $userPermissions = isset($userPermissionsObj->energy_permissions) ? $userPermissionsObj->energy_permissions : [];
            } else if ($serviceId == 2) {
                $userPermissions = isset($userPermissionsObj->mobile_permissions) ? $userPermissionsObj->mobile_permissions : [];
            } else if ($serviceId == 3) {
                $userPermissions = isset($userPermissionsObj->broadband_permissions) ? $userPermissionsObj->broadband_permissions : [];
            }
            return $userPermissions;
        } catch (\Exception $err) {
            return [];
        }
    }
}

/**
 * all application permission and user based permissions.
 *
 * @return boolean
 */
/****
Note:- this function is also used in saas-dashboard, if you will change this function body you will have to change in saas-dashboard also, because whenever we assigned permission from saas admin redis is updated.
 *****/
if (!function_exists('getPermissions')) {
    function getPermissions($userId)
    {
        try {
            $permissions = \DB::table('model_has_permissions')
                ->join('permissions', 'permissions.id', 'model_has_permissions.permission_id')
                ->where('model_id', $userId)
                ->select('model_has_permissions.permission_id', 'permissions.name', 'model_has_permissions.service_id')
                ->get();

            $userPermissions['all_permissions'] = array_column($permissions->toArray(), 'name');
            $permissions = $permissions->groupBy('service_id');
            $userPermissions['energy_permissions'] = isset($permissions[1]) ? array_column($permissions[1]->toArray(), 'name') : [];
            $userPermissions['mobile_permissions'] = isset($permissions[2]) ? array_column($permissions[2]->toArray(), 'name') : [];
            $userPermissions['broadband_permissions'] = isset($permissions[3]) ? array_column($permissions[3]->toArray(), 'name') : [];
            return $userPermissions;
        } catch (\Exception $err) {
            throw $err;
        }
    }
}


/**
 * all application permission and user based permissions.
 *
 * @return array
 */
if (!function_exists('getAppPermissions')) {
    function getAppPermissions()
    {
        try {
            if (Redis::exists('application_permission')) {
                $appPermissions = json_decode(Redis::get('application_permission'));
            } else {
                $appPermissions =  \DB::table('application_permissions')->pluck('permission_id')->toArray();
                $appPermissions = \DB::table('permissions')->whereIn('id', $appPermissions)->pluck('name')->toArray();
                Redis::set('application_permission', json_encode($appPermissions));
            }
            return $appPermissions;
        } catch (\Exception $err) {
            return [];
        }
    }
}

/**
 * all application permission and user based permissions.
 *
 * @return boolean
 */
if (!function_exists('checkPermission')) {
    function checkPermission($permission, $userPermissions, $appPermissions)
    {
        try {
            if (in_array($permission, $userPermissions) && in_array($permission, $appPermissions)) {
                return true;
            }
            return false;
        } catch (\Exception $err) {
            return false;
        }
    }
}
