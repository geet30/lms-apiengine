<?php
  
namespace App\Traits\Provider\SimplyEnergy;
  
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
            'SalesAgent',  //A      				
            'TrackingNumber', //B 					
            'OfferType', //C
            'FeedInType', //D 						 
            'CampaignName', //E
            'ContractSignedDate', //F 
            'ElectricityProductCode',  //G
            'GasProductCode', //H
            'SupplyBuildingPropertyName', //I 
            'SupplyLotNumber', //J
            'SupplyFlatUnitType', //K
            'SupplyFlatUnitNumber', //L
            'SupplyFloorLevelType', //M
            'SupplyFloorLevelNumber', //N
            'SupplyHouseNumber', //O
            'SupplyHouseNumberSuffix', //P
            'SupplyStreet', //Q
            'SupplyStreetType', //R 
            'SupplyStreetSuffix', //S
            'SupplySuburbTown', //T
            'SupplyPostcode', //U
            'SupplyState', //V
            'NMI', //W
            'MIRN', //X
            'NumberOfBedrooms', //Y 				
            'OwnPremise', //Z 						
            'LifeSupport',  //AA 
            'Title', //AB
            'FirstName', //AC
            'LastName',  //AD
            'DateofBirth', //AE
            'PhoneBH', //AF 						
            'PhoneAH', //AG 						
            'PhoneMobile', //AH
            'EmailAddress', //AI
            'CompanyPositionHeld', //AJ
            'CustomerNumber', //AK
            'PinNumber', //AL
            'EstimatedAnnualUsage(kWh)', //AM
            'DriversLicense', //AN
            'Passport', //AO
            'Medicare', //AP
            'InternetExempt', //AQ 					
            'VisionImpairedExempt', //AR 			
            'PaperFeeExempt', //AS 					
            'CompanyName', //AT 
            'TradingName', //AU
            'AustralianBusinessNumber', //AV
            'AustralianCompanyNumber', //AW
            'BusinessType', //AX
            'IntendDigitalMailbox', //AY 			
            'WelcomePackDeliveryMethod', //AZ
            'MarketingMedia', //BA 					
            'AccountMedia', //BB
            'BillMedia', //BC
            'PaymentMethod', //BD 					
            'BankName', //BE 						 
            'BankBranchNumber', //BF 				 
            'BankAccountNumber', //BG 				 
            'BankAccountHolderName', //BH 			 
            'CreditCardType', //BI 					 
            'CreditCardNumber', //BJ 				
            'CreditCardExpiry', //BK         	 
            'CreditCardHolderName', //BL 	 
            'PensionType', //BM
            'PensionNumber', //BN
            'PensionStartDate', //BO
            'PensionCardFirstName', //BP
            'PensionCardOtherNames', //BP
            'PensionCardSurname', //BQ
            'RewardPlanMembershipId', //BR 			
            'SurnameOnRewardCard', //BS 			
            'NameInitialOnRewardCard', //BT 	
            'ResidentialBuildingPropertyName', //BU  
            'ResidentialLotNumber', //BV
            'ResidentialFlatUnitType', //BW
            'ResidentialFlatUnitNumber', //BX
            'ResidentialFloorLevelType', //BY
            'ResidentialFloorLevelNumber', //BZ
            'ResidentialHouseNumber', //CA
            'ResidentialHouseNumberSuffix', //CB
            'ResidentialStreet', //CC
            'ResidentialStreetType', //CD
            'ResidentialStreetSuffix', //CE
            'ResidentialSuburbTown', //CF
            'ResidentialPostcode', //CG
            'ResidentialState', //CH
            'PostalBuildingPropertyName', //CI
            'PostalLotNumber', //CJ
            'PostalFlatUnitType', //CK
            'PostalFlatUnitNumber', //CL
            'PostalFloorLevelType', //CM
            'PostalFloorLevelNumber', //CN
            'PostalHouseNumber', //CO
            'PostalHouseNumberSuffix', //CP 
            'PostalDeliveryType', //CQ
            'PostalDeliveryNumber', //CR
            'PostalStreet', //CS
            'PostalStreetType', //CT
            'PostalStreetSuffix', //CU
            'PostalSuburbTown', //CV
            'PostalPostcode', //CW
            'PostalState', //CX
            'Customer2Title', //CY
            'Customer2FirstName', //CZ
            'Customer2LastName', //DA
            'Customer2DateOfBirth', //DB
            'Customer2PhoneBH', //DC
            'Customer2PhoneAH', //DD
            'Customer2PhoneMobile', //DE
            'Customer2EmailAddress', //DF
            'Customer2CompanyPositionHeld', //DG
            'Customer2Signatory', //DH
            'Customer3Title', //DI
            'Customer3FirstName', //DJ
            'Customer3LastName', //DK
            'Customer3DateOfBirth', //DL
            'Customer3PhoneBH', //DM
            'Customer3PhoneAH', //DN
            'Customer3PhoneMobile', //DO$key_array
            'Customer3EmailAddress', //DP 
            'Customer3CompanyPositionHeld', //DQ 
            'Customer3Signatory', //DR
            'EnergisationDate', //DS
            'ServiceOrderSubType', //DT
            'ServiceTime', //DU
            'CustomerPreferredDate', //DV
            'CustomerPreferredTime', //DW
            'ElectricityAdminFeeWaived', //DX
            'ElectricityAdminFeeWaiverReason', //DY 
            'ElecSOFeeWaive', //DZ
            'ElecSOFeeWReason', //EA
            'ElectricitySpecialInstructions', //EB 
            'ElectricityAccessDetails', //EC
            'GasAdminFeeWaived', //ED
            'GasAdminFeeWaiverReason', //EE 
            'GasSOFeeWaive', //EF
            'GasSOFeeWReason', //EG
            'GasSpecialInstructions', //EH 
            'GasAccessDetails', //EI
            'GasSpecialReadReason', //EJ
            'TeamPreference', //EK
            'PrimarySite', //EL
            'SupplyBuildingPropertyNameGas', //EN
            'SupplyLotNumberGas',
            'SupplyFlatUnitTypeGas',
            'SupplyFlatUnitNumberGas',
            'SupplyFloorLevelTypeGas',
            'SupplyFloorLevelNumberGas',
            'SupplyHouseNumberGas',
            'SupplyHouseNumberSuffixGas',
            'SupplyStreetGas',
            'SupplyStreetTypeGas',
            'SupplyStreetSuffixGas',
            'SupplySuburbTownGas',
            'SupplyPostcodeGas',
            'SupplyStateGas',
            'SalesMethod',
            /** CAF changes added on 30 sept 2021 **/
            'CustomerPreferredTransferType',
            'CustomerPreferredReadType',
            'MultisiteSME',
            'PreferredTransferDate',
            /** End **/
        );
    }
}