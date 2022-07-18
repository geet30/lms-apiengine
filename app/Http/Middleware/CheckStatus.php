<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\{ DB, Auth };

class CheckStatus
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
        $user = Auth::user();
        if ($user->status == 0) {
            Auth::logout();
            return redirect('/login')->with('error', __('validation.not_authorized'));
        }
        if ($user->hasAnyRole(['admin', 'bdm', 'accountant', 'qa'])) {
            $ips = DB::table('whitelist_affiliate_ips')->where('ips','!=', '')->where('affiliate_id', $user->id)->get();
 
            if (!$ips->isEmpty()) {
                $ipsList = array_column($ips->toArray(), 'ips');
                $userIp = getClientIp();
                if (!in_array($userIp, array_filter($ipsList))) {
                    Auth::logout();
                    return redirect('/login')->with('error', __('validation.not_authorized'));
                }
            }
        }
        if ($user->hasAnyRole(['affiliate', 'sub-affiliate'])) {
            $ips = DB::table('user_ips')->where('ips','!=', '')->where('user_id', $user->id)->get();
 
            if (!$ips->isEmpty()) {
                $ipsList = array_column($ips->toArray(), 'ips');
                $ipsList = array_filter(array_map(function ($ip) { return decryptGdprData($ip); },$ipsList));
                $userIp = getClientIp();
                if (!empty($ipsList) && !in_array($userIp, array_filter($ipsList))) {
                    Auth::logout();
                    return redirect('/login')->with('error', __('validation.ip_whitelist_error'));
                }
            }
        }
        return $next($request);
    }
}
