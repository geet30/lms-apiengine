<?php
  
namespace App\Traits\Provider\PowerShop;
  
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
            'Brand', // A
            'Channel ID', // B
            'Customer Type', //C
            'NMI', //D
            'MIRN', //E
            'Electricity Connection Date', //F
            'Gas Connection Date', //G
            'Type of Sale', //H
            'Fuel Type', //I
            'Title', //J
            'First Name', //K
            'Last Name', //L
            'Date of Birth', //M
            'Business Name', //N
            'Phone - Home', //O
            'Phone - Office', //P
            'Phone - Mobile', //Q
            'E-mail', //R
            'ABN', //S
            'ACN', //T
            'ID Number', //U
            'ID Expiry date', //V
            'Type of ID', //W
            'Concession Card Number', //X
            'Concession Card Type', //Y
            'Concession Card Expiry Date', //Z
            'Name on Concession Card', //AA
            'Second Person Title', //AB
            'Second First Name', //AC
            'Second Last Name', //AD
            'Second Person DOB', //AE
            'Supply Address', //AF
            'Supply Suburb', //AG
            'State/Territory', //AH
            'Postal Code', //AI
            'Mailing Address', //AJ
            'Mailing Suburb', //AK
            'Mailing State/Territory', //AL
            'Mailing Postal Code', //AM
            'Owner/Renter', //AN
            'Promo', //AO
            'Electricity Already On?', //AP
            'N/A', //AQ
            'N/A', //AR
            'N/A', //AS
            'N/A', //AT
            'N/A', //AU
            'Meter Number(s)', //AV
            'Any Hazards', //AW
            'Any Access Requirements?', //AX
            'Life Support/Sensitive Load', //AY
            'Advised Main Switch Needs Turning Off?', //AZ
            'Safety Certificate Required?', //BA
            'Token', //BB
            'Electricity Offer Status', //BC
            'Electricity Reference Number', //BD
            'Electricity Rejection/Incomplete Reason', //BE
            'Gas Offer Status', //BF
            'Gas Reference Number', //BG
            'Gas Rejection/Incomplete Reason', //BH
            'Other Comments' //BI
        ); 
    }
}