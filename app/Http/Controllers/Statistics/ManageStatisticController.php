<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\{Affiliate, ConnectionStatistic, Providers, Services, UserService, ConversionStatistic, Statistics};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use App\Http\Requests\Statistics\ConversionGraphValidation;

class ManageStatisticController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $services = $user->services;
        $userRole = $user->role ?? '';
        if (!empty($user) && $user->role == 2) {
            $services = UserService::where(['user_id' => $user->id, 'user_type' => 1, 'status' => 1])->with('serviceName')->get();
        } else if (!empty($user) && $user->role == 1) {
            $services = Services::get();
        } else {
            $services = $user->services;
        }
        $serviceId = isset($services[0]['id']) ? $services[0]['id'] : 0;
        $affiliates = $subAffiliates = [];

        if (!in_array($userRole, [2, 3, 8, 9])) {
            $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })->select('id', 'user_id', 'company_name')->where('parent_id', 0)->get();
        } else {
            $affiliateId = Affiliate::where('user_id', $user->id)->select('id')->value('id');
            $subAffiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })->where('parent_id', $affiliateId)->select('id', 'user_id', 'company_name')->get();
        }
        $providers = Providers::whereHas('getProviderServices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->select('id', 'name', 'legal_name', 'user_id')->get();
        return view('pages.statistics.index', compact('services', 'affiliates', 'subAffiliates', 'providers'));
    }

    public function getAffiliateByService(Request $request)
    {
        $serviceId = $request->serviceId;
        $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
            $query->whereIn('service_id', $serviceId);
        })->where('parent_id', 0)->select('id', 'user_id', 'company_name')->get()->toArray();

        $providers = Providers::whereHas('getProviderServices', function ($query) use ($serviceId) {
            $query->whereIn('service_id', $serviceId);
        })->select('id', 'name', 'user_id')->get()->toArray();

        return response()->json(['affiliates' => $affiliates, 'providers' => $providers], 200);
    }

    public function getSubAffiliateList(Request $request)
    {
        $affiliateId = $request->affiliate;
        $serviceId = $request->serviceId;
        $affiliateData = Affiliate::whereIn('user_id', $affiliateId)->select('id', 'user_id', 'company_name')->get()->toArray();
        $affiliateId = array_column($affiliateData, 'id');
        $affiliates = Affiliate::whereHas('getaffiliateservices', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->whereIn('parent_id', $affiliateId)->select('id', 'user_id', 'company_name')->get()->toArray();
        return response()->json(['affiliates' => $affiliates, 'masterAffiliateData' => $affiliateData]);
    }

    public function getData(ConversionGraphValidation $request)
    {
        $startDate     = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
        $fromDate     = Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
        $endDate     = Carbon::createFromFormat('d-m-Y', $request->input('end_date'));
        $tillDate     = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
        $parent_affiliate_id = Affiliate::where('parent_id', 0)->where('user_id', $request->sub_affiliates)->pluck('user_id')->toArray();
        $affiliate_ids = $request->affiliates;
        if (!isset($request->affiliates) || empty($request->affiliates)) {
            $affiliate_ids = Affiliate::whereHas('getaffiliateservices', function ($query) use ($request) {
                $query->where('service_id', $request->serviceId);
            })->where('parent_id', 0)->pluck('user_id')->toArray();
        }
        $provider_ids = $request->providers;
        if (!isset($request->providers) || empty($request->providers)) {
            $provider_ids = Providers::whereHas('getProviderServices', function ($query) use ($request) {
                $query->where('service_id', $request->serviceId);
            })->pluck('user_id')->toArray();
        }

        //Get difference between dates
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $tillDate);
        $diff_in_days = $to->diffInDays($from);

        if ($diff_in_days <= 30) {
            $raw1     = "DATE(created_at) as stats,SUM(counter) AS count";
            $groupby1 = "DATE(created_at)";
            $list     = 'date';
        } else {
            $raw1     = "DATE_FORMAT(created_at,'%m-%Y') as stats,SUM(counter)AS count";
            $groupby1 = "DATE_FORMAT(created_at,'%m-%Y')";
            $list     = 'month';
        }
        $request_data_array['service_id'] = $request->serviceId;
        $request_data_array['affiliate_id'] = $affiliate_ids;
        $request_data_array['provider_id'] = $provider_ids;
        $request_data_array['sub_affiliate_id'] = $request->sub_affiliates;
        $request_data_array['parent_affiliate_id'] = $parent_affiliate_id;
        $request_data_array['retailer_affiliate'] = $request->connection_type_charts_retailer_affiliate;
        $request_data_array['raw'] = $raw1;
        $request_data_array['groupBy'] = $groupby1;
        //New Connection
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 1;
        $newConnection = $this->fetchConnectiondatewise($request_data_array);

        //Port In
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 2;
        $portIn = $this->fetchConnectiondatewise($request_data_array);

        //ReContract
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 3;
        $reContract = $this->fetchConnectiondatewise($request_data_array);

        $modifynewconnection = $this->modifyResult($newConnection, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyportin  = $this->modifyResult($portIn, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyrecontract  = $this->modifyResult($reContract, $list, $request->input('start_date'), $request->input('end_date'));
        $newConnectionData = $portInData = $reContractData = $label = [];
        foreach ($modifynewconnection['data'] as $key => $value) {
            array_push($newConnectionData, $modifynewconnection['data'][$key]['value']);
        }
        foreach ($modifyportin['data'] as $key => $value) {
            array_push($portInData, $modifyportin['data'][$key]['value']);
        }
        foreach ($modifyrecontract['data'] as $key => $value) {
            array_push($reContractData, $modifyrecontract['data'][$key]['value']);
        }
        $label = array_column($modifynewconnection['category'], 'label');
        return response()->json(['status' => true, 'newconnection' => $newConnectionData, 'portin' => $portInData, 'recontract' => $reContractData, 'label' => $label, 'no_of_days' => $diff_in_days], 200);
    }

    public function fetchConnectiondatewise($send_data_array = array())
    {
        $response = [];
        $data = ConnectionStatistic::selectRaw($send_data_array['raw'])
            ->where('service_id', $send_data_array['service_id'])
            ->where('connection_type', $send_data_array['type'])
            ->whereRaw(DB::raw($send_data_array['between']))
            ->groupBy(DB::raw($send_data_array['groupBy']));
        if ($send_data_array['retailer_affiliate'] == '1') {
            $data->whereIn('affiliate_id', $send_data_array['affiliate_id']);
        } else if ($send_data_array['retailer_affiliate'] == '2') {
            $data->whereIn('provider_id', $send_data_array['provider_id']);
        }
        if (isset($send_data_array['sub_affiliate_id'])) {
            $data->where(function ($query) use ($send_data_array) {
                $query->where(function ($query) use ($send_data_array) {
                    return $query->where('affiliate_id', $send_data_array['parent_affiliate_id'])->whereNull('sub_affiliate_id');
                })
                    ->orWhere(function ($query) use ($send_data_array) {
                        return $query->whereIn('sub_affiliate_id', $send_data_array['sub_affiliate_id']);
                    });
            });
        }
        $response = $data->get()->toArray();
        return $response;
    }
    public function getComparisonGraphData(ConversionGraphValidation $request)
    {
        $startDate     = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
        $fromDate     = Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
        $endDate     = Carbon::createFromFormat('d-m-Y', $request->input('end_date'));
        $tillDate     = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
        $comparison_stat_type = $request->input('type');

        $parent_affiliate_id = Affiliate::where('parent_id', 0)->where('user_id', $request->sub_affiliates)->pluck('user_id')->toArray();
        $affiliate_ids = $request->affiliates;
        if (!isset($request->affiliates) || empty($request->affiliates)) {
            $affiliate_ids = Affiliate::whereHas('getaffiliateservices', function ($query) use ($request) {
                $query->where('service_id', $request->serviceId);
            })->where('parent_id', 0)->pluck('user_id')->toArray();
        }
        $provider_ids = $request->providers;
        if (!isset($request->providers) || empty($request->providers)) {
            $provider_ids = Providers::whereHas('getProviderServices', function ($query) use ($request) {
                $query->where('service_id', $request->serviceId);
            })->pluck('user_id')->toArray();
        }

        //Get difference between dates
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $tillDate);
        $diff_in_days = $to->diffInDays($from);

        if ($diff_in_days <= 30) {
            $raw1     = "DATE(created_at) as stats,SUM(counter) AS count";
            $groupby1 = "DATE(created_at)";
            $list     = 'date';
        } else {
            $raw1     = "DATE_FORMAT(created_at,'%m-%Y') as stats,SUM(counter)AS count";
            $groupby1 = "DATE_FORMAT(created_at,'%m-%Y')";
            $list     = 'month';
        }
        $request_data_array['service_id'] = $request->serviceId;
        $request_data_array['affiliate_id'] = $affiliate_ids;
        $request_data_array['provider_id'] = $provider_ids;
        $request_data_array['sub_affiliate_id'] = $request->sub_affiliates;
        $request_data_array['parent_affiliate_id'] = $parent_affiliate_id;
        $request_data_array['retailer_affiliate'] = $request->affiliate_provider_chart_retailer_affiliate;
        $request_data_array['raw'] = $raw1;
        $request_data_array['groupBy'] = $groupby1;
        //Visits
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 1;
        $visits = $this->fetchComparisondatewise($request_data_array);

        //Leads
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 2;
        $leads = $this->fetchComparisondatewise($request_data_array);

        //Unique Leads
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 4;
        $uniqueLeads = $this->fetchComparisondatewise($request_data_array);

        //Net sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 3;
        $netSales = $this->fetchComparisondatewise($request_data_array);

        //Gross Sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['type'] = 5;
        $grossSales = $this->fetchComparisondatewise($request_data_array);

        $modifyvisits = $this->modifyResult($visits, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyleads  = $this->modifyResult($leads, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyuniqueleads  = $this->modifyResult($uniqueLeads, $list, $request->input('start_date'), $request->input('end_date'));
        $modifynetsales  = $this->modifyResult($netSales, $list, $request->input('start_date'), $request->input('end_date'));
        $modifygrosssales  = $this->modifyResult($grossSales, $list, $request->input('start_date'), $request->input('end_date'));
        $visits = $leads = $sales = [];
        $leadType = 'Leads';
        $saleType = 'Net Sales';
        $comparisonType = 'Visits, Leads, Net Sales';
        foreach ($modifyvisits['data'] as $key => $value) {
            array_push($visits, $modifyvisits['data'][$key]['value']);
        }
        $label = array_column($modifyvisits['category'], 'label');
        if ($comparison_stat_type == '1') {
            foreach ($modifyleads['data'] as $key => $value) {
                array_push($leads, $modifyleads['data'][$key]['value']);
            }
            foreach ($modifynetsales['data'] as $key => $value) {
                array_push($sales, $modifynetsales['data'][$key]['value']);
            }
            $leadType = 'Leads';
            $saleType = 'Net Sales';
            $comparisonType = 'Visits, Leads, Net Sales';
        } else if ($comparison_stat_type == '2') {
            foreach ($modifyleads['data'] as $key => $value) {
                array_push($leads, $modifyleads['data'][$key]['value']);
            }
            foreach ($modifygrosssales['data'] as $key => $value) {
                array_push($sales, $modifygrosssales['data'][$key]['value']);
            }
            $leadType = 'Leads';
            $saleType = 'Gross Sales';
            $comparisonType = 'Visits, Leads, Gross Sales';
        } else if ($comparison_stat_type == '3') {
            foreach ($modifyuniqueleads['data'] as $key => $value) {
                array_push($leads, $modifyuniqueleads['data'][$key]['value']);
            }
            foreach ($modifynetsales['data'] as $key => $value) {
                array_push($sales, $modifynetsales['data'][$key]['value']);
            }
            $leadType = 'Unique Leads';
            $saleType = 'Net Sales';
            $comparisonType = 'Visits, Unique Leads, Net Sales';
        } else if ($comparison_stat_type == '4') {
            foreach ($modifyuniqueleads['data'] as $key => $value) {
                array_push($leads, $modifyuniqueleads['data'][$key]['value']);
            }
            foreach ($modifygrosssales['data'] as $key => $value) {
                array_push($sales, $modifygrosssales['data'][$key]['value']);
            }
            $leadType = 'Unique Leads';
            $saleType = 'Gross Sales';
            $comparisonType = 'Visits, Unique Leads, Gross Sales';
        }
        return response()->json(['status' => true, 'visits' => $visits, 'leads' => $leads, 'sales' => $sales, 'label' => $label, 'no_of_days' => $diff_in_days, 'leadType' => $leadType, 'saleType' => $saleType,'comparisonType' => $comparisonType], 200);

    }

    public function fetchComparisondatewise($send_data_array = array())
    {
        $response = [];
        $data = Statistics::selectRaw($send_data_array['raw'])->where('type', $send_data_array['type']);
        $data->whereIn('service_id', $send_data_array['service_id'])
            ->whereRaw(DB::raw($send_data_array['between']))
            ->groupBy(DB::raw($send_data_array['groupBy']));
        if ($send_data_array['retailer_affiliate'] == '1') {
            $data->whereIn('affiliate_id', $send_data_array['affiliate_id']);
        } else if ($send_data_array['retailer_affiliate'] == '2') {
            $data->whereIn('provider_id', $send_data_array['provider_id']);
        }
        if (isset($send_data_array['sub_affiliate_id'])) {
            $data->where(function ($query) use ($send_data_array) {
                $query->where(function ($query) use ($send_data_array) {
                    return $query->where('affiliate_id', $send_data_array['parent_affiliate_id'])->whereNull('sub_affiliate_id');
                })
                    ->orWhere(function ($query) use ($send_data_array) {
                        return $query->whereIn('sub_affiliate_id', $send_data_array['sub_affiliate_id']);
                    });
            });
        }
        $response = $data->get()->toArray();
        return $response;
    }

    public function getTopWorstPlans(Request $request)
    {
        try {
            return Statistics::getTopWorstPlans($request);
        } catch (\Exception $err) {
            return response()->json(['status' => 400, 'message' => $err->getMessage()]);
        }
    }

    public function getConversionGraphData(ConversionGraphValidation $request)
    {
        $startDate     = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
        $fromDate     = Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s');
        $endDate     = Carbon::createFromFormat('d-m-Y', $request->input('end_date'));
        $tillDate     = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');
        $conversion_stat_type = $request->input('type');

        $parent_affiliate_id = Affiliate::where('parent_id', 0)->where('user_id', $request->sub_affiliates)->pluck('user_id')->toArray();

        $affiliate_ids = $request->affiliates;
        if (!isset($request->affiliates) || empty($request->affiliates)) {
            $affiliate_ids = Affiliate::whereHas('getaffiliateservices', function ($query) use ($request) {
                $query->whereIn('service_id', $request->serviceId);
            })->where('parent_id', 0)->pluck('user_id')->toArray();
        }

        $provider_ids = $request->provider_id;
        if (!isset($request->provider_id) || empty($request->provider_id)) {
            $provider_ids = Providers::whereHas('getProviderServices', function ($query) use ($request) {
                $query->where('service_id', $request->serviceId);
            })->pluck('user_id')->toArray();
        }

        $sub_affiliate_ids = $request->sub_affiliates;

        //Get difference between dates
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $tillDate);
        $diff_in_days = $to->diffInDays($from);

        if ($diff_in_days <= 30) {
            $raw1     = "DATE(created_at) as stats,SUM(counter) AS count";
            $groupby1 = "DATE(created_at)";
            $list     = 'date';
        } else {
            $raw1     = "DATE_FORMAT(created_at,'%m-%Y') as stats,SUM(counter)AS count";
            $groupby1 = "DATE_FORMAT(created_at,'%m-%Y')";
            $list     = 'month';
        }
        $request_data_array['service_id'] = $request->serviceId;
        $request_data_array['affiliate_id'] = $affiliate_ids;
        $request_data_array['provider_ids'] = $provider_ids;
        $request_data_array['sub_affiliate_id'] = $sub_affiliate_ids;
        $request_data_array['parent_affiliate_id'] = $parent_affiliate_id;
        $request_data_array['retailer_affiliate'] = $request->conversions_chart_retailer_affiliate;
        $request_data_array['raw'] = $raw1;
        $request_data_array['groupBy'] = $groupby1;

        //visits
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-visits';
        $request_data_array['type'] = 1;
        $visits = $this->fetchAffiliatesdatewise($request_data_array);
        $visitsNo = array_sum(array_column($visits, 'count'));

        //leads
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-leads';
        $request_data_array['type'] = 2;
        $leads = $this->fetchAffiliatesdatewise($request_data_array);
        $leadsNo = array_sum(array_column($leads, 'count'));

        //unique leads
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-unique-leads';
        $request_data_array['type'] = 3;
        $uniqueLeads = $this->fetchAffiliatesdatewise($request_data_array);
        $uniqueLeadsNo = array_sum(array_column($uniqueLeads, 'count'));

        //net sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-net-sales';
        $request_data_array['type'] = 4;
        $netSales = $this->fetchAffiliatesdatewise($request_data_array);
        $netSalesNo = array_sum(array_column($netSales, 'count'));

        //gross sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-gross-sales';
        $request_data_array['type'] = 5;
        $grossSales = $this->fetchAffiliatesdatewise($request_data_array);
        $grossSalesNo = array_sum(array_column($grossSales, 'count'));

        //unique net sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-unique-net-sales';
        $request_data_array['type'] = 6;
        $uniqueNetSales = $this->fetchAffiliatesdatewise($request_data_array);
        $uniqueNetSalesNo = array_sum(array_column($uniqueNetSales, 'count'));

        //unique gross sales
        $request_data_array['between'] = "(CONVERT(created_at,date) between '" . $fromDate . "' AND '" . $tillDate . "')";
        $request_data_array['stats'] = 'total-unique-gross-sales';
        $request_data_array['type'] = 7;
        $uniqueGrossSales = $this->fetchAffiliatesdatewise($request_data_array);
        $uniqueGrossSalesNo = array_sum(array_column($uniqueGrossSales, 'count'));

        $data = $result = [];
        $result['visitToLeadConversion'] = '0.00%';
        if ($visitsNo != 0) {
            $percent = $leadsNo / $visitsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['visitToLeadConversion'] = $percent_friendly;
        }

        $result['visitToGrossSaleConversion'] = '0.00%';
        if ($leadsNo != 0) {
            $percent = $grossSalesNo / $visitsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['visitToGrossSaleConversion'] = $percent_friendly;
        }

        $result['visitToNetSaleConversion'] = '0.00%';
        if ($visitsNo != 0) {
            $percent = $netSalesNo / $visitsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['visitToNetSaleConversion'] = $percent_friendly;
        }

        $result['leadToGrossSaleConversion'] = '0.00%';
        if ($leadsNo != 0) {
            $percent = $grossSalesNo / $leadsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['leadToGrossSaleConversion'] = $percent_friendly;
        }

        $result['leadToNetSaleConversion'] = '0.00%';
        if ($leadsNo != 0) {
            $percent = $netSalesNo / $leadsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['leadToNetSaleConversion'] = $percent_friendly;
        }

        $result['uniqueLeadToGrossSaleConversion'] = '0.00%';
        if ($uniqueLeadsNo != 0) {
            $percent = $uniqueGrossSalesNo / $uniqueLeadsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['uniqueLeadToGrossSaleConversion'] = $percent_friendly;
        }

        $result['uniqueLeadToNetSaleConversion'] = '0.00%';
        if ($uniqueLeadsNo != 0) {
            $percent = $uniqueNetSalesNo / $uniqueLeadsNo;
            $percent_friendly = number_format($percent * 100, 2) . '%';
            $result['uniqueLeadToNetSaleConversion'] = $percent_friendly;
        }


        $modifyvisits = $this->modifyResult($visits, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyleads  = $this->modifyResult($leads, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyuniqueLeads  = $this->modifyResult($uniqueLeads, $list, $request->input('start_date'), $request->input('end_date'));
        $modifynetSales = $this->modifyResult($netSales, $list, $request->input('start_date'), $request->input('end_date'));
        $modifygrossSales = $this->modifyResult($grossSales, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyuniquegrossSales = $this->modifyResult($uniqueGrossSales, $list, $request->input('start_date'), $request->input('end_date'));
        $modifyuniqueNetSales = $this->modifyResult($uniqueNetSales, $list, $request->input('start_date'), $request->input('end_date'));

        if ($conversion_stat_type == '1') {
            foreach ($modifyleads['data'] as $key => $value) {
                if ($modifyvisits['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifyleads['data'][$key]['value'] / $modifyvisits['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '2') {
            foreach ($modifyleads['data'] as $key => $value) {
                if ($modifyvisits['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifygrossSales['data'][$key]['value'] / $modifyvisits['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '3') {
            foreach ($modifyleads['data'] as $key => $value) {
                if ($modifyvisits['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifynetSales['data'][$key]['value'] / $modifyvisits['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '4') {
            foreach ($modifyleads['data'] as $key => $value) {
                if ($modifyleads['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifygrossSales['data'][$key]['value'] / $modifyleads['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '5') {
            foreach ($modifyleads['data'] as $key => $value) {
                if ($modifyleads['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifynetSales['data'][$key]['value'] / $modifyleads['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '6') {
            foreach ($modifyuniqueLeads['data'] as $key => $value) {
                if ($modifyuniqueLeads['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifyuniquegrossSales['data'][$key]['value'] / $modifyuniqueLeads['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        } else if ($conversion_stat_type == '7') {
            foreach ($modifyuniqueLeads['data'] as $key => $value) {
                if ($modifyuniqueLeads['data'][$key]['value'] == 0) {
                    array_push($data, '0');
                } else {
                    $percent = $modifyuniqueNetSales['data'][$key]['value'] / $modifyuniqueLeads['data'][$key]['value'];
                    $percent_friendly = round($percent * 100);
                    array_push($data, $percent_friendly);
                }
            }
            $result['category'] = array_column($modifyleads['category'], 'label');
            $result['data']     = $data;
        }
        $result['no_of_days'] = $diff_in_days;
        return response()->json($result, 200);
    }

    public function fetchAffiliatesdatewise($send_data_array = array())
    {
        $response = [];
        $data = ConversionStatistic::selectRaw($send_data_array['raw'])->where('type', $send_data_array['type']);
        $data->whereIn('service_id', $send_data_array['service_id'])
            ->whereRaw(DB::raw($send_data_array['between']))
            ->groupBy(DB::raw($send_data_array['groupBy']));
        if ($send_data_array['retailer_affiliate'] == '1') {
            $data->whereIn('affiliate_id', $send_data_array['affiliate_id']);
        } else if ($send_data_array['retailer_affiliate'] == '2') {
            $data->whereIn('provider_id', $send_data_array['provider_ids']);
        }
        if (isset($send_data_array['sub_affiliate_id'])) {
            $data->where(function ($query) use ($send_data_array) {
                $query->where(function ($query) use ($send_data_array) {
                    return $query->where('affiliate_id', $send_data_array['parent_affiliate_id'])->whereNull('sub_affiliate_id');
                })
                    ->orWhere(function ($query) use ($send_data_array) {
                        return $query->whereIn('sub_affiliate_id', $send_data_array['sub_affiliate_id'])->where('type', $send_data_array['type']);
                    });
            });
        }

        $response = $data->get()->toArray();
        return $response;
    }

    public function modifyResult($result = array(), $list, $from, $to)
    {
        try {

            $category = [];
            $data = [];
            $month = [];
            if ($list == 'date') {
                $static_data = [];
                $period = CarbonPeriod::create($from, $to);
                foreach ($period as $date) {
                    array_push($static_data, [
                        'stats' => $date->format('Y-m-d'),
                        'count' => 0
                    ]);
                }

                $merge_data = array_merge($result, $static_data);
                $temp = array_unique(array_column($merge_data, 'stats'));
                $unique_arr = array_intersect_key($merge_data, $temp);
                $columns = array_column($unique_arr, "stats");
                array_multisort($columns, SORT_ASC, $unique_arr);
                //Set data for graph
                foreach ($unique_arr as $key => $value) {
                    array_push($category, [
                        'label' => date('jS-M', strtotime($value['stats']))
                    ]);

                    array_push($data, [
                        'value' => $value['count']
                    ]);
                }
            } else {
                $static_data = [];
                $period = CarbonPeriod::create($from, '1 month', $to);
                foreach ($period as $date) {
                    array_push($static_data, [
                        'stats' => $date->format('m-Y'),
                        'count' => 0
                    ]);
                }

                $merge_data = array_merge($result, $static_data);
                $temp = array_unique(array_column($merge_data, 'stats'));
                $unique_arr = array_intersect_key($merge_data, $temp);
                $columns = array_column($unique_arr, "stats");
                array_multisort($columns, SORT_ASC, $unique_arr);

                //Sort data year and month wise
                foreach ($unique_arr as $key => $value) {
                    array_push($month, [
                        'date' => date('d-' . $value['stats']),
                        'value' => $value['count']
                    ]);

                    $sort[$key] = strtotime(date('d-' . $value['stats']));
                }

                array_multisort($sort, SORT_ASC, $unique_arr);
                //Set data for graph
                foreach ($unique_arr as $key => $value) {
                    $old = date('d-' . $value['stats']);
                    array_push($category, [
                        'label' => date('M-Y', strtotime($old))
                    ]);

                    array_push($data, [
                        'value' => $value['count']
                    ]);
                }
            }

            return array('category' => $category, 'data' => $data);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error_message' => $e->getMessage()], 422);
        }
    }
}
