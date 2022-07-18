<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Reports\SalesQaReport\BasicCrudMethods;

class SalesQaLog extends Model
{
    use BasicCrudMethods;
    protected $connection = 'sale_logs';
    protected $table = 'sales_qa_logs';
}
