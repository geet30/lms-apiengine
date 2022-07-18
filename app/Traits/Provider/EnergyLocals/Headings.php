<?php
  
namespace App\Traits\Provider\EnergyLocals;
  
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
            'customer_type_code',
            'contact1_title',
            'contact1_first_name',
            'contact1_last_name',
            'contact1_mobile_no',
            'contact1_phone_std',
            'contact1_phone_no',
            'email_address',
            'contact1_email_address',
            'business_name',
            'abn_number',
            'site_floor_no',
            'site_floor_type',
            'site_unit_no',
            'site_unit_type',
            'site_street_no',
            'site_street_name',
            'site_street_type_code',
            'site_suburb',
            'site_state',
            'site_post_code',
            'transfer_type',
            //'site_network_code',
            'transfer_move_in_date',
            'previous_supplier_code',
            'site_identifier',
            'user_defined_1',
            'concession_flag',
            'conc_card_type_code',
            'conc_card_number',
            'conc_end_date',
            'conc_expiry_date',
            'conc_group_home_flag',
            'conc_start_date',
            'conc_first_name',
            'conc_last_name',
            'conc_life_support_flag',
            'conc_life_support_machine_type',
            'conc_ls_start_date',
            'contact1_date_of_birth',
            'contact1_drivers_licence',
            'contact1_drivers_expiry',
            'contact1_passport',
            'contact1_passport_expiry',
            'contact1_medicard_no',
            'payment_method_type',
            'direct_debit_bank_code',
            'direct_debit_number',
            'credit_card_no',
            'credit_card_expiry_date',
            'credit_card_verif_no',
            'credit_card_type_code',
            'smoothpay_amount',
            'User_Defined_3',
            'green_percent',
            'user_defined_4',
            'user_defined_2',
            'promo_allowed',
            'offering_code',
            'bill_cycle_code',
            'brand_code',
            'post_addr_1',
            'post_addr_2',
            'post_addr_3',
            'post_post_code',
            'product_type_code',
            'conc_consent_flag',
            'contract_term_code',
            'customer_sub_type_code',
            'invoice_delivery_class',
            'letter_delivery_class',
            'company_type',
            'industry_type_code',
            'acn_number',
            'trading_name',
            'direct_debit_branch',
            'direct_debit_name',
            'credit_card_name',
            'conc_ms_flag',
            'conc_ls_end_date',
            'business_phone_no',
            'contracted_capacity_code',
            'site_network_code',
            'life_support_on_site'
        );
    }
}