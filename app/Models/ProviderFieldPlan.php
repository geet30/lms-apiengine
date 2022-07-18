<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderFieldPlan extends Model
{
    use HasFactory;
    protected $table = 'provider_plan_custom_fields';

    protected $fillable = ['user_id', 'provider_section_custom_fields_id', 'plan_id', 'created_at', 'updated_at'];
}
