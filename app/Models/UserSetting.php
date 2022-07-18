<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id', 'date_range_from','date_range_to', 'date_range_checkbox','created_by','deleted_at'
    ];

}
