<?php
  
namespace App\Traits\Provider\Tango;
  
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
            'vendor_id',  //A 1     				
            'Agent', //B 2					
            'ChannelRef', //C 3
            'SaleRef', //D 4						 
            'LeadID', //E 5
            'Incentive', //F  6
            'DateofSale',  //G 7
            'CampaignRef', //H 8
            'PromoCode', //I  9
            'CurrentElecRetailer', //J 10
            'CurrentGasRetailer', //K 11
            'Multisite', //L 12
            'ExistingCustomer', //M 13
            'CustomerAccountNumber', //N 14
            'CustomerType', //O 15
            'AccountName', //P 16
            'ABN', //Q 17
            'ACN', //R 18
            'BusinessName', //S 19
            'BusinessType', //T 20
            'TrusteeName', //U 21
            'TradingName', //V 22
            'Position', //W 23
            'SaleType', //X 24
            'CustomerTitle', //Y 25
            'FirstName', //Z 26				
            'LastName',  //AA 27 
            'PhoneLandline', //AB 28
            'PhoneMobile', //AC 29
            'AuthenticationDateOfBirth',  //AD 30
            'AuthenticationExpiry', //AE 31
            'AuthenticationNo', //AF 32						
            'AuthenticationType', //AG 	33				
            'Email', //AH 34
            'LifeSupport', //AI 35
            'ConcessionerNumber', //AJ 36
            'ConcessionExpiryDate', //AK 37
            'ConcessionFlag', //AL 38
            'ConcessionStartDate', //AM 39
            'ConcessionType', //AN 40
            'ConcFirstName', //AO 41
            'ConcLastName', //AP 42
            'SecondaryCustomerTitle', //AQ 	43
            'SecondaryFirstName', //AR 44
            'SecondaryLastName', //AS 	45		
            'SecondaryAuthenticationDateOfBirth', //AT 46
            'SecondaryEmail', //AU 47
            'SecondaryPhoneHome', //AV 48
            'SecondaryPhoneMobile', //AW 49
            'SecondaryAuthenticationExpiry', //AX 50
            'SecondaryAuthenticationNo', //AY 51
            'SecondaryAuthenticationType', //AZ 52
            'SiteApartmentNumber', //BA 53 					
            'SiteApartmentType', //BB 54
            'SiteBuildingName', //BC 55
            'SiteFloorNumber', //BD 	56				
            'SiteFloorType', //BE 	57					 
            'SiteLocationDescription', //BF 58
            'SiteLotNumber', //BG  59				 
            'SiteStreetName', //BH 60 			 
            'SiteStreetNumber', //BI 	61				 
            'SiteStreetNumberSuffix', //BJ 62				
            'SiteStreetType', //BK   63
            'SiteStreetSuffix', //BL 64
            'SiteSuburb', //BM 65
            'SiteState', //BN 66
            'SitePostCode', //BO 67 
            'GasSiteApartmentNumber', //BP 68
            'GasSiteApartmentType', //BP 69 
            'GasSiteBuildingName', //BQ 70
            'GasSiteFloorNumber', //BR 	71
            'GasSiteFloorType', //BS 72		
            'GasSiteLocationDescription', //BT 73
            'GasSiteLotNumber', //BU  74
            'GasSiteStreetName', //BV 75
            'GasSiteStreetNumber', //BW 76
            'GasSiteStreetNumberSuffix', //BX 77
            'GasSiteStreetType', //BY 78
            'GasSiteStreetSuffix', //BZ 79
            'GasSiteSuburb', //CA 80
            'GasSiteState', //CB 81
            'GasSitePostCode', //CC 82
            'NMI', //CD 83
            'MIRN', //CE 84
            'Fuel', //CF 85 
            'FeedIn', //CG 86
            'AnnualUsage', //CH 87 
            'GasAnnualUsage', //CI 88
            'ProductCode', //CJ 89
            'GasProductCode', //CK 90
            'OfferDescription', //CL 91
            'GasOfferDescription', //CM 92
            'GreenPercent', //CN 93
            'ProposedTransferDate', //CO 94
            'GasProposedTransferDate', //CP 95
            'BillCycleCode', //CQ 96
            'GasBillCycleCode', //CR 97
            'Averagemonthlyspend',
            'IsOwner', //CS 98
            'HasAcceptedMarketing', //CT 99
            'EmailAccountNotice', //CU 100
            'EmailInvoice', //CV 101
            'BillingEmail', //CW 102
            'PostalApartmentNumber', //CX 103
            'PostalApartmentType', //CY 104
            'PostalFloorNumber', //CZ 105
            'PostalFloorType', //DA 106
            'PostalLotNo', //DB 107
            'PostalBuildingName', //DC 108
            'PostalStreetNumber', //DD 109
            'PostalStreetNumberSuffix', //DE 110
            'PostalStreetName', //DF 111
            'PostalStreetType', //DG 112
            'PostPropertyName', //DH 113
            'PostalStreetSuffix', //DI 114
            'PostalSuburb', //DJ 115
            'PostalPostCode', //DK 116
            'PostalState', //DL 117
            'Comments', //DM 118
            'TransferSpecialInstructions', //DN 119
            'MedicalCoolingEnergyRebate', //DO$key_array 120
            'BenefitEndDate', //DP  121
            'SalesClass', //DQ  122
            'BillGroupCode', //DR 123
            'GasMeterNumber' //DS 124
        );
    }
}