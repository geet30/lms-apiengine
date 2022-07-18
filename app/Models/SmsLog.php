<?php

namespace App\Models;

use App\Traits\SMS\Methods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory, Methods;

    protected $table = 'sms_logs';
    protected $fillable = [
        'affiliate_id', 'service_id', 'api_name', 'api_status', 'api_response', 'api_request', 'phone'
    ];
}
