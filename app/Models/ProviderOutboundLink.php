<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderOutboundLink extends Model
{
    use HasFactory;
    protected $table = 'provider_outbound_links';

    protected $fillable = ['user_id','order','link_title','link_url','deleted_at'];
}
