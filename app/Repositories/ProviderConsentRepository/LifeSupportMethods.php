<?php

namespace App\Repositories\ProviderConsentRepository;

use App\Models\LifeSupportCode;

trait LifeSupportMethods
{

    public static function store($request)
    {
        $data = [
            'provider_id' => $request->provider_id,
            'life_support_equip_id' => $request->life_support_equip_id,
            'code' => $request->code,
        ];
        try {
            $result = self::updateOrCreate(['id' => $request->life_support_code_id], $data);
            $provider_codes = LifeSupportCode::where('id', $result->id)->get();
            return response()->json(['status' => 200, 'message' => trans('providers.lifesupport.success'), 'provider_codes' => $provider_codes]);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public static function get($provider_id, $life_support_equip_id)
    {
        $provider_codes = LifeSupportCode::select('life_support_codes.id', 'life_support_codes.life_support_equip_id', 'life_support_codes.code')
            ->where(['provider_id' => $provider_id, 'life_support_equip_id' => $life_support_equip_id])
            ->get();
        return response()->json(['status' => 200, 'provider_codes' => $provider_codes]);
    }

}
