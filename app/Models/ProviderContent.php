<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ProviderConsentRepository\{Relationship, Accessor, Mutators};

class ProviderContent extends Model
{
    use HasFactory, Relationship, Accessor, Mutators;

    protected $table = 'provider_contents';
    protected $fillable = ['provider_id', 'state_id', 'title', 'status', 'type', 'description', 'e_billing_preference_option', 'show_plan_on', 'why_us', 'service_type'];

    public function providerContentCheckbox()
    {
        return $this->hasMany('App\Models\ProviderContentCheckbox', 'provider_content_id', 'id');
    }
}
