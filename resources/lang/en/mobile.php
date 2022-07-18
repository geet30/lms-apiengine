<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Affiliates Language Lines
    |--------------------------------------------------------------------------
    |
    */
    'listPage' => [
        'filter' => 'Filter',
        'apply' => 'Apply',
        'addPlan' => 'Add Plan',
        'uploadPlan' => 'Upload Plan',
     
        'name_filter' => [
            'label' => 'Plan Name',
            'placeHolder' => 'Search Plan Name',
        ],
        'plan_type_filter' => [
            'label' => 'Plan Type',
            'placeHolder' => 'Select Plan Type',
        ],
        'connection_type_filter' => [
            'label' => 'Connection Type',
            'placeHolder' => 'Select Connection Type',
        ],
        'status_filter' => [
            'label' => 'Status',
            'placeHolder' => 'Select Status',
        ],
        'reset' => 'Reset',
        'applyFilter' => 'Apply Filter',

        'sNo' => 'Sr.No.',
        'planId' => 'Plan ID',
        'planName' => 'Plan Name',
        'connectionType' => 'Connection Type',
        'planType' => 'Plan Type',
        'status' => 'Status',
        'actions' => 'Actions',
        'editPlan' => 'Edit Plan',
        'deletePlan' => 'Delete Plan',
        'managePhone' => 'Manage Phone(s)',
    ],

    'formPage' => [

        'tabs' => [
            'basicDetails' => 'Plan View',
            'inclusions' => 'Plan Information',
            'fees' => 'Fees',
            'terms' => 'T&C',
            'otherInformation' => 'Other Information',
            'planReferences' => 'Plan References',
        ],
        'basicDetails' => [
            'sectionTitle' => 'Plan View',
            'submitButton' => 'Save Changes',
            'cancelButton' => 'Discard',
            'name' => [
                'label' => 'Plan Name',
                'placeHolder' => 'e.g. Unlimited Data',
                'errors' => [
                    'required' => 'Please specify Plan Name.',
                    'max' => 'Plan Name exceeding max character length of 100.',
                ],
            ],
            'connection_type' => [
                'label' => 'Connection Type',
                'placeHolder' => 'Select Connection Type',
                'errors' => [
                    'required' => 'Please select Connection Type.'
                ],
            ],
            'plan_type' => [
                'label' => 'Plan Type',
                'placeHolder' => 'Select Plan Type',
                'errors' => ['required' => 'Please select Plan Type.'],
            ],

            'business_size' => [
                'label' => 'Business Size',
                'placeHolder' => 'Select Business Size',
                'errors' => ['required' => 'Please select Business Size.'],
            ],

            'bdm_available' => [
                'label' => 'BDM Plans (To Contact BDM)',
                'yes' => 'Yes',
                'no' => 'No',
                'errors' => ['required' => 'Please select BDM Plans (To Contact BDM).'],
            ],

            'bdm_contact_number' => [
                'label' => 'BDM Contact Number',
                'placeHolder' => 'Enter BDM Contact Number',
                'errors' => ['required' => 'Please specify BDM Contact Number.'],
            ],


            'bdm_details' => [
                'label' => 'BDM Contact Pop up Content',
                'placeHolder' => 'Enter BDM Contact Pop up Content',
                'errors' => ['required' => 'Please specify BDM Contact Pop up Content.'],
            ],
            'cost_type_id' => [
                'label' => 'Plan Cost Type',
                'placeHolder' => 'Enter Plan Cost Type',
                'errors' => ['required' => 'Please select Plan Cost Type.'],
            ],
            'cost' => [
                'label' => 'Plan Monthly Cost',
                'placeHolder' => 'e.g. 100',
                'errors' => [
                    'required' => 'Please provide Plan Cost (In AUD).',
                    'numeric' => 'Only numeric values allowed.',
                    'gt' => 'Only positive values allowed.',
                    // 'between' => 'Plan Cost exceeding max character length of 99999.99.',
                    'min' => 'Plan Cost should be greater than 0.',
                    'max' => 'Plan Cost exceeding max value 99999.99.',
                ],
            ],
            'plan_data' => [
                'label' => 'Data per Month',
                'placeHolder' => 'e.g. 100 or Unlimited',
                'errors' => [
                    'required' => 'Please provide Data Per Month.',
                    'numeric' => 'Only numeric values allowed.',
                    'gt' => 'Only positive values allowed.',
                    'min' => 'Plan Data should be greater than 0.',
                    'max' => 'Plan Data exceeding max value 1023.',
                ],
            ],
            'plan_data_unit' => [
                'label' => 'Plan Data Unit',
                'placeHolder' => 'Select Plan Data Unit',
                'errors' => ['required' => 'Please select Plan Data Unit.'],
            ],
            'network_host' => [
                'label' => 'Network Host',
                'placeHolder' => 'Select Network Host',
                'errors' => ['required' => 'Please select Network Host.'],
            ],
            'network_host_information' => [
                'label' => 'Network Host Information',
                'placeHolder' => 'e.g. Network Host Description',
                'errors' => [
                    'required' => 'Please enter some text for Network Host Information.',
                    'max' => 'Network Host Information exceeding max character length of 10000.',
                ],
            ],
            'network_type' => [
                'label' => 'Network Type',
                'placeHolder' => 'Select Network Type',
                'errors' => ['required' => 'Please select Network Type.'],
            ],
            'contract_id' => [
                'label' => 'Plan Duration',
                'placeHolder' => 'Select Plan Duration',
                'errors' => ['required' => 'Please select Plan Duration.'],
            ],
            'activation_date_time' => [
                'label' => 'Plan Activation Date',
                'placeHolder' => 'e.g. '. now(),
                'errors' => [
                    'required' => 'Please select Plan Activation Date.',
                    'after' => 'Activation Date and Time must be greater than current date and time.'
                ],
            ],
            'deactivation_date_time' => [
                'label' => 'Plan Deactivation Date',
                'placeHolder' => 'e.g. '. now()->addDays(365),
                'errors' => [
                    'required' => 'Please enter plan deactivation date',
                    'date' => 'Please select valid date',
                    'after' => 'Deactivation Date and Time should be greater than Activation Date and Time.',
                ],
            ],

            'billing_preference' => [
                'label' => 'Override Billing Preferences ',
                'email' => 'Email',
                'post' => 'Post',
                'both' => 'Both',
                'errors' => [
                    'required' => 'Please select Override Billing Preferences',
                ],
            ],
            'sim_type' => [
                'label' => 'Plan Compatible',
                'esim' => 'E-sim',
                'phy' => 'Physical',
                'both' => 'Both',
                'errors' => [
                    'required' => 'Please select Sim Type',
                ],
            ],

            'inclusion' => [
                'label' => 'Plan Inclusion',
                'placeHolder' => 'e.g. All SMS & Calls within Australia',
                'errors' => [
                    'required' => 'Please enter some text for Plan Inclusion.',
                    'max' => ' exceeding max character length of 10000.',
                ],
            ],
        ],
        
            'permissions_authorizations' => [
                'sectionTitle' => 'Plan Permissions',
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
                'override_permission' => [
                    'label' => 'Override Provider Permission',
                    'enable' => 'Enable',
                    'disable' => 'Disable',
                    'errors' => ['required' => 'Please select either Enable or Disable.'],
                ],
                'new_connection_allowed' => [
                    'label' => 'New Connection Allowed',
                    'yes' => 'Yes',
                    'no' => 'No',
                    'errors' => ['required' => 'Please select either Yes or No.'],
                ],

                'port_allowed' => [
                    'label' => 'Port In Allowed',
                    'yes' => 'Yes',
                    'no' => 'No',
                    'errors' => ['required' => 'Please select either Yes or No.'],
                ],

                'retention_allowed' => [
                    'label' => 'Recontract',
                    'yes' => 'Yes',
                    'no' => 'No',
                    'errors' => ['required' => 'Please select either Yes or No.'],
                ],
            ],
            'amazing_extra_facilities' => [
                'sectionTitle' => 'Amazing Extra Facilities',
                'placeHolder' => 'e.g. All SMS & Calls within Australia',

                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
            ],

            'nationalInclusion' => [
                'sectionTitle' => 'National Inclusion',
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
                'national_voice_calls' => [
                    'label' => 'Voice Calls ',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter voice calls.',
                        'max' => 'Voice Calls exceeding max character length of 100.',
                    ]
                ],
                'details' => [
                    'label' => 'Plan Details',
                    'placeHolder' => 'e.g. Plan Details',
                    'errors' => [
                        'required' => 'Please Enter Plan Details.',
                        'max' => 'Plan Deatils exceeding max character length of 100.',
                    ]
                ],
                'national_video_calls' => [
                    'label' => 'Video Calls',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter Video calls.',
                        'max' => 'Video Calls exceeding max character length of 100.',
                    ]
                ],
                'national_text' => [
                    'label' => 'SMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter SMS.',
                        'max' => 'SMS exceeding max character length of 100.',
                    ]
                ],
                'national_mms' => [
                    'label' => 'MMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter MMS.',
                        'max' => 'MMS exceeding max character length of 100.',
                    ]
                ],
                'national_directory_assist' => [
                    'label' => 'Directory Assistance',
                    'placeHolder' => 'e.g. 123',
                    'errors' => [
                        'required' => 'Please enter Directory Assistance.',
                        'max' => 'National Directory Assistance exceeding max character length of 100.',
                    ]
                ],
                'national_diversion' => [
                    'label' => 'National Diversion',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter National Diversion.',
                        'max' => 'National National Diversion exceeding max character length of 100.',
                    ]
                ],
                'national_call_forwarding' => [
                    'label' => 'Call Forwarding',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter Call Forwarding.',
                        'max' => 'National Call Forwarding exceeding max character length of 100.',
                    ]
                ],
                'national_voicemail_deposits' => [
                    'label' => 'Voicemail Deposits and Retrivals',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter voice calls.',
                        'max' => 'National Voicemail Deposits and Retrivals exceeding max character length of 100.',
                    ]
                ],
                'national_toll_free_numbers' => [
                    'label' => 'Toll Free Number(s)',
                    'placeHolder' => 'Select Tollfree Number(s)',
                    'errors' => [
                        'required' => 'Please select Tollfree Number(s).',
                        'max' => 'National Tollfree Number(s) exceeding max character length of 100.',
                    ]
                ],
                'national_internet_data' => [
                    'label' => 'Internet Data',
                    'placeHolder' => 'e.g. $0.60/ GB',
                    'errors' => [
                        'required' => 'Please enter Internet Data.',
                        'max' => 'National Internet Data exceeding max character length of 10000.',
                    ]
                ],
                'national_special_features' => [
                    'label' => 'Special Features',
                    'placeHolder' => 'e.g. 100 GB high speed data',
                    'errors' => [
                        'required' => 'Please enter Special Features.',
                        'max' => 'National Special Features exceeding max character length of 10000.',
                    ]
                ],
                'national_additonal_info' => [
                    'label' => 'Additional Information',
                    'placeHolder' => 'e.g. Add upto 5 GB extra',
                    'errors' => [
                        'required' => 'Please enter Additional Information.',
                        'max' => 'National Additional Information exceeding max character length of 10000.',
                    ]
                ]
            ],
            'planInformation' => [
                'sectionTitle' => 'Plan Information',
                'planDetail' => [
                    'label' => 'Plan Detail',
                     
                ],
                'extraFacilities' => [
                    'label' => 'Extra Facilities'
                ],
                'validations' => [
                    'plan_details_required' => 'Please Enter Plan Details',
                    'plan_details_max' => 'Plan Details exceeding max character length 10000.',
                    'plan_extra_facilities_required' => 'Please Enter Extra Facilities',
                    'plan_extra_facilities_max' => 'Extra Facilities exceeding max character length 10000.',
                ],
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard'
            ],

            'internationalInclusion' => [
                'sectionTitle' => 'International Inclusion',
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
                'international_voice_calls' => [
                    'label' => 'Voice Calls ',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter voice calls.',
                        'max' => 'International Voice Calls exceeding max character length of 100.',
                    ]
                ],
                'international_video_calls' => [
                    'label' => 'Video Calls',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter Video Calls.',
                        'max' => 'International Video Calls exceeding max character length of 100.',
                    ]
                ],
                'international_text' => [
                    'label' => 'SMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter SMS.',
                        'max' => 'International SMS exceeding max character length of 100.',
                    ]
                ],
                'international_mms' => [
                    'label' => 'MMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter MMS.',
                        'max' => 'International MMS exceeding max character length of 100.',
                    ]
                ],
                'international_diversion' => [
                    'label' => 'International Diversion',
                    'placeHolder' => 'e.g. Included or $1/min',
                    'errors' => [
                        'required' => 'Please enter International Diversion.',
                        'max' => 'International Diversion exceeding max character length of 100.',
                    ]
                ],
                'international_roaming' => [
                    'label' => 'International Roaming',
                    'placeHolder' => 'e.g. Included or $10/min',
                    'errors' => [
                        'required' => 'Please enter International Roaming.',
                        'max' => 'International Roaming exceeding max character length of 100.',
                    ]
                ],
                'international_additonal_info' => [
                    'label' => 'Additional Information',
                    'placeHolder' => 'e.g. Add upto 5 GB extra',
                    'errors' => [
                        'required' => 'Please enter Additional Information.',
                        'max' => 'International Additional Information exceeding max character length of 10000.',
                    ]
                ],
            ],

            'roamingInclusion' => [
                'sectionTitle' => 'Roaming Inclusion',
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
                'roaming_charge' => [
                    'label' => 'Roaming Charge',
                    'placeHolder' => 'e.g. $1.50/min',
                    'errors' => [
                        'required' => 'Please enter Charge.',
                        'max' => 'Roaming Charge exceeding max character length of 100.',
                    ]
                ],
                'roaming_voice_incoming' => [
                    'label' => 'Voice Calls Incoming',
                    'placeHolder' => 'e.g. Included or $1/min',
                    'errors' => [
                        'required' => 'Please enter Voice Calls Incoming.',
                        'max' => 'Roaming Voice Calls Incoming exceeding max character length of 100.',
                    ]
                ],
                'roaming_voice_outgoing' => [
                    'label' => 'Voice Call Outgoing',
                    'placeHolder' => 'e.g. Included or $1/min',
                    'errors' => [
                        'required' => 'Please enter Voice Call Outgoing.',
                        'max' => 'Roaming Voice Call Outgoing exceeding max character length of 100.',
                    ]
                ],
                'roaming_video_calls' => [
                    'label' => 'Video Calls',
                    'placeHolder' => 'e.g. Included or $1/min',
                    'errors' => [
                        'required' => 'Please enter Video Calls.',
                        'max' => 'Roaming Video Calls exceeding max character length of 100.',
                    ]
                ],
                'roaming_text' => [
                    'label' => 'SMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter SMS.',
                        'max' => 'Roaming SMS exceeding max character length of 100.',
                    ]
                ],
                'roaming_mms' => [
                    'label' => 'MMS',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter MMS.',
                        'max' => 'Roaming MMS exceeding max character length of 100.',
                    ]
                ],
                'roaming_voicemail_deposits' => [
                    'label' => 'Voicemail Deposits and Retrivals',
                    'placeHolder' => 'e.g. Included',
                    'errors' => [
                        'required' => 'Please enter Voicemail Deposits and Retrivals.',
                        'max' => 'Roaming Voicemail Deposits and Retrivals exceeding max character length of 100.',
                    ]
                ],
                'roaming_internet_data' => [
                    'label' => 'Internet Data',
                    'placeHolder' => 'e.g. $0.60/ GB',
                    'errors' => [
                        'required' => 'Please enter Internet Data.',
                        'max' => 'Roaming Internet Data exceeding max character length of 10000.',
                    ]
                ],
                'roaming_additonal_info' => [
                    'label' => 'Additional Information',
                    'placeHolder' => 'e.g. Add upto 5 GB extra',
                    'errors' => [
                        'required' => 'Please enter Additional Information.',
                        'max' => 'Roaming Additional Information exceeding max character length of 10000.',
                    ]
                ]
            ],

            'fees' => [
                'sectionTitle' => 'Fees',
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard',
                'cancellation_fee' => [
                    'label' => 'Termination Fees',
                    'placeHolder' => 'e.g. 10',
                    'errors' => [
                        'required' => 'Please enter Termination Fees.',
                        'max' => 'Termination Fees Charge exceeding max character length of 10000.',
                    ]
                ],
                'lease_phone_return_fee' => [
                    'label' => 'Lease Phone Return Fees',
                    'placeHolder' => 'e.g. 5',
                    'errors' => [
                        'required' => 'Please enter Lease Phone Return Fees.',
                        'max' => 'Lease Phone Return Fees Charge exceeding max character length of 10000.',
                    ]
                ],
                'activation_fee' => [
                    'label' => 'Setup/Activation Fees',
                    'placeHolder' => 'e.g. 1',
                    'errors' => [
                        'required' => 'Please enter Setup/Activation Fees.',
                        'max' => 'Setup/Activation Fees exceeding max character length of 10000.',
                    ]
                ],
                'late_payment_fee' => [
                    'label' => 'Late Payment Fees',
                    'placeHolder' => 'e.g. 1',
                    'errors' => [
                        'required' => 'Please enter Late Payment Fees.',
                        'max' => 'Late Payment Fees exceeding max character length of 10000.',
                    ]
                ],
                'delivery_fee' => [
                    'label' => 'Delivery Fees',
                    'placeHolder' => 'e.g. 1',
                    'errors' => [
                        'required' => 'Please enter Delivery Fees.',
                        'max' => 'Delivery Fees exceeding max character length of 10000.',
                    ]
                ],
                'express_delivery_fee' => [
                    'label' => 'Express Delivery Fees',
                    'placeHolder' => 'e.g. 1',
                    'errors' => [
                        'required' => 'Please enter Express Delivery Fees.',
                        'max' => 'Express Delivery Fees exceeding max character length of 10000.',
                    ]
                ],
                'paper_invoice_fee' => [
                    'label' => 'Paper Invoice Fees',
                    'placeHolder' => 'e.g. 3.5',
                    'errors' => [
                        'required' => 'Please enter Paper Invoice Fees.',
                        'max' => 'Paper Invoice Fees exceeding max character length of 10000.',
                    ]
                ],
                'payment_processing_fee' => [
                    'label' => 'Payment Processing Fees',
                    'placeHolder' => 'e.g. 1.5',
                    'errors' => [
                        'required' => 'Please enter Payment Processing Fees.',
                        'max' => 'Payment Processing Fees exceeding max character length of 10000.',
                    ]
                ],
                'card_payment_fee' => [
                    'label' => 'Card Payment Fees',
                    'placeHolder' => 'e.g. 0.5',
                    'errors' => [
                        'required' => 'Please enter Card Payment Fees.',
                        'max' => 'Card Payment Fees exceeding max character length of 10000.',
                    ]
                ],
                'minimum_total_cost' => [
                    'label' => 'Minimum Total Cost',
                    'placeHolder' => 'e.g. 80',
                    'errors' => [
                        'required' => 'Please enter Minimum Total Cost.',
                        'max' => 'Minimum Total Cost exceeding max character length of 10000.',
                    ]
                ],
                'other_fee_charges' => [
                    'label' => 'Other Fees & Charges',
                    'placeHolder' => 'e.g. No Other Fee',
                    'errors' => [
                        'required' => 'Please enter Other Fees & Charges.',
                        'max' => 'Other Fees & Charges exceeding max character length of 10000.',
                    ]
                ],

            ],

            'tnc' => [
                'sectionTitle' => 'Terms & Conditions',
                'edit' => 'Edit',
                'tncModalTitle' => 'Terms & Conditions',
                'modalCancelButton' => 'Discard',
                'modalSubmitButton' => 'Save Changes',
                'term_title_content' => [
                    'label' => 'Title',
                    'placeHolder' => 'e.g. Cimet Terms and Conditions',
                    'errors' => ['required' => 'Please specify Title.'],
                ],
                'term_content' => [
                    'label' => 'Content',
                    'placeHolder' => 'e.g. This plan required no other fee',
                    'errors' => ['required' => 'Please specify content.'],
                ],
            ],

            'other_info' => [
                'sectionTitle' => 'Other Information',
                'submitButton' => 'Submit',
                'cancelButton' => 'Discard',
                'deleteButton' => 'Delete',
                'addButton' => 'Add',

                'other_info_field' => [
                    'label' => 'Field Name',
                    'placeHolder' => 'e.g. Additional Charges',
                    'errors' => 'Please enter field name.',
                ],
                'other_info_desc' => [
                    'label' => 'Field Description',
                    'placeHolder' => 'e.g. Additional Information Description',
                    'errors' => 'Please enter field description.',
                ],
            ],

            'planRef' => [
                'sectionTitle' => 'Plan Reference',
                'addButton' => 'Add Reference',
                'modal' => [
                    'modalTitle' => 'Plan Reference',
                    'cancelButton' => 'Discard',
                    'submitButton' => 'Submit',
                    's_no' => [
                        'label' => 'S no.',
                        'placeHolder' => 'S No.',
                        'errors' => ['required' => 'Please enter S No.'],
                    ],
                    'title' => [
                        'label' => 'Title',
                        'placeHolder' => 'e.g. Cimet Reference',
                        'errors' => ['required' => 'Please specify Title.'],
                    ],
                    'linktype' => [
                        'label' => 'Select Option ',
                        'url' => 'URL',
                        'file' => 'File',
                        'errors' => ['required' => 'Please select one option'],
                    ],
                    'url' => [
                        'label' => 'URL',
                        'placeHolder' => 'e.g. https://www.cimet.com.au/',
                        'errors' => ['required' => 'Please specify URL.'],
                    ],
                    'file' => [
                        'label' => 'File',
                        'placeHolder' => 'Select File',
                        'errors' => ['required' => 'Please select the file to upload.'],
                    ],
                ],
                'sr_no' => 'Sr. No.',
                'sNo' => 'Order No.',
                'title' => 'Title',
                'url' => 'URL',
                'actions' => 'Actions',
                'edit' => 'Edit',
                'delete' => 'Delete',
            ],
            'specialOffer' =>[
                'sectionTitle' => 'Special Offer',
                'status' => [
                    'label' => 'Status',
                    'enableRadioLabel' => 'Enable',
                    'disableRadioLabel' => 'Disable'
                ],
                'specialOfferTitle' =>[
                    'label' => 'Special Offer Title',
                    'placeHolder' => 'e.g. 50% discount'
                ],
                'specialOfferCost' =>[
                    'label' => 'Special Offer Cost',
                    'placeHolder' => 'e.g. 10'
                ],
                'specialOfferDescription' =>[
                    'label' => 'Special Offer Description',
                    'placeHolder' => 'e.g. 50% discount on plan cost'
                
                ],
                'validations' =>[ 
                    'special_offer_status_required' => 'Special offer status is required',
                    'special_offer_title_required' => 'Please specify Special Offer Title.',
                    'special_offer_title_max_length' => 'Special Offer Title exceeding max value 100',
                    'special_offer_cost_required' => 'Please specify Special Offer Cost.',
                    'special_offer_description_required' => 'Please enter some text for special offer description.',
                    'special_offer_cost_numeric' => 'Only numeric values allowed.',
                    'special_offer_cost_gt' => 'Only positive values allowed.',
                    'special_offer_cost_min' => 'Special Offer Cost should be greater than 0',
                    'special_offer_cost_max' => 'Special Offer Cost exceeding max value 999.'
                ],
                'submitButton' => 'Save Changes',
                'cancelButton' => 'Discard'
            ]
        
    ]
];
