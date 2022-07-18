<?php

namespace App\Http\Requests\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckIpFormat;
use App\Models\{User};
class AssignUserRequest extends FormRequest
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
        $user = User::where('id',Request::Input('user_id'))->first(); 
        if($user->getRoleNames()[0]== 'bdm')
        { 
            return [
                'ip' => [  new CheckIpFormat() ],
                'date_range_from'=>'required',
                'date_range_to'=>'required_without:date_range_checkbox|after_or_equal:date_range_from',  
            ];
        }
        return [
                'ip' => [  new CheckIpFormat() ],
            ];
    }
}
