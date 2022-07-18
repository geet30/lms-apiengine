<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\{LifeSupportRequest};
use App\Models\{LifeSupportCode};

class LifeSupportController extends Controller
{
    /**
     * Assign Codes to Life Support Equipments
     *
     */
    public function store(LifeSupportRequest $request)
    {
        return LifeSupportCode::store($request);
    }

    public function get($provider_id, $life_support_equip_id)
    {
        return LifeSupportCode::get($provider_id, $life_support_equip_id);
    }
}
