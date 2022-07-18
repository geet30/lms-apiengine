<?php

namespace App\Rules\Plan\Common;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;
use App\Models\PlansTelcoFee;
class UniqueFeeType implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    { 

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
        $request = Request::all(); 
        $feeExists = PlansTelcoFee::where('plan_id',decryptGdprData($request['plan_id']))->where('service_id',$request['service_id'])->where('fee_id',$value);
        
        if($request['action'] =='edit'){
            $feeExists = $feeExists->where('id','!=',$request['id']); 
        }
        $feeExists = $feeExists->first();  
        if(!empty($feeExists)){
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
        return __('plans/broadband.fees.validation.unique');
    }
}
