<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Provider\ { SftpMethods };

class ProviderSftp extends Model
{
    use SftpMethods;

    protected $table = 'provider_sftps';

    protected $hidden= ['id','created_at','updated_at'];

    protected $fillable = ['provider_id','destination_name','remote_host','port','username','auth_type','password','directory','timeout','status','protocol_type'];
}
