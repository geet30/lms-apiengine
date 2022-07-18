<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Affiliates\{ManageUserRequest, ProviderDisallowPlansRequest, WhiteListIpRequest};
use App\Models\{
    AssignedUsers
};

class ManageUserController extends Controller
{
    /**
     * Get User Services
     */
    public function index(Request $request, $userId = null)
    {
        try {
            $realationType = 2;
            $affId = decryptGdprData($userId);
            $userType = '';
            if ($request->user == 'sub-affiliates') {
                $realationType = 3;
                $userType = 4;
            }
            $getAssignedUsers = AssignedUsers::getAssignedUsers($realationType, decryptGdprData($userId));
            return ['getAssignedUsers' => $getAssignedUsers];
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    /**
     * Get User Services and assignedproviders
     */
    public function getProviders(Request $request, $userId = null)
    {
        try {
            $realationType = 1;
            $affId = decryptGdprData($userId);
            $userType = '';
            if ($request->user == 'sub-affiliates') {
                $realationType = 4;
                $userType = 4;
            }
            $getAssignedProviders = AssignedUsers::getAssignedProviders($realationType, decryptGdprData($userId));
           
            return ['getAssignedProviders' => $getAssignedProviders];
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }



    /**
     * Get User By ServiceID
     */
    public function getUsers(Request $request)
    {
        try {

            $realationType = 2;
            if ($request->user == 'sub-affiliates') {
                $realationType = 3;
            }

            $users = AssignedUsers::getUserServiceById($request);
            $getAssignedUsers = AssignedUsers::getAssignedUsers($realationType, decryptGdprData($request->id), $request->userservice);
            $result = ['users' => $users, 'getAssignedUsers' => $getAssignedUsers];
            return response()->json(['status' => 200, 'message' => trans('affiliates.success'), 'result' => $result]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Assign Users
     */
    public function assignUsers(ManageUserRequest $request)
    {
        try {
            return  AssignedUsers::assginUsersWithService($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            return AssignedUsers::deleteUserById($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function assignProviders(ManageUserRequest $request)
    {
        try {
            return AssignedUsers::assginProvidersWithService($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Get providers By ServiceID
     */
    public function getProviderWithRelation(Request $request)
    {
        try {

            $realationType = 1;
            if ($request->user == 'sub-affiliates') {
                $realationType = 4;
            }
            $users = AssignedUsers::getUserServiceById($request);
            $getAssignedProviders = AssignedUsers::getAssignedProviders($realationType, decryptGdprData($request->id), $request->providerservice);

            $result = ['users' => $users, 'getAssignedProviders' => $getAssignedProviders];
            return response()->json(['status' => 200, 'message' => trans('affiliates.success'), 'result' => $result]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }


    public function deleteProvider(Request $request)
    {
        try {
            return AssignedUsers::deleteProviderById($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function changeProviderStatus(Request $request)
    {
        try {
            return AssignedUsers::providerChangeStatus($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }



    public function getDistributors(Request $request, $userId = null)
    {
        try {
            $realationType = 5;
            $affId = decryptGdprData($userId);
            $userType = '';
            if ($request->user == 'sub-affiliates') {
                $realationType = 6;
                $userType = 4;
            }
            $getAssignedDistributors = AssignedUsers::getAssignedDistributors($realationType, decryptGdprData($userId));
            return ['getAssignedDistributors' => $getAssignedDistributors];
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    /**
     * Get distributors By ServiceID
     */
    public function getDistributorsWithService(Request $request)
    {
        try {

            $realationType = 5;
            if ($request->user == 'sub-affiliates') {
                $realationType = 6;
            }

            $distributors = AssignedUsers::getDistributorsByServiceId($request);
            $getAssignedDistributors = AssignedUsers::getAssignedDistributors($realationType, decryptGdprData($request->id), $request->distributorservice);

            $result = ['distributors' => $distributors, 'getAssignedDistributors' => $getAssignedDistributors];
            return response()->json(['status' => 200, 'message' => trans('affiliates.success'), 'result' => $result]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function assignDistributors(ManageUserRequest $request)
    {
        try {
            return AssignedUsers::assignDistributorsWithService($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function deleteDistributor(Request $request)
    {
        try {
            return AssignedUsers::deleteDistributorById($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getProviderAssignedPlans(Request $request)
    {
        try {
            $getAssignedPlans = AssignedUsers::getProviderRelatedPlans($request);
            return ['getAssignedPlans' => $getAssignedPlans, 'status' => 200];
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function setProviderDisallowPlans(ProviderDisallowPlansRequest $request)
    {
        try {
            return AssignedUsers::setProviderDisallowPlans($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

}
