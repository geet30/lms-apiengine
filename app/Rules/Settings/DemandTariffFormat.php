<?php

namespace App\Rules\Settings;

use Illuminate\Contracts\Validation\Rule;

class DemandTariffFormat implements Rule
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
        $path = \Request::file('tariff_code_file');
        ini_set('auto_detect_line_endings', true);
		if (!file_exists($path) || !is_readable($path))
			return false;

		if (($handle = fopen($path, 'r')) !== false) {
			$header = fgetcsv($handle);
			$target = array(
				'rate tariff ID',
				'demand tariff Code ID',
				'demand tariff discount on usage',
				'demand tariff discount on supply',
				'demand tariff daily supply charges',
				'demand tariff daily supply charges',
				'Peak rate 1 first limit daily usage',
				'peak rate 1 first limit Yearly usage',
				'peak rate 1 first limit description',
				'peak rate 1 first limit charges',
				'peak rate 1 second limit daily usage',
				'peak rate 1 second limit Yearly usage',
				'peak rate 1 second limit description',
				'peak rate 1 second limit usage charges',
				'peak rate 1 remaining  limit description',
				'peak rate 1 remaining usage charges',
				'Off peak rate 1 first limit daily usage',
				'Off peak rate 1 first limit Yearly usage',
				'Off peak rate 1 first limit description',
				'Off peak rate 1 first limit charges',
				'Off peak rate 1 second limit daily usage',
				'Off peak rate 1 second limit Yearly usage',
				'Off peak rate 1 second limit description',
				'Off peak rate 1 second limit usage charges',
				'Off peak rate 1 remaining  limit description',
				'Off peak rate 1 remaining usage charges',
				'shoulder rate 1 first limit daily usage',
				'shoulder rate 1 first limit Yearly usage',
				'shoulder rate 1 first limit description',
				'shoulder rate 1 first limit charges',
				'shoulder rate 1 second limit daily usage',
				'shoulder rate 1 second limit Yearly usage',
				'shoulder rate 1 second limit description',
				'shoulder rate 1 second limit usage charges',
				'shoulder rate 1 remaining  limit description',
				'shoulder rate 1 remaining usage charges',

				'Peak rate 2 first limit daily usage',
				'peak rate 2 first limit Yearly usage',
				'peak rate 2 first limit description',
				'peak rate 2 first limit charges',
				'peak rate 2 second limit daily usage',
				'peak rate 2 second limit Yearly usage',
				'peak rate 2 second limit description',
				'peak rate 2 second limit usage charges',
				'peak rate 2 remaining  limit description',
				'peak rate 2 remaining usage charges',
				'Off peak rate 2 first limit daily usage',
				'Off peak rate 2 first limit Yearly usage',
				'Off peak rate 2 first limit description',
				'Off peak rate 2 first limit charges',
				'Off peak rate 2 second limit daily usage',
				'Off peak rate 2 second limit Yearly usage',
				'Off peak rate 2 second limit description',
				'Off peak rate 2 second limit usage charges',
				'Off peak rate 2 remaining  limit description',
				'Off peak rate 2 remaining usage charges',
				'shoulder rate 2 first limit daily usage',
				'shoulder rate 2 first limit Yearly usage',
				'shoulder rate 2 first limit description',
				'shoulder rate 2 first limit charges',
				'shoulder rate 2 second limit daily usage',
				'shoulder rate 2 second limit Yearly usage',
				'shoulder rate 2 second limit description',
				'shoulder rate 2 second limit usage charges',
				'shoulder rate 2 remaining  limit description',
				'shoulder rate 2 remaining usage charges',

				'Peak rate 3 first limit daily usage',
				'peak rate 3 first limit Yearly usage',
				'peak rate 3 first limit description',
				'peak rate 3 first limit charges',
				'peak rate 3 second limit daily usage',
				'peak rate 3 second limit Yearly usage',
				'peak rate 3 second limit description',
				'peak rate 3 second limit usage charges',
				'peak rate 3 remaining  limit description',
				'peak rate 3 remaining usage charges',
				'Off peak rate 3 first limit daily usage',
				'Off peak rate 3 first limit Yearly usage',
				'Off peak rate 3 first limit description',
				'Off peak rate 3 first limit charges',
				'Off peak rate 3 second limit daily usage',
				'Off peak rate 3 second limit Yearly usage',
				'Off peak rate 3 second limit description',
				'Off peak rate 3 second limit usage charges',
				'Off peak rate 3 remaining  limit description',
				'Off peak rate 3 remaining usage charges',
				'shoulder rate 3 first limit daily usage',
				'shoulder rate 3 first limit Yearly usage',
				'shoulder rate 3 first limit description',
				'shoulder rate 3 first limit charges',
				'shoulder rate 3 second limit daily usage',
				'shoulder rate 3 second limit Yearly usage',
				'shoulder rate 3 second limit description',
				'shoulder rate 3 second limit usage charges',
				'shoulder rate 3 remaining  limit description',
				'shoulder rate 3 remaining usage charges',

				'Peak rate 4 first limit daily usage',
				'peak rate 4 first limit Yearly usage',
				'peak rate 4 first limit description',
				'peak rate 4 first limit charges',
				'peak rate 4 second limit daily usage',
				'peak rate 4 second limit Yearly usage',
				'peak rate 4 second limit description',
				'peak rate 4 second limit usage charges',
				'peak rate 4 remaining  limit description',
				'peak rate 4 remaining usage charges',
				'Off peak rate 4 first limit daily usage',
				'Off peak rate 4 first limit Yearly usage',
				'Off peak rate 4 first limit description',
				'Off peak rate 4 first limit charges',
				'Off peak rate 4 second limit daily usage',
				'Off peak rate 4 second limit Yearly usage',
				'Off peak rate 4 second limit description',
				'Off peak rate 4 second limit usage charges',
				'Off peak rate 4 remaining  limit description',
				'Off peak rate 4 remaining usage charges',
				'shoulder rate 4 first limit daily usage',
				'shoulder rate 4 first limit Yearly usage',
				'shoulder rate 4 first limit description',
				'shoulder rate 4 first limit charges',
				'shoulder rate 4 second limit daily usage',
				'shoulder rate 4 second limit Yearly usage',
				'shoulder rate 4 second limit description',
				'shoulder rate 4 second limit usage charges',
				'shoulder rate 4 remaining  limit description',
				'shoulder rate 4 remaining usage charges',
				'demand tariff discount on usage description',
				'demand tariff discount on supply description',
				'demand tariff daily supply description',
				'relational tariff codes'
			);
			if (array_diff($target, $header)) {
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
        return  __('plans/energyPlans.upload_plan_file_validation') ;
    }
}
