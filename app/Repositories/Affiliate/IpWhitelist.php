<?php

namespace App\Repositories\Affiliate;

use Illuminate\Support\Facades\DB;
use App\Models\{
    AssignedUsers,
    Userip
};
use Carbon\Carbon;

trait IpWhitelist
{
    

    public static function getAssignedIps($request)
    {
        try {

            $query = DB::table('user_ips')
                ->selectRaw('user_ips.*,users.first_name,users.last_name')
                ->leftJoin("users", "users.id", "=", "user_ips.assigned_by")
                ->where('user_id', decryptGdprData($request->id))->get();

            return self::modifyIpresult($query);
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }


    public static function assginWhiteListIp($request)
    {
        try {
            $type = 1;
            if (strpos($request->ips, ',') !== false) {
                $type = 2;
            }
            
            Userip::create([
                'ips' => encryptGdprData($request->ips),
                'user_id' => decryptGdprData($request->id),
                'assigned_by' => auth()->user()->id,
                'type' => $type
            ]);
            return true;
        } catch (\Exception $err) {
            return ['status' => 400, 'message' => $err->getMessage()];
        }
    }

    public static function modifyIpresult($result)
    {
        $data = [];
        foreach ($result as $value) {
            array_push($data, [
                'id' => $value->id,
                'ips' => decryptGdprData($value->ips),
                'assignedby' => ucfirst(decryptGdprData($value->first_name)) . ' ' . ucfirst(decryptGdprData($value->last_name)),
                'created' => $value->created_at
            ]);
        }
        return $data;
    }

    public static function deleteIpById($request)
    {
        return Userip::where('id', $request->id)->delete();
    }


}
