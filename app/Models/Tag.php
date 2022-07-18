<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Settings\TagsInfo\
                                {
                                    BasicCrudMethods,
                                };

class Tag extends Model
{
    use HasFactory;
    use BasicCrudMethods;
    protected $table = 'tags';
    protected $fillable =['name','service_id','is_highlighted','is_one_in_state','is_top_of_list','set_for_all_plans','rank','status','is_deleted'];
}
