<?php

namespace App\Repositories\SaleDetail;
use App\Models\{SaleStatusHistoryEnergy, SaleStatusHistoryMobile, SaleStatusHistoryBroadband};
use DB;

trait CommonMethods
{
    public static function getStatusHistory($productId){
		return self::where('sale_product_id',$productId)->with('getStatuses','getUser')->orderBy('id','desc')->get();
	}

}
