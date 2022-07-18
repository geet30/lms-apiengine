<?php
  
namespace App\Traits\Provider\MomentumEnergy;
  
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
  
class Headings implements FromCollection, WithHeadings
{
    protected $data;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function collection()
    {
        return collect($this->data);
    }
  
    /**
     * Alinta Headings
     *
     * @return response()
     */
    public function headings() :array
    {
        return [
				'sales_cust_number',        	//A
				'Customer_type',            	//B
				'product_type_code',        	//C
				'voice_ver_extn',           	//D
				'agreement_date',           	//E
				'sales_name',               	//F
				'acct_mgr_name',            	//G
				'first_name',               	//H
				'last_name',                	//I
				'Initials',             		//J
				'party_name',               	//K
				'Company_type',         		//L
				'industry_type',            	//M
				'acn_number',               	//N
				'abn_number',               	//O
				'site_identifier',          	//P
				'site_addr_unit_type',      	//Q
				'site_addr_unit_no',        	//R
				'site_addr_floor_type', 		//S
				'site_addr_floor_no',       	//T
				'site_addr_street_no',      	//U
				'site_addr_street_no_suffix',   //V
				'site_addr_street_name',        //W
				'site_street_type_code',        //X
				'site_addr_suburb',             //Y
				'site_addr_city',               //Z
				'site_addr_postcode',           //AA
				'site_addr_property_name',      //AB
				'site_addr_location_desc',      //AC
				'site_hazard_desc',             //AD
				'site_access_details',          //AE
				'cust_postal_addr_1',           //AF
				'cust_postal_addr_2',           //AG
				'cust_postal_addr_3',           //AH
				'cust_postal_post_code',        //AI
				'cust_street_addr_1',       	//AJ
				'cust_street_addr_2',       	//AK
				'cust_street_addr_3',       	//AL
				'cust_dpid_number',     		//AM
				'cust_dpid_barcode',        	//AN
				'cust_rent_or_own',     		//AO
				'cust_income_source',       	//AP
				'cust_promo_allowed',       	//AQ
				'cust_notes',               	//AR
				'cust_std_code',            	//AS
				'cust_phone_no',            	//AT
				'cust_fax_no',              	//AU
				'cust_email_addr',          	//AV
				'cust_web_addr',            	//AW
				'cust_employer',            	//AX
				'cust_emp_ph_no',           	//AY
				'dob',                      	//AZ
				'contact_first_name',       	//BA
				'contact_last_name',        	//BB
				'contact_initials',     		//BC
				'contact_addr_ln1',     		//BD
				'contact_addr_ln2',     		//BE
				'contact_addr_ln3',     		//BF
				'contact_job_title',        	//BG
				'contact_work_ph',          	//BH
				'contact_work_fax',     		//BI
				'contact_home_ph',          	//BJ
				'contact_mobile_ph',        	//BK
				'contact_email',            	//BL
				'customer_dlicense',        	//BM
				'customer_dlicense_exp_date',   //BN
				'customer_passport',            //BO
				'customer_passport_exp_date',   //BP
				'bill_cycle_code',              //BQ
				'delivery_method_code',         //BR
				'pull_bill_custom_dir',         //BS
				'pull_bill_custom_date',        //BT
				'previous_supplier_code',       //BU
				'average_monthly_spend',        //BV
				'usage_profile_code',           //BW
				'network_code',                 //BX
				'TCO_Code',                     //BY
				'contract_term_code',           //BZ
				'contract_date',                //CA
				'concession',                   //CB
				'conc_start_date',              //CC
				'conc_end_date',                //CD
				'conc_card_type_code',          //CE
				'conc_card_number',             //CF
				'conc_card_code',               //CG
				'conc_card_exp_date',           //CH
				'conc_on_life_support',         //CI
				'conc_has_ms',                  //CJ
				'conc_in_grp_home',             //CK
				'customer_salutation',          //CL
				'transfer_type',                //CM
				'customer_payment_method',      //CN
				'customer_DD_bank',             //CO
				'customer_DD_branch',           //CP
				'customer_DD_number',           //CQ
				'customer_CC_type',             //CR
				'customer_CC_name',             //CS
				'customer_CC_number',           //CT
				'customer_CC_expiry_dt',        //CU
				'customer_CC_verify_no',        //CV
				'medicard_no',                  //CW
				'Site_addr_street_suffix',      //CX
				'life_support_machine_type',    //CY
				'price_plan_code',              //CZ
				'campaign_name',                //DA
				'incentive_code',               //DB
				'termination_fee_code',         //DC
				'est_ann_kwhs',                 //DD (yellow)
				'password',                 	//DE
				'sales_internal_tariff',        //DF
				'green_percent',                //DG
				'meter_num',                    //DH
				'g_code',                       //DI
				'lot_number',                   //DJ
				'identifier',                   //DK
				'trading_name',                 //DL
				'trustee_name',                 //DM
				'Account Type Code',            //DN
				'Customer Sub Type Code',       //DO
				'Customer Invoice PPD Days',    //DP
				'Customer Invoice Due Days',    //DQ
				'rate_card_version',            //DR
				'green_type',                   //DS
				'Campaign_Number',              //DT
				'Reference',                    //DU
				'customer_medicard_exp_date',   //DV
				'activity_type_code',           //DW
				'activitiy_note',               //DX
				'Concession - Life Support Machine Start Date', //DY
				'Concession - Life Support Machine End Date',   //DZ
				'Move-In Date/Special Read Date',       		//EA
				'Special Instructions',         				//EB
				'Concession Consent Obtained',      			//EC
				'Concession Card - First Name',     			//EE
				'Concession Card - Middle Name',    			//ED
				'Concession Card - Last Name',      			//EF
				'Parent Account Number',            			//EG
				'Customer Consult',                 			//EH
				'Confirm De-energise',              			//EI
				'Customer Preferred Date',          			//EJ
				'Customer Preferred Time',          			//EK
				'Change Reason ID',                 			//EL
				'Charge Cost To',                   			//EM
				'Service Time',                     			//EN
				'Priority',                         			//EO
				'Secondary Contact Salutation',             	//EP
				'Secondary Contact First Name',             	//EQ
				'Secondary Contact Last Name',                  //ER
				'Secondary Contact Initials',                   //ES
				'Secondary Contact Date of Birth',              //ET
				'Secondary Contact Address Line 1',         	//EU
				'Secondary Contact Address Line 2',         	//EV
				'Secondary Contact Address Suburb',         	//EW
				'Secondary Contact Address State',              //EX
				'Secondary Contact Address Postcode',       	//EY
				'Secondary Contact Job Title',                  //EZ
				'Secondary Contact Work Phone',             	//FA
				'Secondary Contact Work Fax',               	//FB
				'Secondary Contact Home Phone',             	//FC
				'Secondary Contact Mobile Phone',           	//FD
				'Secondary Contact Email',                      //FE
				'Secondary Contact Drivers Licence No.',    	//FF
				'Secondary Contact Drivers Licence Expiry', 	//FG
				'Secondary Contact Passport No.',           	//FH
				'Secondary Contact Passport Expiry',            //FI
				'Secondary Contact Medicare No.',               //FJ
				'Customer Direct Debit Bank',               	//FK
				'Customer Direct Debit Branch',             	//FL
				'Customer Direct Debit No.',                    //FM
				'Customer Credit Card Type',                    //FN
				'Customer Credit Card Name',                    //FO
				'Customer Credit Card No.',                 	//FP
				'Customer Credit Card Expiry',                  //FQ
				'Customer Credit Card Verify No.',              //FR
				'Secondary Contact Medicare Expiry',            //FS
				'Xml Config',                               	//FT
				'Quote Date',                               	//FU
				'Offer with Rate ID',                       	//FV
				'Offer With Rate Name',                     	//FW
				'Regulatory Communication Preference',          //FX
				'existing_customer',                            //FY
				'contact_passport_country_of_birth',            //FZ
				'contact_driving_licence_issuing_state',        //GA
				'contact_time_at_current_address',              //GB
				'contact_medicare_card_reference_number',       //GC
        ];
    }
}