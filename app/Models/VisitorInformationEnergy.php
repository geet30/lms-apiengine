<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorInformationEnergy extends Model
{
    use HasFactory;

    protected $table = 'visitor_informations_energy';
    
    protected $fillable = ['nmi_number','dpi_mirn_number','nmi_skip','mirn_skip','meter_number_e','meter_number_g','electricity_network_code','gas_network_code','tariff_list','tariff_type','electricity_code','gas_code','meter_hazard','dog_code','site_access_electricity','site_access_gas'];
}
