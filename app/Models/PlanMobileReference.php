<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanMobileReference extends Model
{
    use HasFactory;
    protected $table ='plan_mobile_references';
    // protected $fillable = [];
    protected $guarded = ['id']; 

    public function getIdAttribute($value)
    {
        return encryptGdprData($value);
    }
}
