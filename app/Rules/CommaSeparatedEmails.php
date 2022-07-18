<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommaSeparatedEmails implements Rule
{
    protected $emails = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $emails = explode(',', $this->emails);
        $rules = ['email' => 'regex:/(.+)@(.+)\.(.+)/i'];
        foreach ($emails as $email) {
            $data = ['email' => $email];
            $validator = \Validator::make($data, $rules);
            if($validator->fails()){
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
        return 'The :attribute must be valid emails, can be separated with comma.';
    }
}
