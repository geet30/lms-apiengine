<?php

namespace App\Rules\Affiliates;

use Illuminate\Contracts\Validation\Rule;

class ValidIp implements Rule
{
    protected $requestArray=[];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->requestArray = $request;
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
       
        $checkip = explode(',', $this->requestArray['ips']);
        if (filter_var($checkip[0], FILTER_VALIDATE_IP)) {
            return true;
        } 
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('affiliates.invalidwhitelistip');
    }

}
