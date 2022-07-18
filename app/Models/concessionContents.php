<?php

namespace App\Models;

use App\Repositories\ProviderConsentRepository\BasicCrudMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class concessionContents extends Model
{
    use HasFactory, BasicCrudMethods;
    protected $table = 'concession_content';
    protected $fillable =['provider_id','state_id','type','content'];
}
