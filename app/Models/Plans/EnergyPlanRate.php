<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PlansEnergy\{
    PlanRateCrud,Relationship,Accessor
};

use App\Repositories\PlansEnergy\Uploads\{PlanRateUpload,PlanRateUploadValidation};

class EnergyPlanRate extends Model
{
    use HasFactory,PlanRateCrud,Relationship,Accessor,PlanRateUpload,PlanRateUploadValidation;
     protected $fillable=['provider_id',
                            'plan_id',
                            'type',
                            'distributor_id',
                            'rate_type',
                            'exit_fee_option',
                            'effective_from',
                            'tariff_type_code',
                            'tariff_type_title',
                            'time_of_use_rate_type',
                            'tariff_desc',
                            'late_payment_fee',
                            'late_fee_title',
                            'connection_fee',
                            'disconnection_fee',
                            'dual_fuel_discount_usage',
                            'dual_fuel_discount_supply',
                            'dual_fuel_discount_desc',
                            'pay_day_discount_usage',
                            'pay_day_discount_usage_desc',
                            'pay_day_discount_supply',
                            'pay_day_discount_supply_desc',
                            'gurrented_discount_usage',
                            'gurrented_discount_usage_desc',
                            'gurrented_discount_supply',
                            'gurrented_discount_supply_desc',
                            'direct_debit_discount_usage',
                            'direct_debit_discount_supply',
                            'direct_debit_discount_desc',
                            'daily_supply_charges',
                            'gst_rate',
                            'control_load_1_daily_supply_charges',
                            'control_load_2_daily_supply_charges',
                            'meter_type',
                            'demand_usage_desc',
                            'demand_supply_charges_daily',
                            'demand_usage_charges',
                            'price_fact_sheet',
                            'offer_id',
                            'batch_id',
                            'demand_usage_check',
                            'dmo_vdo_content',
                            'dmo_content_status',
                            'telesale_dmo_content',
                            'telesale_dmo_content_status',
                            'dmo_static_content_status',
                            'lowest_annual_cost',
                            'without_conditional_value',
                            'without_conditional',
                            'with_conditional_value',
                            'with_conditional',
                            'is_deleted',
                            'status'
                        ];

}
