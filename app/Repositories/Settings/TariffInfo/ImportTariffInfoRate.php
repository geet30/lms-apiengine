<?php

namespace App\Repositories\Settings\TariffInfo; 
use App\Models\Plans\{
        EnergyTariffInfo,
        EnergyTariffRate, 
        EnergyMasterTariff,
        EnergyPlanRate, 
    };  
use Carbon;
trait ImportTariffInfoRate
{ 
    /**
     * it import demand rate in database and send sheet to s3 bucket
     */
    public static function importDemandTariffRates($request)
    {
        try
        {
            \DB::beginTransaction();
            $temp_path = \Request::file('tariff_code_file'); 
            //make array of records present in sheet
            $totalRecords = array();
            if (($handle = fopen($temp_path, 'r')) !== FALSE) {
                
                $header = fgetcsv($handle);
                while ($ar = fgetcsv($handle)) {
                    $totalRecords[] = array_combine($header, $ar);
                }
            }

            //store file in s3 bucket
            // $file = \Request::file('tariff_code_file');
            // $fileOriginalName = \Request::file('tariff_code_file')->getClientOriginalName();
            // $filename = pathinfo($fileOriginalName, PATHINFO_FILENAME);
            // $extension = pathinfo($fileOriginalName, PATHINFO_EXTENSION);
            // $filePath = 'demand_tariff' . '/' . date("Y") . '/' . date("m") . '/' . date("d") . '/' . $filename . '_' . Carbon::now()->timestamp . '.' . $extension;
            //\Storage::disk('s3_plan')->put($filePath, file_get_contents($file), 'public');

            $missingRecords = [];
            $tariffId = array_column($totalRecords, 'rate tariff ID');
            $existTariffId = EnergyPlanRate::whereIn('id', $tariffId)->pluck('id')->toArray();

            $tariffCodeId = array_column($totalRecords, 'demand tariff Code ID');
            $existTariffCodeId = EnergyMasterTariff::whereIn('id', $tariffCodeId)->pluck('id')->toArray(); 

            $insertRecords = [];
            $missingRowNumber = [];
            $startRowNumber = 1;
            $existTariffId = array_map(function($value)
                {
                    return decryptGdprData($value); 
                },$existTariffId); 

            $tariffInfo = [];  
            foreach ($totalRecords as $record) {
                if (in_array($record['rate tariff ID'], $existTariffId) && in_array($record['demand tariff Code ID'], $existTariffCodeId)) {
                    array_push($insertRecords, $record);
                    $row = array(
                        'plan_rate_ref_id' => $record['rate tariff ID'],
                        'tariff_code_ref_id' => trim(strtolower($record['demand tariff Code ID'])),
                        'tariff_discount' => substr($record['demand tariff discount on usage'], 0, 10),
                        'tariff_daily_supply' => trim(strtolower($record['demand tariff daily supply charges'])),
                        'tariff_supply_discount' => substr($record['demand tariff discount on supply'], 0, 10),
                        'tariff_code_aliases' => substr($record['relational tariff codes'], 0, 10),
                        'discount_on_usage_description' => trim($record['demand tariff discount on usage description']),
                        'discount_on_supply_description' => trim($record['demand tariff discount on supply description']),
                        'daily_supply_charges_description' => trim($record['demand tariff daily supply description']),
                    );
                    array_push($tariffInfo, $row);
                } else {
                    array_push($missingRecords, $record);
                    array_push($missingRowNumber, $startRowNumber);
                }
                $startRowNumber++;
            }

            $records = self::genrateDemandtariffData($insertRecords, $tariffInfo);
            if ($records) {
                \DB::commit();
                $response = ['success' => true, 'total_records' => count($totalRecords), 'inserted_records' => count($insertRecords), 'missing_records' => $missingRecords, 'missing_row_no' => $missingRowNumber, 'message' => 'Tariff demands imported succesfully.'];
                return response()->json($response);
            } 
            \DB::rollback();
            return response()->json(array('success' => 'false', 'errors' => array('plan_rate_sheet' => 'Some error with selected file')), 422);
        }
        catch (\Exception $err) { 
            \DB::rollback();
            throw $err;
        }
        
    }
    /**
     * generate demad tariff rates
     */
    public static function genrateDemandtariffData($data, $tariffInfo)
    {
        try
        {
            $ratedata = [];
            $result = EnergyTariffInfo::insert($tariffInfo);
            if ($result) {
                $newRecordsLength = count($tariffInfo);
                $lastIds = EnergyTariffInfo::orderBy('id', 'desc')->take($newRecordsLength)->pluck('id')->toArray(); 
                $lastIds = array_map(function($value)
                {
                    return decryptGdprData($value); 
                },$lastIds);  

                foreach ($data as $row) {
                    --$newRecordsLength;
                    $ratedata = array_merge($ratedata, self::demandRates($row, 1, $lastIds[$newRecordsLength]));
                    $ratedata = array_merge($ratedata, self::demandRates($row, 2, $lastIds[$newRecordsLength]));
                    $ratedata = array_merge($ratedata, self::demandRates($row, 3, $lastIds[$newRecordsLength]));
                    $ratedata = array_merge($ratedata, self::demandRates($row, 4, $lastIds[$newRecordsLength]));
                }
                EnergyTariffRate::insert($ratedata);
            }
            return true;
        }
        catch (\Exception $err) { 
            throw $err;
        }
    }

    /**
     * generate demad tariff data for Rate 1,2,3,4
     */ 
    public static function demandRates($row, $rate, $tariffInfoId)
    {
        try
        {
            $limit_data = [];
            $limit_type = 'rate_' . $rate;
            //Peak
            //first limit 
            if (!empty($row['peak rate ' . $rate . ' first limit charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'peak',
                    'limit_level' => 1,
                    'limit_charges' => substr($row['peak rate ' . $rate . ' first limit charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['Peak rate ' . $rate . ' first limit daily usage'])),
                    'limit_yearly' => substr($row['peak rate ' . $rate . ' first limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['peak rate ' . $rate . ' first limit description'])),
                );
                array_push($limit_data, $limit);
            }


            //Second limit
            if (!empty($row['peak rate ' . $rate . ' second limit usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'peak',
                    'limit_level' => 2,
                    'limit_charges' => substr($row['peak rate ' . $rate . ' second limit usage charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['peak rate ' . $rate . ' second limit daily usage'])),
                    'limit_yearly' => substr($row['peak rate ' . $rate . ' second limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['peak rate ' . $rate . ' second limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Remaining limits
            if (!empty($row['peak rate ' . $rate . ' remaining usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'peak',
                    'limit_level' => 32768,
                    'limit_charges' => substr($row['peak rate ' . $rate . ' remaining usage charges'], 0, 10),
                    'limit_daily' => 0,
                    'limit_yearly' => 0,
                    'usage_discription' => trim(strtolower($row['peak rate ' . $rate . ' remaining  limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Off Peak
            //first limit
            if (!empty($row['Off peak rate ' . $rate . ' first limit charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'off_peak',
                    'limit_level' => 1,
                    'limit_charges' => substr($row['Off peak rate ' . $rate . ' first limit charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['Off peak rate ' . $rate . ' first limit daily usage'])),
                    'limit_yearly' => substr($row['Off peak rate ' . $rate . ' first limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['Off peak rate ' . $rate . ' first limit description'])),
                );
                array_push($limit_data, $limit);
            }
            //Second limit
            if (!empty($row['Off peak rate ' . $rate . ' second limit usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'off_peak',
                    'limit_level' => 2,
                    'limit_charges' => substr($row['Off peak rate ' . $rate . ' second limit usage charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['Off peak rate ' . $rate . ' second limit daily usage'])),
                    'limit_yearly' => substr($row['Off peak rate ' . $rate . ' second limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['Off peak rate ' . $rate . ' second limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Remaining limits
            if (!empty($row['Off peak rate ' . $rate . ' remaining usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'off_peak',
                    'limit_level' => 32768,
                    'limit_charges' => substr($row['Off peak rate ' . $rate . ' remaining usage charges'], 0, 10),
                    'limit_daily' => 0,
                    'limit_yearly' => 0,
                    'usage_discription' => trim(strtolower($row['Off peak rate ' . $rate . ' remaining  limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Shoulder
            //first limit
            if (!empty($row['shoulder rate ' . $rate . ' first limit charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'shoulder',
                    'limit_level' => 1,
                    'limit_charges' => substr($row['shoulder rate ' . $rate . ' first limit charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['shoulder rate ' . $rate . ' first limit daily usage'])),
                    'limit_yearly' => substr($row['shoulder rate ' . $rate . ' first limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['shoulder rate ' . $rate . ' first limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Second limit
            if (!empty($row['shoulder rate ' . $rate . ' second limit usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'shoulder',
                    'limit_level' => 2,
                    'limit_charges' => substr($row['shoulder rate ' . $rate . ' second limit usage charges'], 0, 10),
                    'limit_daily' => trim(strtolower($row['shoulder rate ' . $rate . ' second limit daily usage'])),
                    'limit_yearly' => substr($row['shoulder rate ' . $rate . ' second limit Yearly usage'], 0, 10),
                    'usage_discription' => trim(strtolower($row['shoulder rate ' . $rate . ' second limit description'])),
                );
                array_push($limit_data, $limit);
            }

            //Remaining limits
            if (!empty($row['shoulder rate ' . $rate . ' remaining usage charges'])) {
                $limit = array(
                    'tariff_info_ref_id' => $tariffInfoId,
                    'season_rate_type' => $limit_type,
                    'usage_type' => 'shoulder',
                    'limit_level' => 32768,
                    'limit_charges' => substr($row['shoulder rate ' . $rate . ' remaining usage charges'], 0, 10),
                    'limit_daily' => 0,
                    'limit_yearly' => 0,
                    'usage_discription' => trim(strtolower($row['shoulder rate ' . $rate . ' remaining  limit description'])),
                );
                array_push($limit_data, $limit);
            }
            return $limit_data;
        }
        catch (\Exception $err) { 
            throw $err;
        }
    }
}
