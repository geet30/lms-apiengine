<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\PasswordBroker as BasePasswordBroker;
use Closure;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class CimetPasswordBroker extends BasePasswordBroker
{
    public function sendResetLink(array $credentials, Closure $callback = null)
    {
        $user = $this->getUser(['email' => encryptGdprData($credentials['email'])]);
        if (is_null($user)) {
            return static::INVALID_USER;
        }

        $user->email = decryptGdprData($user->email);
        if ($this->tokens->recentlyCreatedToken($user)) {
            return static::RESET_THROTTLED;
        }

        $token = $this->tokens->create($user);

        if ($callback) {
            $callback($user, $token);
        } else {
            $user->sendPasswordResetNotification($token);
        }

        return static::RESET_LINK_SENT;
    }

    public function reset(array $credentials, Closure $callback)
    {
        $user = $this->validateReset($credentials);

        if (!$user instanceof CanResetPasswordContract) {
            return $user;
        }
        $password = $credentials['password'];

        $this->tokens->delete($user);

        $user['email'] = encryptGdprData($user->email);

        $callback($user, $password);

        return static::PASSWORD_RESET;
    }

    protected function validateReset(array $credentials)
    {
        $credentials['email'] = encryptGdprData($credentials['email']);
        if (is_null($user = $this->getUser($credentials))) {
            return static::INVALID_USER;
        }

        $user->email = decryptGdprData($user->email);
        if (!$this->tokens->exists($user, $credentials['token'])) {
            return static::INVALID_TOKEN;
        }

        return $user;
    }
}
