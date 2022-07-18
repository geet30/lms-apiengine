<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{ManageApiKeys, GeneralMethods, Accessor};

class AffiliateKeys extends Model
{
    use ManageApiKeys, GeneralMethods, Accessor;
    protected $table = 'affiliate_keys';
    protected $fillable = ['user_id', 'name', 'api_key', 'page_url', 'origin_url', 'status', 'rc_code', 'is_default', 'deleted_at', 'created_at', 'updated_at'];
}
