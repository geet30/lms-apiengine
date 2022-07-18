<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRemarketingInformation extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id','discount','remarketing_allow','discount_title','contract_term','termination_fee','remarketing_terms_conditions'];

}
