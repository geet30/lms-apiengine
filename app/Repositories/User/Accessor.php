<?php

namespace App\Repositories\User;

trait Accessor
{
    public function getFullNameAttribute()
    {
        return  decryptGdprData($this->first_name) .' '. decryptGdprData($this->last_name);
    }
}
