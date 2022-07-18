<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class States extends Model
{
	protected $table = 'states';

    protected $fillable = ['state_id', 'state', 'state_code','country','status'];

	public function suburbs()
    {
        return $this->hasMany('App\Models\Postcode','state','state_code');
    }
}
