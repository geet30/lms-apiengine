<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionType extends Model
{
    use HasFactory;
    protected $table = 'connection_types';
    protected $fillable = ['service_id','connection_name','connection_type_id','technology_name','script'];
    public function technology()
	{
	    return $this->hasMany('App\Models\ConnectionType', 'connection_type_id','id');
	}
    public function get_technology_type()
    {
        return $this->technology()->with('get_technology_type');
    }
    public function planProviderCheckbox(){
        return $this->hasMany('App\Models\ProviderContentCheckbox', 'connection_type','local_id');
    }
   
}                                                                                                              