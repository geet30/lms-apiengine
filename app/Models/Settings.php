<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Settings\ExportSetting\Basic;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    //
    use HasFactory,Basic;
    protected $table = 'settings';

    protected $fillable = ['sort_num','type','key','value'];

   

}
