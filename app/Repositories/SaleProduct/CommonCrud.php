<?php
namespace App\Repositories\SaleProduct;
use App\Models\{SaleStatusHistoryEnergy, SaleStatusHistoryMobile, SaleStatusHistoryBroadband,SaleProductsEnergy};
use Illuminate\Support\Facades\DB;
use App\Repositories\Lead\SaleSubmissions\EA\EASaleSubmissionRepo;
use App\Repositories\Lead\SaleSubmissions\Ovo\OvoRepository;
use App\Repositories\Lead\SaleSubmissions\Powershop\FluxRepository;
use App\Repositories\Lead\SaleSubmissions\AglAndPower\AP;
use App\Repositories\Lead\SaleSubmissions\origin\originSubmission;
use App\Repositories\Lead\SaleSubmissions\RedAndLumo\RLSaleSubmission;
use Carbon\Carbon;

trait CommonCrud
{
	public static function saleProduct($id)
	{
		try {
            return self::where('id',$id)->with('statusHierarchies')->first();
		} catch (\Exception $err) {
			throw $err;
		}
	}public static function saleEnergyProduct($id,$type)
	{
		try {
            return self::where('id',$id)->where('product_type',$type)->with('statusHierarchies')->first();
		} catch (\Exception $err) {
			throw $err;
		}
	}

    public static function updateStats($request)
    {
        try {
            $saleProductId = decryptGdprData($request->saleProductId);
            $saleProductType = $request->saleProductType;
            $leadId = decryptGdprData($request->lead_id);
            $status_arr = [0, 5, 3, 2];
            $response = [];
            if ($request->status == 8) {
				//mar this lead as net sale.
				$lead['sale_com_type'] = 2;
				$lead['commission_status'] = 1;
				$lead['sale_status'] = 8;
			}
			// in case of affiliate payable
			elseif ($request->status == 10) {
				$lead['commission_status'] = 1;
				$lead['sale_status'] = 8;
			}
			// if request has affiliate paid
			elseif ($request->status == 11) {
				$lead['commission_status'] = 2;
				$lead['sale_status'] = 8;
			}
            else if (in_array($request->status, $status_arr) && $request->service_id == 1) {
                $lead['commission_status'] = null;
				$lead['sale_status'] = $request->status;
                $lead['sale_submission_status'] = '0';
            }
            else
            {
				$lead['commission_status'] = null;
				$lead['sale_status'] = $request->status;
			}
            if($request->service_id == 1 && in_array($request->status,[3,4,12,5]))
            {
                $providerID = DB::table('sale_products_energy')->where('id',$saleProductId)->pluck('provider_id')->first(); 
                
                if(in_array($providerID,[config('env.ENERGY_AUSTRALIA'),config('env.OVO_ID'),config('env.POWERSHOP'),config('env.AGL_ID'),config('env.RED_ENERGY_ID'),config('env.ORIGIN_ID')]))
                { 
                    DB::select('set @leadId=' . $leadId);
                    $saleDetails = DB::select('call final_sale_detail_energy(@leadId)');
                    $response = self::saleSubmissionApi($saleProductId,$saleProductType,$saleDetails,$request);
                    if(!$response['success'])
                    {
                        return response()->json($response,400);
                    }
                }
            }
            self::where('id', $saleProductId)->update($lead);
            switch ($request->service_id) {
                case '1':
                    $historyResponse = SaleStatusHistoryEnergy::createHistory($request, $saleProductId, $saleProductType);
                    break;
                case '2':
                    $historyResponse = SaleStatusHistoryMobile::createHistory($request, $saleProductId);
                    break;
                case '3':
                    $historyResponse = SaleStatusHistoryBroadband::createHistory($request, $saleProductId);
                    break;
            }
            $response['history_update'] = $historyResponse; 
            return response()->json($response,200);
        } catch (\Exception $err) {
            throw $err;
        }
    }

    public static function saleSubmissionApi($saleProductId,$saleProductType,$saleDetails,$request){
        $groupDetails = collect($saleDetails)->groupBy('sale_product_product_type');
        $response = [];
        if(count($groupDetails) == 1)
        {
            if(in_array($request->status, [3,5]))
            {
                return ['success' => true];
            }
            $response = self::submitData($saleDetails[0]->sale_product_provider_id,$saleProductType,true,$request,'1',$groupDetails,$saleDetails);
        }
        else
        {
            $firstSale = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
            $secondSale = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null;
            if($saleProductType == 2)
            {
                $firstSale = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null;
                $secondSale = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
            }

            if($saleDetails[0]->sale_product_provider_id != $saleDetails[1]->sale_product_provider_id)
            {
                $response = self::submitData($firstSale->sale_product_provider_id,$firstSale->sale_product_product_type,true,$request,'1',$groupDetails,$saleDetails);
            }
            else
            {
                if($request->status == 3)
                {
                    if(in_array($secondSale->sale_product_sale_status, [4,12]) && $secondSale->sale_product_submission_status == 0)
                    {
                        $response = self::submitData($secondSale->sale_product_provider_id,$secondSale->sale_product_product_type,true,$request,'1',$groupDetails,$saleDetails);
                    }
                }
                else
                {
                    if(!in_array($secondSale->sale_product_sale_status, [1,2]))
                    {
                        if(in_array($secondSale->sale_product_sale_status, [3,5]))
                        {
                            $response = self::submitData($firstSale->sale_product_provider_id,$firstSale->sale_product_product_type,true,$request,'1',$groupDetails,$saleDetails);
                        }
                        else
                        {
                            if(in_array($secondSale->sale_product_sale_status, [4,12]) && $secondSale->sale_product_submission_status == 1)
                            {
                                $response = self::submitData($firstSale->sale_product_provider_id,$firstSale->sale_product_product_type,true,$request,'1',$groupDetails,$saleDetails);
                            }
                            else
                            {
                                $response = self::submitData($firstSale->sale_product_provider_id,3,true,$request,'1',$groupDetails,$saleDetails);
                            }
                        }
                    }
                }
            }
        }
        return $response;
	}

    static function submitData($provider,$productType,$test,$request,$currentEnergy,$groupDetails,$saleDetails)
    {
            $newResponse = []; 
            if ($provider == config('env.ENERGY_AUSTRALIA')) {
                $energyObj = new EASaleSubmissionRepo;
                $response = $energyObj->submitEASale(decryptGdprData($request->lead_id),$productType,$groupDetails);
                $newResponse = json_decode(json_encode($response));
            }
            else if ($provider == config('env.OVO_ID')) {
                $energyObj = new OvoRepository;
                $response = $energyObj->setDataForOvoApi(decryptGdprData($request->lead_id), $productType, $provider, $test,$groupDetails);
                $newResponse = json_decode(json_encode($response));
            }
            else if ($provider == config('env.POWERSHOP')) {
                $energyObj = new FluxRepository;
                $response = $energyObj->getFluxData(decryptGdprData($request->lead_id), $productType, $productType,$groupDetails);
                $newResponse = json_decode(json_encode($response));
            }
            else if ($provider == config('env.AGL_ID')) {
                $energyObj = new AP;
                $response = $energyObj->submitData(decryptGdprData($request->lead_id),$productType,$saleDetails);
                $newResponse = json_decode(json_encode($response));
            }
            else if ($provider == config('env.RED_ENERGY_ID')) {
                $energyObj = new RLSaleSubmission;
                $response = $energyObj->submitData(decryptGdprData($request->lead_id), $productType,$saleDetails);
                $newResponse = json_decode(json_encode($response));
            }
            else if ($provider == config('env.ORIGIN_ID')) {
                $energyObj = new originSubmission;
                $response = self::getOriginProductId($request,$productType,$saleDetails,$groupDetails);  
                $newResponse = json_decode(json_encode($response)); 
            }
            if ($newResponse->code == 200) {
                $saleProduct = SaleProductsEnergy::where('lead_id', $request->id);
                if($productType != 3)
                {
                    $saleProduct->where('product_type', $productType);
                }
                $saleProduct = $saleProduct->update(['sale_submission_status' => '1']);
                $response = ['success' => true, 'response' => true, 'message' => 'Api Response get sucessfully .', 'data' => $response['output'], 'request' => $response['data'], 'header' => $response['header']];
            }
            else if ($newResponse->code == 401) {
                $response = ['success' => false, 'response' => false, 'message' => 'Something went wrong.', 'data' => $response['request_data'], 'request' => $response['response_data']];
            }
            else{  
                $response = ['success' => false, 'response' => false, 'message' => 'Something went wrong.', 'data' => $response['output'], 'request' => $response['data'], 'header' => $response['header']];
            } 
            return $response;
        }

        public static function getOriginProductId($request,$origin_energy_type,$saleDetails,$groupDetails)
        {
            $gas_id  = $elec_id = "";
            if ($origin_energy_type == '3') { 
                $lead = isset($groupDetails[1][0]) ? $groupDetails[1][0] : null;
                $gasLead = isset($groupDetails[2][0]) ? $groupDetails[2][0] : null; 
                if ($lead->journey_energy_type == '1') {
                    $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();

                    $expirydate = Carbon::parse($expiry_time)->addHour();

                    if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) {
                        $elec_id = originSubmission::getProductId('1', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->plan_product_code, 'submit');
                         if ($elec_id[0] == 0) {
                            $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                        }
                        $elec_id = $elec_id[0];
                    } else {
                        $elec_id =  $lead->plan_product_id;
                    }

                    $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                    $expirydate = Carbon::parse($expiry_time)->addHour(); 
                    if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) {
                        $gas_id = originSubmission::getProductId('Gas', $gasLead->sale_product_reference_no, $gasLead->plan_campaign_code, $gasLead->product_code, 'submit');
                       
                        if ($gas_id[0] == 0) { 
                            $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                        }
                        $gas_id = $gas_id[0];
                    }

                    $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->sale_product_id, 'both', 'production');
                    $result = json_decode($originData->getContent());
                    if ($result->status_code != 200 && $result->status_code != 201) {
                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                        $status = $result->status_code;
                        return response()->json($response, $status);
                    }
                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                } else {
                    $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                    $expirydate = Carbon::parse($expiry_time)->addHour();
                    if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) { 

                        $gas_id =  originSubmission::getProductId('Gas', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->product_code_g, 'submit');

                        if ($gas_id[0] == 0) {
                            $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                        }
                        $gas_id = $gas_id[0];
                    } else {
                        $gas_id =  $lead->plan_product_id;
                    }
                    $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                    $expirydate = Carbon::parse($expiry_time)->addHour();
                    if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) {
                        $elec_id = originSubmission::getProductId('Electricity', $gasLead->sale_product_reference_no, $gasLead->plan_campaign_code, $gasLead->product_code, 'submit');
                        if ($elec_id[0] == 0) {
                            $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                        }
                        $elec_id = $elec_id[0];
                    } else {

                        $elec_id =  $lead->plan_product_id;
                    }

                    $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->sale_product_id, 'both', 'production');

                    $result = json_decode($originData->getContent());

                    if ($result->status_code != 200 && $result->status_code != 201) {

                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                        $status = $result->status_code;
                        return response()->json($response, $status);
                    } 
                    $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                } 
            } else {
                $lead = isset($groupDetails[$origin_energy_type][0]) ? $groupDetails[$origin_energy_type][0] : null;
                if ($request->status != 3) {
                    if ($lead->journey_energy_type == 1) {
                        $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                        $expirydate = Carbon::parse($expiry_time)->addHour();
                        if (!Carbon::parse($expirydate)->gt(Carbon::now()) ||  $lead->sale_product_id_expiry_time == null) 
                        { 
                            $elec_id = originSubmission::getProductId('Electricity', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->product_code, 'submit');

                            if ($elec_id[0] == 0) {
                                $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401];
                                $status = 422;
                                return response()->json($response, $status);
                            }
                            $elec_id = $elec_id[0];
                        } else {
                            $elec_id = $lead->plan_product_id;
                        }

                        $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->l_lead_id, $lead->journey_energy_type, 'production');
                        $result = json_decode($originData->getContent());
                        if ($result->status_code != 200 && $result->status_code != 201) {
                            $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                            $status = $result->status_code;
                            return response()->json($response, $status);
                        }

                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                    } else {

                        $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                        $expirydate = Carbon::parse($expiry_time)->addHour();

                        if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) { 
                            $gas_id =  originSubmission::getProductId('Gas', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->product_code, 'submit');
                            if ($gas_id[0] == 0) {
                                $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                            }
                            $gas_id = $gas_id[0];
                        } else {

                            $gas_id = $lead->plan_product_id;
                        }

                        $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->l_lead_id, $lead->journey_energy_type, 'production');

                        $result = json_decode($originData->getContent());

                        if ($result->status_code != 200 && $result->status_code != 201) {
                            $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                            $status = $result->status_code;
                            return response()->json($response, $status);
                        }

                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                    }
                } else {
                    if ($lead->journey_energy_type == '1') {
                        $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();

                        $expirydate = Carbon::parse($expiry_time)->addHour();

                        if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) { 

                            $elec_id = originSubmission::getProductId('Electricity', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->plan_product_code, 'submit');

                            if ($elec_id[0] == 0) {
                                $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                                return $response;
                            }
                            $elec_id = $elec_id[0];
                        } else {
                            $elec_id = $lead->plan_product_id;
                        }

                        $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->l_lead_id, $lead->journey_energy_type, 'production');

                        $result = json_decode($originData->getContent());

                        if ($result->status_code != 200 && $result->status_code != 201) {
                            $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                            $status = $result->status_code;
                            return response()->json($response, $status);
                        }

                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                    } else {
                        $expiry_time = Carbon::parse($lead->sale_product_id_expiry_time)->toDateTimeString();
                        $expirydate = Carbon::parse($expiry_time)->addHour();
                        if (!Carbon::parse($expirydate)->gt(Carbon::now()) || $lead->sale_product_id_expiry_time == null) {
                            if (empty($lead))
                                $lead = null;
  
                            $gas_id =  originSubmission::getProductId('Gas', $lead->sale_product_reference_no, $lead->plan_campaign_code, $lead->product_code, 'submit');

                            if ($gas_id[0] == 0) {
                                $response = ['success' => false, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => "Electricity Product ID not found", 'response_data' => "",'code' => 401]; 
                            return $response;
                            }
                            $gas_id = $gas_id[0];
                        } else {
                            $gas_id = $lead->plan_product_id;
                        }

                        $originData = originSubmission::postOriginData($gas_id, $elec_id, $lead->l_lead_id, $lead->journey_energy_type, 'production');
                        $result = json_decode($originData->getContent());
                        if ($result->status_code != 200 && $result->status_code != 201) {

                            $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                            $status = $result->status_code;
                            return response()->json($response, $status);
                        }

                        $response = ['success' => true, 'origin' => true, 'message' => 'Origin API Response Successfully.', 'request_data' => $result->request_data, 'response_data' => $result->response_data];
                    }
                }
            }
            return $response;
        }
        
    public static function getOtherInfo($productId){
		return DB::table('sale_product_energy_other_info')->where('lead_id',$productId)->first();
	}
}
