<?php

namespace App\Traits\Provider\SumoPower;

trait Constant
{
    public $sumoAddressFields = [
        'PostalFloorType' => 'floor_level_type', //PostalFloorType - excel column BG
        'PostalFloorNo' => 'floor_no',  //PostalFloorNumber - excel column BH
        'PostalApartmentType' => 'unit_type', //PostalApartmentType - excel column BI
        'PostalApartmentNumber' => 'unit_number', //PostalApartmentNumber - excel column BJ
        'PostalStreetNumber' => 'street_number', //PostalStreetNumber - excel column BK
        'Postal_Street_Number_Suffix' => '', //Postal Street Number Suffix - excel column BM
        'PostalStreetName' => 'street_name', //Postal Street Number Suffix - excel column BM
        'PostalStreetType' => 'street_code', //Postal Street Name - excel column BM
        'PostalStreetSuffix' => 'street_suffix', //Postal Street Type - excel column BN
        'PostalSuburb' => 'suburb', //PostalStreetSuffix - excel column BO
        'PostalState' => 'state', //PostalSuburb - excel column BP
        'PostalPostCode' => 'postcode' //PostalState - excel column BQ
    ];
}
