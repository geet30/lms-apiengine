<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTags extends Model
{
    protected $fillable = ['affiliate_id', 'user_id', 'tag_id', 'is_cookies', 'is_advertisement', '	is_remarketing', 'is_any_time', 'status', 'created_at', 'updated_at', 'is_deleted'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function affiliate()
    {
        return $this->belongsTo('App\Affiliate', 'affiliate_id');
    }
}
