<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\User\RecoveryCodes;
use App\Traits\User\TwoFactorAuth;
use App\Repositories\Affiliate\{BasicCrudMethods};
use App\Repositories\User\{BasicCrudMethods as UserCrud,Accessor,ManageUserCrud};
use App\Repositories\Affiliate\AssignAffiliateBdmPermission;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable implements MustVerifyEmail
{
    use BasicCrudMethods,UserCrud,Accessor,ManageUserCrud,AssignAffiliateBdmPermission;
    use HasFactory, Notifiable;
    use SpatieLogsActivity;
    use HasRoles;
    use RecoveryCodes, TwoFactorAuth;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_sent',
        'api_token',
        'password',
        'two_factor_secret',
        'phone',
        'role',
        'created_by',
        'status',
    ];

    protected $appends = ['full_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return ucwords(decryptGdprData($this->first_name)) . " " . ucwords(decryptGdprData($this->last_name));
    }

    /**
     * Prepare proper error handling for url attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->info) {
            return asset($this->info->avatar_url);
        }

        return asset(theme()->getMediaUrlPath() . 'avatars/blank.png');
    }

    /**
     * User relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function ApiKeys()
    {
        return $this->hasMany(\App\Models\AffiliateKeys::class, 'user_id');
    }
    public function target()
    {
        return $this->hasMany('App\Models\AffiliateTarget', 'user_id');
    }
    public function affiliate()
    {
        return $this->hasOne(\App\Models\Affiliate::class, 'user_id');
    }
    public function provider()
    {
        return $this->hasOne(\App\Models\Providers::class, 'user_id');
    }
    public function services()
    {
        return $this->belongsToMany(\App\Models\Services::class, 'user_services', 'user_id', 'service_id');
    }
    public function userService()
    {
        return $this->hasMany(\App\Models\UserService::class,'user_id', 'id');
    }
    function getAffiliate ($columns = '*', $withBank=null, $withKey=null, $withThirdParty=null, $withAddress=null) {
        $query = DB::table('affiliates')->select($columns)->where('affiliates.user_id', $this->id);

        if ($withKey) { 
			$query = $query->join('affiliate_keys', 'affiliates.user_id', '=', 'affiliate_keys.user_id');
		}
        
        if ($withBank) { 
			$query = $query->leftjoin('user_bank_details', 'affiliates.user_id', '=', 'user_bank_details.user_id');
		}

        if ($withThirdParty) { 
			$query = $query->leftjoin('affiliate_third_party_apis', 'affiliates.user_id', '=', 'affiliate_third_party_apis.user_id');
		}

        if ($withAddress) { 
			$query = $query->leftjoin('user_address', 'affiliates.user_id', '=', 'user_address.user_id');
		}

        
        return $query->first();
    }
    
    public function qaAssignedAffiliates()
    {
        return $this->hasMany(\App\Models\AssignedUsers::class,'source_user_id', 'id')->where('relation_type',2);
    }

    public function userSetting()
    {
        return $this->hasOne(\App\Models\UserSetting::class,'user_id', 'id');
    }

}
