<?php

namespace App\Models;

use App\Repositories\userPostcode\Accessor;
use App\Repositories\userPostcode\BasicCrudMethods;
use App\Repositories\userPostcode\Mutators;
use App\Repositories\userPostcode\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPostcode extends Model
{
    use HasFactory,Accessor,BasicCrudMethods,Mutators,Relationship;

    protected $fillable=['user_id','distributor_id','status','is_deleted'];
}
