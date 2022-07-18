<?php

namespace App\Repositories\SaleQaSection;

trait CommonCrud
{
	public static function saleQaSection($id)
	{
		try {
            return self::where('lead_id',$id)->first();
		} catch (\Exception $err) {
			throw $err;
		}
	}
}
