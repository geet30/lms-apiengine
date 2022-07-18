<?php

namespace App\Traits\Product;

use App\Models\ { Service, Providers, PlanEnergy, PlansBroadband, PlanMobile, SaleProductsBroadbandAddon, Handset, Variant, Contract, Color,MobileConnectionDetails };

/**
* Lead Relationship model.
* Author: Sandeep Bangarh
*/

trait Relationship
{

    public function provider() {
        return $this->hasOne(Providers::class, 'user_id', 'provider_id')->whereStatus(1);
    }

    public function planEnergy() {
        return $this->hasOne(PlanEnergy::class, 'id', 'plan_id')->whereStatus(1);
    }

    public function planBroadband() {
        return $this->hasOne(PlansBroadband::class, 'id', 'plan_id')->whereStatus(1);
    }

    public function planMobile() {
        return $this->hasOne(PlanMobile::class, 'id', 'plan_id')->whereStatus(1);
    }
    public function handset () {
        return $this->hasOne(Handset::class, 'id', 'handset_id')->whereStatus(1);
    }

    public function variant () {
        return $this->hasOne(Variant::class, 'id', 'variant_id')->whereStatus(1);
    }

    public function contract () {
        return $this->hasOne(Contract::class, 'id', 'contract_id')->whereStatus(1);
    }

    public function color () {
        return $this->hasOne(Color::class, 'id', 'color_id')->whereStatus(1);
    }
    // public function mobileConnection () {
    //     return $this->hasOne(MobileConnectionDetails::class, 'mobile_connection_id', 'id');
    // }


}