<?php

namespace App\Repositories\Statistics\TopWorstPlans;

use App\Models\Affiliate;
use App\Models\Statistics;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait BasicCrud
{
	public static function getTopWorstPlans($request)
	{
		try {
			$parent_affiliate_id = Affiliate::where('parent_id', 0)->where('user_id',$request->sub_affiliate_ids)->pluck('user_id')->toArray();
			if(!empty($request->start_date) && !empty($request->end_date)){
				$startDate = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
				$fromDate = Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
				$endDate = Carbon::createFromFormat('d-m-Y', $request->input('end_date'));
				$tillDate = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
			}
			$query = self::selectRaw("plan_id,counter,plans_mobile.name as plan_name, plans_mobile.cost as plan_cost, providers.legal_name as provider_name")
                    ->leftJoin("plans_mobile", "plans_mobile.id", "=", "statistics.plan_id")
                    ->leftJoin("providers", "providers.user_id", "=", "statistics.provider_id")
                    ->where("type", Statistics::TYPE_NET_SALES)
					->where('statistics.service_id', $request->service_id)
                    ->whereNotNull('statistics.plan_id');

			if(!empty($request->start_date) && !empty($request->end_date))
			{ 
				$query->whereBetween("statistics.created_at", [$fromDate, $tillDate]);
			}
			if(!empty($request->affiliate_ids))
			{ 
				$query->whereIn('statistics.affiliate_id', $request->affiliate_ids);
			}
			if(!empty($request->sub_affiliate_ids))
			{ 
				$query->where(function ($query) use($request, $parent_affiliate_id){
					$query->where(function ($query) use($parent_affiliate_id) {
						return $query->where('statistics.affiliate_id',$parent_affiliate_id)->whereNull('statistics.sub_affiliate_id');
					})
					->orWhere(function ($query) use($request) {
						return $query->whereIn('statistics.sub_affiliate_id', $request->sub_affiliate_ids);
					});
				});
			}
			if(!empty($request->provider_ids))
			{ 
				$query->whereIn('statistics.provider_id', $request->provider_ids);
			}

			$final_query = clone $query;
		
			$response['topplans'] = $query->orderBy('counter', 'DESC')
				->limit(5)
				->get()->toArray();

			$response['worstplans'] = $final_query->orderBy('counter', 'ASC')
				->limit(5)
				->get()->toArray();
			
			return $response;


		} catch (\Exception $err) {
			throw $err;
		}
	}
}
