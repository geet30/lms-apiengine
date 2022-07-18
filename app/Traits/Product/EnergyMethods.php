<?php

namespace App\Traits\Product;
use Illuminate\Support\Facades\DB;

trait EnergyMethods
{
    static function updateData ($conditions, $data) {
        self::where($conditions)->update($data);
    }

    static function getData ($conditions, $columns, $firstRow=false) {
        $query = DB::table('sale_products_energy')->select($columns)->where($conditions);
        if ($firstRow) {
            return $query->first();
        }
        return $query->get();
    }
}