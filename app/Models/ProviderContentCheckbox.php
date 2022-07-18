<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\ { DB };

class ProviderContentCheckbox extends Model
{
    use HasFactory;
    protected $table = 'provider_content_checkboxes';
    protected $appends=['connection_name'];

    protected $fillable = ['provider_content_id','checkbox_required','order','validation_message','content','status','type','deleted_at','connection_type'];
    public function getConnectionTypeName()
    {
        return $this->belongsTo('App\Models\ConnectionType', 'local_id','provider_content_id');
    }
    public function getConnectionNameAttribute(){
        $connectionType = DB::table('connection_types')->select('name')->where(['local_id'=> $this->connection_type , 'service_id' => 2,'connection_type_id'=> 8])->first();
        return $connectionType?$connectionType->name:'';
    }
}
