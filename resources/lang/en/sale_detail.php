<?php
return[
'invalid_sale' => 'This sale is invalid.',
'invalid_service' => 'This service is invalid.',
'stage'=>'Stage',
'source'=>'Source',
'completed'=>'Completed By',
'electricity_lead'=>'Electricity Lead Duplicate',
'electricity_sale'=>'Electricity sale Duplicate',
'gas_lead'=>'Gas Lead Duplicate',
'gas_sale'=>'Gas Sale Duplicate',
'sms'=>'SMS',
'email'=>'Email',
'gas_resale'=>'Gas Resale Allow',
'electricity_resale'=>'Electricity Resale Allow',
'utm_s'=>'UTM Source',
'utm_m'=>'UTM Medium',
'utm_c'=>'UTM Compaign',
'utm_t'=>'UTM Term',
'utm_cont'=>'UTM Content',
'gclid'=>'GClid',
'fbclid'=>'FBClid',
'electricity_details'=>'Electricity Details',
'gas_status'=>'Gas Status',
'electricity'=>'Electricity',
'gas'=>'Gas',
'provider_name'=>'Provider Name',
'name'=>'Plan Name',
'plan_desc'=>'Plan Desc',
'plan_code'=>'Plan Compaign Code',
'distributor'=>'Distributor',
'bundle_code'=>'Plan Bundle Code',
'manual_address'=>'Manual Connection Address',
'billing'=>'Billing Prefrences',
'connection_details'=>'Connection Details',
'customer_info'=>'Customer Info',
'add_info'=>'Additional Info',
'affiliate'=>'Affiliate',
'id_details'=>'Identification Details',
'customer_gas_note_required' => 'Gas note is required',
'customer_elec_note_required' => 'Electricity note is required',
'card_number_required' => 'Card Number is required',
'card_start_date_required' => 'Card Issue date is required',
'card_start_date_before' => 'Card Issue date must be less than expiry date',
'card_expiry_date_required' => 'Card Expiry date is required',
'card_expiry_date_after' => 'Card Expiry date must be greater than issue date',
'comment_max_validation' => 'Comment must be less than 500 characters',


'view' => [
    'customer' => [
        'customer_info' => [
            'title' => [
                'label' => 'Title',
                'placeHolder' => 'Select',
                'errors' => [
                    'required' => 'Please Select title.'
                ],
            ],
            'first_name' => [
                'label' => 'First Name',
                'placeHolder' => 'e.g. Ronald',
                'errors' => [
                    'required' => 'Please Enter First Name',
                    'max' => 'First Name exceeding max character length 50',
                ],
            ],
            'middle_name' => [
                'label' => 'Middle Name',
                'placeHolder' => 'e.g. Levis',
                'errors' => [
                    'required' => 'Please Enter Middle Name',
                    'max' => 'Middle Name exceeding max character length 50',
                ],
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeHolder' => 'e.g. Gordan',
                'errors' => [
                    'required' => 'Please Enter Last Name',
                    'max' => 'Last Name exceeding max character length 50',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'placeHolder' => 'e.g. steve.waugh@gmail.com',
                'errors' => [
                    'required' => 'Please Enter Email',
                    'email' => 'Please Enter Valid Email',
                ],
            ],
            'phone' => [
                'label' => 'Phone',
                'placeHolder' => 'e.g. 9887678765',
                'errors' => [
                    'required' => 'Please Enter Phone Number',
                    'numeric' => 'Only numeric values allowed.',
                    'digits_between' => 'Phone number must be between 8 to 12 digits.',
                ],
            ],
            'alternate_phone' => [
                'label' => 'Alternate Ph.',
                'placeHolder' => 'e.g. 9887235677',
                'errors' => [
                    'required' => 'Please Enter Alternate Phone Number',
                    'numeric' => 'Only numeric values allowed.',
                    'digits_between' => 'Phone number must be between 8 to 12 digits.',
                ],
            ],
            'dob' => [
                'label' => 'DOB',
                'placeHolder' => 'e.g. 14-03-1947',
                'errors' => [
                    'required' => 'Please Enter Date Of Birth',
                    'date' => 'Please enter valid Date format'
                ],
            ],
            'comment' => [
                'label' => 'Comment',
                'placeHolder' => 'e.g. Do the needful',
            ],
        ],
    ],
    'demand_details' => [
        'demand_tariff' => [
            'label' => 'Demand Tariff',
        ],
        'demand_usage_type' => [
            'label' => 'Demand Usage Type',
        ],
        'demand_tariff_code' => [
            'label' => 'Demand Tariff Code',
            'placeHolder' => 'Select',
        ],
        'demand_meter_type' => [
            'label' => 'Demand Meter Type',
        ],
        'demand_rate1_peak_usage' => [
            'placeHolder' => 'e.g. 30',
        ],
        'demand_rate1_off_peak_usage' => [
            'placeHolder' => 'e.g. 20',
        ],
        'demand_rate1_shoulder_usage' => [
            'placeHolder' => 'e.g. 5',
        ],
        'demand_rate1_days' => [
            'placeHolder' => 'e.g. 31',
        ],
    ],
],
]
?>