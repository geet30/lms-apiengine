<?php

namespace App\Models;

use App\Repositories\Affiliate\ManageRetention;
use Illuminate\Database\Eloquent\Model;

class AffiliateRetension extends Model
{
    use ManageRetention;
    protected $table = 'affiliates_retention';
    protected $fillable = ['user_id', 'service_id', 'provider_id', 'master_retention_allow', 'retention_allow', 'type', 'created_at', 'updated_at','override_provider_retention'];
}
