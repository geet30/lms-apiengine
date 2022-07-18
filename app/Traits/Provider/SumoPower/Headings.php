<?php
  
namespace App\Traits\Provider\SumoPower;
  
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
            'CommodityType',// A
            'CustomerTitle',// B
            'FirstName',// C
            'LastName',// D
            'SecondaryCustomerTitle', // E
            'SecondaryFirstName', // F
            'SecondaryLastName', // G
            'AuthenticationType',// H
            'AuthenticationNo', // I
            'AuthenticationName',// J
            'AuthenticationDateOfBirth', // K
            'SecondaryAuthenticationType', // L
            'SecondaryAuthenticationNo',// M
            'SecondaryAuthenticationName',// N
            'SecondaryAuthenticationDateOfBirth',// O
            'PhoneHome',// P
            'PhoneMobile',// Q
            'Email',// R
            'SecondaryPhoneHome',// S
            'SecondaryPhoneMobile',// T
            'SecondaryEmail',// U
            'CustomerType',// V
            'InvoiceDisplayName',// W
            'CustomerReference',// X
            'NMI',// Y
            'MIRN',// Z
            'ElecProductOffer',// AA
            'GasProductOffer',// AB
            'ProposedTransferDate',// AC
            'EmailInvoice',// AD
            'CommunicationMethod',// AE
            'ConcessionType',// AF
            'ConcessionerNumber',// AG
            'ConcessionerElectricityRebate',// AH
            'ConcessionerDeclarationProvided',// AI
            'OccupancyType',// AJ
            'IsOwner',// AK
            'LifeSupport',// AL
            'lifeSupportFuel',
            'SiteBuildingName',// AM
            'SiteLocationDescriptor',// AN
            'SiteLotNumber',// AO
            'SiteFloorType',// AP
            'SiteFloorNumber',// AQ
            'SiteApartmentType',// AR
            'SiteApartmentNumber',// AS
            'SiteStreetNumber',// AT
            'SiteStreetNumberSuffix',// AU
            'SiteStreetName',// AV
            'SiteStreetType',// AW
            'SiteStreetSuffix',// AX
            'SiteSuburb',// AY
            'SiteState',// AZ
            'SitePostCode',// BA
            'SiteAddressIsPostalAddress',// BB
            'UseStructuredPostalAddress',// BC
            'PostalUnstructuredAddress1',// BD
            'PostalUnstructuredAddress2',// BE
            'PostalUnstructuredAddress3',// BF
            'PostalFloorType',// BG
            'PostalFloorNumber',// BH
            'PostalApartmentType',// BI
            'PostalApartmentNumber',// BJ
            'PostalStreetNumber',// BK
            'Postal Street Number Suffix',// BL
            'PostalStreetName',// BM
            'PostalStreetType',// BN
            'PostalStreetSuffix',// BO
            'PostalSuburb',// BP
            'PostalState',// BQ
            'PostalPostCode',// BR
            'PostalCountry',// BS
            'SalesRepresentative',// BT
            'HasAcceptedMarketing',// BU
            'HasAcceptedConditions',// BV
            'MiddleName',// BW
            'SecondaryContactMiddleName',// BX
            'DateofSale',// BY
            'ElecPromoCode',// BZ
            'GasPromoCode',// CA
            'Solar',// CB
            'ABN',// CC
            'ACN',// CD
            'ExistingSumoPowerCustomer',// CE
            'CustomerAccountNumber',// CF
            'CompanyBillingContact',// CG
            'MovingHouse',// CH
            'HouseholdSize',// CI
            'ElecAverageDailyUsage',// CJ
            'GasAverageDailyUsage',// CK
            'ElecEstimatedBillAmount',// CL
            'GasEstimatedBillAmount',// CM
        ];
    }
}