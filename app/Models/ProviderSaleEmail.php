<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Provider\ { EmailMethods };

class ProviderSaleEmail extends Model
{
    use EmailMethods; 
    
    protected $table = 'provider_sales_emails';
    
    protected $hidden= ['created_at','updated_at'];

    protected $fillable = ['provider_id','status','time','sale_submission_type','from_name','from_email','subject','to_emails','cc_emails','bcc_emails'];


    public function scopeSelectCustom($query, $value) {
    	return $query->where('sale_submission_type',$value);
	}

    public function getfFomEmailAttribute($value)
    {
        return decryptGdprData($value);
         
    }
}
