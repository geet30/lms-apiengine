<?php

namespace App\Traits\User;

use Google2FA;
use \ParagonIE\ConstantTime\Base32;
use Exception;

trait TwoFactorAuth
{
    /**
     * Get the user's two factor authentication QR Code.
     *
     * @return array
     */
    public function qrCode($pickOld=null)
    {
        $secret = $this->secret($pickOld);
        $imageDataUri = Google2FA::getQRCodeInline(
            app('request')->getHttpHost(),
            decryptGdprData($this->email),
            $secret
        );
       
        return [ $imageDataUri, $secret ];
    }

    /**
     * Check either user have Secret key or not.
     *
     * @return boolean
     */
    public function hasSecret()
    {
        if ($this->two_factor_secret) return true;
            
        return false;
    }

    /**
     * Check either admin have enabled user's 2FA forcefully or not.
     *
     * @return boolean
     */
    public function isForced()
    {
        if ($this->two_fa_force && $this->two_fa_force == 1) return true;
            
        return false;
    }

    /**
     * Verify user's entered TOTP for enabling 2FA.
     *
     * @return boolean
    */
    public function verifyKey($secret=null)
    {
        try {
            $secretKey = $this->getSecretKey($secret);
        } catch(\RuntimeException $e) {
            throw new Exception("Invalid secret key");
        }
        $totp = app('request')->totp;
        if (is_array($totp)) {
            $totp = implode('', $totp);
        }

        return Google2FA::verifyKey($secretKey, $totp, 0);
    }

    /**
     * Get the user's two factor authentication Secret key.
     *
     * @return array
     */
    function getSecretKey ($secret) {
        try {
            return decrypt($this->two_factor_secret);
        } catch(\RuntimeException $e) {
            return decrypt($secret);
        }
    }

    /**
     * Get the user's two factor authentication Secret key.
     *
     * @return array
     */
    public function secret($pickOld=null)
    {
        if ($pickOld) $secretKey = \Cache::get('2fa:secret:'.$this->id);
        elseif (!$this->two_factor_secret) $secretKey = '';
        else $secretKey = $this->two_factor_secret;

        if ($secretKey && $secretKey != '' ) {
            try {
                $secret = decrypt($secretKey);
            } catch(\RuntimeException $e) {
                throw new Exception("Invalid secret key");
            }
            
        } else {
            $secret = $this->generateSecret();
            \Cache::put('2fa:secret:'.$this->id, encrypt($secret), 600);
        }
        return $secret;
    }

    /**
     * Generate a secret key in Base32 format
    *
    * @return string
    */
    public function generateSecret()
    {
        $randomBytes = random_bytes(10);
        return Base32::encodeUpper($randomBytes);
    }

    /**
     * Disable 2FA
    *
    * @return string
    */
    public function disable2FA () {
        
        if ($this->isForced()) {
            return back()->with(['warning' => trans('2fa.force_enabled'), 'toast' => true]);
        }

        /** Check secret key **/
        if (!$this->verifyKey())  {
            return back()->with(['error' => trans('2fa.invalid_totp'), 'toast' => true]);
        }

        /** make secret column Null **/
        $this->update(['two_factor_secret' => null]);

        return back()->with(['success' => trans('2fa.two_fa_disabled'), 'toast' => true]);
    }

    /**
     * Enable 2FA
    * @return boolean
    */
    public function enable2FA ($secret) {
        return $this->update(['two_factor_secret' => $secret]);
    }

    /**
     * Fully Disable 2FA
    * @return string
    */
    public function completeDisable2FA () {
        $this->two_factor_secret = null;
        $this->two_factor_recovery_codes = null;
        $this->two_fa_force = 0;
        $this->save();
        return trans('2fa.two_fa_disabled');
    }

    /**
     * Get 2FA Apply route according to role
    * @return string
    */
    public function get2FARouteByRole () {
        return '/2fa/force';
    }

}
