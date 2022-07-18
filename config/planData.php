<?php

return [

    'contract_length' => ["No Contract" => "No Contract", "12 month" => "12 month", "24 month" => "24 month", "36 month" => "36 month", "No Lock-In Contract" => "No Lock-In Contract", "Ongoing market contract" => "Ongoing market contract"],

    'benefit_terms' => ["12 month" => "12 month", "24 month" => "24 month", "36 month" => "36 month", "Ongoing" => "Ongoing", "No Benefit Term" => "No Benefit Term", "Minimum of 12 months" => "Minimum of 12 months", "12 Month Energy Plan Period" => "12 Month Energy Plan Period", "24 Month Energy Plan Period" => "24 Month Energy Plan Period"],

    'billing_option' => ["Monthly" => "Monthly", "Yearly" => "Yearly", "Quarterly" => "Quarterly", "Monthly/Quarterly" => "Monthly/Quarterly", "Every 2 Months" => "Every 2 Months", "Monthly and Quarterly available on request" => "Monthly and Quarterly available on request"],

    'apply_now_attributes' => ["@Provider_Name@" => "@Provider_Name@", "@Provider_Term_And_Conditions@" => "@Provider_Term_And_Conditions@", "@Provider_Logo@" => "@Provider_Logo@", "@name@" => "@name@", "@Provider_Phone_Number@" => "@Provider_Phone_Number@", "@Price_Fact_Sheet_Link@" => "@Price_Fact_Sheet_Link@", "@Provider_Email@" => "@Provider_Email@", "@Affiliate_Name@" => "@Affiliate_Name@", "@Affiliate_Logo@" => "@Affiliate_Logo@", "@Customer_Full_Name@" => "@Customer_Full_Name@", "@Customer_Mobile_Number@" => "@Customer_Mobile_Number@", "@Customer_Email@" => "@Customer_Email@"],

    'eic_attributes' => [' @Affiliate-Name@' => ' @Affiliate-Name@', '@Provider-Name@' => '@Provider-Name@', '@Provider-Phone-Number@' => '@Provider-Phone-Number@', ',@Provider-Address@' => '@Provider-Address@', '@Provider-Email@' => '@Provider-Email@'],

    'remarketing_attributes' => [' @Affiliate-Name@' => ' @Affiliate-Name@', '@Provider-Name@' => '@Provider-Name@', '@Provider-Phone-Number@' => '@Provider-Phone-Number@', ',@Provider-Address@' => '@Provider-Address@', '@Provider-Email@' => '@Provider-Email@'],

    'moduleTypes' => ['1' => 'Credit Check Consent', '2' => 'Move In', '3' => 'Paper Bill', '4' => 'Tele Sale', '5' => 'Terms & Conditions', '6' => 'Others', '7' => 'Bolt On'],


    'limitType' => ['' => 'Select Limit Type', 'peak' => 'Peak', 'offpeak' => 'Offpeak', 'shoulder' => 'Shoulder', 'c1' => 'Control Load 1', 'c2' => 'Control Load 2', 'summer_peak' => 'Summer Peak', 'winter_peak' => 'Winter Peak', 'c1_offpeak' => 'Control load 1 off-peak', 'c1_shoulder' => 'Control load 1 shoulder', 'c2_offpeak' => 'Control load 2 off-peak', 'c2_shoulder' => 'Control load 2 shoulder'],

    'limitTypeGas' => ['' => 'Select Limit Type', 'peak' => 'Peak', 'offpeak' => 'Offpeak', 'shoulder' => 'Shoulder', 'c1' => 'Control Load 1', 'c2' => 'Control Load 2'],

    'demandRateType' => ['' => 'Select rate type', 1 => 'Rate 1', 2 => 'Rate 2', 3 => 'Rate 3', 4 => 'Rate 4'],
    // 'demandUsageType'=>[''=>'Select Usage type','peak'=>'peak only','off_peak'=>'Off Peak 2','shoulder'=>'Shoulder 3'],
    'demandUsageType' => ['peak', 'off_peak', 'shoulder'],
    'demandUsageLevel' => [1, 2, 32768],
    'statusList' => ['all' => 'All', '1' => 'Active', '0' => 'Inactive'],



];
