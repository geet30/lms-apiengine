<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhitelistAffiliateIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ips', 'affiliate_id','created_by','deleted_at'
    ];
}
