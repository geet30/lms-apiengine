<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiResponse extends Model
{
    protected $fillable = ['lead_id','service_id','api_name','api_reference','response_text','api_response','api_request','s3_url','phone','message','header_data'];
}
