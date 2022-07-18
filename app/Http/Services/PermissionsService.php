<?php

namespace App\Http\Services; 

class PermissionsService
{ 
	public function getPermissionsList()
    {
		return [
		    'permissions_section' 
					=> array( 
						[ 
							'0' => 'Visit',
							'1' => 'show_visits', 
							'2' => '',
							'3' =>  [
										[
											'0' => 'Stage',
											'1' => 'visit_stage', 
											'2' => '',
											'3' =>   []
										],
										[
											'0' => 'Affiliates',
											'1' => 'visit_affiliate_information', 
											'2' => '',
											'3' =>  
													[
														[
															'0' => 'Affiliate Name',
															'1' => 'visit_affiliate_name', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Key',
															'1' => 'visit_affiliate_key', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Email',
															'1' => 'visit_affiliate_email', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Phone',
															'1' => 'visit_affiliate_phone', 
															'2' => '',
														],    
														[
															'0' => 'Sub Affiliate Name',
															'1' => 'visit_affiliate_sub_affiliate_name', 
															'2' => '',
														], 
														[
															'0' => 'Referal Code Url Title',
															'1' => 'visit_referal_code_url', 
															'2' => '',
														],
													]
										],
										[
											'0' => 'User Analytic Section',
											'1' => 'visit_user_analytices', 
											'2' => '',
											'3' =>  []
										], 
									],            
						],
						[ 
									'0' => 'Lead',
									'1' => 'show_leads', 
									'2' => '',
									'3' =>  [
												[
													'0' => 'Stage',
													'1' => 'lead_stage', 
													'2' => '',
													'3' =>  []
												],
												[
													'0' => 'Affiliate Information',
													'1' => 'lead_affiliate_information', 
													'2' => '',
													'3' =>  
															[
																[
																	'0' => 'Affiliate Name',
																	'1' => 'lead_affiliate_name', 
																	'2' => '',
																],
																[
																	'0' => 'Affiliate Key',
																	'1' => 'lead_affiliate_key', 
																	'2' => '',
																],
																[
																	'0' => 'Affiliate Email',
																	'1' => 'lead_affiliate_email', 
																	'2' => '',
																],
																[
																	'0' => 'Affiliate Phone',
																	'1' => 'lead_affiliate_phone', 
																	'2' => '',
																],
																[
																	'0' => 'Sub Affiliate Name',
																	'1' => 'lead_affiliate_sub_affiliate_name', 
																	'2' => '',
																], 
																[
																	'0' => 'Referal Code Url Title',
																	'1' => 'lead_referal_code_url', 
																	'2' => '',
																],  
															]
												],
												[
													'0' => 'Customer Information',
													'1' => 'lead_customer_information', 
													'2' => '',
													'3' =>  []
												],
												[
													'0' => 'Customer Journey',
													'1' => 'lead_customer_journey', 
													'2' => '',
													'3' =>  []
												], 
												[
													'0' => 'Plan Information',
													'1' => 'lead_plan_information', 
													'2' => '',
													'3' =>  [] 
												], 
												[
													'0' => "Addon's",
													'1' => 'lead_addons', 
													'2' => '',
													'3' =>  []
												],
												[
													'0' => 'API Response',
													'1' => 'lead_api_response',
													'2' => '',
													'3' =>  []
												],  
												[
													'0' => 'Additional Info',
													'1' => 'lead_additional_info',
													'2' => 'energy',
													'3' =>  []
												], 
												[
													'0' => 'QA Section',
													'1' => 'lead_qa_section', 
													'2' => '',
													'3' =>  [] 
												], 
												[
													'0' => 'Identification Information',
													'1' => 'lead_identification_information', 
													'2' => '',
													'3' =>  [] 
												],
												[
													'0' => 'Direct Debit Information',
													'1' => 'lead_direct_debit_information', 
													'2' => '',
													'3' =>  [
																[
																	'0' => 'Detokenization Button',
																	'1' => 'lead_detokenization_button', 
																	'2' => '',
																],

															] 
												],    
											] 
								],
						[ 
							'0' => 'Sale',
							'1' => 'show_sales', 
							'2' => '',
							'3' =>  [
										[
											'0' => 'Stage',
											'1' => 'sale_stage', 
											'2' => '',
											'3' =>  []
										],
										[
											'0' => 'Affiliate Information',
											'1' => 'sale_affiliate_information', 
											'2' => '',
											'3' =>  
													[
														[
															'0' => 'Affiliate Name',
															'1' => 'sale_affiliate_name', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Key',
															'1' => 'sale_affiliate_key', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Email',
															'1' => 'sale_affiliate_email', 
															'2' => '',
														],
														[
															'0' => 'Affiliate Phone',
															'1' => 'sale_affiliate_phone', 
															'2' => '',
														],
														[
															'0' => 'Sub Affiliate Name',
															'1' => 'sale_affiliate_sub_affiliate_name', 
															'2' => '',
														], 
														[
															'0' => 'Referal Code Url Title',
															'1' => 'sale_referal_code_url', 
															'2' => '',
														],  
													]
										],
										[
											'0' => 'Customer Information',
											'1' => 'sale_customer_information', 
											'2' => '',
											'3' =>  []
										],
										[
											'0' => 'Customer Journey',
											'1' => 'sale_customer_journey', 
											'2' => '',
											'3' =>  []
										], 
										[
											'0' => 'Plan Information',
											'1' => 'sale_plan_information', 
											'2' => '',
											'3' =>  [] 
										], 
										[
											'0' => "Addon's",
											'1' => 'sale_addons', 
											'2' => '',
											'3' =>  []
										],
										[
											'0' => 'API Response',
											'1' => 'sale_api_response',
											'2' => '',
											'3' =>  []
										],  
										[
											'0' => 'Additional Info',
											'1' => 'sale_additional_info',
											'2' => 'energy',
											'3' =>  []
										], 
										[
											'0' => 'QA Section',
											'1' => 'sale_qa_section', 
											'2' => '',
											'3' =>  [] 
										], 
										[
											'0' => 'Identification Information',
											'1' => 'sale_identification_information', 
											'2' => '',
											'3' =>  [] 
										],
										[
											'0' => 'Direct Debit Information',
											'1' => 'sale_direct_debit_information', 
											'2' => '',
											'3' =>  [
														[
															'0' => 'Detokenization Button',
															'1' => 'sale_detokenization_button', 
															'2' => '',
														],

													] 
										],   
										[
											'0' => 'Sale Status Information',
											'1' => 'sale_status_information', 
											'2' => '',
											'3' =>  [
														 
														[
															'0' => 'Sale Status History',
															'1' => 'sale_status_history', 
															'2' => '',
														],
														[
															'0' => 'Change Sale Status',
															'1' => 'sale_change_sale_status', 
															'2' => '',
														],

													] 
										], 
									] 
						],         
		        ),
		];

    }
} 