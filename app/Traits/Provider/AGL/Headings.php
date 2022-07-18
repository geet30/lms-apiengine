<?php
  
namespace App\Traits\Provider\AGL;
  
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
            'VENDOR',				//A
            'VENDOR_BP',			//B
            'CHANNEL',				//C
            'BATCH_NUMBER',			//D
            'TRANSACTION_TYPE',		//E
            'LEAD_ID',		   		//F
            'RESUBMISSION_COUNT',	//G
            'RESUBMISSION_COMMENT',	//H
            'TITLE',				//I
            'NAME_FIRST',			//J
            'NAME_MIDDLE',			//J
            'NAME_LAST',			//K
            'DOB',					//L
            'BUILDING_NAME',		//M
            'FLOOR',				//N
            'LOT_NUMBER',			//O
            'UNIT_NUMBER',			//P
            'STREET_NUMBER',		//Q
            'STREET_NAME',			//R
            'SUBURB',				//S
            'STATE',				//T
            'POSTCODE',				//U
            'PHONE_HOME',			//V
            'PHONE_WORK',			//W
            'PHONE_MOBILE',			//X
            'EMAIL',				//Y
            'MARKETING',			//Z
            'ECONF_PACK_CONSENT',	//AA
            'ECOMM_CONSENT',		//AB
            'PRIMARY_SMS_CONSENT',	//AC
            'CREDIT_CONSENT',		//AD
            'AP_TITLE',				//AE
            'AP_FIRST_NAME',		//AF
            'AP_MIDDLE_NAME',		//AG
            'AP_LAST_NAME',			//AH
            'AP_PHONE_HOME',		//AI
            'AP_PHONE_WORK',		//AJ
            'AP_PHONE_MOBILE',		//AK
            'AP_DOB',				//AL
            'AP_DRIVERS_LICENSE',	//AM
            'BUSINESS_NAME',		//AN
            'LEGAL_NAME',			//AO
            'ABN_ACN',				//AP
            'BUSINESS_TYPE',		//AQ
            'MAILING_BUILDING_NAME', //AR
            'MAILING_FLOOR',		//AS
            'MAILING_LOT_NUMBER',	//AT
            'MAILING_UNIT_NUMBER',	//AU
            'MAILING_STREET_NUMBER', //AV
            'MAILING_STREET_NAME',	//AW
            'MAILING_SUBURB',		//AX
            'MAILING_STATE',		//AY
            'MAILING_POSTCODE',		//AZ
            'CONCESSION_TYPE',		//BB
            'CONCESSION_NUMBER',	//BC
            'VALID_TO',				//BD
            'DRIVERS_LICENSE',		//BE
            'PASSPORT',				//BF
            'MEDICARE_NUMBER',		//BG
            'LIFE_SUPPORT',			//BH
            'DD_REQ',				//BI
            'NMI',					//BJ
            'DPI_MIRN',				//BK
            'METER_NUMBER_E',		//BL
            'METER_NUMBER_G',		//BM
            'METER_TYPE',			//BN
            'METER_HAZARD_E',		//BO
            'DOG_CODE_G',			//BP
            'SITE_ACCESS_E',		//BQ
            'SITE_ACCESS_G',		//BR
            'RE_EN_REMOTE_SAFETY_CONFIRMATION', //BS
            'DE_EN_REMOTE_SAFETY_CONFIRMATION', //BT
            'SO_REQ',				//BU
            'RETAILER',				//BV
            'PROGRAM',				//BW
            'CAMPAIGN',				//BX
            'SALES_DATE',			//BY
            'CONTRACT_NUMBER',		//BZ
            'OFFER_TYPE',			//CA
            'PRODUCT_CODE_E',		//CB
            'PRODUCT_CODE_G',		//CC
            'CAMPAIGN_CODE_RES_ELEC',	//CD
            'CAMPAIGN_CODE_RES_GAS',	//CE
            'CAMPAIGN_CODE_SME_ELEC',	//CF
            'CAMPAIGN_CODE_SME_GAS',	//CG
            'MATRIX_CODE',			//CH
            'TARIFF_TYPE',			//CI
            'FLEX_PRICE',			//CJ
            'REFERRER_NUMBER',		//CK
            'FLYBUYS_CONSENT',		//CL
            'FLYBUYS_NUMBER',		//CM
            'FLYBUYS_POINTS',		//CN
            'AEO_REG',				//CO
            'OWN_RENT',				//CP
            'PROMOTION_CODE',		//CQ
            'MERCH_REQ',			//CR
            'AGL_ASSIST',			//CS
            'GAS_OFFER',			//CT
            'ELEC_OFFER',			//CU
            'MOVEIN_DATE_E',		//CV
            'MOVEIN_DATE_G',		//CW
            'MOVEIN_INSTRUCT_E',	//CX
            'MOVEIN_INSTRUCT_G',	//CY
            'MOVEOUT_DATE_E',		//CZ
            'MOVEOUT_DATE_G',		//DA
            'MOVEOUT_INSTRUCT_E',	//DB
            'MOVEOUT_INSTRUCT_G',	//DC
            'GREENSALE',			//DD
            'AARH_DONATION',		//DE
            'EPFS_REQ',				//DF
            'SALES_AGENT',			//DG
            'EXISTING_GAS_BP_NUMBER',	//DH
            'EXISTING_ELEC_BP_NUMBER',	//DI
            'EXISTING_CRN_NUMBER',	//DJ
            'CANCELLATION_DATE',	//DK
            'CANCELLATION_TYPE',	//DL
            'CANCELLATION_REASON',	//DM
            'CANCELLATION_REASON_OTHER',	//DN
            'QUOTE_DATE',			//DO
            'QUOTE_TYPE',			//DP
            'CHANGE_REQUEST',		//DQ
            'CHANGE_REQUEST_DATE',	//DR
            'COMMENTS'				//DS
        );
    }
}