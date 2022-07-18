<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadband plan labels
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */
    //Filter Plan
    'filter' => 'Filter',
    'add_plan' => 'Add Plan',
    'apply_filter' => 'Apply Filter',
    'reset' => 'Reset',

    //alerts
    'connection_change_title' => 'Notice !',
    'connection_change_text' => 'Changing connection type will might effect the linked modem and addons. Please check addons again after saving connection type.',
    'tech_type_change_title' => 'Notice !',
    'tech_type_change_text' => 'Changing technology type will might effect the linked modem and addons. Please check addons again after saving technology type.',
    'delete_checkbox_title' => 'You are about to delete the consent.',
    'delete_checkbox_text' => 'Deleting consent will effect immediately. You might not be able to access this consent again.',
    'change_status_title' => 'You are about to enable this plan.',
    'change_status_text' => 'Enabling plan will effect immediately. Plan will be visible to all the assigned platforms.',
    'disable_status_title' => 'You are about to disable this plan.',
    'disable_status_text' => 'Disabling plan will effect immediately. Plan will get disabled from all the assigned platforms.',
    'delete_fees_title' => 'You are about to delete the fees.',
    'delete_fees_text' => 'Deleting fees will effect immediately. You might not be able to access this fees again.',
    
    //Add/Edit Plan messages
    //Alert messages
    'server_error_toastr' => 'Something went wrong. Please try again later.',
    'plan_saved_toastr' => 'Plan saved successfully.',
    'plan_updated_toastr' => 'Plan updated successfully.',
    'term_condition_toastr' => 'Term and condition saved successfully.',

    'plan_fee_unique_toartr' => 'Please select unique fee type.',
    'plan_fee_updated_toastr' => 'Fees updated successfully.',

    'acknowledgement_toastr' => 'Acknowledgement consent saved successfully.',
    'other_addon_toastr' => 'Other addon updated successfully.',
    'change_status_toastr' => 'Status changed successfully.',

    'default_addon_toastr' => 'Included addon updated successfully.',
    'content_checkbox_add_toastr' => 'Checkbox saved successfully.',
    'content_checkbox_delete_toastr' => 'Checkbox deleted successfully.',
    'content_checkbox_not_delete_toastr' => 'Checkbox is not deleted. Please try again later.',

    'plan_fees_add_toastr' => 'Fees saved successfully.',
    'plan_fees_delete_toastr' => 'Fees deleted successfully.',
    'plan_fees_not_delete_toastr' => 'Fees is not deleted. Please try again later.',

    //table 
    'planname' => 'Name',
    'table_connection_type' => 'Connection Type',
    'status' => 'Status',
    'table_actions' => 'Action', 
    
    //common 
    'script' => 'Script',
    'show' => 'Show',
    'hide' => 'Hide',
    'yes' => 'Yes',
    'no' => 'No',
    'enable' => 'Enable',
    'disable' => 'Disable',
    
    //buttons
    'discard_button' => 'Cancel',
    'save_changes_button' => 'Save Changes',

    //tabs
    'plan_detail_tab' => 'Plan Detail',  
    'special_offer_tab' => 'Special Offer', 
    'fee_tab' => 'Fees', 
    'included_addon_tab' => 'Included Addons', 
    'addon_tab' => 'Addons', 
    't&c_tab' => 'T & C', 
    'ask_concent_tab' => 'Acks. Consent', 

    //plan detail sections
    'basic_detail' => 'Basic Details', 
    'name' => [
        'label'=> 'Plan Name',
        'placeholder' => 'e.g. Standard Speed Wireless',
        'validation' => [
            'required' => 'Please specify Plan Name',
            'unique' => 'Plan Name already exists, please choose another Plan Name'
        ]
    ] ,  
    'plan_duration' => [
        'label'=> 'Plan Duration/Contract length',
        'placeholder' => 'e.g. 3 Months',
        'validation' => [
            'required' => 'Please select Plan Duration/Contract length from dropdown'
        ]
    ],
    'connection_type' => [
        'label'=> 'Connection Type',
        'placeholder' => 'e.g. NBN',
        'validation' => [
            'required' => 'Please select Connection Type from dropdown'
        ]
    ] ,  
    'technology_type' => [
        'label'=> 'Technology Type',
        'placeholder' => 'e.g. FTTP',
        'validation' => ''
    ], 
    
    'satellite_inclusion' => [
        'label'=> 'Satellite Inclusion', 
        'validation' => ''
    ],
    'plan_inclusion' => [
        'label'=> 'Plan Inclusion', 
        'validation' => [
            'required' => 'Please enter some text for Plan Inclusion',
            'max' => 'Max Length Validation: Plan Inclusion exceeding max character length of 10000'
        ]
    ] ,  
    'connection_type_info' => [
        'label'=> 'Connection Type Info',
        'placeholder' => 'e.g. The NBN™ is a government ...',
        'validation' => [
            'required' => 'Please enter some text for Connection Type Info',
            'max' => 'Max Length Validation: Plan Inclusion exceeding max character length of 10000'
        ]
    ],
    'internet_speed' => [
        'label'=> 'Internet Speed',
        'placeholder' => 'e.g. 10',
        'validation' => ''
    ],
    'internet_speed_info' => [
        'label'=> 'Internet Speed Info',
        'placeholder' => 'e.g. The NBN™ is a government ...',
        'validation' => ''
    ],  
    'plan_cost_type' => [
        'label'=> 'Plan Cost Type',
        'placeholder' => 'e.g. Monthly',
        'validation' => [
            'required' => 'Please select Plan Cost Type from dropdown'
        ]
    ],
    'plan_cost' => [
        'label'=> 'Plan Cost',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Plan Cost',
            'numeric' => 'Only numeric values allowed',
            'gt' => 'Length Validation: Plan Cost should be greater than or equal 0'
        ]
    ],
    'plan_cost_info' => [
        'label'=> 'Plan Cost Info', 
        'validation' => [
            'required' => 'Please enter some text for Plan Cost Info',
            'max' => 'Max Length Validation: Plan Cost Info exceeding max character length of 10000'
        ]
    ],
    'plan_cost_description' => [
        'label'=> 'Plan Cost Description', 
        'validation' => ''
    ],
    'is_boyo_modem' => [
        'label'=> 'BYO Modem',  
        'validation' =>  [
            'required' => 'Please select either Yes or No'
        ]
    ],
    'nbn_key_facts' => [
        'label'=> 'NBN Key Facts', 
        'validation' => [
            'required' => 'Please select either File or URL'
        ]
    ],
    'nbn_key_facts_file' => [
        'label'=> 'File', 
        'validation' => [
            'required' => 'Please select the file to upload'
        ]
    ],
    'nbn_key_facts_url' => [
        'label'=> 'URL', 
        'placeholder' => 'e.g. http://www.google.com',
        'validation' => [
            'required' => 'Please provide URL',
            'url' => 'Please provide valid URL'
        ]
    ],      
    'billing_preference' => [
        'label'=> 'Override Billing Preferences ',
        'validation' => [
            'required' => 'Please select Billing Preference'
        ]
    ],
    'billing_preference_email' => 'Email',
    'billing_preference_sms' => 'SMS',
    'billing_preference_both' => 'Both',

    //Plan Information 
    'plan_information' => 'Plan Information', 
    'download_speed' => [
        'label'=> 'Download Speed',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'numeric' => 'Only numeric values allowed', 
            'between' => 'Max Length Validation: Download Speed exceeding max character length of 9999999.99'
        ]
    ],  
    'upload_speed' => [
        'label'=> 'Upload Speed',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'numeric' => 'Only numeric values allowed', 
            'between' => 'Max Length Validation: Download Speed exceeding max character length of 9999999.99'
        ]
    ],
    'typical_peak_time_download_speed' => [
        'label'=> 'Typical Peak Time Download Speed',
        'placeholder' => 'e.g. The NBN™ is a government ...',
        'validation' => [
            'required' => 'Please provide Typical Peak Time Download Speed'
        ]
    ],
    'data_limit' => [
        'label'=> 'Data Limit',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please select Data Limit from dropdown',
            'numeric' => 'Only numeric values allowed', 
        ]
    ],
    'speed_description' => [
        'label'=> 'Speed Description', 
        'validation' => [
            'max' => 'Max Length Validation: Plan Cost Info exceeding max character length of 10000'
        ]
    ],
    'additional_plan_information_text' => [
        'label'=> 'Additional Plan Information Text', 
        'validation' =>  [
            'max' => 'Max Length Validation: Plan Cost Info exceeding max character length of 10000'
        ]
    ],    

    //Plan Data 
    'plan_data' => 'Plan Data', 
    'total_data_allowance' => [
        'label'=> 'Total Data Allowance',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Total Data Allowance',
            'max' => 'Total data allowance exceeding max character length of 150'
        ]
    ],
    'off_peak_data' => [
        'label'=> 'Off Peak Data',
        'placeholder' => 'e.g. 10',
        'validation' => [ 
            'max' => 'Off Peak Data exceeding max character length of 150'
        ]
    ],
    'peak_data' => [
        'label'=> 'Peak Data',
        'placeholder' => 'e.g. 10',
        'validation' => [ 
            'max' => 'Peak Data exceeding max character length of 150'
        ]
    ], 

    //Critical Information 
    'critical_information' => 'Critical Information',  
    'select_option' => [
        'label'=> 'Please select one option', 
        'validation' => [
            'required' => 'Please select either File or URL'
        ]
    ],
    'critical_info_file' => [
        'label'=> 'File', 
        'validation' => [
            'required' => 'Please choose a file to upload'
        ]
    ],
    'critical_info_url' => [
        'label'=> 'URL', 
        'placeholder' => 'e.g. http://www.google.com',
        'validation' => [
            'required' => 'Please provide URL',
            'url' => 'Please provide valid URL'

        ]
    ],

    //Remarketing Information '
    'remarketing_information' => 'Remarketing Information',  
    'remarketing_allow' => [
        'label'=> 'Remarketing Allow', 
        'validation' => [
            'required' => 'Please select either Yes or No'
        ]
    ],
    'remarketing_allow_yes' => [
        'label'=> 'Yes',  
    ],
    'remarketing_allow_no' => [
        'label'=> 'No',  
    ], 

    //Special Offer
    'special_offer' => 'Special Offer',
    'special_offer_status' => [
        'label'=> 'Special Offer Status',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please select either Show or Hide'
        ]
    ],
    'special_offer_status_show' => [
        'label'=> 'Show',  
    ],
    'special_offer_status_hide' => [
        'label'=> 'Hide',  
    ],
    'special_offer_cost_type' => [
        'label'=> 'Cost Type',
        'placeholder' => 'e.g. Monthly',
        'validation' => [
            'required' => 'Please select Plan Cost Type from dropdown'
        ]
    ], 
    'special_offer_price' => [
        'label'=> 'Special Offer Price',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Special Offer Price',
            'between' => 'Max Length Validation: Special Offer Price exceeding max character length of 9999999.99',
            'numeric' => 'Only numeric values allowed'
        ]
    ],
    'special_offer_script' => [
        'label'=> 'Special Offer', 
        'validation' => [
            'required' => 'Please enter some text for Special Offer',
            'max' => 'Max Length Validation: Special Offer exceeding max character length of 10000'
        ]
    ],  
    
    //Fees
    'plan_fees' => 'Plan Fees',
    'fees' => [
        'label'=> 'Fee Type',
        'placeholder' => 'e.g. Development Fee',
        'validation' => [
            'required' => 'Please select Fee Type from dropdown',
            'unique' => 'Fee Type already exists, please choose another Fee Type.'
        ]
    ], 
    'fees_cost_type' => [
        'label'=> 'Cost Type',
        'placeholder' => 'e.g. Monthly',
        'validation' => [
            'required' => 'Please select Cost Type from dropdown'
        ]
    ],
    'fees_amount' => [
        'label'=> 'Amount',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Amount',
            'numeric' => 'Amount should be numeric',
            'gt' => 'Amount should be greater than or equal 0'
        ]
    ], 
    'additional_info' => [
        'label' => 'Additional Info'
    ],

    'fees_action' => 'Action',
    'fees_remove' => 'Remove',
    'fees_add' => 'Add Fees',
    'fees_edit' => 'Edit Fees',

    //Home Plan Included
    'home_plan_included' => 'Home Plan Included',
    'calling_plan_status' => [
        'label'=> 'Calling Plan Status', 
        'validation' => [
            'required' => 'Please select either Show or Hide'
        ]
    ],
    'home_plan_included_name' => [
        'label'=> 'Name',
        'placeholder' => 'Select Home Connection',
        'validation' => [
            'required' => 'Please select Home Connection'
        ]
    ],
    'home_plan_included_is_mandatory' => [
        'label'=> 'Is Mandatory', 
        'validation' => ''
    ],

    //Modem Included
    'modem_included' => 'Modem Included',
    'include_modem_status' =>  [
        'label'=> 'Include Modem Status',
        'validation' => [
            'required' => 'Please select either Show or Hide'
        ]
    ],
    'included_modem' => [
        'label'=> 'Modem', 
        'placeholder' => 'Select Modem',
        'validation' => [
            'required' => 'Please select Modem'
        ]
    ],  
    'modem_cost_type' => [
        'label'=> 'Modem Cost Type',
        'placeholder' => 'e.g. Monthly',
        'validation' => [
            'required' => 'Please select Modem Cost Type'
        ]
    ],
    'modem_cost' => [
        'label'=> 'Modem Cost',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Modem Cost',
            'numeric' => 'Only numeric values allowed',
            'gt' => 'Length Validation: Modem Cost should be greater than or equal 0'
        ]
    ], 
    'modem_included_is_mandatory' => [
        'label'=> 'Is Mandatory', 
        'validation' => ''
    ], 

    //Other Addon Included
    'other_addon_included' => 'Other Addon Included',
    'include_other_addon_status' => [
        'label'=> 'Include Other Addon Status', 
        'validation' => [
            'required' => 'Please select either Show or Hide'
        ]
    ], 
    'other_addon' => [
        'label'=> 'Other Addon',
        'placeholder' => 'Select Addon',
        'validation' => [
            'required' => 'Please select Other Addon'
        ]
    ], 
    'other_addon_cost_type' => [
        'label'=> 'Other Addon Cost Type',
        'placeholder' => 'e.g. Monthly',
        'validation' => [
            'required' => 'Please select Other Addon Cost Type'
        ]
    ], 
    'other_addon_cost' => [
        'label'=> 'Other Addon Cost',
        'placeholder' => 'e.g. 10',
        'validation' => [
            'required' => 'Please provide Other Addon Cost',
            'numeric' => 'Only numeric values allowed',
            'gt' => 'Length Validation: Addon Cost should be greater than or equal 0'
        ]
    ],  

    //Addons
    'addons' => 'Addons',
    'phone_home_line_connection' => 'Phone Home Line Connection',
    'addon' => 'Additional Addon', 
    'modem' => 'Modem',  //common
    'addon_cost_type' => [ 
        'placeholder' => 'e.g. Monthly', 
    ],
    'addon_cost' => [ 
        'placeholder' => 'e.g. 10', 
    ], 

    //Terms & Conditions
    'terms_and_condition' => 'Terms & Conditions',
    'title' => 'Title',
    'action' => 'Action', //common

    //Acknowledgement Concent
    'acknowledgement_concent' => 'Acknowledgement Consent',
    'enable_plan_acknowledgement' => [
        'label'=> 'Enable Plan Acknowledgement', 
        'validation' => [
            'required' => 'Please select either Enable or Disable'
        ]
    ],
    'description' => [
        'label'=> 'Please enter some text for Acknowledgement Consent',
        'validation' => [
            'required' => 'Please enter some text for Description'
        ]
    ],
    'plan_acknowledgement_concent_checkboxes' => 'Plan Acknowledgement Consent Checkboxes',
    'sr_no' => 'Sr. No',
    'required' => 'Required',
    'content' => 'Content', //common
    'validation_message' => 'Validation Message', //common
    'save_checkbox_status_in_database' => 'Save Checkbox Status In Database',
    'edit' => 'Edit', //common
    'delete' => 'Delete', //common
    'add_checkbox' => 'Add Checkbox',
    'no_checkbox_found' => 'No checkbox found.',
    'no_plan_found' => 'No plan found.',

    //modal
    'term_form_title' => [
        'validation' => [
            'required' => 'Please specify Title',
            'max' => 'Max Length Validation: Title exceeding max character length of 255'
        ]
    ],
    'acknowledgement_checkbox' => 'Acknowledgement Checkbox',
    'checkbox_required' => [
        'label'=> 'Checkbox Required',
        'validation' => [
            'required' => 'Please select either Show or Hide'
        ]
    ],
    'ack_form_save_checkbox_status_in_database' => [
        'label'=> 'Save Checkbox Status in Database?',
        'validation' => [
            'required' => 'Please select either Yes or No'
        ]
    ],
    'ack_form_validation_message' => [
        'label' => 'Validation Message',
        'validation' => [
            'required' => 'Please enter some text for Validation Message',
            'max' => 'Max Length Validation: Validation Message exceeding max character length of 100'
        ]
    ],
    'ack_form_content' => [
        'label' => 'Content',
        'validation' => [
            'required' => 'Please enter some text for Content',
        ]
        ],
    'data_unit' => [
        'label' => 'Data Unit',
        'placeHolder' => 'Select',
        'validation' => [
            'required' => 'Please select Data Unit.',
        ]
    ]

];
