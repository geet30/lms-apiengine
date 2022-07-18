<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Visitor\Address\ { Methods };

class VisitorAddress extends Model
{
    use Methods;

	protected $fillable = ['visitor_id','address','address_type','lot_number','unit_number','unit_type','unit_type_code','floor_number','floor_level_type','floor_type_code','street_number','street_number_suffix','street_name','street_suffix','street_code','house_number','house_number_suffix','suburb','state','postcode','property_name','residential_status','living_year','living_month','gnf_no','dpid','is_qas_valid','validate_address','property_ownership','site_descriptor','po_box','is_same_gas_connection','manual_connection_details'];
}
