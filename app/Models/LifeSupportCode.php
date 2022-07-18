<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\ProviderConsentRepository\{LifeSupportMethods};

class LifeSupportCode extends Model
{
    use LifeSupportMethods;

    protected $fillable = ['life_support_equip_id', 'provider_id', 'code'];
}
