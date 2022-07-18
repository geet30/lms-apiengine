<?php

namespace App\Traits\Provider;

use Carbon\Carbon;
use App\Repositories\SparkPost\NodeMailer;
use Illuminate\Support\Facades\{View, Storage, DB};

trait SftpMethods
{
    static function getData ($providerId) {
        return DB::table('provider_sftps')->where('provider_id', $providerId)->get();
    }
}