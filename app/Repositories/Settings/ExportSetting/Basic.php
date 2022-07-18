<?php

namespace App\Repositories\Settings\ExportSetting;

use App\Models\Settings;

trait Basic
{
    public static function updateLeadSalePassword($request)
    {
        try{
            $user=auth()->user();
            if($request->request_from=='reset_sale_lead_password'){
                $saleExportPwd=$request->reset_sale_export_password ?? '';
                $leadExportPwd=$request->reset_lead_export_password ?? '';
              
                if(!empty($request->ips)){
                $saleExportIps = implode(',', array_column(json_decode($request->ips), 'value'));
                $saleIps=Settings::updateOrCreate(['key' => 'sale_export_ips'],['user_id' => $user->id,'key' => 'sale_export_ips','value' => $saleExportIps]);
                }
                if(!empty($saleExportPwd)){
                $saleRes=Settings::updateOrCreate(['key' => 'sale_export_password'],['key' => 'sale_export_password','value' => encryptGdprData($saleExportPwd)]);
                  
                }
              
                if(!empty($leadExportPwd)){
                  
                $leadRes=Settings::updateOrCreate(['key' => 'lead_export_password'],['user_id' => $user->id,'key' => 'lead_export_password','value' => encryptGdprData($leadExportPwd)]);
                }
                
                $res=[
                    'salePasswordRes' => $saleRes ?? '',
                    'leadPasswordRes' => $leadRes ?? '',
                    'saleIps' => $saleIps ?? ''
                ];
               
              
                
                    return response()->json(['message' => 'Data updated successfully', 'data' => $res , 'status' => 200]);
                
            }
            if($request->request_from=='export_setting_direct_debit_form'){
              
                $directDebitPwd=$request->export_setting_direct_debit_password?? '';
                $directDebitEmailLogs=$request->export_setting_direct_debit_log_email ?? '';
                
                if(!empty($request->direct_debit_ips)){
                $directDebitIps = implode(',', array_column(json_decode($request->direct_debit_ips), 'value'));
                $directDebitIpsRes=Settings::updateOrCreate(['key' => 'direct_debit_ips'],['user_id' => $user->id,'key' => 'direct_debit_ips','value' => $directDebitIps]);
                }
                if(!empty($request->direct_debit_emails)){
                $directDebitEmails = implode(',', array_column(json_decode($request->direct_debit_emails), 'value'));
                $directDebitEmailsRes=Settings::updateOrCreate(['key' => 'direct_debit_emails'],['user_id' => $user->id,'key' => 'direct_debit_emails','value' => $directDebitEmails]);
                }
                if(!empty($directDebitPwd)){
                    $directDebitPwdRes=Settings::updateOrCreate(['key' => 'direct_debit_password'],['user_id' => $user->id,'key' => 'direct_debit_password','value' => encryptGdprData($directDebitPwd)]);
                }
               
              
                $directDebitEmailLogRes=Settings::updateOrCreate(['key' => 'direct_debit_log_email'],['user_id' => $user->id,'key' => 'direct_debit_log_email','value' => $directDebitEmailLogs]);
                
              
                $res=[
                    'directDebitPassword' => $directDebitPwdRes ?? '',
                    'directDebitEmailLog' => $directDebitEmailLogRes ?? '',
                    'directDebitIps' => $directDebitIpsRes ?? '',
                    'directDebitEmails' => $directDebitEmailsRes ?? '',
                ];
                if(!empty($res) ){
                    return response()->json(['message' => 'Data updated successfully', 'data' => $res , 'status' => 200]);
                }
            }
            if($request->request_from=='export_setting_detokenization_form'){ 

                $detokenizationPwd=$request->export_setting_detokenization_password ??'';
                $detokenizationEmailLogs=$request->export_setting_detokenization_log_email??'';
                if(!empty($request->detokenization_ips)){
                    $detokenizationIps = implode(',', array_column(json_decode($request->detokenization_ips), 'value'));
                    $detokenizationIpsRes=Settings::updateOrCreate(['key' => 'detokenization_ips'],['user_id' => $user->id,'key' => 'detokenization_ips','value' => $detokenizationIps]);

                }
                if(!empty($request->detokenization_emails)){
                    $detokenizationEmails = implode(',', array_column(json_decode($request->detokenization_emails), 'value'));
                    $detokenizationEmailsRes=Settings::updateOrCreate(['key' => 'detokenization_emails'],['user_id' => $user->id,'key' => 'detokenization_emails','value' => $detokenizationEmails]);
                }
                //dd($user->id);
                if(!empty($detokenizationPwd)){
                    $detokenizationPwdRes=Settings::updateOrCreate(['key' => 'detokenization_password'],['user_id' => $user->id,'key' => 'detokenization_password','value' => encryptGdprData($detokenizationPwd)]);
                }
               
                    $detokenizationEmailLogRes=Settings::updateOrCreate(['key' => 'detokenization_log_email'],['user_id' => $user->id,'key' => 'detokenization_log_email','value' => $detokenizationEmailLogs]);
                

                $res=[
                    'detokenizationPassword' => $detokenizationPwdRes ?? '',
                    'detokenizationEmailLog' => $detokenizationEmailLogRes ?? '',
                    'detokenizationIps' => $detokenizationIpsRes ?? '',
                    'detokenizationEmails' => $detokenizationEmailsRes ?? ''
                ];
             
                    return response()->json(['message' => 'Data updated successfully', 'data' => $res , 'status' => 200]);
                
            }
        
        return response()->json(['message' => 'Something went wrong', 'data' => '' ],500);
        }
        catch(\Exception $err) {
            return response()->json(['status' => '0', 'message' => 'Something went wrong'], 500);
        }
    }
     
    public static function getExportSaleData(){
        $keys=[
            'sale_export_password',
            'lead_export_password',
            'sale_export_ips',
            'direct_debit_password',
            'direct_debit_log_email',
            'direct_debit_ips',
            'detokenization_password',
            'detokenization_log_email',
            'detokenization_ips',
            'detokenization_emails',
            'direct_debit_emails'

        ];
        $saleExportRes=Settings::whereIn('key',$keys)->get();
        return $saleExportRes;
    }
}