<?php

namespace App\Traits\Provider;

use Illuminate\Support\Facades\DB;
use App\Models\ProviderSaleEmail;

trait EmailMethods
{
    static function getData ($conditions, $columns) {
        return ProviderSaleEmail::select($columns)->where($conditions)->get();
    }
}