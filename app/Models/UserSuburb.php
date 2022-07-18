<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSuburb extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'state_id','suburb_id','status'];

    public function subrubs()
    {
        return $this->hasOne('App\Models\Postcode','id','suburb_id');
    }
}
