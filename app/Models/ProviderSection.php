<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSection extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','service_id','section_id','section_script','acknowledgement','section_status'];

    public  function getSectionOption(){
		return $this->hasMany('App\Models\ProviderSectionOption','provider_section_id','id')->where('section_option_status', 1);
	}
}
