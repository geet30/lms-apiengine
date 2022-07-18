<?php

use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;

if (!function_exists('states')) {
    function states(){
        return DB::table('states')->selectRaw('state_id,state')->get();
    }
}

if (!function_exists('getModifyRoleName')) {
    function getModifyRoleName($role){
        if($role == 1)
        {
            return 'Admin';
        }
        else if($role == 2)
        {
            return 'Affiliate';
        }
        else if($role == 3)
        {
            return 'Sub-Affiliate';
        }
        else if($role == 4)
        {
            return 'QA';
        }
        else if($role == 5)
        {
            return 'BDM';
        }
        else if($role == 6)
        {
            return 'Accountant';
        }
        else if($role == 8)
        {
            return 'Affiliate BDM';
        }
        else if($role == 9)
        {
            return 'Sub-Affiliate BDM';
        }
        return 'N/A';
    }
}

if (!function_exists('getLoginUserLogo')) {
    function getLoginUserLogo($id, $role){
        // Role 2 for Affiliate
        switch ($role) {
            case 2:
                $affliateLogo = Affiliate::where('user_id',$id)->first();
                return $affliateLogo->logo;
                break; 

            default:
            return asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
                
        }
    }
}


