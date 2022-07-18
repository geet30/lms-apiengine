<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class StatusHierarchy extends Model
{
    use HasFactory;
    public function getStatus()
    {
        return $this->belongsTo('App\Models\Status','assigned_status_id','id');
    }
}