<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderDirectDebit extends Model
{
    use HasFactory;
    protected $table = 'provider_direct_debits';

    protected $fillable = ['user_id','payment_method_type','card_information','bank_information','is_card_content','is_bank_content','status','deleted_at'];
    public  function getContentCheckbox(){
		return $this->hasMany('App\Models\ProviderContentCheckbox','provider_content_id','id')->where('type', 18);
	}
}
