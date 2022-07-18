<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Settings\DiallerIgnoreList\BasicCrudMethods;


class DiallerSetting extends Model
{
    use HasFactory,BasicCrudMethods;

    protected $table = 'dialler_settings';
    protected $fillable = ['type', 'type_value', 'comment', 'created_at', 'updated_at'];
}
