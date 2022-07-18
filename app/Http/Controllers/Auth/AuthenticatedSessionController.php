<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis; 
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        /** check 2FA **/
        $route = $this->check2FA($request);

        return redirect($route);
    }

    /**
     * Handle an incoming api authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function apiStore(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        $user = User::where('email', $request->email)->first();
        return response($user);
    }

    /**
     * Verifies user token.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function apiVerifyToken(Request $request)
    {
        $request->validate([
            'api_token' => 'required'
        ]);

        $user = User::where('api_token', $request->api_token)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'token' => ['Invalid token']
            ]);
        }
        return response($user);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $userId = auth()->user()->id;
        Auth::guard('web')->logout();
        Redis::del('user_permission:'.$userId);
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /** 
	 * Check either user enabled their two factor authentication or not.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return route name
	 */
	public function check2FA($request)
	{
		$user = Auth::user();

		if ($user->hasSecret()) {
			Auth::guard('web')->logout();
			$request->session()->put('2fa:user:id', encrypt($user->id));
			return '/2fa/verify';
		}

		return RouteServiceProvider::HOME;
	}
}
