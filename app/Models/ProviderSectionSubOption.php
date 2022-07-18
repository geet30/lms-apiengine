<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderSectionSubOption extends Model
{
    use HasFactory;
    protected $fillable = ['section_option_id','section_sub_option_id','section_sub_option_status'];
}
