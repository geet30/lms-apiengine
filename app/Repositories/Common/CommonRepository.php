<?php

namespace App\Repositories\Common;

use App\Models\{Distributor,LifeSupportEquipment};

use DB;

trait CommonRepository
{
    public static function getIdentificationArr()
    {
        return DB::table('master_identification_details')->pluck('options', 'id');
    }

    public static function getDistributorList($energy)
    {
        return Distributor::where('status', 1)->where('is_deleted', 0)->where('energy_type', $energy)->get()->pluck('name', 'id');
    }

    public static function getLifeSupportList(){
        return LifeSupportEquipment::where('status', 1)->orderBy('id', 'desc')->select('title', 'id')->get();
    }
}
