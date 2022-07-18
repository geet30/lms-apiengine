<?php

namespace App\Http\Middleware;

use Closure;
class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $excludeUris = ['logout', 'force', 'enable-disable-2fa'];
        $user = auth()->user();
        $applyRoute = $user->get2FARouteByRole();

        if ($user && !in_array($request->segment(2), $excludeUris) && $user->two_fa_force && $user->two_fa_force == 1 && !$user->two_factor_secret) 
            return redirect($applyRoute);

        return $this->handleRedirects($request, $user, $next);
    }

    function handleRedirects ($request, $user, $next) {
        $noNeedToCheck2FA = (($user->two_fa_force == 0 || ($user->two_fa_force == 1 && $user->two_factor_secret && $user->two_factor_secret!= '')) && $request->segment(1) == '2fa' && $request->segment(2) == 'force');
        if (!$user) return redirect('/');

        if ($noNeedToCheck2FA && $request->method() != 'POST')
            return redirect('/');
        
        return $next($request);
    }
}
