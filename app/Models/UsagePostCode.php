<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsagePostCode extends Model
{
    protected $table = 'postcode_limits';
    protected $fillable = ['usage_type','suburb_usage_limit_id','post_code'];

    public function usage_limit() {
      return $this->belongsTo('App\models\UsageLimit','suburb_usage_limit_id');
    }
}
