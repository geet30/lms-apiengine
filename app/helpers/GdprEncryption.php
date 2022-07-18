<?php

use App\Models\AffiliateKeys;

if (!function_exists('encryptGdprData')) {

  function encryptGdprData($string)
  {
    if (!empty($string)) {
      $encryptMethod = "AES-256-CBC";
      $key = hash('sha256', config('app.gdpr_secret_key'));
      $iv = substr(hash('sha256', config('app.gdpr_secret_iv')), 0, 16);
      return base64_encode(openssl_encrypt($string, $encryptMethod, $key, 0, $iv));
    }
    return $string;
  }
}

if (!function_exists('decryptGdprData')) {

  function decryptGdprData($output)
  {
    if (!empty($output)) {
      $encryptMethod = "AES-256-CBC";
      $key = hash('sha256', config('app.gdpr_secret_key'));
      $iv = substr(hash('sha256', config('app.gdpr_secret_iv')), 0, 16);
      return openssl_decrypt(base64_decode($output), $encryptMethod, $key, 0, $iv);
    }
    return $output;
  }
}

if (!function_exists('setTokenexEncryptData')) {

    function setTokenexEncryptData($string)
    {
      $encrypt_method = "AES-256-CBC";
      $key = hash('sha256', config('app.tokenex_secret_key'));
      $iv = substr(hash('sha256', config('app.tokenex_secret_iv')), 0, 16);
      return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
  }
  if (!function_exists('encryptBankDetail')) {

    function encryptBankDetail($string)
    {
      $encrypt_method = "AES-256-CBC";
      $key = hash('sha256', env('bank_secret_key'));
      $iv = substr(hash('sha256', env('bank_secret_iv')), 0, 16);
      return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
  }

  if (!function_exists('setTokenexDecryptData')) {

    function setTokenexDecryptData($string)
    {
      $encrypt_method = "AES-256-CBC";
      $key = hash('sha256', config('app.tokenex_secret_key'));
      $iv = substr(hash('sha256', config('app.tokenex_secret_iv')), 0, 16);
      return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }
  if (!function_exists('decryptBankDetail')) {

    function decryptBankDetail($string)
    {
      $encrypt_method = "AES-256-CBC";
      $key = hash('sha256', env('bank_secret_key'));
      $iv = substr(hash('sha256', env('bank_secret_iv')), 0, 16);
      return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
  }

if (!function_exists('randomAffiliateKey')) {

  function randomAffiliateKey($key = null)
  {
    $length = 15;
    $possibleChars = Carbon::now()->timestamp . "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ" . uniqid();
    $string = '';
    for ($i = 0; $i < $length; $i++) {
      $rand = rand(0, strlen($possibleChars) - 1);
      $string .= substr($possibleChars, $rand, 1);
    }
    $key = strtoupper($string . Carbon::now()->timestamp);
    $key = str_split($key, 5);
    $key = implode("-", $key);
    //$result = AffiliateKeys::where('api_key', $key)->count();
    return $key;
  }
}

if (!function_exists('checkApplicationPermission')) {

  function checkApplicationPermission($permissions)
  {
    $result = \DB::select('select permissions.id from permissions
             INNER JOIN application_permissions
             ON permissions.id = application_permissions.permission_id
             where name =:permissionName', array('permissionName' => $permissions));
    if (count($result)) {
      return true;
    }
    return false;
  }
}
