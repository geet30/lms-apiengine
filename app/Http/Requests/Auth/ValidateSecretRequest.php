<?php

namespace App\Http\Requests\Auth;

use Cache;
use Google2FA;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidatonFactory;

class ValidateSecretRequest extends FormRequest
{
  /**
  *
  * @var \App\Models\User
  */
  private $user;

  /**
  * Create a new FormRequest instance.
  * @SuppressWarnings(PHPMD)
  * @param \Illuminate\Validation\Factory $factory
  * @return void
  */
  public function __construct(ValidatonFactory $factory)
  {
    $factory->extend(
      'valid_token',
      function ($attribute, $value) {
        if (!$this->user->two_factor_secret) return false;

        /** check for length **/
        $value = implode('', $value);
        // @phpstan-ignore-next-line
        if (strlen($value) > 6 && $this->user->verifyCode($value)) return true;

        try {
          $secret = decrypt($this->user->two_factor_secret);
        } catch (\Exception $exc) {
          return false;
        }
        
        return Google2FA::verifyKey($secret, $value, 0);
      },
      trans('2fa.valid_token')
    );

    $factory->extend(
      'used_token',
      function ($attribute, $value) {
        $value = implode('', $value);
       
        $key = $this->user->id . ':' . $value;

        return !Cache::has($key);
      },
      trans('2fa.reuse_token')
    );
  }

  /**
  * Redirect with invalid token.
  *
  */
  public function response(array $errors) {
    return back()->with(['error' => $errors()->first(), 'toast' => true]);
  }

  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    try {
      if (!session('2fa:user:id')) throw new \ErrorException('Not Authorized');
      $userId = decrypt(session('2fa:user:id'));
      $this->user = User::findOrFail(
        $userId
      );
    } catch (\Exception $exc) {
      return false;
    }

    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  * digits:6|valid_token|used_token
  * @return array
  */
  public function rules()
  {
    return [
      'totp' => 'required|valid_token|used_token',
    ];
  }

  public function messages()
    {
        return [
            'totp.required' => trans('2fa.totp_required'),
       ];
    }
}
