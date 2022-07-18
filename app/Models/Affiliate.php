<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{BasicCrudMethods, CommissionStructureMethods, Relationship, Accessor, Mutators, GeneralMethods};

class Affiliate extends Model
{
    use BasicCrudMethods, Relationship, Accessor, Mutators, GeneralMethods, CommissionStructureMethods;

    protected $fillable = ['user_id', 'parent_id', 'legal_name', 'company_name', 'sender_id', 'support_phone_number', 'lead_export_password', 'sale_export_password', 'generate_token', 'show_agent_portal', 'sub_affiliate_type', 'referral_code_url', 'referral_code_title', 'referal_code', 'logo', 'dedicated_page', 'facebook_url', 'twitter_url', 'instagram_url', 'youtube_url', 'linkedin_url', 'google_plus_url', 'lead_data_in_cookie', 'lead_ownership_days_interval', 'debit_info_password', 'allow_credit_score', 'default_credit_score', 'allow_default_credit_score', 'status', 'restricted_start_time', 'restricted_end_time','reconmethod','cross_selling','life_support_content','life_support_status'];

    public function getreconAffiliates()
    {
        return $this->hasMany('App\Models\AffiliateRecon', 'user_id', 'user_id');
    }

    public function getLogoAttribute($value)
    {
        if (isset($value) && !empty($value)) {
            $AffiliateName = $this->user_id;
            $s3fileName =   str_replace("<aff-id>", $AffiliateName, config('env.AFFILIATE_LOGO'));
            $url = config('env.Public_BUCKET_ORIGIN') . config('env.DEV_FOLDER') . $s3fileName . $value;
            return $url;
        }
        return $value;
    }

    public function getParentAffiliate(){
        return $this->belongsTo('App\Models\Affiliate','parent_id','id');
    }
}
