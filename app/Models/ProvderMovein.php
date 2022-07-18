<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvderMovein extends Model
{
    use HasFactory;
    protected $table = 'provider_movein';
    protected $fillable = ['user_id', 'property_type', 'energy_type', 'distributor_id', 'grace_day', 'move_in_content_status', 'move_in_content', 'move_in_eic_content_status', 'move_in_eic_content', 'is_deleted', 'created_at', 'updated_at', 'restricted_start_time'];

    public  function getMoveinCheckbox(){
		return $this->hasMany('App\Models\ProviderContentCheckbox','provider_content_id','id');
	}
}
