<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanMobileVariant extends Model
{
    protected $table ='plans_mobile_variants';

	// reverse database relationship
	public function variant(){
		return $this->belongsTo('App\Models\Variant','variant_id');
	}

	protected $fillable = ['status'];

	public function scopeApiStatus($query)
    {
        return $query->where('master_status',1)->where('provider_status',1)->where('status',1);
    }

    public function contracts(){
    	return $this->hasMany(PlanContract::class);
    }
    public function plan(){
    	return $this->belongsTo(PlanMobile::class);
    }
    public function handset(){
    	return $this->belongsTo(Handset::class);
    }
}
