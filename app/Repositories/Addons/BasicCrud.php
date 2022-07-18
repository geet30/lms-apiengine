<?php

namespace App\Repositories\Addons;

use Auth;
use Carbon\Carbon;
use App\Models\{
    PlanAddonsMaster,
    PlanAddonMasterTechType,
};
use DB;

trait BasicCrud
{
    public static function storeOrUpdateAddons($request, $category)
    {
        try {
            if ($category == 3) {
                $id = '';
                $status = true;
                $msg = 'Addon has been added succesfully';
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $id = decryptGdprData($request->addon_id); //table id
                    $msg = trans('Addon has been updated succesfully');
                }
                $data = $request->only('category', 'provider_id', 'name', 'cost', 'cost_type_id', 'order', 'inclusion', 'script', 'description');
                $data['service_id'] = 3;
                $data['status'] = 1;
                $data['is_deleted'] = 0;
                $countOrder = PlanAddonsMaster::where('category', '=', $request->category)->where('order', '=', $request->order);
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $countOrder = $countOrder->where('id', '!=', decryptGdprData($request->addon_id));
                }
                $countOrder = $countOrder->select('id')->get();
                if (count($countOrder) > 0) {
                    // return response()->json(['success' => false,'message'=>'Order type already exists.','status'=>422],422);
                    $errors['order'] = 'Order number already exists.';
                    return response()->json(['status' => 422, 'errors' => $errors], 422);
                } else {
                    PlanAddonsMaster::updateOrCreate(['id' => $id], $data);
                }
                return response()->json(['status' => $status, 'message' => $msg], 200);
            }
            if ($category == 4) {
                $id = '';
                $status = true;
                $msg = 'Addon has been added succesfully';
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $id = decryptGdprData($request->addon_id); //table id
                    $msg = trans('Addon has been updated succesfully');
                }
                $data = $request->only('category', 'name', 'connection_type', 'order', 'description');
                $data['service_id'] = 3;
                $data['status'] = 1;
                $data['is_deleted'] = 0;
                $countOrder = PlanAddonsMaster::where('category', '=', $request->category)->where('order', '=', $request->order);
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $countOrder = $countOrder->where('id', '!=', decryptGdprData($request->addon_id));
                }
                $countOrder = $countOrder->select('id')->get();
                if (count($countOrder) > 0) {
                    // return response()->json(['success' => false,'message'=>'Order type already exists.','status'=>422],422);
                    $errors['order'] = 'Order number already exists.';
                    return response()->json(['status' => 422, 'errors' => $errors], 422);
                } 
                else {
                    $addon = PlanAddonsMaster::updateOrCreate(['id' => $id], $data);
                    if (isset($request->addon_id) && $request->addon_id != "") {
                        $addon_id = decryptGdprData($request->addon_id);
                        if ($request->has('tech_type')) {
                            $selectedTech =  $request->tech_type;
                            $assignTech = PlanAddonMasterTechType::where('addon_id', $addon_id)->pluck('tech_type')->toArray();

                            $deleteTechs = array_diff($assignTech, $selectedTech);
                            $insertTechs = array_diff($selectedTech, $assignTech);

                            PlanAddonMasterTechType::where('addon_id', $addon_id)->whereIn('tech_type', $deleteTechs)->delete();
                            $insertTech = [];
                            foreach ($insertTechs as $value) {
                                $insertTech[] = [
                                    'addon_id' => $addon_id,
                                    'tech_type' => $value,
                                ];
                            }
                            PlanAddonMasterTechType::insert($insertTech);
                        } else {
                            PlanAddonMasterTechType::where('addon_id', $addon_id)->delete();
                        }
                    } else {
                        if ($addon && $request->has('tech_type')) {

                            $insertTech = [];
                            foreach ($request->tech_type as $value) {
                                $insertTech[] = [
                                    'addon_id' => $addon->id,
                                    'tech_type' => $value,
                                ];
                            }
                            PlanAddonMasterTechType::insert($insertTech);
                        }
                    }
                }
                return response()->json(['status' => $status, 'message' => $msg], 200);
            }
            if ($category == 5) {
                $id = '';
                $status = true;
                $msg = 'Addon has been added succesfully';
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $id = decryptGdprData($request->addon_id); //table id
                    $msg = trans('Addon has been updated succesfully');
                }
                $data = $request->only('category', 'name', 'order', 'description');
                $data['service_id'] = 3;
                $data['status'] = 1;
                $data['is_deleted'] = 0;
                $countOrder = PlanAddonsMaster::where('category', '=', $request->category)->where('order', '=', $request->order);
                if (isset($request->addon_id) && $request->addon_id != "") {
                    $countOrder = $countOrder->where('id', '!=', decryptGdprData($request->addon_id));
                }
                $countOrder = $countOrder->select('id')->get();
                if (count($countOrder) > 0) {
                    // return response()->json(['success' => false,'message'=>'Order type already exists.','status'=>422],422);
                    $errors['order'] = 'Order number already exists.';
                    return response()->json(['status' => 422, 'errors' => $errors], 422);
                } else {
                    PlanAddonsMaster::updateOrCreate(['id' => $id], $data);
                }
                return response()->json(['status' => $status, 'message' => $msg], 200);
            }
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function updateStatus($request)
    {
        try {
            $addonId = $request->addon_id;
            return PlanAddonsMaster::where('id', $addonId)->update(['status' => $request['status']]);
        } catch (\Exception $err) {
            throw $err;
        }
    }
    public static function deleteAddons($id)
    {
        try {
            $addon = PlanAddonsMaster::find(decryptGdprData($id));
            if ($addon->category == 4) {
                $techtype = PlanAddonMasterTechType::where('addon_id', '=', decryptGdprData($id));
                $techtype->delete();
            }
            $addon->delete();
            return ['status' => true, 'message' => 'Deleted'];
        } catch (\Exception $err) {
            throw $err;
        }
    }
}
