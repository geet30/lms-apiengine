<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderContact extends Model
{
    use HasFactory;
    protected $table = 'provider_contacts';
    protected $fillable =['provider_id','name','email','designation','description'];
}
