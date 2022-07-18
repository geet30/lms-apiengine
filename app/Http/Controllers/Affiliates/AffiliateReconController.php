<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Affiliate, AffiliateKeys,UserService,AffiliateReconSalesHistory, ReconSale,Status,ReconSaleHistory,AffiliateRecon};
use App\Http\Requests\Affiliates\{GenerateReconFileRequest,RetentionRequest};
use Illuminate\Support\Carbon;
use DB;
class AffiliateReconController extends Controller
{
    
    public function getRecon($affId, Request $request)
    {
       
        $type = request()->segment(2);
        $opr = request()->segment(3);
        $userId = '';
        if ($type == 'sub-affiliates') {
            $userId = Affiliate::getAffiliateIdById(decryptGdprData($affId));
            $userId = encryptGdprData($userId);
        }
        $services = [];
        $verticals = [];
    
        $affiliateuser = Affiliate::getFilters(['user_id' => decryptGdprData($affId)], ['*'], ['user' => ['id', 'first_name', 'last_name', 'email', 'phone'], 'getaffiliateservices' => ['id', 'user_id', 'service_id'], 'getunsubscribesources' => ['id', 'user_id', 'unsubscribe_source'], 'affiliateunsubscribesource' => ['user_id', 'unsubscribe_source', 'status'], 'getuseradress' => ['user_id', 'address'], 'getthirdpartyapi' => ['user_id', 'api_key']], false, false);

        $salesHistory=AffiliateReconSalesHistory::select('recon_reference_no','recon_status','recon_created_date','recon_reset_date')->get();

        return view('pages.affiliates.recon.list', compact('affId', 'type', 'opr', 'userId', 'services', 'verticals','affiliateuser','salesHistory'));
        
  
    }
    public function generateReconFile(GenerateReconFileRequest $request){
        try {
			$saleData 			= array();
			$input 				= $request->all();
			$affiliate_id 		= $request->affiliate_id;
			$recon_sales 		= [];
			$recon_sales_ids	= [];
			$history_recon_data	= [];
			$recon_file_name 	= '';
			$recon_reference_no = '';
			$parent_id 			= '';
			$recon_file_no 		= 00001;
			$file_year 			= Carbon::now()->format('Y');
			$recon_pending_sales_ids = [];
			$address = 0;

			$affiliate_data = Affiliate::where('user_id',$affiliate_id)->where('status',1)->first();
            // echo "<pre>";print_r($affiliate_data);die;

			$parent_id 		= $affiliate_data['parent_id'];

			$aff_name 		= strtoupper(str_replace(' ', '', $affiliate_data['company_name']));
		
			$affiliates = DB::table('affiliate_recon')->select('master_recon_permissions.name')->join('master_recon_permissions', 'affiliate_recon.permission_id', 'master_recon_permissions.id')->where('user_id',$affiliate_id)->get()->toArray();
			// $affiliates = Affiliate::with('getreconAffiliates')->where('status',1)->get();
			
			// $masterpermissions =   AffiliateRecon::getMasterReconPermissions();
			
			$columns_name 	= array_column($affiliates,'name');

			if(in_array('Connection Address', $columns_name)){
				$address = 1;
				if (($key = array_search('Connection Address', $columns_name)) !== false) {
    				unset($columns_name[$key]);    				
				}
			}
			
			
			$recon_file_type = $input['recon_file_type'];

			if($affiliate_data['reconmethod'] =='1'){ //monthly
				if(isset($input['selected_month']) && !empty($input['selected_month'])){
					$month_year_arr = explode(' ', $input['selected_month']);
					$file_month = Carbon::now()->subMonth()->format('m');
					$first_day	= date("Y-m-d H:i:s", mktime(23, 59, 59, $month_year_arr[0],1 ,$month_year_arr[1]));
					$start_date = date("Y-m-t H:i:s", strtotime($first_day)); 
					$end_date 	= Carbon::now()->endOfMonth()->subMonth(7);
				}else{
					$file_month = Carbon::now()->subMonth()->format('m');
					$start_date = Carbon::now()->startofMonth()->subMonth()->endOfMonth();
					$end_date 	= Carbon::now()->endOfMonth()->subMonth(7);
				}
			}else{
				$dt = Carbon::today()->format('d');
				$start_date = Carbon::now()->firstOfMonth()->addDays(14);

				if($dt < 15){
					$file_month = Carbon::now()->subMonth()->format('m');
					$start_date = Carbon::now()->startofMonth()->subMonth()->endOfMonth();
					$end_date = Carbon::now()->endOfMonth()->subMonth(7);
				}else{
					$file_month = Carbon::now()->format('m');
					$start_date = Carbon::now()->firstOfMonth()->addDays(14);
					$end_date = Carbon::now()->endOfMonth()->subMonth(7);
				}
			}

			//DB::enableQueryLog();
			
			// $recon_sales_payable = ReconSale::where('sale_created','<=',$start_date)->where('sale_created','>=',$end_date);
			// $recon_sales_payable = $recon_sales_payable->where(['affiliate_id'=> $affiliate_id,'recon_status'=>'0']);
			try { 
				$recon_sales['payable']  = DB::table('recon_sales')->select('recon_sales.id','visitor_addresses.address','visitor_addresses.address_type')
				->join('leads', 'leads.lead_id', 'recon_sales.lead_id')
				->join('visitor_addresses', 'visitor_addresses.id', 'leads.billing_address_id')
				->join('sale_products_energy','sale_products_energy.lead_id', 'leads.lead_id')
				// ->where('visitor_addresses.address_type', 3)			
				// ->where('sale_products_energy.sale_status', [8])
				->where('recon_sales.lead_status', [1]) // its 8 in old code
				->where('recon_sales.affiliate_id', $affiliate_id)
				->where('recon_sales.recon_status', '0')
				->where('recon_sales.sale_created', '<=',$start_date)
				->where('recon_sales.sale_created', '>=',$end_date)
				->get()
				->toArray();
			}
			catch(\Illuminate\Database\QueryException $ex){ 
				dd($ex->getMessage()); 
				// Note any method of class PDOException can be called on $ex.
			}
			// reference_no
			echo "<pre>";print_r($recon_sales);die;

			
			
			// $recon_sales['payable'] = $recon_sales_payable->with(['getBillingAddress'=>function($p){
			// 								$p->select('id','address','address_type');
			// 								// $p->where('address_type',2);
			// 								// $p->orWhere('address_type',3);
			// 							},'sale'=> function ($q)use($columns_name) {
			// 							$q->select($columns_name);
			// 							$q->whereIn("sale_status",[8]);
			// 							}])->whereIn("sale_current_status",[8])->get()->toArray();
			//print_r(DB::getQueryLog());die;
	
			echo "<pre>";print_r($recon_sales);die;
		
			$payable_ref_no = [];

			foreach ($recon_sales['payable'] as $key => $value) {
				$recon_sales_ids[]=$value['id'];
				
				if((!empty($value['sale'])&& count($value['sale'])>0)&& (!in_array($value['sale_reference_no'], $payable_ref_no)) ){
					foreach ($value['sale'] as $saleKey => $saleValue) {
						$sales= array();
						if($saleKey==1){
							$sales =$value['sale'][1];
						}else{
							$sales =$value['sale'][0];
						}
						
						$sale_val_arr 		= array();
						$address_val_arr 	= array();
						foreach ($sales as $sales_key => $sales_value) {
							if($sales_key == 'affiliate_id'){
								$aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$affname 		= strtoupper($aff_data['company_name']);
								$sales_value 	= $affname;
							}
							if(($sales_key == 'sub_affiliate_id' && $sales_key != '')|| $sales_key == 'sale_source_id'){
								$sub_aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$subaffname 		= strtoupper($sub_aff_data['company_name']);
								$sales_value 		= $subaffname;
							}
							if($sales_key == 'sale_status'){
								if($sales_value==8){
									$sales_value = "Paid";
								}	
							}
							if($sales_key == 'sale_sub_status'){
								$substatus_name	= Status::where('id',$sales_value)->first();
								$sales_value 	= $substatus_name['title'];
							}
							if($sales_key == 'resale_type'){
								if($sales_value==0){
									$sales_value = "Aquisition";
								}
								if($sales_value==1){
									$sales_value = "Retention";
								}
							}
							if($sales_key == 'sale_created'){
								$sales_value = date('d,M Y H:i', strtotime($value['sale_created']));
							}
							if($sales_key == 'dob'){
								$sales_value = date('d-m-Y', strtotime($sales_value));
							}

							$sale_val_arr[]= $sales_value;
						}
						if(($address == 1) && (!empty($value['visitor_address_info'])&& count($value['visitor_address_info'])>0)){
							if($sales['energy_type'] == 'gas'){
								if(isset($value['visitor_address_info'][1]) && !empty($value['visitor_address_info'][1]['address']) && $value['visitor_address_info'][1]['address_type'] == 3 ){
									$sale_val_arr[]=$value['visitor_address_info'][1]['address'];
								}else{
									$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
								}
							}else{
								$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
							}
						}
						$saleData['payable'][]=$sale_val_arr;
					}

					$payable_ref_no[] =$value['sale_reference_no'];
				}
				
			}

			$recon_sales_nonpayable = ReconSale::where('sale_created','<=',$start_date)
						->where('sale_created','>=',$end_date);
			$recon_sales_nonpayable = $recon_sales_nonpayable->where(['affiliate_id'=> $affiliate_id,'recon_status'=>'0']);
			
			$recon_sales['non-payable'] = $recon_sales_nonpayable->with(['VisitorAddressInfo'=>function($p){
											$p->select('visitor_sale_id','address','address_type');
											$p->where('address_type',2);
											$p->orWhere('address_type',3);
										},'sale'=> function ($q)use($columns_name) {
									$q->select($columns_name);
									$q->whereIn("sale_status",[2,3,5]);
									}])->whereIn("sale_current_status",[2,3,5])->get()->toArray();

			$non_payable_ref_no = [];
			foreach ($recon_sales['non-payable'] as $key => $value) {
				$recon_sales_ids[]=$value['id'];

				if((!empty($value['sale'])&& count($value['sale'])>0)&& (!in_array($value['sale_reference_no'], $non_payable_ref_no)) ){

					foreach ($value['sale'] as $saleKey => $saleValue) {
						$sales= array();
						if($saleKey==1){
							$sales =$value['sale'][1];
						}else{
							$sales =$value['sale'][0];
						}
						$sale_val_arr =array();
						foreach ($sales as $sales_key => $sales_value) {
							if($sales_key == 'affiliate_id'){
								$aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$affname 		= strtoupper($aff_data['company_name']);
								$sales_value 	= $affname;
							}
							if(($sales_key == 'sub_affiliate_id' && $sales_key != '')|| $sales_key == 'sale_source_id'){
								$sub_aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$subaffname 		= strtoupper($sub_aff_data['company_name']);
								$sales_value 		= $subaffname;
							}
							if($sales_key == 'sale_status'){
								if($sales_value==2){
									$sales_value = "Rejected";
								}	
								if($sales_value==3){
									$sales_value = "Cancelled";
								}
								if($sales_value==5){
									$sales_value = "Retailer Rejected";
								}
							}
							if($sales_key == 'sale_sub_status'){
								$substatus_name	= Status::where('id',$sales_value)->first();
								$sales_value 	= $substatus_name['title'];
							}
							if($sales_key == 'resale_type'){
								if($sales_value==0){
									$sales_value = "Aquisition";
								}
								if($sales_value==1){
									$sales_value = "Retention";
								}
							}
							if($sales_key == 'sale_created'){
								$sales_value = date('d,M Y H:i', strtotime($value['sale_created']));
							}
							if($sales_key == 'dob'){
								$sales_value = date('d-m-Y', strtotime($sales_value));
							}
							$sale_val_arr[]= $sales_value;
						}

						if(($address == 1) && (!empty($value['visitor_address_info'])&& count($value['visitor_address_info'])>0)){
							if($sales['energy_type'] == 'gas'){
								if(isset($value['visitor_address_info'][1]) && !empty($value['visitor_address_info'][1]['address']) && $value['visitor_address_info'][1]['address_type'] == 3 ){
									$sale_val_arr[]=$value['visitor_address_info'][1]['address'];
								}else{
									$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
								}
							}else{
								$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
							}
						}
					$saleData['non-payable'][]=$sale_val_arr;
					}
					$non_payable_ref_no[] =$value['sale_reference_no'];
				}
			}

			$recon_sales_pending = ReconSale::where('sale_created','<=',$start_date)
									->where('sale_created','>=',$end_date);
			$recon_sales_pending = $recon_sales_pending->where(['affiliate_id'=> $affiliate_id,'recon_status'=>'0']);			
			$recon_sales['pending'] = $recon_sales_pending ->with(          ['VisitorAddressInfo'=>function($p){
											$p->select('visitor_sale_id','address','address_type');
											$p->where('address_type',2);
											$p->orWhere('address_type',3);
										},'sale'=> function ($q)use($columns_name) {
									$q->select($columns_name);
									$q->whereIn("sale_status",[0,1,4,6,9,7,12]);
									}])->whereIn("sale_current_status",[0,1,4,6,9,7,12])->get()->toArray();

			$pending_ref_no = [];

			foreach ($recon_sales['pending'] as $key => $value) {
				$recon_sales_ids[] = $value['id'];
				$recon_pending_sales_ids[] = $value['id'];

				if((!empty($value['sale'])&& count($value['sale'])>0)&& (!in_array($value['sale_reference_no'], $pending_ref_no)) ){
					foreach ($value['sale'] as $saleKey => $saleValue) {
						$sales= array();
						if($saleKey==1){
							$sales = $value['sale'][1];
						}else{
							$sales = $value['sale'][0];
						}
						$sale_val_arr =array();
						foreach ($sales as $sales_key => $sales_value) {
							if($sales_key == 'affiliate_id'){
								$aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$affname 		= strtoupper($aff_data['company_name']);
								$sales_value 	= $affname;
							}
							if(($sales_key == 'sub_affiliate_id' && $sales_key != '')|| $sales_key == 'sale_source_id'){
								$sub_aff_data 		= Affiliate::where('user_id',$sales_value)->first();
								$subaffname 		= strtoupper($sub_aff_data['company_name']);
								$sales_value 		= $subaffname;
							}
							if($sales_key == 'sale_status'){
								if($sales_value==0 || $sales_value==1){
									$sales_value = "Pending";
								}
								if($sales_value==4){
									$sales_value = "Submitted";
								}
								if($sales_value==9){
									$sales_value = "In Question";
								}
								if($sales_value==7){
									$sales_value = "Recon";
								}
								if($sales_value==12){
									$sales_value = "ReSubmitted";
								}
								if($sales_value==6){
									$sales_value = "Accepted";
								}
							}
							if($sales_key == 'sale_sub_status'){
								$substatus_name	= Status::where('id',$sales_value)->first();
								$sales_value 	= $substatus_name['title'];
							}
							if($sales_key == 'resale_type'){
								if($sales_value==0){
									$sales_value = "Aquisition";
								}
								if($sales_value==1){
									$sales_value = "Retention";
								}
							}
							if($sales_key == 'sale_created'){
								$sales_value = date('d,M Y H:i', strtotime($value['sale_created']));
							}
							if($sales_key == 'dob'){
								$sales_value = date('d-m-Y', strtotime($sales_value));
							}
							$sale_val_arr[]= $sales_value;
						}

						if(($address == 1) && (!empty($value['visitor_address_info'])&& count($value['visitor_address_info'])>0)){
							if($sales['energy_type'] == 'gas'){
								if(isset($value['visitor_address_info'][1]) && !empty($value['visitor_address_info'][1]['address']) && $value['visitor_address_info'][1]['address_type'] == 3 ){
									$sale_val_arr[]=$value['visitor_address_info'][1]['address'];
								}else{
									$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
								}
							}else{
								$sale_val_arr[]=$value['visitor_address_info'][0]['address'];
							}
						}
						$saleData['pending'][] = $sale_val_arr;
					}
					$pending_ref_no[] = $value['sale_reference_no'];
				}
			}

			$saleData['invoice'][] = "Affiliate Name: ".$aff_name;
			$saleData['invoice'][] = "Invoice till :".$start_date;
			/*Generation of excel file*/
			if((count($recon_sales['payable'])>0)||(count($recon_sales['non-payable'])>0)||(count($recon_sales['pending'])>0)){

				$file_incr = ReconSaleHistory::max('recon_file_no');
		
				if($file_incr>0){
					$recon_file_no = ++$file_incr;
					$recon_file_name_no = str_pad($recon_file_no, 5, '0', STR_PAD_LEFT);
					$recon_file_name = $aff_name.'-CMT-'.$file_year.$file_month.'-'.$recon_file_name_no;
					$recon_reference_no= 'CMT-'.$file_year.$file_month.'-'.$recon_file_name_no;

				}else{
					$recon_file_no = '00001';
					$recon_file_name = $aff_name.'-CMT-'.$file_year.$file_month.'-00001';	
					$recon_reference_no= 'CMT-'.$file_year.$file_month.'-00001';
				}

				$res = $this->getReconExcel($saleData, $columns_name,$affiliate_id,$recon_file_name,$recon_file_type,$address);

				if($input['recon_file_type']=='live'){

					if($res['status']){
						$update_data['recon_reference_no'] 	=  $recon_reference_no;
						$update_data['recon_file_name'] 	=  $recon_file_name;
						$update_data['recon_status'] 		=  1;
						$update_data['recon_created_date'] 	=  Carbon::now()->format("Y-m-d H:i:s");
						$update_status = ReconSale::whereIn('id',$recon_sales_ids)->update($update_data);
						if(!empty($recon_pending_sales_ids)){
							$pending_update_data['recon_status'] =  0;
							$pending_update_status = ReconSale::whereIn('id',$recon_pending_sales_ids)->update($pending_update_data);
						}
						if($update_status){
							$history_recon_data['affiliate_id'] 	= $affiliate_id	;
							$history_recon_data['recon_file_no']	=  $recon_file_no;	
							$history_recon_data['recon_file_name'] 	=  $res['filename'];
							$history_recon_data['recon_reference_no'] =  $recon_reference_no;
							$history_recon_data['recon_status'] 	=  1;
							$history_recon_data['recon_created_date'] = Carbon::now()->format("Y-m-d H:i:s");
							$history_recon_data['s3_url'] = $res['filepath'];
							$history_recon_data['password'] = $res['password'];	
							ReconSaleHistory::insert($history_recon_data);
							$message = "Recon file is generated successfully. File password is ".$res['password']." .";
							return response()->json(array('success' => 'true','data'=>$res,'message'=>$message,'url'=>$res['data']));
						}
					}else{
						// flash()->error("Something went wrong.");
						return response()->json(array('success' => 'false'));
					}
				}else{
					if($res['status']){
						$message = "Test recon file is generated successfully. File password is ".$res['password']." .";
						return response()->json(array('success' => 'true','data'=>$res,'message'=>$message,'url'=>$res['data']));
					}else{
						// flash()->error("Something went wrong.");
						return response()->json(array('success' => 'false'));
					}
				}
			}else{
				// flash()->error('Error,No recon sale found.');
				return response()->json(array('success' => 'false'));
			}
			
        }catch(\Exception $e) {
            $result = [
				'exception_message' => $e->getMessage()
            ];
			return view("errors.error", $result);            		  
        }

    }
    

}
