<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcodelimits extends Model
{
    use HasFactory;
    protected $table = 'postcode_limits';
    protected $fillable = ['usage_type','suburb_usage_limit_id','post_code'];

    public function usagelimits()
    {
        return $this->belongsTo(Suburbusagelimits::class,'suburb_usage_limit_id','id');
    }
}
