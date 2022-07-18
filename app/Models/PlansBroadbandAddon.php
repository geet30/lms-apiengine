<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlansBroadbandAddon extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id','addon_id','category','cost_type_id','price','script','is_default','is_mandatory','status','created_at','updated_at'];

    public function phoneHomeConnection(){
      return $this->belongsTo('App\Models\PhoneHomeLineConnection','phone_home_connection_id', 'id');
    }

    public function broadBandModem(){
      return $this->belongsTo('App\Models\BroadbandModem','broadband_modem_id', 'id');
    }

    public function broadBandOtheraddon(){
      return $this->belongsTo('App\Models\BroadbandAdditionalAddons','broadband_other_addon_id', 'id');
    }

    public function plan(){
      return $this->belongsTo('App\Models\Plan','plan_id', 'id');
    } 
}
