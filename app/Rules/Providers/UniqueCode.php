<?php

namespace App\Rules\Providers;

use Illuminate\Contracts\Validation\Rule;
use App\Models\{
    LifeSupportCode
};

class UniqueCode implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $life_support_code_id = $this->request_array['life_support_code_id'];
        if (!isset($life_support_code_id)) {
            $check = LifeSupportCode::where(['provider_id' => $this->request_array['provider_id'], 'code' => $this->request_array['code']])->select('id')->first();
        } else {
            $check = LifeSupportCode::where(['provider_id' => $this->request_array['provider_id'], 'code' => $this->request_array['code']])
                ->whereNotIn('id', [$life_support_code_id])
                ->select('id')
                ->first();
        }

        if ($check) {
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
        return trans('providers.lifesupport.unique');
    }
}
