<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReconSale extends Model
{
    protected $table = 'recon_sales';
    protected $fillable = [
		'sale_id',
		'sale_reference_no',
		'affiliate_id',
		'parent_id',
		'lead_status',
		'energy_type',
		'sale_created',
		'recon_file_name',
		'recon_reference_no',
		'recon_status',
		'recon_created_date',
    ];
	public function VisitorAddressInfo()
	{
		return $this->hasMany('App\Models\VisitorAddress', 'visitor_sale_id', 'sale_id');
	}

}
