<?php

namespace App\Traits\Provider\AGL;

use App\Traits\Provider\AGL\Headings;
use App\Models\{Providers, SaleStatusHistoryEnergy};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SaleProductsEnergy;

trait Schema
{
    function AGLSchema($data, $providerLead)
    {
        
        try {
            $providerData = [];
            $leadIds = [];
            $key_array = [];
            $submit_data_inc = 0;
            $resubmit_data_inc = 0;
            $reference_key_array = [];

            $sheetArray[] = array(
                'VENDOR',                //A
                'VENDOR_BP',            //B
                'CHANNEL',                //C
                'BATCH_NUMBER',            //D
                'TRANSACTION_TYPE',        //E
                'LEAD_ID',                   //F
                'RESUBMISSION_COUNT',    //G
                'RESUBMISSION_COMMENT',    //H
                'TITLE',                //I
                'NAME_FIRST',            //J
                'NAME_MIDDLE',            //J
                'NAME_LAST',            //K
                'DOB',                    //L
                'BUILDING_NAME',        //M
                'FLOOR',                //N
                'LOT_NUMBER',            //O
                'UNIT_NUMBER',            //P
                'STREET_NUMBER',        //Q
                'STREET_NAME',            //R
                'SUBURB',                //S
                'STATE',                //T
                'POSTCODE',                //U
                'PHONE_HOME',            //V
                'PHONE_WORK',            //W
                'PHONE_MOBILE',            //X
                'EMAIL',                //Y
                'MARKETING',            //Z
                'ECONF_PACK_CONSENT',    //AA
                'ECOMM_CONSENT',        //AB
                'PRIMARY_SMS_CONSENT',    //AC
                'CREDIT_CONSENT',        //AD
                'AP_TITLE',                //AE
                'AP_FIRST_NAME',        //AF
                'AP_MIDDLE_NAME',        //AG
                'AP_LAST_NAME',            //AH
                'AP_PHONE_HOME',        //AI
                'AP_PHONE_WORK',        //AJ
                'AP_PHONE_MOBILE',        //AK
                'AP_DOB',                //AL
                'AP_DRIVERS_LICENSE',    //AM
                'BUSINESS_NAME',        //AN
                'LEGAL_NAME',            //AO
                'ABN_ACN',                //AP
                'BUSINESS_TYPE',        //AQ
                'MAILING_BUILDING_NAME', //AR
                'MAILING_FLOOR',        //AS
                'MAILING_LOT_NUMBER',    //AT
                'MAILING_UNIT_NUMBER',    //AU
                'MAILING_STREET_NUMBER', //AV
                'MAILING_STREET_NAME',    //AW
                'MAILING_SUBURB',        //AX
                'MAILING_STATE',        //AY
                'MAILING_POSTCODE',        //AZ
                'CONCESSION_TYPE',        //BB
                'CONCESSION_NUMBER',    //BC
                'VALID_TO',                //BD
                'DRIVERS_LICENSE',        //BE
                'PASSPORT',                //BF
                'MEDICARE_NUMBER',        //BG
                'LIFE_SUPPORT',            //BH
                'DD_REQ',                //BI
                'NMI',                    //BJ
                'DPI_MIRN',                //BK
                'METER_NUMBER_E',        //BL
                'METER_NUMBER_G',        //BM
                'METER_TYPE',            //BN
                'METER_HAZARD_E',        //BO
                'DOG_CODE_G',            //BP
                'SITE_ACCESS_E',        //BQ
                'SITE_ACCESS_G',        //BR
                'RE_EN_REMOTE_SAFETY_CONFIRMATION', //BS
                'DE_EN_REMOTE_SAFETY_CONFIRMATION', //BT
                'SO_REQ',                //BU
                'RETAILER',                //BV
                'PROGRAM',                //BW
                'CAMPAIGN',                //BX
                'SALES_DATE',            //BY
                'CONTRACT_NUMBER',        //BZ
                'OFFER_TYPE',            //CA
                'PRODUCT_CODE_E',        //CB
                'PRODUCT_CODE_G',        //CC
                'CAMPAIGN_CODE_RES_ELEC',    //CD
                'CAMPAIGN_CODE_RES_GAS',    //CE
                'CAMPAIGN_CODE_SME_ELEC',    //CF
                'CAMPAIGN_CODE_SME_GAS',    //CG
                'MATRIX_CODE',            //CH
                'TARIFF_TYPE',            //CI
                'FLEX_PRICE',            //CJ
                'REFERRER_NUMBER',        //CK
                'FLYBUYS_CONSENT',        //CL
                'FLYBUYS_NUMBER',        //CM
                'FLYBUYS_POINTS',        //CN
                'AEO_REG',                //CO
                'OWN_RENT',                //CP
                'PROMOTION_CODE',        //CQ
                'MERCH_REQ',            //CR
                'AGL_ASSIST',            //CS
                'GAS_OFFER',            //CT
                'ELEC_OFFER',            //CU
                'MOVEIN_DATE_E',        //CV
                'MOVEIN_DATE_G',        //CW
                'MOVEIN_INSTRUCT_E',    //CX
                'MOVEIN_INSTRUCT_G',    //CY
                'MOVEOUT_DATE_E',        //CZ
                'MOVEOUT_DATE_G',        //DA
                'MOVEOUT_INSTRUCT_E',    //DB
                'MOVEOUT_INSTRUCT_G',    //DC
                'GREENSALE',            //DD
                'AARH_DONATION',        //DE
                'EPFS_REQ',                //DF
                'SALES_AGENT',            //DG
                'EXISTING_GAS_BP_NUMBER',    //DH
                'EXISTING_ELEC_BP_NUMBER',    //DI
                'EXISTING_CRN_NUMBER',    //DJ
                'CANCELLATION_DATE',    //DK
                'CANCELLATION_TYPE',    //DL
                'CANCELLATION_REASON',    //DM
                'CANCELLATION_REASON_OTHER',    //DN
                'QUOTE_DATE',            //DO
                'QUOTE_TYPE',            //DP
                'CHANGE_REQUEST',        //DQ
                'CHANGE_REQUEST_DATE',    //DR
                'COMMENTS'                //DS
            );
            $providerLead['mailType'] = 'test';
            $dual_data = $data;
            $data = $data->toArray();
            $refrence_column = array_column($data, 'sale_product_reference_no', 'l_lead_id');
            foreach ($data as $exports) {
                $sale_status = $exports->spe_sale_status;
                if (empty($exports->spe_sale_status)) {
                    $exports->spe_sale_status = 4;
                }
                $lead_ids[$exports->spe_sale_status][] = $exports->l_lead_id;
                array_push($leadIds, $exports->l_lead_id);
                if (!in_array($exports->spe_sale_status . '_' . $exports->sale_product_reference_no, $key_array)) {
                    if (in_array($exports->sale_product_reference_no, $refrence_column)) {
                        $key_array[] = $exports->spe_sale_status . '_' . $exports->sale_product_reference_no;
                        if ($exports->spe_sale_status == '4') {
                            $reference_key_array[$exports->sale_product_reference_no] = $submit_data_inc;
                            $submit_data_inc++;
                        }
                        if ($exports->spe_sale_status == '12') {
                            $reference_key_array[$exports->sale_product_reference_no] = $resubmit_data_inc;
                            $resubmit_data_inc++;
                        }
                        // if ($mail_type == "test") {
                        //     $reference_key_array[$exports['reference_no']] = $send_schema;
                        //     $send_schema++;
                        // }
                    }


                    // start code here
                    $VENDOR = 'CMT';
                    $VENDOR_BP = '130580989';
                    $CHANNEL = 'BROKER';
                    $TRANSACTION_TYPE  = '';
                    if (empty($exports->vie_qa_notes_created_date)) {
                        $date_one = Carbon::parse($exports->l_sale_created)->format('d/m/Y');
                        $other_sale_date = Carbon::createFromFormat('d/m/Y', $date_one);
                    } else {
                        $other_sale_date = Carbon::createFromFormat('d/m/Y', $exports->vie_qa_notes_created_date);
                    }
                    if ((isset($exports) && $exports->journey_solar_panel  == 0 && ($exports->journey_moving_house  == 0))) {
                        //core sale
                        // if ($mail_type == "test") {
                        //     if ($sale_status == 4) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     } elseif ($sale_status == 12) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     }
                        // } else {
                        if ($exports->spe_sale_status == 4) {
                            $TRANSACTION_TYPE = 'SALE';
                        } elseif ($exports->spe_sale_status == 12) {
                            $TRANSACTION_TYPE = 'SALE';
                        }
                        // }
                        
                    } elseif ((isset($exports)  && $exports->journey_moving_house  == 1 )) {
                      
                        //move in sale
                        // if ($mail_type == "test") {
                        //     if ($sale_status == 4) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     } elseif ($sale_status == 12) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     }
                        // } else {
                        if ($exports->spe_sale_status == 4) {
                            $TRANSACTION_TYPE = 'SALE';
                        } elseif ($exports->spe_sale_status == 12) {
                            $TRANSACTION_TYPE = 'SALE';
                        }
                        //  }
                    } elseif ((isset($exports)  && $exports->journey_moving_house /*&& Carbon::createFromFormat('d/m/Y', $exports->journey_moving_date) == Carbon::parse($other_sale_date)*/)) {
                       
                        // if ($mail_type == "test") {
                        //     if ($sale_status == 4) {
                        //         $TRANSACTION_TYPE = 'SDFI';
                        //     } elseif ($sale_status == 12) {
                        //         $TRANSACTION_TYPE = 'SDFI';
                        //     }
                        // } else {
                        if ($exports->spe_sale_status == 4) {
                            $TRANSACTION_TYPE = 'SDFI';
                        } elseif ($exports->spe_sale_status == 12) {
                            $TRANSACTION_TYPE = 'SDFI';
                        }
                        //}

                        # code...
                    } elseif ((isset($exports) && $exports->journey_moving_house == 0)) {
                        //solar cor sale
                        // if ($mail_type == "test") {
                        //     if ($sale_status == 4) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     } elseif ($sale_status == 12) {
                        //         $TRANSACTION_TYPE = 'SALE';
                        //     }
                        // } else {
                        if ($exports->spe_sale_status == 4) {
                            $TRANSACTION_TYPE = 'SALE';
                        } elseif ($exports->spe_sale_status == 12) {
                            $TRANSACTION_TYPE = 'SALE';
                        }
                        //}
                    }
                    $LEAD_ID = 'CMT' . $exports->sale_product_reference_no;
                    $RESUBMISSION_COUNT = SaleStatusHistoryEnergy::where(['sale_product_id' => $exports->sale_product_id, 'status' => 12])->count();
                    if ((!$RESUBMISSION_COUNT)) {
                        $RESUBMISSION_COUNT = '0';
                    }
                    $RESUBMISSION_COMMENT = isset(($exports->vie_retailers_resubmission_comment)) ? $exports->vie_retailers_resubmission_comment : '';
                    $TITLE = $exports->vis_title;
                    $NAME_FIRST =  decryptGdprData($exports->vis_first_name);
                    $NAME_MIDDLE = isset($exports->vis_middle_name) ? decryptGdprData($exports->vis_middle_name) : '';
                    $NAME_LAST = decryptGdprData($exports->vis_last_name);
                    
                    $newdate = \Carbon\Carbon::parse($exports->vis_dob);
                   
                    $DOB  = $newdate->format('d.m.Y');
                    $BUILDING_NAME = $exports->va_property_name;
                    $FLOOR = $exports->va_floor_no;
                    $LOT_NUMBER = $exports->va_lot_number;
                    $UNIT_NUMBER = $exports->va_unit_number;
                    $STREET_NUMBER = $exports->va_street_number;
                    $STREET_NAME = $exports->va_street_name;
                    $SUBURB = $exports->va_suburb;
                    $STATE = $exports->va_state;
                    $POSTCODE = $exports->va_postcode;
                    $PHONE_HOME     = "";
                    $PHONE_WORK     = "";
                    $PHONE_MOBILE     = $exports->vis_visitor_phone;
                    $EMAIL             = decryptGdprData($exports->vis_email);
                    $MARKETING         = 'N';
                    $ECONF_PACK_CONSENT = 'N';
                    $ECOMM_CONSENT = '';
                    /* PHONE_HOME */
                    if (isset($exports->vis_alternate_phone) && !empty($exports->vis_alternate_phone)) {
                        if (substr($exports->vis_alternate_phone, 0, 2) === "04") {
                            $PHONE_HOME = "";
                        } else {
                            $PHONE_HOME = $exports->vis_alternate_phone;
                        }
                    }

                    /*PHONE WORK*/
                    if ($exports->journey_property_type == 1) {
                        if (isset($exports->vis_alternate_phone) && !empty($exports->vis_alternate_phone)) {
                            if (substr($exports->vis_alternate_phone, 0, 2) === "04") {
                                $PHONE_WORK = "";
                            } else {
                                $PHONE_WORK = $exports->vis_alternate_phone;
                            }
                        }
                    } else {
                        if (isset($exports->vbd_customer_work_contact) && !empty($exports->vbd_customer_work_contact)) {
                            if (substr($exports->vbd_customer_work_contact, 0, 2) === "04") {
                                $PHONE_WORK = "";
                            } else {
                                $PHONE_WORK = $exports->vbd_customer_work_contact;
                            }
                        }
                    }
                   
                    $arr = array(
                        'Access' => 'ACCS',    'Acre' => 'ACRE',    'Alley' => 'ALLY',    'Alleyway' => 'ALWY',    'Amble' => 'AMBL',    'Anchorage' => 'ANCG', 'Approach' => 'APP',    'Arcade' => 'ARC',    'Artery' => 'ARTY',    'Arterial' => 'ARTL',    'Avenue' => 'AVE',    'Bank' => 'BANK',    'Basin' => 'BASN',    'Bay' => 'BAY',    'Beach' => 'BCH',    'Bridge' => 'BDGE',    'Broadway' => 'BDWY',    'Bende' => 'BEND',    'Blank' => 'BLK',    'Bowl' => 'BOWL',    'Brace' => 'BRCE',    'Brae' => 'BRAE',    'Branch' => 'BRAN',    'Brett' => 'BRET',    'Break' => 'BRK',    'Brow' => 'BROW',    'Boulevard' => 'BVD',    'Boulevarde' => 'BVDE',    'Boardwalk' => 'BWLK',
                        'Bypass' => 'BYPA',    'Byway' => 'BYWY',    'Causeway' => 'CSWY',    'Circuit' => 'CCT',    'Cul-De-Sac' => 'CSAC',    'Chase' => 'CH',
                        'Circle' => 'CIR',    'Close' => 'CL',    'Colonnade' => 'CLDE',    'Cluster' => 'CLR',    'Circlet' => 'CLT',    'Common' => 'CMMN',
                        'Concord' => 'CNCD',    'Connection' => 'CNTN',    'Corner' => 'CNR',    'Centreway' => 'CNWY',    'Concourse' => 'CON',    'Cove' => 'COVE',    'Crossway' => 'COWY',    'Copse' => 'CPS',    'Crescent' => 'CRES',    'Cicrcus' => 'CRCS',    'Crossroad' => 'CRD',    'Crief' => 'CRF',    'Crook' => 'CRK',    'Course' => 'CRSE',    'Crossing' => 'CRSG',    'Cross' => 'CRSS',    'Crest' => 'CRST',    'Corso' => 'CSO',    'Court' => 'CT',    'Centre' => 'CTR',    'Cutting' => 'CUTT',    'Courtyard' => 'CTYD',
                        'Cut' => 'CUT',    'Cruiseway' => 'CUWY',    'Dale' => 'DALE',    'Dash' => 'DASH',    'Deviation' => 'DEVN',    'Dell' => 'DELL',
                        'Dene' => 'DENE',    'Dip' => 'DIP',    'Divide' => 'DIV',    'Dock' => 'DOCK',    'Domain' => 'DOM',    'Down' => 'DOWN',
                        'Drive' => 'DR',    'Driveway' => 'DVWY',    'Distributor' => 'DSTR',    'Downs' => 'DWNS',    'Edge' => 'EDGE',
                        'Elbow' => 'ELB',    'End' => 'END',    'Entrance' => 'ENT',    'Easement' => 'ESMT',    'Esplanade' => 'ESP',    'Estate' => 'EST',    'Expressway' => 'EXP',    'Extension' => 'EXTN',    'Fairway' => 'FAWY',    'Firebreak' => 'FBRK',    'Firetrail' => 'FITR',
                        'Fork' => 'FORK',    'Flat' => 'FLAT',    'Fireline' => 'FLNE',    'Flats' => 'FLTS',    'Follow' => 'FOLW',    'Ford' => 'FORD',
                        'Formation' => 'FORM',    'Front' => 'FRNT', 'Frontage' => 'FRTG',    'Foreshore' => 'FSHR',    'Fire Track' => 'FTRK',    'Footway' => 'FTWY',    'Freeway' => 'FWY',    'Gap' => 'GAP',    'Garden' => 'GDN',    'Gardens' => 'GDNS',    'Glade' => 'GLDE',    'Glen' => 'GLEN',    'Gully' => 'GLY',    'Grove' => 'GR',    'Grange' => 'GRA',    'Green' => 'GRN',    'Ground' => 'GRND',    'Gate' => 'GTE',    'Gates' => 'GTES',    'Gateway' => 'GWY',    'Heath' => 'HTH',    'Hill' => 'HILL',    'Highroad' => 'HRD',
                        'Hollow' => 'HLLW',    'Harbour' => 'HRBR',    'Heights' => 'HTS',    'Hub' => 'HUB',    'Haven' => 'HVN',    'Highway' => 'HWY',
                        'Island' => 'ISLD',    'Inlet' => 'INLT',    'Interchange' => 'INTG',    'Intersection' => 'INTN',    'Junction' => 'JNC',
                        'Key' => 'KEY',    'Keys' => 'KEYS',    'Knoll' => 'KNOL',    'Ladder' => 'LADR',    'Lane' => 'LANE',    'Landing' => 'LDG',
                        'Lead' => 'LEAD',    'Leader' => 'LEDR',    'Lees' => 'LEES',    'Line' => 'LINE',    'Link' => 'LINK',    'Lookout' => 'LKT',
                        'Laneway' => 'LNWY',    'Loop' => 'LOOP',    'Little' => 'LT',    'Lower' => 'LWR',    'Lynne' => 'LYNN',    'Mall' => 'MALL',
                        'Manor' => 'MNR',    'Mart' => 'MART',    'Mead' => 'MEAD',    'Mew' => 'MEW', 'Mews' => 'MEWS',    'Mile' => 'MILE',    'Meander' => 'MNDR',    'Mount' => 'MT',    'Motorway' => 'MWY',    'Nook' => 'NOOK',    'North' => 'NTH',    'Null' => 'NULL',
                        'Outlook' => 'OTLK',    'Outlet' => 'OTLT',    'Oval' => 'OVAL',    'Park' => 'PARK',    'Part' => 'PART',    'Pass' => 'PASS',
                        'Path' => 'PATH',    'Parade' => 'PDE',    'Pathway' => 'PWAY',    'Piazza' => 'PIAZ',    'Parklands' => 'PKLD',
                        'Pocket' => 'PKT',    'Parkway' => 'PWY',    'Place' => 'PL',    'Plateau' => 'PLAT',    'Palms' => 'PLMS',    'Plaza' => 'PLZA',
                        'Point' => 'PNT',    'Port' => 'PORT',    'Paradise' => 'PRDS',    'Precinct' => 'PREC',    'Promenade' => 'PROM',    'Pursuit' => 'PRST',    'Passage' => 'PSGE',    'Peninsula' => 'PSLA',    'Quadrangle' => 'QDGL',    'Quadrant' => 'QDRT',
                        'Quad' => 'QUAD',    'Quay' => 'QY',    'Quays' => 'QYS',    'Ramp' => 'RAMP',    'Reach' => 'RCH',    'Road' => 'RD',    'Ridge' => 'RDGE',    'Roads' => 'RDS',    'Roadside' => 'RDSD',    'Roadway' => 'RDWY',    'Reef' => 'REEF',    'Reserve' => 'RES',    'Rest' => 'REST',    'Ridgeway' => 'RGWY',    'Ride' => 'RIDE',    'Ring' => 'RING',    'Rise' => 'RISE',    'Ramble' => 'RMBL',
                        'Round' => 'RND',    'Ronde' => 'RNDE',    'Range' => 'RNGE',    'Right Of Way' => 'ROWY',    'Row' => 'ROW',    'Rowe' => 'ROWE',
                        'Rosebowl' => 'RSBL',    'Rising' => 'RSNG',    'Route' => 'RTE',    'Return' => 'RTRN',    'Retreat' => 'RTT',    'Rotary' => 'RTY',
                        'Rue' => 'RUE',    'Run' => 'RUN',    'River' => 'RVR',    'Riviera' => 'RVRA',    'Riverway' => 'RVWY',    'Subway' => 'SBWY',    'Siding' => 'SDNG',    'Shunt' => 'SHUN',    'State Highway' => 'SHWY',    'Skyline' => 'SKLN',    'Slope' => 'SLPE',
                        'Sound' => 'SND',    'Spur' => 'SPUR',    'Square' => 'SQ',    'Street' => 'ST',    'Strait' => 'STAI',    'South' => 'STH',
                        'Steps' => 'STPS',    'Strand' => 'STRA',    'Strip' => 'STRP',    'Stairs' => 'STRS',    'Straight' => 'STRT',    'Serviceway' => 'SVWY',    'Service Way' => 'SWY',    'Tarn' => 'TARN',    'Terrace' => 'TCE',    'Thoroughfare' => 'THOR',    'Throughway' => 'THRU',
                        'Trunkway' => 'TKWY',    'Tollway' => 'TLWY',    'Tramway' => 'TWAY',    'Top' => 'TOP',    'Tor' => 'TOR',    'Triangle' => 'TRI',
                        'Track' => 'TRK',    'Trail' => 'TRL',    'Trailer' => 'TRLR',    'Tunnel' => 'TUNL',    'Turn' => 'TURN',    'Traverse' => 'TVSE',    'Towers' => 'TWRS',    'Underpass' => 'UPAS',    'Upper' => 'UPR',    'Vale' => 'VALE',    'Viaduct' => 'VIAD',    'Views' => 'VWS',    'Village' => 'VLGE',    'Villa' => 'VLLS',    'Valley' => 'VLLY',    'Vista' => 'VSTA',    'Vue' => 'VUE',
                        'Wade' => 'WADE',    'Walk' => 'WALK',    'Way' => 'WAY',    'Wood' => 'WOOD',    'Woods' => 'WDS',    'Wharf' => 'WHRF',
                        'Walkway' => 'WKWY',    'Waters' => 'WTRS',    'Waterway' => 'WWAY',    'Wynd' => 'WYND',    'Yard' => 'YARD'
                    );
                   
                    $street_type_val =  array_search($exports->va_street_code, $arr);
                    $STREET_NAME = $STREET_NAME . ' ' . $street_type_val;

                    if ($exports->l_billing_preference == 1) {
                        $ECOMM_CONSENT = 'Y';
                        if ($exports->l_email_welcome_pack == 0) {
                            $ECONF_PACK_CONSENT = 'Y';
                        } elseif ($exports->l_email_welcome_pack == 1) {
                            $ECONF_PACK_CONSENT = 'N';
                        }
                    } elseif ($exports->l_billing_preference == 2 || $exports->l_billing_preference == 3) {

                        $ECOMM_CONSENT = 'N';
                        $ECONF_PACK_CONSENT = 'N';
                    }

                    $PRIMARY_SMS_CONSENT = 'Y';
                    $CREDIT_CONSENT = 'Y';
                    $AP_TITLE = '';
                    $AP_FIRST_NAME = '';
                    $AP_MIDDLE_NAME = '';
                    $AP_LAST_NAME = '';
                    $AP_PHONE_HOME = '';
                    $AP_PHONE_MOBILE = '';
                    $AP_DOB = '';
                    $AP_DRIVERS_LICENSE = '';
                    $BUSINESS_NAME = '';
                    $LEGAL_NAME = '';
                    $ABN_ACN = '';
                    $BUSINESS_TYPE = '';
                    $AP_PHONE_WORK = '';
                    $VALID_TO = '';
                    $DOG_CODE_G = '';
                    $MERCH_REQ = '';
                   
                    if ($exports->journey_property_type == 2) {
                        $AP_TITLE = $exports->vis_title;
                        $AP_FIRST_NAME =  $exports->vis_first_name;

                        $AP_LAST_NAME = decryptGdprData($exports->vis_last_name);
                        $AP_PHONE_HOME =  isset($exports->vis_alternate_phone) ? decryptGdprData($exports->vis_alternate_phone) : '';
                        $AP_PHONE_WORK =
                            isset($exports->vis_alternate_phone) ? decryptGdprData($exports->vis_alternate_phone) : '';;
                        $AP_PHONE_MOBILE  =  $exports->vis_visitor_phone;
                        
                        $AP_DOBnewdate = \Carbon\Carbon::parse($exports->vis_dob);
                        
                        $AP_DOB  = $AP_DOBnewdate->format('d.m.Y');

                        if (isset($exports->vi_identity_type) && $exports->vi_identity_type == 'Drivers Licence') {
                            $AP_DRIVERS_LICENSE = $exports->vi_licence_number;
                        }

                        $BUSINESS_NAME = (isset($exports->vbd_business_legal_name)) ? $exports->vbd_business_legal_name : '';
                        $LEGAL_NAME = (isset($exports->vbd_business_legal_name)) ? $exports->vbd_business_legal_name : '';
                        $ABN_ACN = (isset($exports->vbd_business_abn)) ? $exports->vbd_business_abn : '';
                        $BUSINESS_TYPE = (isset($exports->vbd_business_company_type)) ? $exports->vbd_business_company_type : '';
                    }
                   
                    $MAILING_BUILDING_NAME = '';
                    $MAILING_FLOOR = '';
                    $MAILING_LOT_NUMBER = '';
                    $MAILING_UNIT_NUMBER = '';
                    $MAILING_STREET_NUMBER = '';
                    $MAILING_STREET_NAME = '';
                    $MAILING_SUBURB = '';
                    $MAILING_STATE = '';
                    $MAILING_POSTCODE = '';

                    if ($exports->is_po_box == 1) {
                        $MAILING_BUILDING_NAME = '';
                        $MAILING_FLOOR = '';
                        $MAILING_LOT_NUMBER = '';
                        $MAILING_UNIT_NUMBER = '';
                        $MAILING_STREET_NUMBER = (isset($exports->vpa_address)) ? $exports->vpa_address : '';
                        $MAILING_STREET_NAME = '';
                        $MAILING_SUBURB = (isset($exports->vpa_suburb)) ? $exports->vpa_suburb : '';
                        $MAILING_STATE = (isset($exports->vpa_state)) ? $exports->vpa_state : '';
                        $MAILING_POSTCODE = (isset($exports->vpa_postcode)) ? $exports->vpa_postcode : '';
                    } else {

                        if (isset($exports->l_billing_preference) && $exports->l_billing_preference == 3) {

                            $MAILING_BUILDING_NAME = $exports->vba_property_name;
                            $MAILING_FLOOR = $exports->vba_floor_no;
                            $MAILING_LOT_NUMBER = $exports->vba_lot_number;
                            $MAILING_UNIT_NUMBER = $exports->vba_unit_number;
                            $MAILING_STREET_NUMBER = $exports->vba_street_number;
                            $MAILING_STREET_NAME = $exports->vba_street_name;
                            $MAILING_SUBURB = $exports->vba_suburb;
                            $MAILING_STATE = $exports->vba_state;
                            $MAILING_POSTCODE = $exports->vba_postcode;
                            $street_type_val =  array_search($exports->vba_street_code, $arr);
                            $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                        } else {
                            $MAILING_BUILDING_NAME = $exports->va_property_name;
                            $MAILING_FLOOR = $exports->va_floor_no;
                            $MAILING_LOT_NUMBER = $exports->va_lot_number;
                            $MAILING_UNIT_NUMBER = $exports->va_unit_number;
                            $MAILING_STREET_NUMBER = $exports->va_street_number;
                            $MAILING_STREET_NAME = $exports->va_street_name;
                            $MAILING_SUBURB = $exports->va_suburb;
                            $MAILING_STATE = $exports->va_state;
                            $MAILING_POSTCODE = $exports->va_postcode;
                            $street_type_val =  array_search($exports->va_street_code, $arr);
                            $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                        }

                        if (isset($exports->l_billing_preference) &&  $exports->l_billing_preference == 1) {
                            if ($exports->l_email_welcome_pack == 1) {
                                $MAILING_BUILDING_NAME = $exports->vba_property_name;
                                $MAILING_FLOOR = $exports->vba_floor_no;
                                $MAILING_LOT_NUMBER = $exports->vba_lot_number;
                                $MAILING_UNIT_NUMBER = $exports->vba_unit_number;
                                $MAILING_STREET_NUMBER = $exports->vba_street_number;
                                $MAILING_STREET_NAME = $exports->vba_street_name;
                                $MAILING_SUBURB = $exports->vba_suburb;
                                $MAILING_STATE = $exports->vba_state;
                                $MAILING_POSTCODE = $exports->va_postcode;
                                $street_type_val =  array_search($exports->va_street_code, $arr);
                                $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;
                            } else {
                                $MAILING_BUILDING_NAME =  $exports->va_property_name;
                                $MAILING_FLOOR =   $exports->va_floor_no;
                                $MAILING_LOT_NUMBER =  $exports->va_lot_number;
                                $MAILING_UNIT_NUMBER =  $exports->va_unit_number;
                                $MAILING_STREET_NUMBER =  $exports->va_street_number;
                                $MAILING_STREET_NAME =  $exports->va_street_name;
                                $MAILING_SUBURB =  $exports->va_suburb;
                                $MAILING_STATE =  $exports->va_state;
                                $MAILING_POSTCODE  =  $exports->va_postcode;
                                $street_type_val =  array_search($exports->va_street_code, $arr);
                                $MAILING_STREET_NAME = $MAILING_STREET_NAME . ' ' . $street_type_val;;
                            }
                        }
                    }
                    $CONCESSION_TYPE = '';
                    $CONCESSION_NUMBER = '';

                    if ($exports->journey_property_type == 2 || (isset($exports->vcd_concession_type) &&  $exports->vcd_concession_type == 'Not Applicable')) {
                        $CONCESSION_TYPE = '';
                        $CONCESSION_NUMBER = '';
                        $VALID_TO  = '';
                    }
                    
                   
                    //elseif(isset($exports['visitor_consession_detail']['concession_type']))
                    //{
                    if ($exports->vcd_concession_type == 'Commonwealth Senior Health Card') {
                        $CONCESSION_TYPE = 'COM_SENIOR';
                    } elseif ($exports->vcd_concession_type == 'Centrelink Healthcare Card') {
                        $CONCESSION_TYPE = 'HEALTHCARE';
                    } elseif ($exports->vcd_concession_type == 'Pensioner Concession Card') {
                        $CONCESSION_TYPE = 'PENSIONER';
                    } elseif ($exports->vcd_concession_type == 'Queensland Government Seniors Card') {
                        $CONCESSION_TYPE = 'QSC_GOV';
                    } elseif ($exports->vcd_concession_type == 'DVA Gold Card(Extreme Disablement Adjustment)') {
                        $CONCESSION_TYPE = 'GOLD_EDA';
                    } elseif ($exports->vcd_concession_type == 'DVA Gold Card(TPI)') {
                        $CONCESSION_TYPE = 'GOLD_TPI';
                    } elseif ($exports->vcd_concession_type == 'DVA Gold Card(War Widow)') {
                        $CONCESSION_TYPE = 'GOLD_WW';
                    } else {
                        $CONCESSION_TYPE = '';
                    }
                    $CONCESSION_NUMBER = $exports->vcd_card_number;
                    if (isset($exports->vcd_card_expiry_date) && $exports->vcd_card_expiry_date != '') {
                        //$VALID_TOdate = \Carbon\Carbon::createFromFormat('d/m/Y', $exports->vcd_card_expiry_date);
                        $VALID_TOdate = Carbon::parse($exports->vcd_card_expiry_date);
                        $VALID_TO = $VALID_TOdate->format('d.m.Y');
                    }
                    

                    //}
                    
                    $DRIVERS_LICENSE = '';
                    $PASSPORT = '';
                    $MEDICARE_NUMBER = '';
                    if (isset($exports->vi_identification_type) && $exports->vi_identification_type == 'Drivers Licence') {

                        $DRIVERS_LICENSE = $exports->vi_licence_number;
                    }
                    if (isset($exports->vi_identification_type) && $exports->vi_identification_type == 'Passport') {

                        $PASSPORT = $exports->vi_passport_number;
                    }

                    if (isset($exports->vi_identification_type) && $exports->vi_identification_type == 'Foreign Passport') {

                        $PASSPORT = $exports->vi_foreign_passport_number;
                    }

                    if (isset($exports->vi_identification_type) && $exports->vi_identification_type == 'Medicare Card') {

                        $MEDICARE_NUMBER  = $exports->vi_medicare_number . $exports->vi_reference_number;
                    }

                    $LIFE_SUPPORT = '';
                    $GREENSALE = '';
                    $elec = false;
                    $gas = false;
                    $current_provider = $exports->journey_current_provider_id;
                    //for single sale
                    if ($exports->journey_is_dual != 0) {
                        //     DB::table('sale_checkbox_statuses')->select('module_type')->where('sale_id', $sale_id)->whereIn('energy_type', $checkEnergyType)->where('status', 1)->where('module_type', 7)->first();
                        $energy_type = 'gas';
                        if ($exports->sale_product_product_type == 1) {
                            $energy_type = 'electricity';
                        }
                        $saleCheckBoxs = DB::table('sale_checkbox_statuses')->select('module_type', 'status')->where('sale_id', $exports->l_lead_id)->where('energy_type', $energy_type)->where('module_type', 7)->first();
                        if ($exports->sale_product_product_type == 1) {

                            if ($exports->journey_life_support == 1) {
                                $LIFE_SUPPORT = 'E';
                            } else {
                                $LIFE_SUPPORT = 'N';
                            }

                            if ($saleCheckBoxs) {
                                //if ($saleCheckBoxs['status'] == 1) {
                                if ($exports->journey_property_type == 1) {
                                    $GREENSALE = 'CNRE1';
                                } else {
                                    $GREENSALE = 'CNBE1';
                                }
                                // } else {
                                //     $GREENSALE = 'CNNO';
                                // }
                            } else {
                                $GREENSALE = '';
                            }
                        } elseif ($exports->sale_product_product_type == 2) {
                            if ($exports->journey_life_support == 1) {
                                $LIFE_SUPPORT = 'G';
                            } else {
                                $LIFE_SUPPORT = 'N';
                            }

                            if ($saleCheckBoxs) {
                                // if ($saleCheckBoxs['status'] == 1) {
                                if ($exports->sale_product_product_type == 1) {
                                    $GREENSALE = 'CNRG1';
                                } else {
                                    $GREENSALE = 'CNBG1';
                                }
                                // } else {
                                //     $GREENSALE = 'CNNO';
                                // }
                            } else {
                                $GREENSALE = '';
                            }
                        }
                    }
                    //for dual sale

                    elseif ($exports->journey_is_dual == 1) {

                        $leads = SaleProductsEnergy::where('lead_id', $exports->l_lead_id)->get();
                        $elec_sale_checkbox =  DB::table('sale_checkbox_statuses')->select('energy_type', 'module_type', 'status')->where('sale_id', $exports->l_lead_id)->where('energy_type', 'electricity')->where('module_type', 7)->first();
                        $gas_sale_checkbox =  DB::table('sale_checkbox_statuses')->select('energy_type', 'module_type', 'status')->where('sale_id', $exports->l_lead_id)->where('energy_type', 'gas')->where('module_type', 7)->first();

                        if (($leads[0]->product_type == 1 && $leads[0]->current_provider == env('agl_id')) || $leads[0]->energy_type == 'electricity' && $leads[0]->current_provider == env('tango_id')) {
                            if ($exports['medical_equipment'] == 'yes' && isset($leads[0]->medical_equipment_energytype) && $leads[0]->medical_equipment_energytype == 1) {
                                $elec = true;
                            }
                        }
                        if (isset($leads[1]->energy_type) && isset($leads[1]->current_provider)) {
                            if (isset($leads[1]->energy_type) && $leads[1]->energy_type == 'gas' && $leads[1]->current_provider && $leads[1]->current_provider == env('agl_id') || $leads[1]->energy_type == 'gas' && $leads[1]->current_provider == env('tango_id')) {
                                if ($exports['medical_equipment'] == 'yes' && isset($leads[1]->medical_equipment_energytype) && $leads[1]->medical_equipment_energytype == 1) {
                                    $gas = true;
                                }
                            }
                        }

                        if ($leads[0]->current_provider == $leads[1]->current_provider) {

                            if (!empty($elec_sale_checkbox) && !empty($gas_sale_checkbox)) {
                                if ($elec_sale_checkbox['status'] == 1 && $gas_sale_checkbox['status'] == 1) {
                                    if ($exports->journey_property_type == 'residential') {
                                        $GREENSALE = 'CNRE1-CNRG1';
                                    } else {
                                        $GREENSALE = 'CNBE1-CNBG1';
                                    }
                                } elseif ($elec_sale_checkbox['status'] == 1 && $gas_sale_checkbox['status'] == 0) {
                                    if ($exports->journey_property_type == 'residential') {
                                        $GREENSALE = 'CNRE1-CNNO';
                                    } else {
                                        $GREENSALE = 'CNBE1-CNNO';
                                    }
                                } elseif ($elec_sale_checkbox['status'] == 0 && $gas_sale_checkbox['status'] == 1) {
                                    if ($exports->journey_property_type == 'residential') {
                                        $GREENSALE = 'CNNO-CNRG1';
                                    } else {
                                        $GREENSALE = 'CNNO-CNBG1';
                                    }
                                } else {
                                    $GREENSALE = 'CNNO-CNNO';
                                }
                            } elseif (!empty($elec_sale_checkbox) && empty($gas_sale_checkbox)) {
                                if ($elec_sale_checkbox['status'] == 1) {
                                    if ($exports->journey_property_type == 'residential') {
                                        $GREENSALE = 'CNRE1-CNNO';
                                    } else {
                                        $GREENSALE = 'CNBE1-CNNO';
                                    }
                                } else {
                                    $GREENSALE = 'CNNO-CNNO';
                                }
                            } elseif (empty($elec_sale_checkbox) && !empty($gas_sale_checkbox)) {
                                if ($gas_sale_checkbox['status'] == 1) {
                                    if ($exports->journey_property_type == 1) {
                                        $GREENSALE = 'CNNO-CNRG1';
                                    } else {
                                        $GREENSALE = 'CNNO-CNBG1';
                                    }
                                } else {
                                    $GREENSALE = 'CNNO-CNNO';
                                }
                            } else {
                                $GREENSALE = '';
                            }
                        } else {
                            if ($leads[0]->current_provider != $leads[1]->current_provider) {
                                /*Code for GREENSALE*/
                                if ($exports['energy_type'] == "electricity") {
                                    if ($elec_sale_checkbox) {
                                        if ($elec_sale_checkbox['status'] == 1) {
                                            if ($exports->journey_property_type == 'residential') {
                                                $GREENSALE = 'CNRE1';
                                            } else {
                                                $GREENSALE = 'CNBE1';
                                            }
                                        } else {
                                            $GREENSALE = 'CNNO';
                                        }
                                    } else {
                                        $GREENSALE = '';
                                    }
                                } else {
                                    if ($gas_sale_checkbox) {
                                        if ($gas_sale_checkbox['status'] == 1) {
                                            if ($exports->journey_property_type == 1) {
                                                $GREENSALE = 'CNRG1';
                                            } else {
                                                $GREENSALE = 'CNBG1';
                                            }
                                        } else {
                                            $GREENSALE = 'CNNO';
                                        }
                                    } else {
                                        $GREENSALE = '';
                                    }
                                }
                            }
                        }

                        //$LIFE_SUPPORT = 'D';

                        if ($elec == true && $gas == true) {
                            $LIFE_SUPPORT = 'D';
                        } elseif ($elec == true && $gas == false) {
                            $LIFE_SUPPORT = 'E';
                        } elseif ($elec == false && $gas == true) {
                            $LIFE_SUPPORT = 'G';
                        } else {
                            $LIFE_SUPPORT = 'N';
                        }
                    }
                    $DD_REQ = 'N';
                    $NMI = '';
                    $DPI_MIRN = '';
                    $METER_NUMBER_E = '';
                    $METER_NUMBER_G = '';
                    $METER_TYPE  = '';
                    $PRODUCT_CODE_E  = '';
                    $PRODUCT_CODE_G = '';
                    $CAMPAIGN_CODE_RES_ELEC = '';
                    $CAMPAIGN_CODE_RES_GAS  = '';
                    $CAMPAIGN_CODE_SME_ELEC = '';
                    $CAMPAIGN_CODE_SME_GAS = '';
                    
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 1) {
                        $NMI = $exports->vie_nmi_number;

                        if (!empty($exports->plan_product_code) && $exports->plan_product_code != 'N/A') {
                            $PRODUCT_CODE_E = $exports->plan_product_code;
                        } else {
                            $PRODUCT_CODE_E = '';
                        }
                        if (!empty($exports->vie_meter_number_e) && $exports->vie_meter_number_e != 'N/A') {
                            $METER_NUMBER_E = $exports->vie_meter_number_e;
                        } else {
                            $METER_NUMBER_E = '';
                        }
                        if ($exports->journey_property_type == 1) {
                            $CAMPAIGN_CODE_RES_ELEC = $exports->plan_plan_campaign_code;
                        } else {
                            $CAMPAIGN_CODE_SME_ELEC = $exports->plan_plan_campaign_code;
                        }
                    }

                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type != 1) {
                        $DPI_MIRN  = $exports->vie_dpi_mirn_number;

                        if (!empty($exports->plan_product_code) && $exports->plan_product_code != 'N/A') {
                            $PRODUCT_CODE_G = $exports->plan_product_code;
                        } else {
                            $PRODUCT_CODE_G = '';
                        }

                        if (!empty($exports->vie_meter_number_g) && $exports->vie_meter_number_g != 'N/A') {
                            $METER_NUMBER_G = $exports->vie_meter_number_g;
                        } else {
                            $METER_NUMBER_G = '';
                        }
                        if ($exports->journey_property_type == 1) {
                            $CAMPAIGN_CODE_RES_GAS  = $exports->plan_plan_campaign_code;
                        } else {
                            $CAMPAIGN_CODE_SME_GAS = $exports->plan_plan_campaign_code;
                        }
                    }
                    

                    $METER_HAZARD_E  = $exports->vie_meter_hazard;
                    $DOG_CODE_G = $exports->vie_dog_code;
                    $SITE_ACCESS_E = $exports->vie_site_access_electricity;
                    $SITE_ACCESS_G = $exports->vie_site_access_gas;
                    $RE_EN_REMOTE_SAFETY_CONFIRMATION = 'Y';
                    $DE_EN_REMOTE_SAFETY_CONFIRMATION = '';
                    $SO_REQ  = '';

                    // set retailer name
                    $OFFER_TYPE = 'TBA';
                    //if ($mail_content['sale_original_source'] == 'agl') {
                    $RETAILER = 'AGL';
                    // } else {
                    //  $RETAILER = 'PD';
                    //}

                    $PROGRAM = '';

                    if ($exports->journey_property_type == 2) {
                        $PROGRAM = 'BUS';
                    } else {
                        $PROGRAM = 'RES';
                    }
                   
                    $CAMPAIGN = 'TBA';
                    $SALES_DATE  = $other_sale_date->format('d.m.Y');
                    $CONTRACT_NUMBER = '';
                    $OFFER_TYPE = '';
                    $MATRIX_CODE = '';
                    $TARIFF_TYPE = $exports->ebd_tariff_type;
                    $FLEX_PRICE = '';
                    $REFERRER_NUMBER = '';
                    $FLYBUYS_CONSENT = 'N';
                    $FLYBUYS_NUMBER = '';
                    $FLYBUYS_POINTS = '';
                    if (isset($exports->l_billing_preference) && $exports->l_billing_preference == 1) {
                        $AEO_REG = 'Y';
                    } else {
                        $AEO_REG = 'N';
                    }
                   
                    $OWN_RENT = '';
                    $PROMOTION_CODE = '';
                    $AGL_ASSIST = '';
                    $GAS_OFFER = '';

                    if ($exports->sale_product_product_type == 2) {
                        if (isset($exports->plan_promotion_code) && !empty($exports->plan_promotion_code)) {
                            $GAS_OFFER = $exports->plan_promotion_code;
                        }
                    }
                    $ELEC_OFFER = '';
                    if ($exports->sale_product_product_type == 1) {
                        if (isset($exports->sale_product_product_type) && !empty($exports->sale_product_product_type)) {
                            $ELEC_OFFER = $exports->sale_product_product_type;
                        }
                    }

                    $MOVEIN_DATE_E = '';
                    $MOVEIN_DATE_G = '';
                    $MOVEIN_INSTRUCT_E  = '';
                    $MOVEIN_INSTRUCT_G = '';
                    $MOVEOUT_DATE_E = '';
                    $MOVEOUT_DATE_G  = '';
                    $MOVEOUT_INSTRUCT_E  = '';
                    $MOVEOUT_INSTRUCT_G  = '';
                    //$GREENSALE = '';
                    $AARH_DONATION = '';
                    $EPFS_REQ = '';
                    $SALES_AGENT = 'ONLINE';
                    $EXISTING_GAS_BP_NUMBER  = '';
                    $EXISTING_ELEC_BP_NUMBER  = '';
                    $EXISTING_CRN_NUMBER = '';
                    $CANCELLATION_DATE  = '';
                    $CANCELLATION_TYPE = '';
                    $CANCELLATION_REASON = '';
                    $CANCELLATION_REASON_OTHER = '';
                    $QUOTE_DATE = '';
                    $QUOTE_TYPE = '';
                    $CHANGE_REQUEST = '';
                    $CHANGE_REQUEST_DATE  = '';
                    $COMMENTS  = '';

                    $life_support_notes = "";
                    $qa_notes = "";

                    if ($exports->sale_product_product_type == 1) {
                        $EXISTING_ELEC_BP_NUMBER  = $exports->vie_elec_account_number ? $exports->vie_elec_account_number : '';
                    }

                    if ($exports->sale_product_product_type == 2) {
                        $EXISTING_GAS_BP_NUMBER  = $exports->vie_gas_account_number ? $exports->vie_gas_account_number : '';
                    }
                    
                    /*Change_request and chnage_request_date according to transction type*/

                    if (isset($TRANSACTION_TYPE) && !empty($TRANSACTION_TYPE)) {

                        if ($TRANSACTION_TYPE == "CHANGE") {
                            $CHANGE_REQUEST = "Y";
                        } else {

                            $CHANGE_REQUEST = "";
                        }
                    }

                    if (isset($CHANGE_REQUEST) && !empty($CHANGE_REQUEST)) {

                        if ($CHANGE_REQUEST == "Y") {

                            $CHANGE_REQUEST_DATE = Carbon::now()->format('d.m.Y');
                            
                        } else {

                            $CHANGE_REQUEST_DATE = "";
                        }
                    }
                   

                    if (isset($exports->vie_life_support_notes) && $exports->vie_life_support_notes != "") {

                        $life_support_notes = $exports->vie_life_support_notes;
                    }

                    if (isset($exports->vie_qa_notes) && $exports->vie_qa_notes != "") {

                        $qa_notes = $exports->vie_qa_notes;
                    }

                    $COMMENTS = $life_support_notes . $qa_notes;
                    
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 1 && $exports->journey_moving_house == 1) {
                        $MOVEIN_DATE_E = '';
                        
                        if(!empty($exports->journey_moving_date)){
                           
                            //$mydate = Carbon::createFromFormat('Y-m-d', $exports->journey_moving_date);
                            //$MOVEIN_DATE_E =     $mydate->format('d.m.Y');
                            $MOVEIN_DATE_E = Carbon::parse($exports->journey_moving_date)->format('d.m.Y');
                           
                            
                        }
                      // dd($exports);
                      
                        $MOVEIN_INSTRUCT_E =  $exports->l_note;
                        
                        

                        
                    }
                    
                    
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 2 && $exports->journey_moving_house == 1) {
                        //$mydate = \Carbon\Carbon::createFromFormat('d/m/Y', $exports->journey_moving_date);
                        
                        //$MOVEIN_DATE_G  =  $mydate->format('d.m.Y');
                        $MOVEIN_DATE_G  =Carbon::parse($exports->journey_moving_date)->format('d.m.Y');
                        $MOVEIN_INSTRUCT_G  =  $exports->l_note;
                    }

                    $MAILING_BUILDING_NAME = str_replace(',', ' ', $MAILING_BUILDING_NAME);
                    $MAILING_FLOOR = str_replace(',', ' ', $MAILING_FLOOR);
                    $MAILING_LOT_NUMBER = str_replace(',', ' ', $MAILING_LOT_NUMBER);
                    $MAILING_UNIT_NUMBER = str_replace(',', ' ', $MAILING_UNIT_NUMBER);
                    $MAILING_STREET_NUMBER = str_replace(',', ' ', $MAILING_STREET_NUMBER);
                    $MAILING_STREET_NAME = str_replace(',', ' ', $MAILING_STREET_NAME);
                    $MAILING_SUBURB = str_replace(',', ' ', $MAILING_SUBURB);
                    $MAILING_POSTCODE = str_replace(',', ' ', $MAILING_POSTCODE);

                    if ($exports->journey_is_dual == 1) {
                       
                       // $plan_promotion_code = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', '!=', $exports->sale_product_product_type)->first()->plan_promotion_code;
                       
                    }
                   

                    /********** OFFER TYPE  *******/
                    //check the provider dynamically

                    if ($exports->journey_moving_house == 0) {

                        //   if ($mail_content['sale_original_source'] == 'agl') {
                        $current_provider_selected = 'AGL';
                        //     $provider_id = '10';
                        // } else {
                        //     $current_provider_selected = 'POWERDIRECT';
                        //     $provider_id = '19';
                        // }

                        $sale_previous_provider = $exports->journey_previous_provider_id;

                        // dual sale
                        $current_provider = decryptGdprData($exports->p_name);

                        if ($exports->journey_is_dual == 1) {
                            if ($exports->spe_sale_status == 4 && $exports->sale_product_product_type == $exports->sale_product_product_type) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 2)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->first();

                                if (!empty($sale_other_record)) {

                                    if (($sale_other_record->journey_previous_provider_id == $exports->journey_current_provider_id) && ($exports->journey_previous_provider_id == $exports->journey_current_provider_id)) {
                                        $OFFER_TYPE = "RDF";
                                    } else {
                                        if (($exports->journey_previous_provider_id == $exports->journey_current_provider_id) || ($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id)) {
                                            $OFFER_TYPE = "RDF";
                                        } else {
                                            $OFFER_TYPE = "ADF";
                                        }
                                    }
                                } else {

                                    if ($exports->journey_previous_provider_id == $exports->journey_current_provider_id) {

                                        $OFFER_TYPE = "REO";
                                    } else {


                                        $OFFER_TYPE = "AEO";
                                    }
                                }
                            }


                            if ($exports->spe_sale_status == 12 && $exports->sale_product_product_type == 1) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 2)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->first();

                                if (!empty($sale_other_record)) {


                                    if (($sale_other_record->journey_previous_provider_id == $exports->journey_current_provider_id) && ($exports->journey_previous_provider_id == $exports->journey_current_provider_id)) {

                                        $OFFER_TYPE = "RDF";
                                    } else {

                                        if (($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id) || ($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id)) {

                                            $OFFER_TYPE = "RDF";
                                        } else {

                                            $OFFER_TYPE = "ADF";
                                        }
                                    }
                                } else {

                                    if ($exports->journey_previous_provider_id == $exports->journey_current_provider_id) {

                                        $OFFER_TYPE = "REO";
                                    } else {

                                        $OFFER_TYPE = "AEO";
                                    }
                                }
                            }

                            if ($exports->spe_sale_status == 4 && $exports->sale_product_product_type == 2) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 2)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->where('spe_sale_status', 4)->first();

                                if (!empty($sale_other_record)) {

                                    if (($sale_other_record->journey_previous_provider_id == $exports->journey_current_provider_id) && ($exports->journey_previous_provider_id == $exports->journey_current_provider_id)) {
                                        $OFFER_TYPE = "RDF";
                                    } else {
                                        if (($exports->journey_current_provider_id == $exports->journey_previous_provider_id) || ($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id)) {
                                            $OFFER_TYPE = "RDF";
                                        } else {
                                            $OFFER_TYPE = "ADF";
                                        }
                                    }
                                } else {
                                    if ($exports->journey_current_provider_id == $exports->journey_previous_provider_id) {
                                        $OFFER_TYPE = "RGO";
                                    } else {
                                        $OFFER_TYPE = "AGO";
                                    }
                                }
                            }

                            //resubmitted cases
                            if ($exports->spe_sale_status == 12 && $exports->sale_product_product_type == 2) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 1)->where('spe_sale_status', 12)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->first();
                                if (!empty($sale_other_record)) {

                                    if (($exports->journey_current_provider_id == $exports->journey_previous_provider_id) || ($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id)) {

                                        $OFFER_TYPE = "RDF";
                                    } else {

                                        if (($exports->journey_current_provider_id == $exports->journey_previous_provider_id) || ($exports->journey_current_provider_id == $sale_other_record->journey_previous_provider_id)) {

                                            $OFFER_TYPE = "RDF";
                                        } else {

                                            $OFFER_TYPE = "ADF";
                                        }
                                    }
                                } else {

                                    if ($exports->journey_current_provider_id == $exports->journey_previous_provider_id) {

                                        $OFFER_TYPE = "RGO";
                                    } else {

                                        $OFFER_TYPE = "AGO";
                                    }
                                }
                            }
                        }
                        // for single sale
                        else {
                            if ($exports->sale_product_product_type == 1) {
                                if ($exports->journey_current_provider_id != $sale_previous_provider) {
                                    $OFFER_TYPE = "AEO";
                                } else if ($exports->journey_current_provider_id == $sale_previous_provider) {
                                    $OFFER_TYPE = "REO";
                                } else {
                                    $OFFER_TYPE = "";
                                }
                            } else {
                                if ($exports->journey_current_provider_id != $sale_previous_provider) {
                                    $OFFER_TYPE = "AGO";
                                } else if ($exports->journey_current_provider_id == $sale_previous_provider) {
                                    $OFFER_TYPE = "RGO";
                                } else {
                                    $OFFER_TYPE = "";
                                }
                            }
                        }
                    } else {
                        //moving house "yes" and sale is dual sale
                        if ($exports->journey_is_dual == 1) {
                            //submit cases
                            if ($exports->spe_sale_status == 4 && $exports->sale_product_product_type == 1) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 2)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->where('spe_sale_status', 4)->first();

                                //if gas record found then ADF
                                if (!empty($sale_other_record)) {
                                    $OFFER_TYPE = "ADF";
                                } else {
                                    $OFFER_TYPE = "AEO"; //else AEO
                                }
                            }

                            //resubmit cases
                            if ($exports->spe_sale_status == 12 && $exports->sale_product_product_type == 1) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 2)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->where('spe_sale_status', 12)->first();

                                //if gas record found
                                if (!empty($sale_other_record)) {
                                    $OFFER_TYPE = "ADF";
                                } else {
                                    $OFFER_TYPE = "AEO"; //else AEO
                                }
                            }

                            //submit cases
                            if ($exports->spe_sale_status == 4 && $exports->sale_product_product_type == 2) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 1)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->where('spe_sale_status', 4)->first();
                                //if electricity record found
                                if (!empty($sale_other_record)) {
                                    $OFFER_TYPE = "ADF";
                                } else {
                                    $OFFER_TYPE = "AGO"; //else AGO
                                }
                            }
                            //resubmitted cases
                            if ($exports->spe_sale_status == 12 && $exports->sale_product_product_type == 2) {
                                $sale_other_record = $dual_data->where('l_lead_id', $exports->l_lead_id)->where('sale_product_product_type', 1)->where('spe_schema_status', '!=', '1')->where('journey_current_provider_id', $exports->journey_current_provider_id)->where('spe_sale_status', 12)->first();
                                //if electricity record found
                                if (!empty($sale_other_record)) {
                                    $OFFER_TYPE = "ADF";
                                } else {
                                    $OFFER_TYPE = "AGO"; //else AGO
                                }
                            }
                        } else {
                            //$current_provider = Provider::select("name")->where('id', $exports['current_provider'])->first()->name;
                            //electricity
                            if ($exports->sale_product_product_type == 1) {
                                $OFFER_TYPE = "AEO";
                            }
                            //gas
                            if ($exports->sale_product_product_type == 2) {
                                $OFFER_TYPE = "AGO";
                            }
                        }
                    }

                    $providerData[$exports->spe_sale_status][] = array(
                        $VENDOR, //A
                        $VENDOR_BP,            //B
                        $CHANNEL,                //C 
                        $TRANSACTION_TYPE,        //E
                        $LEAD_ID,                   //F
                        $RESUBMISSION_COUNT,    //G
                        $RESUBMISSION_COMMENT,    //H
                        $TITLE,                //I
                        $NAME_FIRST,            //J
                        $NAME_MIDDLE,            //J
                        $NAME_LAST,            //K
                        $DOB,                    //L
                        $BUILDING_NAME,        //M
                        $FLOOR,                //N
                        $LOT_NUMBER,            //O
                        $UNIT_NUMBER,            //P
                        $STREET_NUMBER,        //Q
                        $STREET_NAME,            //R
                        $SUBURB,                //S
                        $STATE,                //T
                        $POSTCODE,                //U
                        $PHONE_HOME,            //V
                        $PHONE_WORK,            //W
                        $PHONE_MOBILE,            //X
                        $EMAIL,                //Y
                        $MARKETING,            //Z
                        $ECONF_PACK_CONSENT,    //AA
                        $ECOMM_CONSENT,        //AB
                        $PRIMARY_SMS_CONSENT,    //AC
                        $CREDIT_CONSENT,        //AD
                        $AP_TITLE,                //AE
                        $AP_FIRST_NAME,        //AF
                        $AP_MIDDLE_NAME,        //AG
                        $AP_LAST_NAME,            //AH
                        $AP_PHONE_HOME,        //AI
                        $AP_PHONE_WORK,        //AJ
                        $AP_PHONE_MOBILE,        //AK
                        $AP_DOB,                //AL
                        $AP_DRIVERS_LICENSE,    //AM
                        $BUSINESS_NAME,        //AN
                        $LEGAL_NAME,            //AO
                        $ABN_ACN,                //AP
                        $BUSINESS_TYPE,        //AQ
                        $MAILING_BUILDING_NAME, //AR
                        $MAILING_FLOOR,        //AS
                        $MAILING_LOT_NUMBER,    //AT
                        $MAILING_UNIT_NUMBER,    //AU
                        $MAILING_STREET_NUMBER, //AV
                        $MAILING_STREET_NAME,    //AW
                        $MAILING_SUBURB,        //AX
                        $MAILING_STATE,        //AY
                        $MAILING_POSTCODE,        //AZ
                        $CONCESSION_TYPE,        //BB
                        $CONCESSION_NUMBER,    //BC
                        $VALID_TO,                //BD
                        $DRIVERS_LICENSE,        //BE
                        $PASSPORT,                //BF
                        $MEDICARE_NUMBER,        //BG
                        $LIFE_SUPPORT,            //BH
                        $DD_REQ,                //BI
                        $NMI,                    //BJ
                        $DPI_MIRN,                //BK
                        $METER_NUMBER_E,        //BL
                        $METER_NUMBER_G,        //BM
                        $METER_TYPE,            //BN
                        $METER_HAZARD_E,        //BO
                        $DOG_CODE_G,            //BP
                        $SITE_ACCESS_E,        //BQ
                        $SITE_ACCESS_G,        //BR
                        $RE_EN_REMOTE_SAFETY_CONFIRMATION, //BS
                        $DE_EN_REMOTE_SAFETY_CONFIRMATION, //BT
                        $SO_REQ,                //BU
                        $RETAILER,                //BV
                        $PROGRAM,                //BW
                        $CAMPAIGN,                //BX
                        $SALES_DATE,            //BY
                        $CONTRACT_NUMBER,        //BZ
                        $OFFER_TYPE,            //CA
                        $PRODUCT_CODE_E,        //CB
                        $PRODUCT_CODE_G,        //CC
                        $CAMPAIGN_CODE_RES_ELEC,    //CD
                        $CAMPAIGN_CODE_RES_GAS,    //CE
                        $CAMPAIGN_CODE_SME_ELEC,    //CF
                        $CAMPAIGN_CODE_SME_GAS,    //CG
                        $MATRIX_CODE,            //CH
                        $TARIFF_TYPE,            //CI
                        $FLEX_PRICE,            //CJ
                        $REFERRER_NUMBER,        //CK
                        $FLYBUYS_CONSENT,        //CL
                        $FLYBUYS_NUMBER,        //CM
                        $FLYBUYS_POINTS,        //CN
                        $AEO_REG,                //CO
                        $OWN_RENT,                //CP
                        $PROMOTION_CODE,        //CQ
                        $MERCH_REQ,            //CR
                        $AGL_ASSIST,            //CS
                        $GAS_OFFER,            //CT
                        $ELEC_OFFER,            //CU
                        $MOVEIN_DATE_E,        //CV
                        $MOVEIN_DATE_G,        //CW
                        $MOVEIN_INSTRUCT_E,    //CX
                        $MOVEIN_INSTRUCT_G,    //CY
                        $MOVEOUT_DATE_E,        //CZ
                        $MOVEOUT_DATE_G,        //DA
                        $MOVEOUT_INSTRUCT_E,    //DB
                        $MOVEOUT_INSTRUCT_G,    //DC
                        $GREENSALE,            //DD
                        $AARH_DONATION,        //DE
                        $EPFS_REQ,                //DF
                        $SALES_AGENT,            //DG
                        $EXISTING_GAS_BP_NUMBER,    //DH
                        $EXISTING_ELEC_BP_NUMBER,    //DI
                        $EXISTING_CRN_NUMBER,    //DJ
                        $CANCELLATION_DATE,    //DK
                        $CANCELLATION_TYPE,    //DL
                        $CANCELLATION_REASON,    //DM
                        $CANCELLATION_REASON_OTHER,    //DN
                        $QUOTE_DATE,            //DO
                        $QUOTE_TYPE,            //DP
                        $CHANGE_REQUEST,        //DQ
                        $CHANGE_REQUEST_DATE,    //DR
                        $COMMENTS                //DS				//DS
                    );
                } else {
                   

                    if (empty($exports->vie_qa_notes_created_date)) {
                       
                        $date_one = Carbon::parse($exports->sale_product_sale_created_at)->format('d/m/Y');
                        $other_sale_date = Carbon::createFromFormat('d/m/Y', $date_one);
                      
                    } else {
                        $other_sale_date = Carbon::createFromFormat('d/m/Y', $exports->vie_qa_notes_created_date);
                      
                    }
                    //gas offer = 29 oct changes
                   
                    if ($exports->sale_product_product_type == 2) {
                        if (isset($exports->plan_promotion_code) && !empty($exports->plan_promotion_code)) {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][97] = $exports->plan_promotion_code;
                        }
                    }
                     
                    //elec offer
                    if ($exports->sale_product_product_type == 1) {
                        if (isset($exports->plan_promotion_code) && !empty($exports->plan_promotion_code)) {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][98] = $exports->plan_promotion_code;
                        }
                    }
                    //============== end 29 oc changes
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 1 && $exports->journey_moving_house == 1) {
                        $mydate = Carbon::parse($exports->journey_moving_date)->format('d.m.Y');
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][99] = $mydate;
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][101] = $exports->l_note;
                    }

                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 2 && $exports->journey_moving_house == 1) {
                        $mydate = Carbon::parse($exports->journey_moving_date)->format('d.m.Y');
                        
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][100] = $mydate;
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][102] = $exports->l_note;
                    }
                    
       
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 1) {
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][61] = $exports->vie_nmi_number;
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][63] = $exports->vie_meter_number_e;
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][79] = $exports->plan_product_code;
                        if ($exports->journey_property_type == 1) {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][81] = $exports->plan_plan_campaign_code;
                        } else {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][83] = $exports->plan_plan_campaign_code;
                        }
                    }

                    
                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 2) {
                        $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][62]  = $exports->vie_dpi_mirn_number;

                        if (!empty($exports->plan_product_code) && $exports->plan_product_code != 'N/A') {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][80] = $exports->plan_product_code;
                        } else {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][80] = '';
                        }

                        if (!empty($exports->vie_meter_number_g) && $exports->vie_meter_number_g != 'N/A') {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][64] = $exports->vie_meter_number_g;
                        } else {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][64] = '';
                        }
                        if ($exports->journey_property_type == 1) {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][82] = $exports->plan_plan_campaign_code;
                        } else {
                            $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][84] = $exports->plan_plan_campaign_code;
                        }
                    }

                    if (isset($exports->sale_product_product_type) && $exports->sale_product_product_type == 1) {
                        if ((isset($exports) && $exports->journey_solar_panel  == 0 && $exports->journey_moving_house  == 0)) {
                            //core sale
                            //     if ($mail_type == "test") {
                            if ($sale_status == 4) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SALE';
                            } elseif ($sale_status == 12) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SALE';
                            }
                            // } else {
                            //     if ($exports->spe_sale_status == 4) {
                            //         $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SALE';
                            //     } elseif ($exports->spe_sale_status == 12) {
                            //         $providerData[$exports->spe_sale_status][$reference_key_array[$exports['reference_no']]][4] = 'SALE';
                            //     }
                            // }
                        } elseif ((isset($exports)  && $exports->journey_moving_house  == 1 /*&&  Carbon::createFromFormat('d/m/Y', $exports->journey_moving_date)->gt($other_sale_date)*/)) {
                           
                            //move in sale
                            //    if ($mail_type == "test") {
                            if ($sale_status == 4) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SALE';
                            } elseif ($sale_status == 12) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SALE';
                            }
                            // } else {
                            //     if ($exports['sale_status'] == 4) {
                            //         $providerData[$exports['sale_status']][$reference_key_array[$exports['reference_no']]][4] = 'SALE';
                            //     } elseif ($exports['sale_status'] == 12) {
                            //         $providerData[$exports['sale_status']][$reference_key_array[$exports['reference_no']]][4] = 'SALE';
                            //     }
                            // }
                        } elseif ((isset($exports)  && $exports->journey_moving_house  == 1 /*&& Carbon::createFromFormat('d/m/Y', $exports->journey_moving_date) == Carbon::parse($other_sale_date)*/)) {

                            // if ($mail_type == "test") {
                            //     if ($sale_status == 4) {
                            //         $providerData[$exports['sale_status']][$reference_key_array[$exports['reference_no']]][4] = 'SDFI';
                            //     } elseif ($sale_status == 12) {
                            //         $providerData[$exports['sale_status']][$reference_key_array[$exports['reference_no']]][4] = 'SDFI';
                            //     }
                            // } else {
                            if ($exports->spe_sale_status == 4) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SDFI';
                            } elseif ($exports->spe_sale_status == 12) {
                                $providerData[$exports->spe_sale_status][$reference_key_array[$exports->sale_product_reference_no]][4] = 'SDFI';
                            }
                            // }

                            # code...
                        }
                    }
                }
            }
            

            // if ($mail_content['sale_original_source'] == 'agl') {
            $providerLead['providerName'] = "AGL";
            // } else {
            //    $mail_content['provider_name'] = "POWERDIRECT";
            // }
            $data['protectedPassword'] = '';
            if ($exports->p_protected_sale_submission == 1) {
                $providerLead['protectedPassword'] = $exports->p_protected_password;
            }

            $providerLead['subject'] = 'Agl_Sales_Report_' . Carbon::now()->format('m-d-Y') . '_' . Carbon::now()->format('H:m');

            $batchDetails = Providers::where('id', env('simply_energy'))->select('batch_number', 'batch_created_date')->first();
            $batch_number = $batchDetails ? $batchDetails->batch_number : 0;
            $batch_number = $batch_number + 1;
            $provider_update['batch_number'] = $batch_number;
            $provider_update['batch_created_date'] = Carbon::now();

            $providerLead['leadIds'] = $leadIds;
            if (!$providerLead['isTest'] && array_key_exists('4', $providerData)) {
                $providerLeadData = $providerData['4'];
                $data['requestType'] = 'Fulfilment';
                Providers::where('id', env('simply_energy'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($data['requestType'], $data['saleSubmissionType']);
                $fileName = 'Agl_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                return $this->finalizeCaf($data[0], $fileName, $providerLead, new Headings($providerLeadData));
            }

            if (!$providerLead['isTest'] && array_key_exists('12', $providerData)) {
                $providerLeadData = $providerData['12'];
                $data['requestType'] = 'Resubmission';
                Providers::where('id', env('simply_energy'))->update($provider_update);
                $filenameOffset = self::getFileNameOffset($providerLead['requestType'], $providerLead['saleSubmissionType']);
                $fileName = 'Agl_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s")) + $filenameOffset + $batch_number) . '.xlsx';
                return $this->finalizeCaf($data[0], $fileName, $providerLead, new Headings($providerLeadData));
            }

            if ($providerLead['isTest']) {
                $first_key = key($providerData);
                $providerLeadData = $providerData[$first_key];
                $providerLead['requestType'] = 'Testing manually';
                $fileName = 'Agl_Sales_Report_' . Carbon::now()->format('y-m-d') . '_' . date('H:i:s', strtotime(date("Y-m-d H:i:s"))) . '.xlsx';
                return $this->finalizeCaf($data[0], $fileName, $providerLead, new Headings($providerLeadData));
            }

            return false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $status = 400;
            $result = [
                'exception_message' => $e->getMessage(). $e->getLine(). $e->getFile()
            ];
            echo response()->json($result, $status);
        }
    }
}
