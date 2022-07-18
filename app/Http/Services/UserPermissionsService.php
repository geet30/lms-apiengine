<?php

namespace App\Http\Services; 

class UserPermissionsService
{ 
	public function getPermissionsList()
    {
		return [
		    'permissions_section' => array(
								[ 
									'0' => 'Statistic',
									'1' => 'show_statistics', 
									'2' => '',
									'3' => [],
								],
		            			[
		                            '0' => 'Manage User',
		                            '1' => 'show_users', 
		                            '2' => '',
		                            '3' =>  [
		                                        [
                                        			'0' => 'Users Actions',
    					                            '1' => 'users_action', 
    					                            '2' => '',
    					                            '3' =>  
    					                            		[
    					                            			[
	    					                                        '0' => 'Add User',
				    					                            '1' => 'add_user', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Edit User',
				    					                            '1' => 'edit_user', 
				    					                            '2' => '',

	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Delete User',
				    					                            '1' => 'delete_user', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Update Status',
				    					                            '1' => 'change_status_user', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Assign Affiliate',
				    					                            '1' => 'assign_affliate', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Assign Permissions',
				    					                            '1' => 'assign_permissions', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Manage 2FA',
				    					                            '1' => 'manage_user_2fa', 
				    					                            '2' => '',
	    					                                    ],
	    					                                ]
		    					                        ]
							                ],
		                        ], 
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
															'2' => 'broadband',
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
    					                            '2' => 'broadband',
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
												[
                                        			'0' => 'Assign QA Section',
    					                            '1' => 'sale_assign_qa_section', 
    					                            '2' => '',
    					                            '3' =>  [
    					                            			 
	    					                                    [
	    					                                        '0' => 'Assign Sales To QA',
				    					                            '1' => 'sale_assign_qa_to_sale', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Assign Sales To Collaborator',
				    					                            '1' => 'sale_assign_collaborator_to_sale', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Assign Unsigned Sales To QA',
				    					                            '1' => 'sale_assign_sale_to_unsigned_sale', 
				    					                            '2' => '',
	    					                                    ],

    					                            		] 
    					                        ],
		    					            ] 
		                        ],
		            			[ 
		                            '0' => 'Affiliate',
		                            '1' => 'show_affiliates', 
		                            '2' => '',
		                            '3' =>  [ 
                            					[
                                        			'0' => 'Affiliate Action',
    					                            '1' => 'affiliate_actions', 
    					                            '2' => '',
    					                            '3' =>  [
    					                            			[
	    					                                        '0' => 'Add Affiliate',
				    					                            '1' => 'add_affiliate', 
				    					                            '2' => '',
	    					                                    ],
    					                            			[
	    					                                        '0' => 'Edit Affiliate',
				    					                            '1' => 'edit_affilaite', 
				    					                            '2' => '',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'Change Status',
				    					                            '1' => 'affiliate_change_status', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Comission Structure',
				    					                            '1' => 'affiliate_commission_structure', 
				    					                            '2' => 'energy',
	    					                                    ],
    					                            			[
	    					                                        '0' => 'Manage Api Key',
				    					                            '1' => 'affiliate_api_key', 
				    					                            '2' => '',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'Manage Target',
				    					                            '1' => 'affiliate_target', 
				    					                            '2' => 'energy',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'ID Matrix',
				    					                            '1' => 'affiliate_id_matrix', 
				    					                            '2' => 'energy',
	    					                                    ],
    					                            			[
	    					                                        '0' => 'Tag',
				    					                            '1' => 'affiliate_tags', 
				    					                            '2' => 'energy',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'Retention Sale',
				    					                            '1' => 'affiliate_retention_sale', 
				    					                            '2' => 'energy',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Two Factor Authentication',
				    					                            '1' => 'affiliate_manage_two_factor', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Manage Sub-Affiliates',
				    					                            '1' => 'affiliate_manage_sub_affiliate', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Assign User',
				    					                            '1' => 'affiliate_assign_users', 
				    					                            '2' => '',
	    					                                    ],
    					                            			[
	    					                                        '0' => 'Assign Providers',
				    					                            '1' => 'affiliate_assign_providers', 
				    					                            '2' => '',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'Assign Distributors',
				    					                            '1' => 'affiliate_assign_distributor', 
				    					                            '2' => 'energy',
	    					                                    ],  
    					                            			[
	    					                                        '0' => "IP'S Whitelist",
				    					                            '1' => 'affiliate_ip_whitelist', 
				    					                            '2' => '',
	    					                                    ],  
    					                            		]  
    					                        ], 
    					                        [
                                        			'0' => 'Affiliate Template',
    					                            '1' => 'affiliate_templates', 
    					                            '2' => '',
    					                            '3' =>  [
    					                            			[
	    					                                        '0' => 'Remarketing',
				    					                            '1' => 'affiliate_remarketing_template', 
				    					                            '2' => '',
	    					                                    ],
    					                            			[
	    					                                        '0' => 'Welcome',
				    					                            '1' => 'affiliate_welcome_template', 
				    					                            '2' => '',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => '2 way SMS',
				    					                            '1' => 'affiliate_2way_sms_template', 
				    					                            '2' => '',
	    					                                    ], 
	    					                                    [
	    					                                        '0' => 'Send Plan',
				    					                            '1' => 'affiliate_send_plan_template', 
				    					                            '2' => '',
	    					                                    ], 
    					                            		] 
    					                        ],
		                            		]
		                        ],
		            			[ 
		                            '0' => 'Provider',
		                            '1' => 'show_providers', 
		                            '2' => '',
		                            '3' => 
		                            		[
                            					[
                                        			'0' => 'Provider Action',
    					                            '1' => 'provider_action', 
    					                            '2' => '',
    					                            '3' =>  [
    					                            			 
	    					                                    [
	    					                                        '0' => 'Add Provider',
				    					                            '1' => 'add_provider', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Change Multiple Status',
				    					                            '1' => 'provider_change_status', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Edit Provider',
				    					                            '1' => 'edit_provider', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Delete Provider',
				    					                            '1' => 'delete_provider', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'View Provider',
				    					                            '1' => 'view_provider', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Settings',
				    					                            '1' => 'provider_settings', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Assigned Phone(s)',
				    					                            '1' => 'provider_assigned_phones', 
				    					                            '2' => '',
	    					                                    ],
    					                            		] 
    					                        ], 
												[
                                        			'0' => 'Mobile Plans',
    					                            '1' => 'show_mobile_plans', 
    					                            '2' => 'mobile',
    					                            '3' =>  
    					                            		[
    					                            			[
	    					                                        '0' => 'Add',
				    					                            '1' => 'add_mobile_plan', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Edit',
				    					                            '1' => 'edit_mobile_plan', 
				    					                            '2' => '',
	    					                                    ], 
																[
	    					                                        '0' => 'Delete',
				    					                            '1' => 'delete_mobile_plan', 
				    					                            '2' => '',
	    					                                    ],  
	    					                                    [
	    					                                        '0' => 'Manage Phone(s)',
				    					                            '1' => 'mobile_section_manage_phones', 
				    					                            '2' => '',
	    					                                    ],
	    					                                ]
    					                        ],
												[
                                        			'0' => 'Broadband Plans',
    					                            '1' => 'show_broadband_plans',
    					                            '2' => 'broadband',
    					                            '3' =>  
    					                            		[
    					                            			[
	    					                                        '0' => 'Add',
				    					                            '1' => 'add_broadband_plan', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Edit',
				    					                            '1' => 'edit_broadband_plan', 
				    					                            '2' => '',
	    					                                    ], 
																[
	    					                                        '0' => 'Delete',
				    					                            '1' => 'delete_broadband_plan', 
				    					                            '2' => '',
	    					                                    ],   
	    					                                ]
    					                        ],
												[
                                        			'0' => 'Energy Plans',
    					                            '1' => 'show_energy_plans',
    					                            '2' => 'energy',
    					                            '3' =>  
    					                            		[
    					                            			[
	    					                                        '0' => 'Upload Plans',
				    					                            '1' => 'energy_upload_plans', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Download Plans',
				    					                            '1' => 'energy_download_plans',
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Edit',
				    					                            '1' => 'edit_energy_plan', 
				    					                            '2' => '',
	    					                                    ], 
																[
	    					                                        '0' => 'Solar Rate',
				    					                            '1' => 'energy_solar_rate', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Plan Rate Detail',
				    					                            '1' => 'energy_plan_rate_detail', 
				    					                            '2' => '',
	    					                                    ],
																[
	    					                                        '0' => 'Delete',
				    					                            '1' => 'delete_energy_plan', 
				    					                            '2' => '',
	    					                                    ],
	    					                                ]
    					                        ],
		                        			],
		                        ],
		            			[ 
		                            '0' => 'Addons',
		                            '1' => 'show_addons', 
		                            '2' => 'broadband',
		                            '3' => [ 
												[
													'0' => 'Home Line Connection',
													'1' => 'home_line_connection_action', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add',
																	'1' => 'add_home_line_connection', 
																	'2' => '',
																],
																[
																	'0' => 'Change Status',
																	'1' => 'home_line_connection_change_status', 
																	'2' => '',
																],
																[
																	'0' => 'Edit',
																	'1' => 'edit_home_line_connection', 
																	'2' => '',
																], 
																[
																	'0' => 'Delete',
																	'1' => 'delete_home_line_connection', 
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Modem',
													'1' => 'modem_action', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add',
																	'1' => 'add_modem', 
																	'2' => '',
																],
																[
																	'0' => 'Change Status',
																	'1' => 'modem_change_status', 
																	'2' => '',
																],
																[
																	'0' => 'Edit',
																	'1' => 'edit_modem',
																	'2' => '',
																], 
																[
																	'0' => 'Delete',
																	'1' => 'delete_modem',
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Additional Addons',
													'1' => 'additional_addons_action', 
													'2' => '',
													'3' =>  [
																[
																	'0' => 'Add',
																	'1' => 'add_addons', 
																	'2' => '',
																],
																[
																	'0' => 'Change Status',
																	'1' => 'addons_change_status', 
																	'2' => '',
																],
																[
																	'0' => 'Edit',
																	'1' => 'edit_addons', 
																	'2' => '',
																], 
																[
																	'0' => 'Delete',
																	'1' => 'delete_addons', 
																	'2' => '',
																], 
															] 
												], 
										]
		                        ],
		            			[ 
		                            '0' => 'Handset',
		                            '1' => 'show_handsets', 
		                            '2' => 'mobile',
		                            '3' => [
												[
													'0' => 'Manage Brand',
													'1' => 'manage_brands', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Brand',
																	'1' => 'add_brand', 
																	'2' => '',
																],
																[
																	'0' => 'Actions',
																	'1' => 'brands_action', 
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Manage Ram',
													'1' => 'manage_rams', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Ram',
																	'1' => 'add_ram', 
																	'2' => '',
																],
																[
																	'0' => 'Actions',
																	'1' => 'ram_action', 
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Manage Internal Storage',
													'1' => 'manage_interanl_storage', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Internal Storage',
																	'1' => 'add_interanl_storage', 
																	'2' => '',
																],
																[
																	'0' => 'Action',
																	'1' => 'interanl_storage_action', 
																	'2' => '',
																], 
															] 
												],  
												[
													'0' => 'Manage Colors',
													'1' => 'manage_colors', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Color',
																	'1' => 'add_color', 
																	'2' => '',
																],
																[
																	'0' => 'Actions',
																	'1' => 'color_action', 
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Manage Contracts',
													'1' => 'manage_contracts', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Contract',
																	'1' => 'add_contracts', 
																	'2' => '',
																],
																[
																	'0' => 'Actions',
																	'1' => 'contracts_action', 
																	'2' => '',
																], 
															] 
												], 
												[
													'0' => 'Manage Phone(s)',
													'1' => 'manage_handset_phones', 
													'2' => '',
													'3' =>  [
																
																[
																	'0' => 'Add Phone',
																	'1' => 'add_handset_phones', 
																	'2' => '',
																],
																[
																	'0' => 'Action',
																	'1' => 'handset_phones_action', 
																	'2' => '',
																], 
															] 
												], 
											]
		                        ],    
		            			[ 
		                            '0' => 'Energy Settings',
		                            '1' => 'energy_settings_permission', 
		                            '2' => 'energy',
		                            '3' => []
		                        ], 
								[ 
		                            '0' => 'To Do List',
		                            '1' => 'show_manage_to_do_list', 
		                            '2' => 'energy',
		                            '3' => []
		                        ],      
		            			[ 
		                            '0' => 'Upload Leads',
		                            '1' => 'show_upload_leads', 
		                            '2' => 'energy',
		                            '3' => []
		                        ], 
		      					[ 
		                            '0' => 'Add Lead Manually',
		                            '1' => 'show_add_lead_manually', 
		                            '2' => 'energy',
		                            '3' => []
		                        ], 
		            			[ 
		                            '0' => 'Add Leads Manually Old',
		                            '1' => 'show_add_lead_manually_old', 
		                            '2' => 'energy',
		                            '3' => []
		                        ], 
		            			[ 
		                            '0' => 'IP Setting',
		                            '1' => 'show_ip_settings', 
		                            '2' => 'energy',
		                            '3' => []
		                        ], 
		          				[ 
		                            '0' => 'Set Usage',
		                            '1' => 'show_set_usage', 
		                            '2' => 'energy',
		                            '3' => 
		                            		[
                            					[
                                        			'0' => 'Show Residence Usage Limits',
    					                            '1' => 'show_residence_usage_limit', 
    					                            '2' => '',
    					                            '3' =>  [ 
	    					                                    [
	    					                                        '0' => 'Add Residence Usage Limits',
				    					                            '1' => 'add_residence_usage_limit', 
				    					                            '2' => '',
	    					                                    ],
    					                            		] 
    					                        ],
					                    		[
                                    				'0' => 'Show Business Usage Limits',
    					                            '1' => 'show_business_usage_limit', 
    					                            '2' => '',
    					                            '3' =>  [ 
	    					                                    [
	    					                                        '0' => 'Add Business Usage Limits',
				    					                            '1' => 'add_business_usage_limit', 
				    					                            '2' => '',
	    					                                    ],
    					                            			  
    					                            		] 
    					                        	],
    					                		[
                                        			'0' => 'Show DMO VDO Price',
    					                            '1' => 'show_dmo_vdo_price', 
    					                            '2' => '',
    					                            '3' =>  [ 
    					                            			[
	    					                                        '0' => 'Show Download/upload DMO VDO Price',
				    					                            '1' => 'show_download_upload_dmo_vdo_price', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Show State Enabled for DMO',
				    					                            '1' => 'show_state_enable_dmo', 
				    					                            '2' => '',
	    					                                    ],
	    					                                    [
	    					                                        '0' => 'Show Add New Record',
				    					                            '1' => 'show_add_new_record_dmo_vdo', 
				    					                            '2' => '',
	    					                                    ], 
    					                            		] 
    					                        ],
		                        			],
		                        ],  
		            			[ 
		                            '0' => 'Reports',
		                            '1' => 'show_reports', 
		                            '2' => 'energy',
		                            '3' => [
                            					[
                                        			'0' => 'Show Sms Reports',
    					                            '1' => 'show_sms_reports', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
					                   			[
                                        			'0' => 'Show Unsubscribe Reports',
    					                            '1' => 'show_unsubscribe_reports', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
		                            		]
		                        ], 
		            			[ 
		                            '0' => 'Manage FAQ',
		                            '1' => 'show_manage_faq', 
		                            '2' => 'energy',
		                            '3' => [
                            					[
                                        			'0' => 'Show FAQ listing',
    					                            '1' => 'show_faq_listing', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
					                    		[
                                        			'0' => 'Add FAQ',
    					                            '1' => 'add_faq', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
		                            		]
		                        ], 
		            			[ 
		                            '0' => 'Recon Setting',
		                            '1' => 'show_recon_settings', 
		                            '2' => 'energy',
		                            '3' => [ 
    					                		[
                                        			'0' => 'Manage Recon System Notification',
    					                            '1' => 'recon_setting_notification', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
		                            		]
		                        ], 
		          				[ 
		                            '0' => 'Manage Promotional SMS',
		                            '1' => 'show_promotional_sms', 
		                            '2' => '',
		                            '3' => [ 
    					                		[
                                        			'0' => 'ADD New Manage Promotional SMS',
    					                            '1' => 'add_new_promotional_sms', 
    					                            '2' => '',
    					                            '3' =>  []
    					                        ],
		                            		]
		                        ], 
		            			[
		                            '0' => 'Settings',
		                            '1' => 'show_settings', 
		                            '2' => '',
		                            '3' => []
		                        ], 
		            			[ 
		                            '0' => 'Detokenization Permissions',
		                            '1' => 'show_detokenization', 
		                            '2' => 'mobile_broadband',
		                            '3' => []
		                        ],          
		        ),
		];

    }
} 