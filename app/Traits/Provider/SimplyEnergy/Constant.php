<?php

namespace App\Traits\Provider\SimplyEnergy;

trait Constant
{
    public $supplyFields = [
        'SupplyBuildingPropertyName'=>'property_name',
        'SupplyLotNumber'=>'lot_number',
        'SupplyFlatUnitType'=>'unit_type_code',
        'SupplyFlatUnitNumber'=>'unit_number',
        'SupplyFloorLevelType'=>'floor_level_type',
        'SupplyFloorLevelNumber'=>'floor_no',
        'SupplyHouseNumber'=>'street_number',
        'SupplyHouseNumberSuffix'=>'street_number_suffix',
        'SupplyStreet'=>'street_name',
        'SupplyStreetType'=>'street_code',
        'SupplyStreetSuffix'=>'street_suffix',
        'SupplySuburbTown'=>'suburb',
        'SupplyPostcode'=>'postcode',
        'SupplyState'=>'state'
    ];

    public $residentialFields = [
        'ResidentialBuildingPropertyName'=>'property_name',
        'ResidentialLotNumber'=>'lot_number',
        'ResidentialFlatUnitType'=>'unit_type_code',
        'ResidentialFlatUnitNumber'=>'unit_number',
        'ResidentialFloorLevelType'=>'floor_level_type',
        'ResidentialFloorLevelNumber'=>'floor_no',
        'ResidentialHouseNumber'=>'street_number',
        'ResidentialHouseNumberSuffix'=>'street_number_suffix',
        'ResidentialStreet'=>'street_name',
        'ResidentialStreetType'=>'street_code',
        'ResidentialStreetSuffix'=>'street_suffix',
        'ResidentialSuburbTown'=>'suburb',
        'ResidentialPostcode'=>'postcode',
        'ResidentialState'=>'state'
    ];

    public $postalFields = [
        'PostalBuildingPropertyName'=>'property_name',
        'PostalLotNumber'=>'lot_number',
        'PostalFlatUnitType'=>'unit_type_code',
        'PostalFlatUnitNumber'=>'unit_number',
        'PostalFloorLevelType'=>'floor_level_type',
        'PostalFloorLevelNumber'=>'floor_no',
        'PostalHouseNumber'=>'house_num',
        'PostalHouseNumberSuffix'=>'house_number_suffix',
        'PostalStreet'=>'street_name',
        'PostalStreetType'=>'street_code',
        'PostalStreetSuffix'=>'street_suffix',
        'PostalSuburbTown'=>'suburb',
        'PostalPostcode'=>'postcode',
        'PostalState'=>'state'
    ];
}