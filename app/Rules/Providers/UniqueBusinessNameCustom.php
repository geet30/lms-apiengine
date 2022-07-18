<?php

namespace App\Rules\Providers;

use App\Models\Providers;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueBusinessNameCustom implements Rule
{
    protected $request_array=[];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
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
        $provider = Providers::where('name',encryptGdprData(strtolower($this->request_array['business_name'])))->select('user_id')->first();
        if($provider){
            if(isset($this->request_array['user_id'])){
                $id = $this->request_array['user_id'];

                if($provider->user_id==$id){
                    return true; 
                }else{
                    return false; 
                }
            }

            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('providers.business_name_unique');
    }
}
