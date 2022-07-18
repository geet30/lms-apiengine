<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckEmailValid implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if ($value != '' || $value != null) {
            if (!str_contains($value, '@cimet.com.au')) {
                return false;
            } 
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Email domain should be '@cimet.com.au ' .";
    }
}
