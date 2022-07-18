<?php

namespace App\Traits\User;
use App\Actions\RecoveryCode;

trait RecoveryCodes
{
    /**
     * Get the user's two factor authentication recovery codes.
     *
     * @return array
     */
    public function recoveryCodes()
    {
        if ($this->two_factor_recovery_codes) return json_decode(decrypt($this->two_factor_recovery_codes), true);
        return [];
    }

    /**
     * Check either user have recovery code or not.
     *
     * @return boolean
     */
    public function haveRecoveryCode()
    {
        if ($this->two_factor_recovery_codes) return true;

        return false;
    }

    /**
     * Verify code with backup recovery codes.
     *
     * @param  string  $code
     */
    public function verifyCode($code)
    {
      $codes = json_decode(decrypt($this->two_factor_recovery_codes), true);
      if (in_array(trim($code), $codes)) {
        $this->replaceRecoveryCode($code);
        return true;
      }


      return false;
    }

    /**
     * Replace the given recovery code with a new one in the user's stored codes.
     *
     * @param  string  $code
     * @return void
     */
    public function replaceRecoveryCode($code)
    {
        $this->forceFill([
            'two_factor_recovery_codes' => encrypt(str_replace(
                $code,
                RecoveryCode::generate(),
                decrypt($this->two_factor_recovery_codes)
            )),
        ])->save();
    }
}
