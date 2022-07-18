<?php

namespace App\Traits\Provider\EnergyLocals;

trait Constant
{
    
    public $energylocalspostalFields = [
        'billingUnitNumber'=>'unit_number',
        'billingUnitType'=>'unit_type',
        'billingFloorNo'=>'floor_no',
        'billingHouseNo' => 'house_num',
        'billingHouseNoSuffix' => 'house_number_suffix',
        'billingFloorLevelType'=>'floor_level_type',
        'billingStreetName' => 'street_name',
        'billingStreetNumber'=>'street_number',
        'billingStreetCode' => 'street_code',
        'billingLotNumber' => "lot_number",
        'billingStreetNumberSuffix'=>'street_number_suffix',
        'billingStreetSuffix'=>'street_suffix',
        'billingPropertyName' => 'property_name',
        'billingSuburb'=>'suburb',
        'billingState'=>'state',
        'billingPostCode'=>'postcode'

    ];
    public $gdprFields = ['a_legal_name','a_support_phone_number','u1_first_name','u1_last_name','u1_email','a_legal_name','a_support_phone_number','visitor_phone'];
    
    public $hcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];

    public $pcc = ['Pensioner Concession Card', 'Queensland Government Seniors Card'];

    public $dvagc = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];
}