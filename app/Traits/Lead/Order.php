<?php

namespace App\Traits\Lead;

use Illuminate\Support\Facades\{Auth, DB};
use App\Models\{Lead,  Providers};

/**
 * Lead Order model.
 * Author: Sandeep Bangarh
 */

trait Order
{
    /**
     * Get Products.
     * Author: Sandeep Bangarh
     */
    static function getLeadProducts($verticals, $leadId, $withProvider = null, $withPlan = null, $beautifyResponse = null, $withAddon = null)
    {
        $query = Lead::select(['lead_id', 'status', 'visitor_id']);
        $data = ['providerColumns' => $withProvider, 'planColumns' => $withPlan];
        foreach ($verticals as $relation  => $columns) {
           
            $data['columns'] = $columns;
            $data['relation'] = $relation;
            $data['withAddon'] = $withAddon;
            
            $query = $query->with($relation, function ($query) use ($data) {
            
                $query->whereNotNull('plan_id')->where('plan_id', '!=', '');
                $query->select($data['columns']);
               
                if ($data['providerColumns']) {
                   
                    $query->with(['provider' => function ($qu) use ($data) {
                        foreach($data['providerColumns'] as $key => $column) {
                            $providerModel = new Providers;
                            if ($column != 'id' && !in_array($column, $providerModel->getFillable())) {
                                unset($data['providerColumns'][$key]);
                            }
                        }
                        $qu->select($data['providerColumns']);
                    }]);
                }
                
                if ($data['withAddon'] && $data['relation'] == 'broadband') {
                    $query = static::broadbandRelations($query);
                }

                if ($data['relation'] == 'mobile') {
                    $query = static::mobileRelations($query);
                }
             

                if ($data['planColumns']) {
                  
                    $query->with(['plan' . ucfirst($data['relation']) => function ($qu) use ($data) {
                        
                        $model = self::getModel($data['relation']);
                        $planModel = new $model;
                        foreach($data['planColumns'] as $key => $column) {
                            if ($column != 'id' && !in_array($column, $planModel->getFillable())) {
                                unset($data['planColumns'][$key]);
                            }
                        }
                        $qu->select($data['planColumns']);
                    }]);
                
                   
                }
            });
        }

        $all = $query->find($leadId);
     
    
        if ($all && $beautifyResponse) {
            $finalData = [];
            foreach (array_keys($verticals) as $vertical) {
                if (!$all->{$vertical}->isEmpty()) {
                    $verticalArray = $all->{$vertical}->toArray();
                    if ($withAddon && $withPlan && $vertical == 'broadband') {
                        foreach ($verticalArray as $vertKey => $verticalData) {
                            foreach ($verticalData['addons'] as $addonKey => $addon) {
                                $addon = static::getAddonItemByCategory($addon);
                                $addon = static::costType($addon);
                                $verticalData['addons'][$addonKey] = $addon;
                            }
                            $verticalArray[$vertKey] = $verticalData;
                        }
                    }
                    if ($vertical == 'mobile') {
                        $verticalArray = static::unsetMobileData($verticalArray);
                    } else {
                        foreach ($verticalArray as $vertKey => $verticalData) {
                            $verticalArray[$vertKey] = static::unsetData($verticalArray[$vertKey]);
                        }
                    }

                    $finalData = array_merge($finalData, $verticalArray);
                }
            }
            return $finalData;
        }

        return $all;
    }

    static function getModel ($relation) {
      
        switch ($relation) {
            case 'energy':
                $model = '\App\Models\PlanEnergy';
                break;
            case 'mobile':
                $model = '\App\Models\PlanMobile';
                break;
            case 'broadband':
                $model = '\App\Models\PlanBroadband';
                break;
            
            default:
                $model = null;
                break;
        }
        return $model;
    }

    static function unsetMobileData($verticalArray)
    {
        foreach ($verticalArray as $vertKey => $verticalData) {
            unset($verticalArray[$vertKey]['handset']['id']);
            unset($verticalArray[$vertKey]['variant']['id']);
            unset($verticalArray[$vertKey]['contract']['id']);
            unset($verticalArray[$vertKey]['color']['id']);
            unset($verticalArray[$vertKey]['plan_mobile']['id']);
            unset($verticalArray[$vertKey]['variant']['capacity_id']);
            unset($verticalArray[$vertKey]['variant']['internal_stroage_id']);
            unset($verticalArray[$vertKey]['variant']['capacity']['id']);
            unset($verticalArray[$vertKey]['variant']['internal']['id']);
            unset($verticalArray[$vertKey]['variant']['color_id']);
            unset($verticalArray[$vertKey]['variant']['color']['id']);

            $verticalArray[$vertKey] = static::unsetData($verticalArray[$vertKey]);
        }
        return $verticalArray;
    }

    static function unsetData($verticalArray)
    {
        unset($verticalArray['id']);
        // unset($verticalArray['plan_id']);
        // unset($verticalArray['handset_id']);
        // unset($verticalArray['variant_id']);
        // unset($verticalArray['contract_id']);
        return $verticalArray;
    }

    static function mobileRelations($query)
    {

      
        $query->with(
            [
                'handset' => function ($query) {
                    $query->select('id', 'name','image');
                },
                'variant' => function ($query) {
                    $query->select('id', 'variant_name', 'capacity_id', 'internal_stroage_id', 'color_id');
                },
                'contract' => function ($query) {
                    $query->select('id', 'contract_name','validity');
                },
                'variant.capacity' => function ($query) {
                    $query->select('id','value','unit');
                },
                'variant.internal' => function ($query) {
                    $query->select('id','value','unit');
                },
                'variant.color' => function ($query) {
                    $query->select('id', 'title');
                }
            ]
        );
        return $query;
    }

    static function broadbandRelations($query)
    {
        $query->with(
            [
                'addons.homeConnection' => function ($query) {
                    $query->select('id', 'call_plan_name as name');
                },
                'addons.broadBandModem' => function ($query) {
                    $query->select('id', 'modem_modal_name as name');
                },
                'addons.broadBandOtherAddon' => function ($query) {
                    $query->select('id', 'addon_name as name');
                },
                'addons.cost_type' => function ($query) {
                    $query->select('id', 'cost_name', 'cost_period');
                }
            ]
        );

        return $query;
    }







}
