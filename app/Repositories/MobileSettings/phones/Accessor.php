<?php
namespace App\Repositories\MobileSettings\phones;

trait Accessor
{

    public function getEncryptedIdAttribute()
    {

        return encryptGdprData($this->id);
    }

    public function getImageAttribute($value)
    {
        if (isset($value) && !empty($value)) {
            $handsetId = $this->id;
            $s3fileName =   str_replace("<handset_id>", $handsetId, config('env.HANDSET_LOGO'));
            $url = config('env.Public_BUCKET_ORIGIN').config('env.DEV_FOLDER'). $s3fileName . $value;
            return $url;
        }
        return $value;
    }
}
