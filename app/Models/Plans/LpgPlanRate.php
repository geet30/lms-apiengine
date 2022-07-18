<?php

namespace App\Models\Plans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\PlansEnergy\{
    PlanRateCrud,Relationship,Accessor
};

use App\Repositories\PlansEnergy\Uploads\{PlanRateUpload,PlanRateUploadValidation};

class LpgPlanRate extends Model
{
    use HasFactory,PlanRateCrud,Relationship,Accessor,PlanRateUpload,PlanRateUploadValidation;
     protected $fillable=['provider_id',
                            'plan_id',
                            'distributor_id',
                            'exit_fee_option',
                            'exit_fee',
                            'annual_equipment_fees_rental_fees',
                            'annual_equipment_fees_rental_fees_desc',
                            'delivery_charges',
                            'delivery_charges_desc',
                            'account_establishment_fees',
                            'account_establishment_fees_desc',
                            'urgent_delivery_fees',
                            'urgent_delivery_fees_desc',
                            'service_and_installation_charges',
                            'service_and_installation_charges_desc',
                            'green_LPG_fees',
                            'min_quantity_with_discount',
                            'max_quantity_with_discount',
                            'cash_discount_per_bottle',
                            'cash_credits',
                            'discount_percent',
                            'optional_fees_1',
                            'optional_fees_1_desc',
                            'optional_fees_2',
                            'optional_fees_2_desc',
                            'optional_fees_3',
                            'optional_fees_3_desc',
                            'optional_fees_4',
                            'optional_fees_4_desc',
                            'optional_fees_5',
                            'optional_fees_5_desc',
                            'optional_fees_6',
                            'optional_fees_6_desc',
                            'optional_fees_7',
                            'optional_fees_7_desc',
                            'optional_fees_8',
                            'optional_fees_8_desc',
                            'optional_fees_9',
                            'optional_fees_9_desc',
                            'optional_fees_10',
                            'optional_fees_10_desc',
                            'urgent_delivery_window',
                            'late_payment_fee',
                            'price_fact_sheet',
                            'offer_ID',
                            'batch_ID',
                            'connection_fee',
                            'disconnection_fee',
                            'is_deleted',
                            'status'
                        ];

}
