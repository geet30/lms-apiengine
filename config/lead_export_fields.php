<?php 

return [
    'mobile_sale_fields' => array(
        'Sale Status' => array("Sale Id","Sale Status"),
        'Customer Info' => array("Customer Title","Customer First Name","Customer Last name","Customer Email","Customer Phone","Customer DOB","User browser Information","User Browser Version","Platform","Device Type","Sale IP","Lead IP","Lead Date Time","Lattitude","Longitude"),
        'Customer Journey' => array("Complete Address","Move In Date","Plan Name","Service Type","Connection Type","Total Plan Cost","Provider Name"),
        'Employment Details' => array("Employer Name","Occupation","Employment Duration","Have Credit Card","Occupation Type","Industry","Employment Status"),
        'Affiliate Section' => array("Affiliate Name","Affiliate Comment", "SubAffiliate Name","Sub Affiliate Referal Code"),
        'Stage Section' => array("Source","RC","CUI","UTM SOURCE","UTM MEDIUM","UTM CAMPAIGN","UTM TERM","UTM CONTENT","GCLID","FBCLID","Sale Id","UTM RM","UTM RM Source","UTM RM Date"),
        'Primary Identification' => array("Primary Identification Type","Primary Identification Number","Primary Identification Expiry","Primary Medicare Individual Reference Number","Primary Medicare Middle Name on Card","Primary Medicare Card Color","Primary License State Code"),
        'Secondary Identification' => array("Secondary Identification Type","Secondary Identification Number","Secondary Identification Expiry","Secondary Medicare Individual Reference Number","Secondary Medicare Middle Name on Card","Secondary Medicare Card Color","Secondary License State Code"),
      /*  'Address Details' => array("Time at current address","Previous address","Delivery Address","Billing Address","Resident Status","Connection Delivery Date"),
        'Plan Information' => array("Internet Speed","Contract Length","Total Data Allowance","Download Speed","Upload Speed","Special Offer Price","Special Offer Description","NBN Key Fact","Critical Information","Plan Acknowledgment Consent","Monthly Cost","Setup Fee","Delivery Fee"),
        'Plan Fees' => array("Setup Fee","Delivery Fee","Payment Processing Fees","Termination Fee","Other Fee and Charges","Minimum Total Cost"),
        'Included Addons' => array("Included Home Line Connection","Included Modem","Included Other Addons"),
        'Addons' => array("Home Line Connection","Modem","Other Addons"),
        'Connection Details' => array("Account with Current Provider","Account Number","Existing Phone Number","Home number","Provider account number","Transfer Service"),*/
    ),
    'mobile_lead_fields' => array(
        'Sale Status' => array("Lead Id","Sale Status"),
        'Customer Info' => array("Customer Title","Customer First Name","Customer Last name","Customer Email","Customer Phone","Customer DOB","User browser Information","User Browser Version","Platform","Device Type","Sale IP","Lead IP","Lead Date Time","Lattitude","Longitude"),
        'Customer Journey' => array("Complete Address","Move In Date","Plan Name","Service Type","Connection Type","Total Plan Cost","Provider Name"),
        'Employment Details' => array("Employer Name","Occupation","Employment Duration","Have Credit Card","Occupation Type","Industry","Employment Status"),
        'Affiliate Section' => array("Affiliate Name","Affiliate Comment", "SubAffiliate Name","Sub Affiliate Referal Code"),
        'Stage Section' => array("Source","RC","CUI","UTM SOURCE","UTM MEDIUM","UTM CAMPAIGN","UTM TERM","UTM CONTENT","GCLID","FBCLID","Sale Id","UTM RM","UTM RM Source","UTM RM Date"),
        'Primary Identification' => array("Primary Identification Type","Primary Identification Number","Primary Identification Expiry","Primary Medicare Individual Reference Number","Primary Medicare Middle Name on Card","Primary Medicare Card Color","Primary License State Code"),
        'Secondary Identification' => array("Secondary Identification Type","Secondary Identification Number","Secondary Identification Expiry","Secondary Medicare Individual Reference Number","Secondary Medicare Middle Name on Card","Secondary Medicare Card Color","Secondary License State Code"),
      /*  'Address Details' => array("Time at current address","Previous address","Delivery Address","Billing Address","Resident Status","Connection Delivery Date"),
        'Plan Information' => array("Internet Speed","Contract Length","Total Data Allowance","Download Speed","Upload Speed","Special Offer Price","Special Offer Description","NBN Key Fact","Critical Information","Plan Acknowledgment Consent","Monthly Cost","Setup Fee","Delivery Fee"),
        'Plan Fees' => array("Setup Fee","Delivery Fee","Payment Processing Fees","Termination Fee","Other Fee and Charges","Minimum Total Cost"),
        'Included Addons' => array("Included Home Line Connection","Included Modem","Included Other Addons"),
        'Addons' => array("Home Line Connection","Modem","Other Addons"),
        'Connection Details' => array("Account with Current Provider","Account Number","Existing Phone Number","Home number","Provider account number","Transfer Service"),*/
    ),
    'energy_sale_fields' => array(
        'Sale Detail' => array("Sale Date","Reference Number","Sale status","Sale sub status","Sale source","Sale completed by","Sale Submission Date Time"),
        'Customer Info' => array("Customer Title","Customer First Name","Customer Last name","Customer Email","Customer Phone","Customer DOB","User browser Information","User Browser Version","Platform","Device Type","Sale IP","Lead IP","Lead Date Time","Lattitude","Longitude"),
        'UTM Parameters' => array("utm_source","utm_medium","utm_campaign","utm_term","utm_content","gclid","fbclid"),
        'Concession Info' => array("Concession Card Type","Concession Number","Concession Code","Concession Card Issue Date","Concession Card Expiry Date"),
        'Affiliate and Sub affiliate info' => array("Affiliate Name","Affiliate Comment","SubAffiliate Name","Sub Affiliate Referal Code","CID/CUI"),
        'NMI/MIRN Numbers' => array("NMI/MIRN Numbers","Site Network Code"),
        'Customer Journey' => array("Energy Type","Property Type","Life Support","Life Support Equipment","Life Support Energy Type","Solar","Solar Options","Move In","Move In Date","Current Retailer","Energy Provider Name","Energy Plan Name","Energy Plan Product Code","Energy Distributor","Energy Price Fact Sheet URL","Is Unique","Resale Type","Credit Score"),
        'Primary Identification' => array("Primary Identification Type","Primary Identification Number","Primary Identification Expiry","Primary Medicare Individual Reference Number","Primary Medicare Middle Name on Card","Primary Medicare Card Color","Primary Driving License State Code"),
        'Secondary Identification' => array("Secondary Identification Type","Secondary Identification Number","Secondary Identification Expiry","Secondary Medicare Individual Reference Number","Secondary Medicare Middle Name on Card","Secondary Medicare Card Color","Secondary License State Code"),
        'Connection And Billing Address' => array("Connection Address","Connection Address Suburb","Manual Connection Address","Connection Address State Code","Connection Address Postcode","Billing Preferences","Other Billing Address","Billing Address","Billing Address Suburb","Billing Address State Code","Billing Address Postcode","PO Box Full Address"),
        //'QA Section' => array("QA Comment","Rework Comment","Assigned Agent")
    ),
    'energy_lead_fields' => array(
        'Lead Detail' => array("Lead Id","Customer Title","Customer First Name","Customer Last Name","Customer Email","Customer Phone","Customer DOB","Postcode","State","Suburb","Manual Connection Address","Email Unsubscribe Status","Email Unsubscribe Date","Sms Unsubscribe Status","Sms Unsubscribe Date","Lead Create Date","Lead IP","Affiliate Name","Affiliate Comment","Other Services","Current Provider","Credit Score","Step Name","Journey Percentage","Electricity Duplicate Lead","Gas Duplicate Lead","Subaffiliate Name","Referral Code","CID/CUI","Energy Type","Property Type","Life Support Yes/No","Life Support Equipment","Life Support Energy Type","Solar Electricity","Solar Options","Electricity Bill Handy","Gas Bill handy","Move in","Move In date","Lead Source","Is Unique","Sale Status","utm_source","utm_medium","utm_campaign","utm_term","utm_content","gclid","fbclid","Sale Created Date")
    )];