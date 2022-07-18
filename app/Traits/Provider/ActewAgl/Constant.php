<?php

namespace App\Traits\Provider\ActewAgl;

trait Constant
{
    public $aglHcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];

    public $cc = ['Pensioner Concession Card'];

    public $qld = ['Queensland Government Seniors Card'];

    public $dva = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];

    public $aglAddressFields = ['property_name', 'floor_no', 'floor_type_code', 'unit_type_code', 'unit_number', 'street_number', 'street_name', 'street_code','suburb','state','postcode','unit_type'];
}