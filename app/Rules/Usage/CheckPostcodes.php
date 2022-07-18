<?php

namespace App\Rules\Usage;

use Illuminate\Contracts\Validation\Rule;

class CheckPostcodes implements Rule
{
    protected $request_array=[];

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
        $status = true;
        foreach (json_decode($this->request_array) as $postcode) {
            if (is_numeric($postcode->value)){
               
            }else{
                $status = false;
            }
        }
        if($status == false){
            return false;
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
        return trans('usagelimits.postcodenumber');
    }
}
