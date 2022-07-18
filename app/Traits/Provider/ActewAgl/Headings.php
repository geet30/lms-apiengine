<?php
  
namespace App\Traits\Provider\ActewAgl;
  
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
            'Receipt Number',// A
            'Utility Type',//B
            'NMI / MIRN',//C
            'Account Number',//D
            'Existing Account Number',//E
            'Account Manager',//F
            'Residential/Business/Commercial',//G
            'Company Trading Name',//H
            'ABN Number',//I
            'Business Name',//J
            'Business Email Address',//K
            'Business Phone No',//L
            'Customer ID',//M
            'Title',//N
            'First Name',//O
            'Last Name',//P
            'Date of Birth',//Q
            'Email Address',//R
            'Private Phone No',//S
            'Private Mobile No',//T
            'Work Phone No',//U
            'Communication Preference',//V
            'ID TYPE',//W
            'ID number',//X
            'ID State',//Y
            'Additional Customer ID',//Z
            'Additional Account Holder Title',//AA
            'Additional Account Holder First Name',//AB
            'Additional Account Holder Last Name',//AC
            'Additional Account Holder Date of birth',//AD
            'Additional Account Holder Email address',//AE
            'Additional Account Holder Private phone no',//EF
            'Additional Account Holder Private mobile no',//EG
            'Additional Account Holder Work phone no',//EH
            'ID TYPE',//EI
            'ID number',//AJ
            'ID State',//AK
            'Concession Group',//AL
            'Concession Card Holder',//AM
            'Concession Card number',//AN
            'Concession Card Type',//AO
            'Concession Card Start Date',//AP
            'Health care card expiry date',//AQ
            'Concession Consent',//AR
            'Life Support',//AS
            'lifeSupportFuel',
            'Installation address - Building name',//AT
            'Installation address - Floor Number',//AU
            'Installation address - Floor Type',//AV
            'Installation address - Unit Type',//AW
            'Installation address - Unit number',//AX
            'Installation address - House number',//AY
            'Installation address - Street name',//AZ
            'Installation address - Street Type',//BA
            'Installation address - Suburb',//BB
            'Installation address - State',//BC
            'Installation address - Postcode',//BD
            'Is postal the same as install address',//BE
            'Postal address - Building name',//BF
            'Postal address - Floor',//BG
            'Postal address - Floor Type',//BH
            'Post address - Unit Type',//BI
            'Postal address - Unit number',//BJ
            'Postal address - House number',//BK
            'Postal address - Street name',//BL
            'Post address - Street Type',//BM
            'Postal address - PO Box',//BN
            'Postal address - SubgetProviderExcelSenturb',//BO
            'Postal address - StagetProviderExcelSentte',//BP
            'Postal address - Postcode',//BQ
            'Installation Pricing Class',//BR
            'End Use',//BS
            'Geographical Area',//BT
            'Billed Before',//BU
            'Consumer Proposed Entry Date',//BV
            'Own/Rent',//BW
            'Private or Agency Rental',//BX
            'Rental Agency',//BY
            'Sales Channel',//BZ
            'Sales Date',//CA
            'Bundle Code',//CB
            'Participant roles (RP)',//CC
            'Participant roles (MDP)',//CD
            'Participant roles (MPB)',//CE
            'Participant roles (MPC)',//CF
            'Notes',//CG
            'Spare',//CH
            'Re-energisation Preferred Date',//CI
            'Re-energisation Preferred Time',//CJ
            'Greenchoice Type',//CK
            'Greenchoice Value',//CL
            'Greenchoice Start Date',//CM
            'Greenchoice End Date',//CN
            'Actual Read Required' //CP
        );
    }
}