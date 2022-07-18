<?php

namespace App\Rules\User;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmailCustom implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $request_array=[];
    public function __construct($request){
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
        $user = User::where('email',encryptGdprData($this->request_array['email']))->select('id')->first(); 
        if($user){ 
            if($this->request_array['action']=='edit'){  
                $id = decryptGdprData($this->request_array['id']); 
                if($user->id==$id){
                    return true; 
                }else{
                    return false;
                }
            }
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
        return 'This email already exist.';
    }
}
