<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRoleTemplate extends Model
{
    use HasFactory;
    protected $table = "permission_role_template";
    protected $fillable = ['template_id','permission_id'];

    public function permissionName(){
        return $this->hasOne(\App\Models\Permission::class,'id','permission_id')->select('id','name');
    }
}
