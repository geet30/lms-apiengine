<?php

namespace App\Repositories\Affiliate;

use App\Models\{
    Providers,
    AffiliateRetension,
    AssignedUsers,
    Affiliate
};
use DB;

trait ManageRetention
{
    public static function getProviderSubaff($requestArr)
    {
        $parentId = $requestArr->parent_id;

        $providerPrimaryID = decryptGdprData($requestArr->provider_primary_id);
        $providerUserId = decryptGdprData($requestArr->provider_id);
        $retensionArr['resale_status'] = Providers::where('id', $providerPrimaryID)->select('id', 'user_id')->with([
            'getPermissions' => function ($query) {
                $query->select('is_retention', 'user_id');
            },
        ])->first();

        $retensionArr['edit_providerLink'] = theme()->getPageUrl('provider/edit/' . encryptGdprData($providerUserId) . '/' . encryptGdprData($requestArr->service_id)) . '?' . $requestArr->currentMod . '&permissiontab=active';
        $affuserId = decryptGdprData($requestArr->user_id);
        $retensionArr['retention_data'] = self::getretensionByProviderID($providerPrimaryID, $affuserId);
        //subaffilaite get according to its provider 
        $subaffIds =  AssignedUsers::getSubaffByParentId($parentId);

        if (count($subaffIds) > 0) {
            $assingedSubAffIds = AssignedUsers::where('relation_type', 4)->where('service_id', $requestArr->service_id)->where('relational_user_id', $providerUserId)
                ->pluck('source_user_id')->toArray();

            $subAffArr = Affiliate::where('parent_id', $parentId)->whereIn('user_id', $assingedSubAffIds)->select('company_name', 'user_id')
                ->with(
                    [
                        'getaffRetension' => function ($query) use ($providerPrimaryID) {
                            $query->where('type', 2)->where('provider_id', $providerPrimaryID);
                        },
                    ]
                )->get()->toArray();

            $data = [];
            foreach ($subAffArr as   $value) {
                array_push($data, [
                    'company_name' => $value['company_name'],
                    'user_id' => encryptGdprData($value['user_id']),
                    'sub_retension_allow' => $value['getaff_retension']
                ]);
            }
            $retensionArr['sub_affilaites'] = $data;
        }

        return $retensionArr;
    }
    static function saveRetenstiondata($requestArr)
    {

        if ($requestArr) {
            $msg = trans('affiliates.retention.retention_success_updated');
            $overrideRetention = 0;
            $masterRentionAllow = 0;
            $RentionAllow = 0;
            if ($requestArr->override_provider_retention) {
                $overrideRetention = 1;
            }
            if ($requestArr->master_retention_allow) {
                $masterRentionAllow = 1;
            }
            if ($requestArr->retention_allow) {
                $RentionAllow = 1;
            }
            $userId = decryptGdprData($requestArr->user_id);
            $providerPrimaryId = decryptGdprData($requestArr->provider_primary_id);
            $recordArr = [
                'user_id' => $userId,
                'service_id' => $requestArr->service_id,
                'provider_id' => $providerPrimaryId,
                'master_retention_allow' => $masterRentionAllow,
                'override_provider_retention' => $overrideRetention,
                'retention_allow' => $RentionAllow,
                'type' => 1
            ];
            $providerData = self::getretensionByProviderID($providerPrimaryId, $userId);
            if ($providerData) {
                $query = AffiliateRetension::where('provider_id', $providerPrimaryId)->where('user_id', $userId)->where('type', 1);
                $result = $query->update($recordArr);
            } else {
                $result = AffiliateRetension::Create($recordArr);
            }
            //subaffiliates
            if ($requestArr->subaffiliates) {
                foreach ($requestArr->subaffiliates as $key => $value) {
                    $providerSubData = self::getretensionByProviderID($providerPrimaryId, decryptGdprData($key));
                    $recordArray = [
                        'user_id' => decryptGdprData($key),
                        'service_id' => $requestArr->service_id,
                        'provider_id' => $providerPrimaryId,
                        'master_retention_allow' => $masterRentionAllow,
                        'retention_allow' => $value,
                        'type' => 2

                    ];
                    if ($providerSubData) {
                        $query = AffiliateRetension::where('provider_id', $providerPrimaryId)->where('user_id', decryptGdprData($key))->where('type', 2);;
                        $query->update($recordArray);
                    } else {
                        AffiliateRetension::Create($recordArray);
                    }
                }
            }

            // if affiliate target record save saved then return response.
            return ['status' => true, 'message' => $msg];
        }
    }

    public static function getretensionByProviderID($providerId, $userId)
    {

        return AffiliateRetension::select('retention_allow', 'override_provider_retention', 'master_retention_allow', 'provider_id')->where('provider_id', $providerId)->where('user_id', $userId)->first();
    }
}
