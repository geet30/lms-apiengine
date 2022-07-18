<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{GeneralMethods, ManageUsers};
use App\Repositories\ProviderConsentRepository\{BasicCrudMethods, Relationship, Accessor, Mutators, StatesMethods};
use App\Traits\Provider\{SchemaMethods};
use App\Traits\Provider\AlintaEnergy\{Schema, Constant};
use App\Traits\Provider\ActewAgl\{Schema as ActewAglSchema, Constant as ActewAglConstant};
use App\Traits\Provider\FirstEnergy\{Schema as FirstEnergySchema, Constant as FirstEnergyConstant};
use App\Traits\Provider\Tango\{Schema as TangoSchema, Constant as TangoConstant};
use App\Traits\Provider\SumoPower\{Schema as SumoPowerSchema, Constant as SumoPowerConstant};
use App\Traits\Provider\SimplyEnergy\{Schema as SimplyEnergySchema, Constant as SimplyEnergyConstant};
use App\Traits\Provider\MomentumEnergy\{Schema as MomentumEnergySchema, Constant as MomentumEnergyConstant};
use App\Traits\Provider\EnergyLocals\{Schema as EnergyLocalsSchema, Constant as EnergyLocalsConstant};
use App\Traits\Provider\BlueNRG\{Schema as BlueNRGSchema, Constant as BlueNRGConstant};
use App\Traits\Provider\DodoRetailer\{Schema as DodoRetailerSchema, Constant as DodoRetailerConstant};
use App\Traits\Provider\EnergyAustralia\{Schema as EnergyAustraliaSchema, Constant as EnergyAustraliaConstant};
use App\Traits\Provider\Powershop\{Schema as PowershopSchema, Constant as PowershopConstant};
use App\Traits\Provider\AGL\{Schema as AGLSchema};

class Providers extends Model
{
    use BasicCrudMethods, Relationship, Accessor, Mutators, GeneralMethods, ManageUsers, StatesMethods, SchemaMethods, Schema, Constant, ActewAglSchema, ActewAglConstant, FirstEnergySchema, FirstEnergyConstant, SumoPowerSchema, SumoPowerConstant, SimplyEnergySchema, SimplyEnergyConstant, MomentumEnergySchema, MomentumEnergyConstant, TangoSchema, TangoConstant, EnergyLocalsSchema, EnergyLocalsConstant, BlueNRGSchema, BlueNRGConstant, DodoRetailerSchema, DodoRetailerConstant, EnergyAustraliaSchema, EnergyAustraliaConstant, PowershopSchema, PowershopConstant, AGLSchema;

    protected $fillable = ['user_id', 'address_id', 'service_id', 'name', 'legal_name', 'abn_acn_no', 'support_email', 'complaint_email', 'description', 'demand_usage_check', 'status'];
}
