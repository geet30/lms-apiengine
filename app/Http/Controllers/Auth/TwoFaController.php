<?php

namespace App\Http\Controllers\Auth;

use Cache;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Actions\GenerateNewRecoveryCodes;
use App\Http\Requests\Auth\ValidateSecretRequest;

class TwoFaController extends Controller
{
  use ValidatesRequests;

  /**
   * Two Factor Authentication manage view.
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
   */
  public function twoFactorAuthSetting($userId = null)
  {
    try {
      $resultData = [];
      $user = null;
      if (!$userId) {
        $user = Auth::user();
        list($qrcode, $secret) = $user->qrCode();
        $resultData['image'] = $qrcode;
        $resultData['secret'] = $secret;
        $view = 'two-factor-auth-setting';
      } else {
        try {
          $resultData['user_id'] = $userId;
          $userId = decryptGdprData($userId);
        } catch (\Exception $th) {
          return back()->with(['error' => trans('2fa.invalid_user_id'), 'toast' => true]);
        }

        $user = User::find($userId);
        $view = 'manage_2fa';
      }

      if (!$user) return back()->with(['error' => trans('2fa.user_not_exist'), 'toast' => true]);

      $resultData['isForced'] = $user->two_fa_force;
      $resultData['is2faActivated'] = $user->hasSecret();
      $resultData['recoveryCodes'] = $user->recoveryCodes();
      
      return view('auth.2fa.' . $view, $resultData);
    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }

  /**
   * Enable and disable Two Factor Authentication
   * @param \Illuminate\Http\Request $request
   * @param \App\Actions\GenerateNewRecoveryCodes $generate
   * @return \Illuminate\Http\RedirectResponse|string
   */
  function enableDisableTwoFactor(Request $request, GenerateNewRecoveryCodes $generate)
  {
    try {
      $validator = Validator::make($request->all(), [
        'totp' => 'required|array',
      ], ['totp.required' => 'OTP is required!']);

      if ($validator->fails()) {
        return back()->with(['error' => $validator->errors()->first(), 'toast' => true]);
      }

      $user = Auth::user();

      if ($user->hasSecret()) {
        return $user->disable2FA();
      }

      /** generate new secret **/
      $secret = Cache::get('2fa:secret:' . $user->id);

      /** Check secret key **/
      if (!$secret) {
        return back()->with(['error' => trans('2fa.secret_blank'), 'toast' => true]);
      }

      /** Check secret key for verify **/
      if (!$user->verifyKey($secret)) {
        return back()->with(['warning' => trans('2fa.invalid_totp'), 'toast' => true]);
      }

      /** encrypt and then save secret **/
      $user->enable2FA($secret);

      /** Generate backup recovery codes **/
      if (!$user->haveRecoveryCode())
        $generate($user);

      Cache::forget('2fa:secret:' . $user->id);

      if ($request->has('show-popup')) {
        return redirect('/')->with(['show-recovery-popup' => true]);
      }

      return back()->with(['success' => trans('2fa.two_fa_enabled'), 'toast' => true]);
    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }

  /**
   *
   * @param  \Illuminate\Http\Request $request
   * @param \App\Actions\GenerateNewRecoveryCodes $generate
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
   */
  public function postRecoveryCodes(Request $request, GenerateNewRecoveryCodes $generate)
  {
    try {
      $validator = Validator::make($request->all(), [
        'processType' => 'required'
      ]);

      if ($validator->fails()) {
        return back()->with(['error' => $validator->errors()->first(), 'toast' => true]);
      }
      $processType = $request->processType;

      /** get user **/
      $user = Auth::user();

      if ($processType == 'generate') {

        /** Generate backup recovery codes **/
        $generate($user);
        return back()->with(['success' => trans('2fa.recovery_code_generated'), 'toast' => true]);
      } elseif ($processType == 'download') {

        /** Create and download recovery codes file **/
        return $this->downloadRecoveryCodes($generate);
      }
      return back();

    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }

  /**
   *
   * @param  \App\Actions\GenerateNewRecoveryCodes $generateCodes
   * @return \Illuminate\Http\Response
   */
  public function downloadRecoveryCodes(GenerateNewRecoveryCodes $generateCodes)
  {
    $user = Auth::user();

    if (!$user->haveRecoveryCode())
      $generateCodes($user);

    $recoveryCodes = $user->recoveryCodes();
    $fileText = "";
    foreach ($recoveryCodes as $code) {
      $fileText .= $code . "\r\n";
    }
    $fileName = app('request')->getHttpHost() . '-' . $user->name . '-recoverycodes-' . (int) microtime(true) . '.txt';
    $headers = ['Content-type' => 'text/plain', 'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName), 'Content-Length' => strlen($fileText)];
    return Response::make($fileText, 200, $headers);
  }

  /**
   * Return to validate screen or login if session expired
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
   */
  public function validateView()
  {
    try {
      if (auth()->user()) return redirect('/');

      if (session('2fa:user:id')) {
        $userId = decrypt(session('2fa:user:id'));
        $user = User::findOrFail($userId);
        if (!$user->two_factor_secret) return redirect('/login');

        return view('auth.2fa.two-factor-verify');
      }

      return redirect('/');
    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }

  /**
   * Validate user's entered OTP
   * @param  \App\Http\Requests\Auth\ValidateSecretRequest $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function validateOTP(ValidateSecretRequest $request)
  {
    try {
      $user = Auth::user();
      if ($user) return redirect('/');

      /** get user id and create cache key **/
      $userId = $request->session()->pull('2fa:user:id');
      $userId = decrypt($userId);
      $key    = $userId . ':' . implode('', $request->totp);

      /** check for length and use cache to store token to blacklist **/
      if (count($request->totp) == 6)
        Cache::add($key, true, 240);

      /** login and redirect user **/
      Auth::loginUsingId($userId);
      return redirect('/');
    } catch (\Exception $exc) {
      return back()->with(['error' => trans('2fa.valid_token'), 'toast' => true]);
    }
  }

  /**
   * Forcing User to 2FA Page
   * @return \Illuminate\Contracts\View\View
   */
  public function apply2FAView()
  {
    $user = Auth::user();
    list($qrCode, $secret) = $user->qrCode(true);
    $active = '';
    return view('auth.2fa.force-2fa', compact('qrCode', 'secret', 'active'));
  }

  /**
   * Apply 2FA forcefully to  User
   * @return \Illuminate\Http\RedirectResponse
   */
  public function apply2FA(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required',
      ], ['user_id.required' => trans('2fa.invalid_user_id')]);

      if ($validator->fails()) {
        return back()->with(['error' => $validator->errors()->first(), 'toast' => true]);
      }
      try {
        $userId = decryptGdprData($request->user_id);
      } catch (\Exception $th) {
        return back()->with(['error' => trans('2fa.invalid_user_id'), 'toast' => true]);
      }
      
      $user = User::find($userId);

      if ($user->id == Auth::user()->id) {
        return back()->with(['error' => trans('2fa.do_not_have_permission'), 'toast' => true]);
      }

      $userName = trim(decryptGdprData($user->first_name).' '.decryptGdprData($user->last_name));

      $msg = trans('2fa.two_fa_force_disabled', [ 'user' => $userName ]);
      $enable = false;
      if ($request->has('two_fa_force') && $request->two_fa_force) {
        $msg = trans('2fa.two_fa_force_enabled', [ 'user' => $userName ]);
        $enable = true;
      }

      $user->two_fa_force = $enable ? 1 : 0;
      $user->save();
      return back()->with(['success' => $msg, 'toast' => true]);
    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }

  /**
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function cancel()
  {
    session()->forget('2fa:user:id');
    return redirect('/login');
  }

  /**
   * Disable Two Factor Authentication
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function forceDisable2FA(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required',
      ], ['user_id.required' => trans('2fa.invalid_user_id')]);

      if ($validator->fails()) {
        return back()->with(['error' => $validator->errors()->first(), 'toast' => true]);
      }

      try {
        $userId = decryptGdprData($request->user_id);
      } catch (\Exception $th) {
        return back()->with(['error' => trans('2fa.invalid_user_id'), 'toast' => true]);
      }

      /** get user **/
      $user = User::find($userId);

      if ($user->id == auth()->user()->id) {
        return back()->with(['error' => trans('2fa.do_not_have_permission'), 'toast' => true]);
      }

      $msg = $user->completeDisable2FA();

      return back()->with(['success' => $msg, 'toast' => true]);
    } catch (\Exception $th) {
      return back()->with(['error' => $th->getMessage(), 'toast' => true]);
    }
  }
}
