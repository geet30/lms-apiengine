<?php

return [

    //Phone Tab
    'phones' => [
        'phone_created' => 'Phone Added successfully',
        'phone_notcreated' => 'Phone not Added, Please Try Again Later',
    ],
    'formPage' => [
        'tabs' => [
            'basicDetails' => 'Basic Details',
            'specifications' => 'Specifications',
            'features' => 'Features',
            'more_info' => 'More Info',
        ],
        'basicDetails' => [
            'sectionTitle' => 'Basic Details',
            'submitButton' => 'Save Changes',
            'cancelButton' => 'Cancel',
            'phone_name' => [
                'label' => 'Display Name',
                'placeHolder' => 'e.g. Samsung Galaxy',
                'errors' => [
                    'required' => 'Please Enter Display Name.',
                    'max' => 'Name exceeding max character length of 100.'
                ],
            ],
            'phone_brand' => [
                'label' => 'Phone Brand',
                'placeHolder' => 'Select',
                'errors' => [
                    'required' => 'Please Select Phone Brand',
                ],
            ],
            'phone_model' => [
                'label' => 'Phone Model',
                'placeHolder' => 'e.g. Galaxy 10',
                'errors' => [
                    'required' => 'Please Enter Phone Model',
                ],
            ],
            'launch_details' => [
                'label' => 'Launch Details',
                'placeHolder' => 'e.g. This Christmas',
            ],
            'image' => [
                'label' => 'Image',
                'errors' => [
                    'required' => 'Please Add Image',
                ],
            ],
            'pre_order_allowed' => [
                'label' => 'Pre-Order Allowed',
            ],
            'why_this' => [
                'label' => 'Why this?',
                'placeHolder' => 'e.g. It is 7G',
            ],
            'other_info' => [
                'label' => 'Other Info',
                'placeHolder' => "e.g. Latest gorilla glass used in phone's screen",
            ],
        ],
        'specifications' => [
            'sectionTitle' => 'Specifications',
            'submitButton' => 'Save Changes',
            'cancelButton' => 'Cancel',
            'network' => [
                'subSectionTitle' => 'Network And Connectivity',
                'technology' => [
                    'label' => 'Technology',
                    'placeHolder' => 'e.g. 7G',
                    'errors' => [
                        'required' => "Please Enter Technology Name",
                        'max' => 'Technology exceeding max character length of 100.'
                    ]
                ],
                'network_manageability' => [
                    'label' => 'Network Manageability',
                    'placeHolder' => 'e.g. 7G',
                    'errors' => [
                        'required' => "Please Enter Network Manageability.",
                        'max' => 'Network Manageability exceeding max character length of 1000.'
                    ]
                ],
                'extra_technologies' => [
                    'label' => 'Extra Technologies',
                    'placeHolder' => 'e.g. 7G',
                    'errors' => [
                        'required' => "Please Enter Extra Technologies.",
                        'max' => 'Extra Technologies exceeding max character length of 1000.'
                    ]
                ]
            ],
            'body' => [
                'subSectionTitle' => 'Body',
                'dimensions' => [
                    'label' => 'Dimensions',
                    'placeHolder' => 'e.g. 6"8"',
                    'errors' => [
                        'required' => 'Please Enter Dimensions.',
                        'max' => 'Dimensions exceeding max character length of 100.'
                ],
                'weight' => [
                    'label' => 'Weight (g)',
                    'placeHolder' => 'e.g. 200',
                    'errors' => [
                        'required' => 'Please Enter Weight.',
                        'max' => 'Weight exceeding max character length of 100.'
                    ],
                ],
                'body_protection_build' => [
                    'label' => 'Body Protection Build',
                    'placeHolder' => 'e.g. Yes',
                ],
                'sim_compatibility' => [
                    'label' => 'SIM Compatibility',
                    'placeHolder' => 'e.g. 5G, 6G, 7G',
                    'errors' => [
                        'required' => 'Please Enter SIM Compatibility.',
                        'max' => 'SIM Compatibility exceeding max character length of 100.'
                    ],
                ],
                'card_slot' => [
                    'label' => 'Card Slot',
                ]
            ],
            'screen_display' => [
                'subSectionTitle' => 'Screen Display',
                'screen_type' => [
                    'label' => 'Screen Type',
                    'placeHolder' => 'e.g. Curved Edges',
                    'errors' => [
                        'required' => 'Please Enter Screen Type.',
                        'max' => 'Screen Display exceeding max character length of 100.'
                    ],
                ],
                'screen_size' => [
                    'label' => 'Screen Size',
                    'placeHolder' => 'e.g. 6"7"',
                    'errors' => [
                        'required' => 'Please Enter Screen Size.',
                        'max' => 'Screen Size exceeding max character length of 100.'
                    ],
                ],
                'screen_resolution' => [
                    'label' => 'Screen Resolution',
                    'placeHolder' => 'e.g. 1440 * 3040',
                    'errors' => [
                        'required' => 'Please Enter Screen Resolution',
                        'max' => 'Screen Resolution exceeding max character length of 100.'
                    ],
                ],
                'multitouch' => [
                    'label' => 'Multitouch',
                    'placeHolder' => 'e.g. Yes',
                ],
                'screen_protection' => [
                    'label' => 'Screen Protection',
                    'placeHolder' => 'e.g. Included Screen Protector',
                ],


            ],
            'operating_system' => [
                'subSectionTitle' => 'Operating System',
                'operating_system' => [
                    'label' => 'Operating System',
                    'placeHolder' => 'Select',
                    'errors' => [
                        'required' => 'Please Select Operating System.',
                    ],
                ],
                'version' => [
                    'label' => 'Version',
                    'placeHolder' => 'e.g. 12.0',
                    'errors' => [
                        'required' => 'Please Enter Version.',
                        'max' => 'Version exceeding max character length of 100.'
                    ],
                ],
                'chipset' => [
                    'label' => 'Chipset',
                    'placeHolder' => 'e.g. 2.73 GHz',
                    'errors' => [
                        'required' => 'Please Enter Chipset',
                        'max' => 'Chipset exceeding max character length of 100.'
                    ],
                ],
                'cpu' => [
                    'label' => 'CPU',
                    'placeHolder' => 'e.g. Dual Core',
                    'errors' => [
                        'required' => 'Please Enter CPU',
                    ],
                ],
            ],
        ],
        'feature' => [
            'sectionTitle' => 'Features & Box Details',
            'submitButton' => 'Save Changes',
            'cancelButton' => 'Cancel',
            'camera' => [
                'label' => 'Camera',
                'placeHolder' => 'e.g. 128 MP',
                'errors' => [
                    'required' => 'Please Enter Camera Details',
                    'max' => 'Camera exceeding max character length of 10000.'
                ],
            ],
            'sensor' => [
                'label' => 'Sensors',
                'placeHolder' => 'e.g. Retina',
                'errors' => [
                    'required' => 'Please Enter Sensors Details',
                    'max' => 'Sensors exceeding max character length of 10000.'
                ],
            ],
            'technical_specs' => [
                'label' => 'Technical Specs',
                'placeHolder' => 'e.g. 16 GB RAM',
                'errors' => [
                    'required' => 'Please Enter Technical Specifications',
                    'max' => 'Technical Specs exceeding max character length of 10000.'
                ],
            ],
            'battery_info' => [
                'label' => 'Battery Info',
                'placeHolder' => 'e.g. 5000 Mah',
                'errors' => [
                    'required' => 'Please Enter Battery Info',
                    'max' => 'Battery Info exceeding max character length of 10000.'
                ],
            ],
            'in_the_box' => [
                'label' => 'In The Box',
                'placeHolder' => 'e.g. Handset and Charger',
                'errors' => [
                    'required' => 'Please Enter Box Details',
                    'max' => 'Box Details exceeding max character length of 10000.'
                ],
            ],
        ],
        'more_info' => [
            'sectionTitle' => 'More Information',
            'addMoreInfoButton' => 'Add',
            'submitButton' => 'Save',
            'cancelButton' => 'Cancel',
            's_no' => [
                'label' => 'Sr No',
                'placeHolder' => 'Select Sr No',
                'errors' => [
                    'required' => 'Please Enter Sr No',
                ],
            ],
            'title' => [
                'label' => 'Title',
                'placeHolder' => 'e.g. Fast Charging',
                'errors' => [
                    'required' => 'Please Enter Title',
                ],
            ],
            'what_to_upload' => [
                'label' => 'Select Option',
                'errors' => [
                    'required' => 'Please Select option',
                ],
            ],
            'url' => [
                'label' => 'URL',
                'placeHolder' => 'e.g. https://www.google.com',
                'errors' => [
                    'required' => 'Please Enter URL',
                ],
            ],
            'file' => [
                'label' => 'File',
                'errors' => [
                    'required' => 'Please Upload a File',
                    'mimes' => 'File type accepted is Pdf'
                ],
            ],
        ],
    ],
    'indexPage' => [
        'warning_msg_title' => 'Are you sure?',
        'delete_msg_text' => 'You want to delete',
        'delete_success' => 'Handset has been deleted successfully.',
        'delete_error' => 'Handset cannot be deleted as it is assigned to some providers.',
        'yes_text' => 'Yes',
        'handset_status_changed' => 'Handset Status Updated Successfully.',
        'handset_status_change_error' => 'Handset status not updated. Please try again later.',
        'complete_handset_info_before' => 'This phone do not have all the required parameters to enable it, please verify.',
    ],
],
];
