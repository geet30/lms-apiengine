<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Plans\Broadband\
                                {
                                    BasicCrud, 
                                    Relationship, 
                                    Accessor,
                                    Mutators,
                                    Master
                                };
use App\Repositories\Plans\Common;
class PlansBroadband extends Model
{
    use HasFactory;
    use BasicCrud, Relationship, Accessor, Mutators,Master,Common;

    protected $fillable = [
                'name',
                'contract_id',
                'connection_type',
                'technology_type',
                'satellite_inclusion',
                'inclusion',
                'connection_type_info',
                'internet_speed',
                'internet_speed_info',
                'plan_cost_type',
                'plan_cost',
                'plan_cost_info',
                'plan_cost_description',
                'is_boyo_modem',
                'nbn_key', 
                'provider_id',
                'version',

                'download_speed',
                'upload_speed',
                'typical_peak_time_download_speed',
                'data_limit',
                'speed_description',
                'additional_plan_information',
                'plan_script',

                'data_unit_id',
                'total_data_allowance',
                'off_peak_data',
                'peak_data',

                'critical_info_type',
                'critical_info_url',

                'remarketing_allow',

                'special_offer_status',
                'special_cost_id',
                'special_offer_price',
                'special_offer',
                'billing_preference'
            ];

}
