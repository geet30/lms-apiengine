<?php

namespace App\Traits\Provider\AGL;

trait Constant
{
    public $gdprFields = ['a_legal_name','a_support_phone_number','u1_first_name','u1_last_name','u1_email','a_legal_name','a_support_phone_number','visitor_phone'];
    
    public $hcc = ['Centrelink Healthcare Card', 'Commonwealth Senior Health Card'];

    public $pcc = ['Pensioner Concession Card', 'Queensland Government Seniors Card'];

    public $dvagc = ['DVA Gold Card', 'DVA Gold Card(War Widow)', 'DVA Gold Card(TPI)', 'DVA Gold Card(Extreme Disablement Adjustment)', 'DVA Pension Concession Card'];
}