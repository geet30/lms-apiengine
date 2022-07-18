<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderConcessions extends Model
{
    use HasFactory;
    protected $table = 'provider_concession';
    protected $fillable =['provider_id','state_id','enable_section'];

    public function getConcessionData($id)
    {
        return self::where('provider_id',$id)->select('value','id','unit')->first();
    }
}
