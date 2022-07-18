<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\LifeSupportEquipmentRequest;
use App\Http\Requests\Settings\MasterLifeSupportContentRequest;
use App\Models\LifeSupportEquipment;
use App\Repositories\Settings\LifeSupportEquipments;
use Illuminate\Http\Request;

class LifeSupportEquipmentController extends Controller
{
    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function index(Request $request)
    {
        try {
            return LifeSupportEquipments::index();
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function getLifeSupportData()
    {
        try {
            return LifeSupportEquipment::getLifeSupportData();
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function addUpdate(LifeSupportEquipmentRequest $request, $life_support_id=null)
    {
        try {
            return LifeSupportEquipment::addUpdate($request, $life_support_id);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function deleteLifeSupportEquipment($life_support_id)
    {
        try {
            return LifeSupportEquipment::deleteLifeSupportEquipment($life_support_id);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function changeLifeSupportEquipmentStatus($life_support_id)
    {
        try {
            return LifeSupportEquipment::changeLifeSupportEquipmentStatus($life_support_id);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     */
    public function postMasterLifeSupportContent(MasterLifeSupportContentRequest $request)
    {
        try {
            return LifeSupportEquipment::postMasterLifeSupportContent($request);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }
}
