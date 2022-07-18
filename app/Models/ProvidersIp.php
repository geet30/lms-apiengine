<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidersIp extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','ips','ip_range','debit_info_csv_password','debit_info_csv_ip','token','deleted_at'];

    public function getTokenAttribute($value)
    {
        return decryptGdprData($value);
         
    }
}
