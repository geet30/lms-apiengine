<?php

namespace App\Traits\Provider\MomentumEnergy;

trait Constant
{
    public $addressFields = [
        'site_addr_unit_type' => 'unit_type_code',
        'site_addr_unit_no' => 'unit_number',
        'site_addr_floor_type' => 'floor_level_type',
        'site_addr_floor_no' => 'floor_no',
        'site_addr_street_no' => 'street_number',
        'site_addr_street_no_suffix' => 'street_number_suffix',
        'site_addr_street_name' => 'street_name',
        'site_street_type_code' => 'street_code',
        'site_addr_suburb' => 'suburb',
        'site_addr_city' => 'state',
        'site_addr_postcode' => 'postcode',
        'site_addr_property_name' => 'property_name'
    ];
    public $billingFields = [
        'lot_number' => 'lot_number',
        'unit_no' => 'unit_number',
        'street_number' => 'street_number',
        'street_name' => 'street_name',
        'street_code' => 'street_code',
        'cust_postal_addr_2' => 'suburb',
        'cust_postal_addr_3' => 'state',
        'cust_postal_post_code' => 'postcode'
    ];
    public $momentumHcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];
    public $momentumPcc = ['Pensioner Concession Card', 'Queensland Government Seniors Card', 'QLD Government Seniors Card', 'Australian Government ImmiCard (Asylum Seeker)'];
    public $momentumDva = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];
}