<?php

namespace App\Traits\Visitor\Address;

use App\Models\{VisitorAddress, Lead};

/**
 * Visitor Address Methods model.
 * Author: Sandeep Bangarh
 */

trait Methods
{
    /**
     * Mapping address data.
     * Author: Sandeep Bangarh
     */
    static function setAddressData($lead, $prefix='va')
    {
        $visitorAddress = new VisitorAddress;
        $fullAddress = '';
        $needToSave = false;
        foreach ($visitorAddress->fillable as $fillable) {
            if (isset($lead->{$prefix.'_'.$fillable}) && $lead->{$prefix.'_'.$fillable}) {
                $fieldValue = $lead->{$prefix.'_'.$fillable};
                $needToSave = true;
                $fullAddress = $fullAddress . ' ' . $fieldValue;
                if ($fillable == 'property_name') {
                    $fullAddress = $fullAddress . $fieldValue . ', ';
                } elseif ($fillable == 'suburb') {
                    $fullAddress = $fullAddress . ', ' . $fieldValue;
                }
            }
        }
        return $needToSave ? $fullAddress : false;
    }
    static function removeGDPR ($data) {
        
        $isObject = false;
        if (is_object($data)) {
            $data = (array) $data; 
            $isObject = true;
        }
        foreach(self::$gdprFields as $gdprField) {
            if (isset($data[$gdprField]) && $data[$gdprField]) {
                $data[$gdprField] = decryptGdprData($data[$gdprField]);
            }
        }
       
        if ($isObject) {
            return (object) $data;
        }
        return $data;
    }
}
