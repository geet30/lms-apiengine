<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneHomeLineConnection extends Model
{
    use HasFactory;
    protected $table = 'broadband_home_connection';

    public function provider(){
    	return $this->hasOne('App\Models\Provider','provider_unique_id','provider_id');
    }
}
