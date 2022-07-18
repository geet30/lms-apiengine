<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignUser extends Model
{
    use HasFactory;
    protected $table='assigned_users';
    protected $fillable = [
        'source_user_id', 'relational_user_id','created_by','deleted_at'
    ];

    public function affiliateQas()
    {
        return $this->hasOne(\App\Models\User::class,'id', 'source_user_id')->where('role',4);
    }
}
