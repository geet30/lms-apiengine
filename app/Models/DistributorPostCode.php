<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorPostCode extends Model
{
    use HasFactory;

    protected $fillable = ['distributor_id', 'post_code'];
}
