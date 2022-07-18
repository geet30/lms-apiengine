<?php
  
namespace App\Traits\Provider\FirstEnergy;
  
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
            'sales_cust_number',
            /** 1 **/
            'sales_person',
            /** 2 **/
            'voice_ver_date',
            /** 3 **/
            'voice_ver_extn',
            /** 4 **/
            'abn_number',
            /** 5 **/
            'acn_number',
            /** 6 **/
            'business_name',
            /** 7 **/
            'account_manager',
            /** 8 **/
            'account_name',
            /** 9 **/
            'bill_cycle_code',
            /** 10 **/
            'customer_type_code',
            /** 11 **/
            'email_address',
            /** 12 **/
            'invoice_delivery_class',
            /** 13 **/
            'payment_method_type',
            /** 14 **/
            'post_addr_1',
            /** 15 **/
            'post_addr_2',
            /** 16 **/
            'post_addr_3',
            /** 17 **/
            'post_post_code',
            /** 18 **/
            'promo_allowed',
            /** 19 **/
            'contact1_date_of_birth',
            /** 20 **/
            'contact1_drivers_licence',
            /** 21 **/
            'contact1_email_address',
            /** 22 **/
            'contact1_first_name',
            /** 23 **/
            'contact1_initials',
            /** 24 **/
            'contact1_last_name',
            /** 25 **/
            'contact1_medicard_no',
            /** 26 **/
            'contact1_mobile_no',
            /** 27 **/
            'contact1_passport',
            /** 28 **/
            'contact1_phone_no',
            /** 29 **/
            'contact1_phone_std',
            /** 30 **/
            'contact1_postal_addr_1',
            /** 31 **/
            'contact1_postal_addr_2',
            /** 32 **/
            'contact1_postal_addr_3',
            /** 33 **/
            'contact1_postal_post_code',
            /** 34 **/
            'contact1_street_addr_1',
            /** 35 **/
            'contact1_street_addr_2',
            /** 36 **/
            'contact1_street_addr_3',
            /** 37 **/
            'contact1_street_post_code',
            /** 38 **/
            'contact1_title',
            /** 39 **/
            'contact1_work_no',
            /** 40 **/

            'contact2_date_of_birth',
            /** 41 **/
            'contact2_first_name',
            /** 42 **/
            'contact2_middle_name',
            /** 43 **/
            'contact2_last_name',
            /** 44 **/
            'contact2_medicard_no',
            /** 45 **/
            'contact2_mobile_no',
            /** 46 **/
            'contact2_passport',
            /** 47 **/
            'contact2_phone_no',
            /** 48 **/
            'contact2_phone_std',
            /** 49 **/
            'contact2_postal_addr_1',
            /** 50 **/
            'contact2_postal_addr_2',
            /** 51 **/
            'contact2_postal_addr_3',
            /** 52 **/
            'contact2_postal_post_code',
            /** 53 **/
            'contact2_street_addr_1',
            /** 54 **/
            'contact2_street_addr_2',
            /** 55 **/
            'contact2_street_addr_3',
            /** 56 **/
            'contact2_street_post_code',
            /** 57 **/
            'contact2_title',
            /** 58 **/
            'contact2_work_no',
            /** 59 **/
            'life_support_on_site',
            /** 60 **/

            'concession_flag',
            /** 61 **/
            'conc_first_name',
            /** 62 **/
            'conc_last_name',
            /** 63 **/
            'conc_card_type_code',
            /** 64 **/
            'conc_expiry_date',
            /** 65 **/
            'conc_card_number',
            /** 66 **/
            'conc_start_date',
            /** 67 **/
            'smoothpay_amount',
            /** 68 **/
            'contract_start_date',
            /** 69 **/
            'contract_term_code',
            /** 70 **/
            'offering_code',
            /** 71 **/
            'product_type_code',
            /** 72 **/
            'site_identifier',
            /** 73 **/
            'site_network_code',
            /** 74 **/
            'site_network_tariff_list',
            /** 75 **/
            'site_post_code',
            /** 76 **/
            'site_state',
            /** 77 **/
            'site_street_name',
            /** 78 **/
            'site_street_no',
            /** 79 **/
            'site_street_type_code',
            /** 80 **/
            'site_suburb',
            /** 81 **/
            'site_unit_no',
            /** 82 **/
            'transfer_type',
            /** 83 **/
            'transfer_move_in_date',
            /** 84 **/
            'contact1_drivers_expiry',
            /** 85 **/
            'average_monthly_spend'
            /** 86 **/
        );
    }
}