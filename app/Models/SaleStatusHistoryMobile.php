<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SaleDetail\{Relationship,CommonMethods};
use App\Repositories\SaleStatusHistory\{CommonCrud};

class SaleStatusHistoryMobile extends Model
{
    use HasFactory,Relationship,CommonCrud,CommonMethods;
    protected $table ='sale_status_history_mobile';
    protected $appends = ['status_class'];
    protected $guarded = ['id'];
    public function getStatusClassAttribute()
    {
        $primaryClassArr = [1, 9, 10];
        $dangerClassArr = [2, 3, 5];

        if (in_array($this->status, $primaryClassArr))
            return 'primary';
        elseif (in_array($this->status, $dangerClassArr))
            return 'danger';
        else
            return 'success';
    }
}
