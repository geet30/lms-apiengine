<?php

namespace App\Traits\Lead;

use Illuminate\Support\Facades\{View, Storage, DB};
use App\Models\{SaleProductsEnergy, SaleProductsBroadband, SaleProductsMobile};
use Carbon\Carbon;
trait Methods
{
    public static  $service;
    static function updateData ($conditions, $data) {
        self::where($conditions)->update($data);
    }

    static function getProductData ($conditions, $columns, $firstRow=null) {
        $query = DB::table('leads')
        ->join('sale_products_energy', 'leads.lead_id', '=', 'sale_products_energy.lead_id')
        ->join('lead_journey_data_energy', 'leads.lead_id', '=', 'lead_journey_data_energy.lead_id')
        ->select($columns)->where($conditions);
        if ($firstRow) {
            return $query->first();
        }
        return $query->get();
    }

    static function getData ($conditions, $columns) {
        return DB::table('leads')->select($columns)->where($conditions)->get();
    }
	static function getService($serviceId)
	{
		
		$service = 'energy';
		switch ($serviceId) {
			case 1:
				$service = 'energy';
				break;
			case 2:
				$service = 'mobile';
				break;
			case 3:
				$service = 'broadband';
				break;
	
			default:
				# code...
				break;
		}
		return $service;
	}
    static function getJourneyData ($conditions, $columns) {
        return DB::table('lead_journey_data_energy')->select($columns)->where($conditions)->get();
    }
    static function withJoins($serviceId,$query, $withVisitor, $withProduct, $withJourney, $withConnection, $withBillDetails, $withAddress, $withMarketing, $withProvider, $withAffiliate, $withInfo, $withPlan)
	{
		$service = self::getService($serviceId);

		if ($withVisitor) {
			$query = $query->join('visitors', 'leads.visitor_id', '=', 'visitors.id');
		}

		if ($withProduct) {
			$query = $query->leftjoin('sale_products_' . $service, 'leads.lead_id', '=', 'sale_products_' . $service . '.lead_id');
			if ($withProvider) {
				$query = $query->leftjoin('providers', 'sale_products_' . $service.'.provider_id', '=', 'providers.user_id');
			}
			if ($withPlan) {
				$table = 'plans_'.$service;
				if ($service == 'broadband') $table = 'plans_broadbands';
				$query = $query->leftjoin($table, 'sale_products_' . $service.'.plan_id', '=', $table.'.id');
				if (in_array($service, ['broadband','mobile'])) {
					$serviceId = self::getService($serviceId);
					$query = $query->leftjoin('connection_types', $table.'.connection_type', '=', 'connection_types.local_id')->where('connection_types.service_id', $serviceId)->where('connection_types.status', 1)->where('connection_type_id', 1);
				}
				
			}
		}

		if ($withJourney) {
			$query = $query->leftjoin('lead_journey_data_' . $service, 'leads.lead_id', '=', 'lead_journey_data_' . $service . '.lead_id');
		}
		if ($withBillDetails) {
			$query = $query->leftjoin($service . '_bill_details', 'leads.lead_id', '=', $service . '_bill_details.lead_id');
		}

		if ($withConnection && in_array($service, ['energy','mobile'])) {
			$query = $query->leftjoin('sale_product_' . $service . '_connection_details', 'leads.connection_address_id', '=', 'sale_product_' . $service . '_connection_details.id');
		}

		if ($withAddress) {
			$query = $query->leftjoin('visitor_addresses', 'leads.connection_address_id', '=', 'visitor_addresses.id');
		}

		if ($withMarketing) {
			$query = $query->leftjoin('marketing', 'leads.lead_id', '=', 'marketing.lead_id');
		}

		if ($withAffiliate) {
			$query = $query->leftjoin('affiliates', 'leads.affiliate_id', '=', 'affiliates.user_id');
			$query = $query->leftjoin('affiliates as subaff', 'leads.sub_affiliate_id', '=', 'subaff.user_id');
		}

		if ($withInfo) {
			if ($service == 'energy') {
				$query = $query->leftjoin('visitor_informations_energy', 'leads.visitor_info_energy_id', '=', 'visitor_informations_energy.id');
			}
			if ($service != 'energy') {
				$query = $query->leftjoin('visitor_identifications', 'leads.visitor_primary_identifications_id', '=', 'visitor_identifications.id');
				$query = $query->leftjoin('visitor_identifications as secondary_identifications', 'leads.visitor_secondary_identifications_id', '=', 'secondary_identifications.id');
			}
			
		}

		return $query;
	}

    static function getFirstLead($conditions,$serviceId, $columns = '*', $withVisitor = null, $withProduct = null, $withJourney = null, $withConnection = null, $withBillDetails = null, $withAddress = null, $withMarketing = null, $withProvider = null, $withAffiliate = null, $withInfo = null, $withPlan = null)
	{
		$query = DB::table('leads');
		$query = static::withJoins($serviceId,$query, $withVisitor, $withProduct, $withJourney, $withConnection, $withBillDetails, $withAddress, $withMarketing, $withProvider, $withAffiliate, $withInfo, $withPlan);

		return $query->where($conditions)->select($columns)->first();
	}
    static function addReferenceNo($leadId, $products)
    {
        $refNos = [];
        $refNos[1] = static::setReferenceForEnergy($leadId, $products);
        $refNos[2] = static::setReferenceForMobile($leadId, $products);
        $refNos[3] = static::setReferenceForBroadband($leadId, $products);

        return $refNos;
    }
    
    static function setReferenceForEnergy($leadId, $products)
    {
        $energyData = $products->where('service_id', 1)->first();
        if ($energyData) {
            $elecData = $products->where('product_type', 1)->first();
            $gasData = $products->where('product_type', 2)->first();
            $elecProvider = $elecData ? $elecData['provider_id'] : '';
            $gasProvider = $gasData ? $gasData['provider_id'] : '';
            $time = Carbon::now()->timestamp;
            $firstRefNo = $elecData ? $time + $elecData['product_id'] + $elecProvider : null;
            $secondRefNo = $gasData ? $time + $elecData['product_id'] + $gasProvider : null;
            if ($elecData && $gasData && $elecProvider != $gasProvider) {
                $firstRefNo = $time + $elecData['product_id'] + $elecProvider;
                $secondRefNo = $time + $gasData['product_id'] + $gasProvider;
                SaleProductsEnergy::updateData(['lead_id' => $leadId, 'product_type' => 1], ['reference_no' => $firstRefNo]);
                SaleProductsEnergy::updateData(['lead_id' => $leadId, 'product_type' => 2], ['reference_no' => $secondRefNo]);
                return [$firstRefNo, $secondRefNo];
            }

            SaleProductsEnergy::updateData(['lead_id' => $leadId], ['reference_no' => $firstRefNo]);

            return [$firstRefNo, $secondRefNo];
        }

        return null;
    }

    static function setReferenceForMobile($leadId, $products)
    {
        $mobileData = $products->where('service_id', 2)->first();
        if ($mobileData) {
            $time = Carbon::now()->timestamp;
            $refNo = $time + $mobileData['product_id'] + $mobileData['provider_id'];
            SaleProductsMobile::updateData(['lead_id' => $leadId], ['reference_no' => $refNo]);
            return $refNo;
        }
        return null;
    }

    static function setReferenceForBroadband($leadId, $products)
    {
        $broadbandData = $products->where('service_id', 3)->first();
        if ($broadbandData) {
            $time = Carbon::now()->timestamp;
            $refNo = $time + $broadbandData['product_id'] + $broadbandData['provider_id'];
            SaleProductsBroadband::updateData(['lead_id' => $leadId], ['reference_no' => $refNo]);
            return $refNo;
        }
        return null;
    }
}