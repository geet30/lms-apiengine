<?php

namespace App\Http\Requests\Providers;

use App\Rules\CommaSeparatedEmails;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class AddSftpLogsRequest extends FormRequest
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
            'sftp_enable' => 'bail|sometimes|boolean',
            'log_from_email' => 'bail|required|regex:/(.+)@(.+)\.(.+)/i',
            'log_from_name' => 'bail|required|string',
            'log_subject' => 'bail|required|string',
            'log_to_emails' => ['bail','required', new CommaSeparatedEmails(request()->log_to_emails)],
        ];
    }
}
