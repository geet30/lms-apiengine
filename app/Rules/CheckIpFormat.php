<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckIpFormat implements Rule
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
        if($value != '' || $value!= null)
        {
            $ips = implode(', ', array_column(json_decode($value), 'value'));
            $ips = explode(',', $ips); 
            foreach ($ips as $ip) 
            {
                if (!filter_var(trim($ip), FILTER_VALIDATE_IP)) 
                {
                    if($ip != "")
                    {
                        return false; 
                    }
                }
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
        return 'Invalid IP address.';
    }
}
