<?php

namespace App\Traits\Plan;

use Illuminate\Support\Facades\{View, Storage, DB};

trait Methods
{
    static function getTags ($planId) {
        return DB::table('plan_tags')
        ->select('name')
        ->join('tags', 'plan_tags.tag_id', '=', 'tags.id')
        ->where('plan_id', $planId)
        ->get();
    }
}