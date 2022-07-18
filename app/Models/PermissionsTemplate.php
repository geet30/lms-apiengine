<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class PermissionsTemplate extends Model
{
    use HasFactory;
     
    protected $table = 'permissions_template';
    protected $fillable = ['name','role_id','service_id'];

    public function roleName(){

        return $this->belongsTo(\App\Models\Role::class,'role_id','id')->select('name');
    }
    public function serviceName(){

        return $this->belongsTo(\App\Models\Services::class,'service_id','id')->select('service_title');
    }

}
