<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Visitor\Address\{Methods};
class Visitor extends Model
{
    use Methods;
    protected $fillable = ['title','first_name','middle_name','last_name','email','dob','phone','alternate_phone'];
    protected static $gdprFields = ['first_name', 'middle_name', 'last_name', 'email', 'phone', 'alternate_phone'];
  
}
