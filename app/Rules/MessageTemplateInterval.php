<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MessageTemplateInterval implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $message;

    protected $request = [];
    public function __construct($request)
    {
        $this->request = $request;
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

        if ($this->request['type'] == 'message') {
            $this->request['type'] = 'sms';
        }
        $exists = null;
        /**
         * (select_remarketing_type)
         * 1=>Normal
         * 2=>Movin
         */
        if (isset($this->request['select_remarketing_type']) && $this->request['action'] == 'add') {
            /**
             * (email_type)
             * 2=>remarketing
             */
            $exists = \DB::table('affiliate_templates')->where($attribute, $value)->where('user_id', decryptGdprData($this->request['user_id']))->where(['type' => $this->request['type'], 'email_type' => '2'])->where('service_id', $this->request['service_id'])->where('select_remarketing_type', $this->request['select_remarketing_type'])->where('status', 1)->first();
        } else {
            if (!empty($this->request['id'])) {
                if (isset($this->request['select_remarketing_type'])) {
                    $exists = \DB::table('affiliate_templates')->where($attribute, $value)->where('user_id', decryptGdprData($this->request['user_id']))->where(['type' => $this->request['type'], 'email_type' => '2'])->where('id', '!=', decryptGdprData($this->request['id']))->where('select_remarketing_type', $this->request['select_remarketing_type'])->where('status', 1)->first();
                }
                //  else {
                //     $exists = \DB::table('affiliate_templates')->where($attribute, $value)->where('affiliate_id', decryptGdprData($this->request->get('affiliate_id')))->where(['type' => $this->request['type'], 'email_type' => 'remarketing'])->where('id', '!=', decryptGdprData($this->request['id']))->where('status', '1')->first();
                // }
            }
        }
        if ($exists) {
            $response = false;
        } else {
            $response = true;
        }
        return $response;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Template with same days interval already exists.';
    }
}
