<?php
  
namespace App\Traits\Provider\EnergyAustralia;
  
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
            'Vendor ID',
            'Sale Date',
            'Elec Source Code',
            'Gas Source Code',
            'Customer Type',
            'Offer Type',
            'Connection Date',
            'Visual Inspection',
            'Electricity Already On?',
            'Inspection Timeframe',
            'Special Instructions for Access',
            'VIC Only - Renovation/Alterations at the property currently?',
            'VIC Only - Renovation/Alterations at the property (previously)?',
            'VIC ONLY - Mains Switch OFF',
            'Business Name',
            'ABN/ACN',
            'Business Type',
            'First Account Holder Title',
            'First Account Holder Firstname',
            'First Account Holder Surname',
            'First Account Holder DOB',
            'Phone Type',
            'Phone Number',
            'Email Welcome Consent',
            'Email Billing',
            'Email Address',
            'ID First name', //aa
            'ID Middle name', //ab
            'ID Surname', //ac
            'ID Type',
            'ID Number',
            'Medicare Expiry date', //af
            'DRV State/Medicare Card Colour/Country of Issue', //AG
            'Medicare Card Reference Number', //AH
            'Primary Id Flag',
            'Second Account Holder Title',
            'Second Account Holder Firstname',
            'Second Account Holder Surname',
            'Second Account Holder DOB',
            'Supply Unit/Flat Number',
            'Supply Street Number',
            'Supply Street Name',
            'Supply  Street Type',
            'Supply Suburb',
            'Supply State',
            'Supply Postcode',
            'Mailing Unit/Flat Number',
            'Mailing Street Number',
            'Mailing Street Name',
            'Mailing Street Type',
            'Mailing Suburb',
            'Mailing State',
            'Mailing Postcode',
            'NMI',
            'MIRN',
            'Premise Type',
            'DPID',
            'Fuel elec',
            'Fuel gas',
            'Elec Plan',
            'Gas Plan',
            'ACT Only - Green Energy', //BJ
            'Windpower',
            'Payment Method',
            'Additonal Comments',
            'Elec Status',
            'Gas Status',
            'Elec Reason',
            'Gas Reason',
            'Quote ID - Elec',
            'Quote ID - Gas',
            'Go Neutral',
            'Solar Y/N',
            'Tariff Code',
            'Solar Buyback Rate'
        );
    }
}