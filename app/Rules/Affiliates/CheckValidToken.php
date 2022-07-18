<?php

namespace App\Rules\Affiliates;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckValidToken implements Rule
{
    protected $request_array = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request_array = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email',encryptGdprData($this->request_array['email']))->where('token', $this->request_array['token'])->first();

        return isset($user) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('affiliates.invalid_token');
    }
}
