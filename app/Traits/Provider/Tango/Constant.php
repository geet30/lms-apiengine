<?php

namespace App\Traits\Provider\Tango;

trait Constant
{
    public $electricityAddressFields = [
        'SiteApartmentNumber'=>'unit_number',
        'SiteApartmentType'=>'unit_type',
        'SiteBuildingName'=>'property_name',
        'SiteFloorNumber'=>'floor_no',
        'SiteFloorType'=>'floor_type_code',
        "SiteLocationDescription" => "site_descriptor", 
        'SiteLotNumber'=>'lot_number',
        'SiteStreetName'=>'street_name',
        'SiteStreetNumber'=>'street_number',
        'SiteStreetNumberSuffix'=>'street_number_suffix',
        'SiteStreetType'=>'street_code',
        'SiteStreetSuffix'=>'street_suffix',
        'SiteSuburb'=>'suburb',
        'SiteState'=>'state',
        'SitePostCode'=>'postcode'
    ];
    public $gasAddressFields = [
        'SiteApartmentNumber'=>'unit_number',
        'SiteApartmentType'=>'unit_type',
        'SiteBuildingName'=>'property_name',
        'SiteFloorNumber'=>'floor_no',
        'SiteFloorType'=>'floor_type_code',
        "SiteLocationDescription" => "site_descriptor", 
        'SiteLotNumber'=>'lot_number',
        'SiteStreetName'=>'street_name',
        'SiteStreetNumber'=>'street_number',
        'SiteStreetNumberSuffix'=>'street_number_suffix',
        'SiteStreetType'=>'street_code',
        'SiteStreetSuffix'=>'street_suffix',
        'SiteSuburb'=>'suburb',
        'SiteState'=>'state',
        'SitePostCode'=>'postcode',
        'GasSiteApartmentNumber' => 'unit_number',
        'GasSiteApartmentType'=>'unit_type',
        'GasSiteBuildingName'=>'property_name',
        'GasSiteFloorNumber'=>'floor_no',
        'GasSiteFloorType'=>'floor_type_code',
        "GasSiteLocationDescription" => "site_descriptor", 
        'GasSiteLotNumber'=>'lot_number',
        'GasSiteStreetName'=>'street_name',
        'GasSiteStreetNumber'=>'street_number',
        'GasSiteStreetNumberSuffix'=>'street_number_suffix',
        'GasSiteStreetType'=>'street_code',
        'GasSiteStreetSuffix'=>'street_suffix',
        'GasSiteSuburb'=>'suburb',
        'GasSiteState'=>'state',
        'GasSitePostCode'=>'postcode'

    ];
    public $tangopostalFields = [
        'PostalApartmentNumber'=>'unit_number',
        'PostalApartmentType'=>'unit_type',
        'PostalFloorNumber'=>'floor_no',
        'PostalFloorType'=>'floor_type_code',
        'PostalStreetName' => 'street_name',
        'PostalStreetNumber'=>'street_number',
        'PostalStreetType' => 'street_code',
        'PostalLotNo' => "lot_number",
        'PostalStreetNumberSuffix'=>'street_number_suffix',
        'PostalStreetSuffix'=>'street_suffix',
        'PostalBuildingName' => 'property_name',
        'PostPropertyName'=>'property_name',
        'PostalSuburb'=>'suburb',
        'PostalState'=>'state',
        'PostalPostCode'=>'postcode'

    ];
    public $gdprFields = ['a_legal_name','a_support_phone_number','u1_first_name','u1_last_name','u1_email','a_legal_name','a_support_phone_number','visitor_phone'];
    
    public $hcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];

    public $pcc = ['Pensioner Concession Card', 'Queensland Government Seniors Card'];
    public $tangoEnergyId = 4;
    public $dvagc = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];
    public $DVAGC_TPI = ['DVA Gold Card(TPI)'];
    public $DVAPCC = ['DVA Pension Concession Card'];
}
