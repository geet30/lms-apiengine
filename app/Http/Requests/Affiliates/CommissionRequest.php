<?php

namespace App\Http\Requests\Affiliates;

use App\Models\Affiliate;
use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
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
        $data = [
            'year'                  => 'bail|required|string',
            'month'                 => 'bail|required|numeric|min:1|max:12',
            'providers'             => 'bail|required|array',
            'comment'               => 'bail|nullable|string',
            'donot_update_existing' => 'bail|sometimes|boolean',
        ];

        if ($this->service_id == 1) {
            $data1 = [
                'Ele-Res-Ret' => 'bail|required|numeric|gt:0',
                'Ele-Res-Aq'  => 'bail|required|numeric|gt:0',
                'Ele-Bus-Ret' => 'bail|required|numeric|gt:0',
                'Ele-Bus-Aq'  => 'bail|required|numeric|gt:0',

                'Gas-Res-Ret' => 'bail|required|numeric|gt:0',
                'Gas-Res-Aq'  => 'bail|required|numeric|gt:0',
                'Gas-Bus-Ret' => 'bail|required|numeric|gt:0',
                'Gas-Bus-Aq'  => 'bail|required|numeric|gt:0',

                'LPG-Res-Ret' => 'bail|required|numeric|gt:0',
                'LPG-Res-Aq'  => 'bail|required|numeric|gt:0',
                'LPG-Bus-Ret' => 'bail|required|numeric|gt:0',
                'LPG-Bus-Aq'  => 'bail|required|numeric|gt:0',
            ];
            $data = array_merge($data, $data1);
        }

        if ($this->service_id == 2) {
            $data1 = [
                'Mob-Res-Ret' => 'bail|required|numeric|gt:0',
                'Mob-Res-Aq'  => 'bail|required|numeric|gt:0',
                'Mob-Bus-Ret' => 'bail|required|numeric|gt:0',
                'Mob-Bus-Aq'  => 'bail|required|numeric|gt:0',
            ];
            $data = array_merge($data, $data1);
        }

        if ($this->service_id == 3) {
            $data1 = [
                'Bro-Res-Ret' => 'bail|required|numeric|gt:0',
                'Bro-Res-Aq'  => 'bail|required|numeric|gt:0',
                'Bro-Bus-Ret' => 'bail|required|numeric|gt:0',
                'Bro-Bus-Aq'  => 'bail|required|numeric|gt:0',
            ];
            $data = array_merge($data, $data1);
        }

        return $data;
    }

    public function messages()
    {
        return [
            'Ele-Res-Ret.required' => 'This field is required.',
            'Ele-Res-Aq.required'  => 'This field is required.',
            'Ele-Bus-Aq.required'  => 'This field is required.',
            'Ele-Bus-Ret.required' => 'This field is required.',
            'Ele-Res-Ret.numeric'  => 'Enter a number.',
            'Ele-Res-Aq.numeric'   => 'Enter a number.',
            'Ele-Bus-Aq.numeric'   => 'Enter a number.',
            'Ele-Bus-Ret.numeric'  => 'Enter a number.',
            'Ele-Res-Ret.gt'       => 'Enter value greater than 0.',
            'Ele-Res-Aq.gt'        => 'Enter value greater than 0.',
            'Ele-Bus-Aq.gt'        => 'Enter value greater than 0.',
            'Ele-Bus-Ret.gt'       => 'Enter value greater than 0.',


            'Gas-Res-Ret.required' => 'This field is required.',
            'Gas-Res-Aq.required'  => 'This field is required.',
            'Gas-Bus-Aq.required'  => 'This field is required.',
            'Gas-Bus-Ret.required' => 'This field is required.',
            'Gas-Res-Ret.numeric'  => 'Enter a number.',
            'Gas-Res-Aq.numeric'   => 'Enter a number.',
            'Gas-Bus-Aq.numeric'   => 'Enter a number.',
            'Gas-Bus-Ret.numeric'  => 'Enter a number.',
            'Gas-Res-Ret.gt'       => 'Enter value greater than 0.',
            'Gas-Res-Aq.gt'        => 'Enter value greater than 0.',
            'Gas-Bus-Aq.gt'        => 'Enter value greater than 0.',
            'Gas-Bus-Ret.gt'       => 'Enter value greater than 0.',


            'LPG-Res-Ret.required' => 'This field is required.',
            'LPG-Res-Aq.required'  => 'This field is required.',
            'LPG-Bus-Aq.required'  => 'This field is required.',
            'LPG-Bus-Ret.required' => 'This field is required.',
            'LPG-Res-Ret.numeric'  => 'Enter a number.',
            'LPG-Res-Aq.numeric'   => 'Enter a number.',
            'LPG-Bus-Aq.numeric'   => 'Enter a number.',
            'LPG-Bus-Ret.numeric'  => 'Enter a number.',
            'LPG-Res-Ret.gt'       => 'Enter value greater than 0.',
            'LPG-Res-Aq.gt'        => 'Enter value greater than 0.',
            'LPG-Bus-Aq.gt'        => 'Enter value greater than 0.',
            'LPG-Bus-Ret.gt'       => 'Enter value greater than 0.',


            'Mob-Res-Ret.required' => 'This field is required.',
            'Mob-Res-Aq.required'  => 'This field is required.',
            'Mob-Bus-Aq.required'  => 'This field is required.',
            'Mob-Bus-Ret.required' => 'This field is required.',
            'Mob-Res-Ret.numeric'  => 'Enter a number.',
            'Mob-Res-Aq.numeric'   => 'Enter a number.',
            'Mob-Bus-Aq.numeric'   => 'Enter a number.',
            'Mob-Bus-Ret.numeric'  => 'Enter a number.',
            'Mob-Res-Ret.gt'       => 'Enter value greater than 0.',
            'Mob-Res-Aq.gt'        => 'Enter value greater than 0.',
            'Mob-Bus-Aq.gt'        => 'Enter value greater than 0.',
            'Mob-Bus-Ret.gt'       => 'Enter value greater than 0.',

            'Bro-Res-Ret.required' => 'This field is required.',
            'Bro-Res-Aq.required'  => 'This field is required.',
            'Bro-Bus-Aq.required'  => 'This field is required.',
            'Bro-Bus-Ret.required' => 'This field is required.',
            'Bro-Res-Ret.numeric'  => 'Enter a number.',
            'Bro-Res-Aq.numeric'   => 'Enter a number.',
            'Bro-Bus-Aq.numeric'   => 'Enter a number.',
            'Bro-Bus-Ret.numeric'  => 'Enter a number.',
            'Bro-Res-Ret.gt'       => 'Enter value greater than 0.',
            'Bro-Res-Aq.gt'        => 'Enter value greater than 0.',
            'Bro-Bus-Aq.gt'        => 'Enter value greater than 0.',
            'Bro-Bus-Ret.gt'       => 'Enter value greater than 0.',
        ];
    }
}
