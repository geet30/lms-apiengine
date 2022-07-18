<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadbandModem extends Model
{
    use HasFactory;
    protected $table = 'broadband_modem';

    public function broadband_connection()
    {
        return $this->hasOne('App\Models\ConnectionType','id','connection_type');
    }
}
