<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Affiliate\{MatrixRepo};


class Idmatrixs extends Model
{
    use MatrixRepo;
    protected $table = 'affiliate_idmatrix';
    protected $fillable = ['user_id', 'foreign_passport', 'medicare_card', 'australian_passport', 'driver_license', 'matrix_content_key_enable', 'matrix_content', 'id_matrix_enable', 'status', 'created_at', 'updated_at','secondary_identification_allow','services'];
}
