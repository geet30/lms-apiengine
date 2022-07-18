<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class AffiliateUnsubscribeSource extends Model
{
	protected $fillable = ['user_id','unsubscribe_source','status'];
}
