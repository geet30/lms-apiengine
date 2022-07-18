<?php

namespace App\Rules\Settings\MobileSettings;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class   UniqueStorageValue implements Rule
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
        $id = request('hidden_edit_id');

        if(!isset($id)) {
            $result = DB::table('internal_storages')
                ->where(['value' => request('value'), 'unit' => request('unit')])
                ->count();
        } else {
            $result = DB::table('internal_storages')
                ->where(['value' => request('value'), 'unit' => request('unit')])
                ->whereNotIn('id', [$id])
                ->count();
        }

        if (!$result) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Data already exist with these values.';
    }
}
