<?php
use Illuminate\Support\Facades\DB;
if (!function_exists('getLimitLevel')) {

 function getLimitLevel($value){
        switch ($value) {
            case '1': switch ($value) {
                case '1':
                    return 'First';
                    break;
                 case '2':
                    return 'Second';
                    break;
                case '3':
                    return 'Third';
                    break;
                case '4':
                    return 'Fourth';
                    break;
                case '5':
                    return 'Fifth';
                    break;
                case '6':
                    return 'Sixth';
                    break;
                case '7':
                    return 'Seventh';
                    break;
                case '8':
                    return 'Eight';
                    break;
                case '9':
                    return 'Nine';
                    break;
                default:
                     return 'Remaining';
                    break;
            }
                return 'First';
                break;
             case '2':
                return 'Second';
                break;
            case '3':
                return 'Third';
                break;
            case '4':
                return 'Fourth';
                break;
            case '5':
                return 'Fifth';
                break;
            case '6':
                return 'Sixth';
                break;
            case '7':
                return 'Seventh';
                break;
            case '8':
                return 'Eight';
                break;
            case '9':
                return 'Nine';
                break;
            default:
                 return 'Remaining';
                break;
        }
        return 'Remaining';
    }
}
    if (!function_exists('getDemandRateType')) {
    function getDemandRateType($value){
        switch ($value) {
            case '1':
                return 'Rate 1';
                break;
             case '2':
                return 'Rate 2';
                break;
            case '3':
                return 'Rate 3';
                break;
            case '4':
                return 'Rate 4';
                break;
         }
    }
}

if (!function_exists('getEnergyContentAttributes')) {
    function getEnergyContentAttributes($type,$service_id){
        return DB::table('energy_content_attributes')->selectRaw('id,type,service_id,attribute')->where('type', $type)->where('service_id', $service_id)->get();
    }
}


