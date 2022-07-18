<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use App\Actions\RecoveryCode;
use Crypt;

class GenerateNewRecoveryCodes
{
    /**
     * Generate new recovery codes for the user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function __invoke($user)
    {
        $recoveryCodes = [];
        for ($i=0; $i < 8; $i++) {
          array_push($recoveryCodes, RecoveryCode::generate());
        }
        $user->forceFill([
            'two_factor_recovery_codes' => Crypt::encrypt(json_encode($recoveryCodes)),
        ])->save();
    }
}
