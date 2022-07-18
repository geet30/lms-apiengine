<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CostType extends Model
{
	protected $table = 'cost_types';
    use HasFactory;

     protected $fillable = ['cost_name','order','cost_period'] ;
}
