<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Repositories\Plans\Mobile\{ BasicCrudMethods, Relationship, Accessor, Mutators };
use App\Repositories\Plans\Mobile\Uploads\PlanUpload;
class PlanMobile extends Model
{
    use HasFactory, BasicCrudMethods, Relationship, Accessor, Mutators, SoftDeletes,PlanUpload;
    protected $table ='plans_mobile';
    protected $fillable = array ( 'provider_id','name','connection_type','plan_type','sim_type','host_type','business_size','bdm_available','bdm_contact_number','bdm_details','cost_type_id','cost','plan_data','plan_data_unit','network_type','contract_id','activation_date_time','deactivation_date_time', 'billing_preference','inclusion','details','new_connection_allowed','port_allowed','retention_allowed','amazing_extra_facilities','national_voice_calls','national_video_calls','national_text','national_mms','national_directory_assist','national_diversion','national_call_forwarding','national_voicemail_deposits','national_toll_free_numbers','national_internet_data','national_special_features','national_additonal_info','international_voice_calls','international_video_calls','international_text','international_mms','international_diversion','international_additonal_info','roaming_charge','roaming_voice_incoming','roaming_voice_outgoing','roaming_video_calls','roaming_text','roaming_mms','roaming_voicemail_deposits','roaming_internet_data','roaming_additonal_info','cancellation_fee','lease_phone_return_fee','activation_fee','late_payment_fee','delivery_fee','express_delivery_fee','paper_invoice_fee','payment_processing_fee','card_payment_fee','minimum_total_cost','other_fee_charges','remarketing_allow','status','network_host_information','special_offer_status','special_offer_title','special_offer_cost','special_offer_description');
    protected $guarded = ['id']; 
    public function getconnectiontypes()
    {
      return $this->belongsTo('App\Models\ConnectionType','connection_type','id');
    }

}
