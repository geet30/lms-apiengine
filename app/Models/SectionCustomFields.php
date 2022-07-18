<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCustomFields extends Model
{
    use HasFactory;
    protected $table = 'provider_section_custom_fields';
    protected $fillable = ['user_id', 'section_id', 'label', 'placeholder', 'mandatory', 'message', 'answer_type', 'count', 'question', 'label'];

   
    public function customPlanSection()
    {
        return $this->hasMany('App\Models\ProviderFieldPlan', 'provider_section_custom_fields_id', 'id');
    }
}
