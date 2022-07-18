<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Providers\MobileHandset\{ BasicCrudMethods, Relationship, Accessor, Mutators };
class ProviderHandset extends Model
{
   protected $table = 'provider_handsets';
   use BasicCrudMethods, Relationship, Accessor, Mutators;

   protected $fillable = ['provider_id','handset_id','status'];    

}
