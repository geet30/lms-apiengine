<?php

namespace App\Repositories\SaleStatusHistory;

trait CommonCrud
{
    /**
     * update the plan EIC content.
     *
     * @return Array
     */
    public static function createHistory($request,$saleProductId)
    {
        try {
            $user = auth()->user();
            self::create([
                'user_id' => $user->id,
                'sale_product_id' => $saleProductId,
                'status' => $request->status,
                'sub_status' => $request->sub_status,
                'comment' => $request->comment
            ]);
            return true;
        } catch (\Exception $err) {
            throw $err;
        }
    }
}
