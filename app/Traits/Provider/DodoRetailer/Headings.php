<?php
  
namespace App\Traits\Provider\DodoRetailer;
  
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
            'sales_name',
            'sales_reference',
            'agreement_date',
            'site_address_postcode',
            'concession',
            'concession_card_type',
            'concession_card_no',
            'concession_start_date',
            'concession_exp_date',
            'concession_first_name',
            'concession_middle_name',
            'concession_last_name',
            'product_code',
            'meter_type',
            'kWh_usage_per_day',
            'how_many_people',
            'how_many_bedrooms',
            'solar_power',
            'solar_type',
            'solar_output',
            'green_energy',
            'winter_gas_usage',
            'summer_gas_usage',
            'monthly_winter_spend',
            'monthly_summer_spend',
            'invoice_method',
            'customer_salutation',
            'first_name',
            'last_name',
            'date_of_birth',
            'email_contact',
            'contact_number',
            'hearing_impaired',
            'secondary_contact',
            'secondary_salutation',
            'secondary_first_name',
            'secondary_last_name',
            'secondary_date_of_birth',
            'secondary_email',
            'site_addr_unit_type',
            'site_addr_unit_no',
            'site_addr_floor_type',
            'site_addr_floor_no',
            'site_addr_street_no',
            'site_addr_street_no_suffix',
            'site_addr_street_name',
            'site_addr_street_type',
            'site_addr_suburb',
            'site_addr_state',
            'site_addr_postcode',
            'site_addr_desc',
            'site_access',
            'site_less_than_12_months',
            'prev_addr_1',
            'prev_addr_2',
            'prev_addr_state',
            'prev_addr_postcode',
            'billing_address',
            'bill_addr_1',
            'bill_addr_2',
            'bill_addr_state',
            'bill_addr_postcode',
            'referral_code',
            'new_username',
            'new_password',
            'customer_dlicense',
            'customer_dlicense_state',
            'customer_dlicense_exp',
            'customer_passport',
            'customer_passport_exp',
            'position_at_current_employer',
            'employment_status',
            'current_employer',
            'employer_contact_number',
            'years_in_employment',
            'months_in_employment',
            'employment_confirmation',
            'life_support',
            'life_support_machine_type',
            'life_support_details',
            'NMI',
            'NMI_source',
            'MIRN',
            'MIRN_source',
            'connection_date',
            'electricity_connection',
            'gas_connection',
            '12_month_disconnection',
            'cert_electrical_safety',
            'cert_electrical_safety_ID',
            'cert_electrical_safety_sent',
            'explicit_informed_consent',
        );
    }
}