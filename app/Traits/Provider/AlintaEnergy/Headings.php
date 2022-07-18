<?php
  
namespace App\Traits\Provider\AlintaEnergy;
  
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
            'sales_cust_number',
            'sales_person',
            'sales_channel',
            'voice_eic_extn',
            'voice_eic_date',
            'contract_date',
            'site_addr_unit_type',
            'site_addr_unit_no',
            'site_addr_floor_type',
            'site_addr_floor_no',
            'site_addr_street_no',
            'site_addr_street_no_suffix',
            'site_addr_street_name',
            'site_addr_street_suffix',
            'site_addr_street_type',
            'site_addr_suburb',
            'site_addr_state',
            'site_addr_postcode',
            'site_addr_property_name',
            'site_addr_location_desc',
            'site_addr_lot_number',
            'cust_dpid_number',
            'customer_type',
            'transfer_type',
            'service_type',
            'site_identifier',
            'product_name',
            'acn_number',
            'abn_number',
            'trading_name',
            'customer_salutation',
            'first_name',
            'last_name',
            'dob',
            'contact_phone_1',
            'contact_phone_2',
            'contact_email',
            'cur_addr_unit_no',
            'cur_addr_street_no',
            'cur_addr_street_no_suffix',
            'cur_addr_street_name',
            'cur_addr_street_type',
            'cur_addr_suburb',
            'cur_addr_state',
            'cur_addr_postcode',
            'cur_addr_lot_number',
            'identity_type',
            'dlicence_issuing_state',
            'dlicense_number',
            'dlicense_exp_date',
            'medicare_card_colour',
            'medicard_no',
            'medicare_irn',
            'medicare_exp_date',
            'passport_issuing_country',
            'passport_number',
            'passport_exp_date',
            'identity_middle_name',
            'bill_group_code',
            'delivery_method_code',
            'preferred_contact_method',
            'cust_postal_addr_1',
            'cust_postal_addr_2',
            'cust_postal_suburb',
            'cust_postal_code',
            'cust_postal_state',
            'occupancy_type',
            'contact_2_salutation',
            'contact_2_first_name',
            'contact_2_last_name',
            'contact_2_dob',
            'contact_2_phone_1',
            'contact_2_phone_2',
            'contact_2_email',
            'conc_card',
            'conc_card_type',
            'conc_consent',
            'conc_card_number',
            'conc_start_date',
            'conc_card_exp_date',
            'conc_med_cool',
            'proposed_move_in_date',
            'appointment_availability',
            'booking_attendance',
            'alterations_prev_deen',
            'alterations_future',
            'main_switch_off',
            'deen_6_months',
            'key_location',
            'key_location_spec',
            'site_hazard_desc',
            'site_hazard_spec',
            'site_access_details',
            'marketing_consent',
            'netwk_code',
            'proposed_tariff',
            'volume_builder',
            'multisite_group',
            'contract_number'
        ];
    }
}