<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\Affiliate\ManageTargets;

class AffiliateTarget extends Model
{
    use ManageTargets;
    protected $table = 'affiliate_target';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'target_value', 'status', 'sales', 'target_year', 'target_month', 'comment', 'created_at', 'updated_at'];
}
