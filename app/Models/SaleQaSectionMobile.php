<?php

namespace App\Models;

use App\Repositories\SaleQaSection\CommonCrud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleQaSectionMobile extends Model
{
    use HasFactory, CommonCrud;
    protected $table = 'sale_qa_section_mobile';
    protected $guarded = [];
}
