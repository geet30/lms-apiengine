<?php

namespace App\Repositories\Affiliate;


trait Accessor
{

    public function getApiKeyAttribute($value)
    {
        return decryptGdprData($value);
    }
    public function getNameAttribute($value)
    {
        return decryptGdprData($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
}
