<?php

namespace App\Traits\Provider\AlintaEnergy;

trait Constant
{
    public $gdprFields = ['a_legal_name','a_support_phone_number','u1_first_name','u1_last_name','u1_email','a_legal_name','a_support_phone_number','visitor_phone'];
    
    public $hcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];

    public $pcc = ['Pensioner Concession Card', 'Queensland Government Seniors Card'];

    public $dvagc = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];

    public $alintaAddressFields = [
        'lot_number' => 'lot_number',
        'site_addr_unit_type' => 'unit_type',
        'site_addr_unit_no' => 'unit_number',
        'site_addr_floor_type' => 'floor_level_type',
        'site_addr_floor_no' => 'floor_no',
        'site_addr_street_no' => 'street_number',
        'site_streetno_suffix' => 'street_number_suffix',
        'site_addr_street_name' => 'street_name',
        'stype_code' => 'street_code',
        'site_addr_suburb' => 'suburb',
        'site_addr_city' => 'state',
        'spost_code' => 'postcode',
        'site_addr_property_name' => 'property_name',
        'site_addr_street_suffix' => 'street_suffix'
    ];
}