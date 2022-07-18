<?php

namespace App\Repositories\User;

trait BasicCrudMethods
{
    public static function users($role,$affiliateIds)
    {
        try {
            return self::where('status',1)->where('role',$role)->get();
            // return self::where('status',1)->where('role',$role)->whereHas('qaAssignedAffiliates',function($q)use($affiliateIds){
            //     $q->whereIn('relational_user_id',$affiliateIds);
            // })->with('qaAssignedAffiliates',function($q)use($affiliateIds){
            //     $q->select('source_user_id','relational_user_id')->whereIn('relational_user_id',$affiliateIds);
            // })->with('userSetting')->get();
        } catch (\Exception $e) {

            $result = [
                'exception_message_front' => $e->getMessage(),
                'exception_message_line' => $e->getLine(),
                'exception_message_file' => $e->getFile(),
                'success' => 'false'
            ];
            return response()->json($result, 400);
        }
    }
}
