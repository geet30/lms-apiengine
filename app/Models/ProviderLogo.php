<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderLogo extends Model
{
    use HasFactory;
    protected $table = 'provider_logos';
    protected $fillable = ['user_id', 'provider_name', 'category_id', 'name', 'description', 'status'];
    public function getNameAttribute($value)
    {
        if (isset($value) && !empty($value)) {
            $providerName = $this->user_id;
            $s3fileName =   str_replace("<pro-id>", $providerName, config('env.PROVIDER_LOGO'));
            $url = config('env.Public_BUCKET_ORIGIN') . config('env.DEV_FOLDER') . $s3fileName . $value;
            return $url;
        }
        return $value;
    }
}
