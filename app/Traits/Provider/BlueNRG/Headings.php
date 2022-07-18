<?php
  
namespace App\Traits\Provider\BlueNRG;
  
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
        return array(
            'sales_cust_number',           	//1
            'customer_type',               	//2
            'product_type_code',          	//3
            'voice_ver_extn',              	//4
            'voice_ver_date',              	//5
            'sales_name',               	//6
            'acct_mgr_name',               	//7
            'first_name',               	//8
            'last_name',               		//9
            'initials',               		//10
            'party_name',               	//11
            'company_type',               	//12
            'industry_type',               	//13
            'acn_number',               	//14
            'abn_number',               	//15
            'site_identifier',              //16
            'site_addr_unit_type',          //17
            'site_addr_unit_no',            //18
            'site_addr_floor_type',         //19
            'site_addr_floor_no',           //20
            'site_addr_street_no',          //21
            'site_streetno_suffix',         //22
            'site_addr_street_name',        //23
            'stype_code',               	//24
            'site_addr_suburb',             //25
            'site_addr_city',               //26
            'spost_code',               	//27
            'site_addr_property_name',      //28
            'site_addr_location_desc',      //29
            'site_hazard_desc',             //30
            'site_access_details',          //31
            'cust_postal_addr_1',           //32
            'cust_postal_addr_2',           //33
            'cust_postal_addr_3',           //34
            'cust_postal_code',             //35
            'cust_street_addr_1',           //36
            'cust_street_addr_2',           //37
            'cust_street_addr_3',           //38
            'cust_dpid_number',             //39
            'cust_dpid_barcode',            //40
            'prop_type',               		//41
            'cust_income_source',           //42
            'P',               				//43
            'cust_notes',               	//44
            'std_code',               		//45
            'cust_phone_no',               	//46
            'cust_fax_no',               	//47
            'cust_email_addr',              //48
            'cust_web_addr',               	//49
            'cust_employer',               	//50
            'cust_emp_ph_no',               //51
            'dob',               			//52
            'contact_first_name',           //53
            'contact_last_name',            //54
            'contact_initials',             //55
            'contact_addr_ln1',             //56
            'contact_addr_ln2',             //57
            'contact_addr_ln3',             //58
            'contact_job_title',            //59
            'contact_work_ph',              //60
            'contact_work_fax',             //61
            'contact_home_ph',              //62
            'contact_mobile_ph',            //63
            'contact_email',               	//64
            'customer_dlicense',            //65
            'customer_dlicense_exp_da',     //66
            'customer_passport',            //67
            'passport_exp_date',            //68
            'bill_cycle_code',              //69
            'delivery_method_code',         //70
            'pull_bill_custom_dir',         //71
            'pull_bill_date',               //72
            'previous_supplier_code',       //73
            'avg_monthly_spend',            //74
            'usage_profile_code',           //75
            'netwk_code',               	//76
            'tco_code',               		//77
            'term_code',               		//78
            'contract_date',               	//79
            'C',               				//80
            'conc_start_date',              //81
            'conc_end_date',               	//82
            'card_type',               		//83
            'conc_card_number',             //84
            'conc_card_code',               //85
            'conc_card_exp_date',           //86
            'O',               				//87
            'c_2',               			//88
            'i',               				//89
            'customer_salutation',          //90
            'transfer_type',               	//91
            'customer_payment_method',      //92
            'customer_dd_bank',             //93
            'customer_dd_branch',           //94
            'customer_dd_number',           //95
            'customer_cc_type',             //96
            'customer_cc_name',             //97
            'customer_cc_number',           //98
            'customer_cc_expiry_dt',        //99
            'customer_cc_verify_no',        //100
            'medicard_no',               	//101
            'site_addr_street_suffix',      //102
            'life_support_machine_type',    //103
            'rate_card_code',               //104
            'campaign_name',               	//105
            'incentive_code',               //106
            'termination_fee_code',         //107
            'est_ann_kwhs',               	//108
            'Password',               		//109
            'sales_internal_tariff',        //110
            'green_percent',               	//111
            'meter_num',               		//112
            'g_code',               		//113
            'lot_number',               	//114
            'identifier',               	//115
            'trading_name',               	//116
            'trustee_name',               	//117
            'blank1',               		//118
            'blank2',               		//119
            'blank3',               		//120
            'blank4',               		//121
            'rate_card_version',            //122
            'green_type',               	//123
            'blank7',               		//124
            'blank8',               		//125
            'blank9',               		//126
            'blank0',               		//127
            'blank10',               		//128
            'blank11',               		//129
            'blank12',               		//130
            'proposed_move_in_date',        //131
            'special_instructions',         //132
            'cgc',               			//133
            'Consolidated_group_NMI',       //134
            'Base_commission',              //135
            'inspection_date',              //136
        );
    }
}