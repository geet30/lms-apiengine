<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderPermission extends Model
{
    use HasFactory;
    protected $table = 'provider_permissions';

    protected $fillable = ['user_id','is_new_connection','is_port','is_retention','is_life_support','life_support_energy_type','is_submit_sale_api','is_resale','is_gas_only','is_demand_usage','ea_credit_score_allow','credit_score','is_telecom','is_send_plan','deleted_at','connection_script','port_script','recontract_script','is_sclerosis','is_medical_cooling','sclerosis_title','medical_cooling_title'];

    public  function getPermissionCheckbox(){
		return $this->hasMany('App\Models\ProviderContentCheckbox','provider_content_id','id');
    }
}
