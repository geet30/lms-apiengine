<?php

namespace App\Http\Requests\Providers;

use App\Rules\CommaSeparatedEmails;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class AddProviderSaleSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_id'          => 'bail|required',
            'from_name'            => 'bail|required|string',
            'from_email'           => 'bail|required|regex:/(.+)@(.+)\.(.+)/i',
            'subject'              => 'bail|required|string',
            'to_email_ids'         => ['bail', 'required', new CommaSeparatedEmails(request()->to_email_ids)],
            'cc_email_ids'         => ['bail', 'nullable', new CommaSeparatedEmails(request()->cc_email_ids)],
            'bcc_email_ids'        => ['bail', 'nullable', new CommaSeparatedEmails(request()->bcc_email_ids)],
            'sale_submission_type' => 'bail|required|string',
            'cor_sale_time'        => 'bail|required|array',
            'cor_sale_time.*' => 'bail|required|string|distinct',
        ];
    }

    public function messages()
    {
        return [
          'cor_sale_time.*.distinct' => 'Sale submission time must be distinct.'
        ];
    }
}
