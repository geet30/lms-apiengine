<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Usagelimits\{BasicCrudMethods, Accessor};

class Suburbusagelimits extends Model
{
    use BasicCrudMethods, Accessor;
    protected $table = 'suburb_usage_limits';
    protected $fillable = ['state','elec_low_range','elec_medium_range','elec_high_range','gas_low_range','gas_medium_range','gas_high_range'];

    public function postcodes()
    {
        return $this->hasMany('App\Models\Postcodelimits','suburb_usage_limit_id','id');
    }
}
