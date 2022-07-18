<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReconSaleHistory extends Model
{
    protected $table = 'recon_sales_history';
    protected $fillable = [
    	'affiliate_id',
    	'recon_file_no',
    	'recon_file_name',
		'recon_reference_no',
		'recon_status',
		'recon_created_date',
		'recon_reset_date',
		's3_url',
		'password',
    ];
}
