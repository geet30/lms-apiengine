<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSectionOption extends Model
{
    use HasFactory;
    protected $fillable = ['provider_section_id','section_option_id','section_option_status','min_value_limit','max_value_limit','is_required'];

    public  function getSectionSubOption(){
		return $this->hasMany('App\Models\ProviderSectionSubOption','section_option_id','id')->where('section_sub_option_status', 1);
	}    
}
