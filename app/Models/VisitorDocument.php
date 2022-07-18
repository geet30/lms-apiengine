<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorDocument extends Model
{
    use HasFactory;
    protected $table='visitor_documents';
    protected $fillable = ['lead_id','document_type','real_name','file_name'];

}
