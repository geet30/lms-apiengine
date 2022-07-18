<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Recon\{GeneralMethods};

class AffiliateReconSalesHistory extends Model
{
     protected $table = 'recon_sales_history';
     use GeneralMethods;
}
