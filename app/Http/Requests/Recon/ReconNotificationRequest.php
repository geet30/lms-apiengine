<?php

namespace App\Http\Requests\Recon;
use App\Rules\CommaSeparatedEmails;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ReconNotificationRequest extends FormRequest
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
        $request = Request::all();
        $rules=[];
        $rules = [
            'fromname'=>'required',
            'fromemail'=>'required|email',
            'emailsubject'=>'required',
            'reciveremails' => ['required', new CommaSeparatedEmails(request()->reciveremails)],
        ];

        return $rules;

    }

    public function messages()
    {
        return [
            'fromname.required' => trans('recon.fromnamerequired'),
            'fromemail.required' => trans('recon.fromemailrequired'),
            'fromemail.email' => trans('recon.validemail'),
            'emailsubject.required' => trans('recon.emailsubjectrequired'),
            'reciveremails.required' => trans('recon.reciveremailsrequired'),
       ];
    }
}
